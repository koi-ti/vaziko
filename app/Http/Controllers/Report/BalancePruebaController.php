<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Excel, DB;

class BalancePruebaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->has('type') ) {
            $validator = Validator::make($request->all(), [
                'filter_initial_month' => 'required',
                'filter_initial_year' => 'required',
                'filter_end_month' => 'required',
                'filter_end_year' => 'required'
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                session()->flash('errors', $validator->errors()->all());
                return redirect('/rbalanceprueba')->withInput();
            }

            // Reference var
            $xmes = $request->filter_initial_month;
            $xano = $request->filter_initial_year;

            // Saldos iniciales
            $saldos = [];
        	while (true) {
    			if ($xmes == 1) {
    				$xmes2 = 13;
    				$xano2 = $xano - 1;
    			} else {
    				$xmes2 = $xmes - 1;
    				$xano2 = $xano;
    			}

                // Prepare sql
                $sql =
                    "SELECT
                        plancuentas_nombre as descripcion,
                        plancuentas_cuenta as p_cuenta,
                        CONCAT(plancuentas_nivel1,plancuentas_nivel2) as grupo,
                        plancuentas_nivel3 as cuenta,
                        plancuentas_nivel4 as subcuenta,
                        plancuentas_nivel5 as auxiliar,
                        plancuentas_nivel6 as subauxiliar,
                        plancuentas_naturaleza as naturaleza,
                        (select (CASE when plancuentas_naturaleza = 'D' THEN (saldoscontables_debito_inicial-saldoscontables_credito_inicial) ELSE (saldoscontables_credito_inicial-saldoscontables_debito_inicial) END) FROM koi_saldoscontables WHERE saldoscontables_mes = $xmes2 AND saldoscontables_ano = $xano2 AND saldoscontables_cuenta = koi_plancuentas.id) AS saldoinicial,
                        (select saldoscontables_debito_mes from koi_saldoscontables where saldoscontables_mes = $xmes and saldoscontables_ano = $xano and saldoscontables_cuenta = koi_plancuentas.id) as debitomes,
                        (select saldoscontables_credito_mes from koi_saldoscontables where saldoscontables_mes = $xmes and saldoscontables_ano = $xano and saldoscontables_cuenta = koi_plancuentas.id) as creditomes,
                        (select saldoscontables_mes from koi_saldoscontables where saldoscontables_mes = $xmes and saldoscontables_ano = $xano and saldoscontables_cuenta = koi_plancuentas.id) as saldo_mes,
                        (select saldoscontables_ano from koi_saldoscontables where saldoscontables_mes = $xmes and saldoscontables_ano = $xano and saldoscontables_cuenta = koi_plancuentas.id) as saldo_ano
                    FROM koi_plancuentas
                    WHERE koi_plancuentas.id IN (
                            select s.saldoscontables_cuenta from koi_saldoscontables as s where s.saldoscontables_mes = $xmes and s.saldoscontables_ano = $xano
                        union
                            select s.saldoscontables_cuenta from koi_saldoscontables as s where s.saldoscontables_mes = $xmes2 and s.saldoscontables_ano = $xano2
                    )
                    ORDER BY plancuentas_cuenta ASC";

                //  Transaction querie
                $saldos[] = DB::select($sql);

    			if ($xmes == $request->filter_end_month && $xano == $request->filter_end_year) {
    				break;
    			}

    			if ($xmes == 13) {
    				$xmes = 1;
    				$xano++;
    			} else {
    				$xmes++;
    			}
    		}

            // Mezclar los saldos de los meses
            $saldos = array_collapse($saldos);

            // Prepare data
            $title = "Balance de pruebas auxiliares de ".config('koi.meses')[$request->filter_initial_month]."/$request->filter_initial_year a ".config('koi.meses')[$request->filter_end_month]."/$request->filter_end_year";
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create( sprintf('%s_%s', 'reporte_balance_prueba', date('Y_m_d H_i_s') ), function($excel) use ($title, $type, $saldos){
                        $excel->sheet('Excel', function($sheet) use ($title, $type, $saldos){
                            $sheet->loadView('reports.accounting.balanceprueba.report', compact('title', 'type', 'saldos'));
                            $sheet->setWidth(array('A' => 15, 'B' => 15, 'C' => 15, 'D' => 15, 'E' => 15, 'F' => 60, 'G' => 20, 'H' => 20, 'I' => 20, 'J' => 20, 'K' => 20));
                            $sheet->setFontSize(8);
                        });
                    })->download('xls');
                break;
            }
        }
        return view('reports.accounting.balanceprueba.index');
    }
}
