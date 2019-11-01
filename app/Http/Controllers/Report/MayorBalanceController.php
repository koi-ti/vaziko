<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\MayorBalance;
use DB, View, Excel, App;

class MayorBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            // Preparar datos reporte
            $sql = '';
            $title = sprintf('%s %s %s', 'Mayor y balance de ',  config('koi.meses')[$request->mes], $request->ano);
            $type = $request->type;
            $mes = $request->mes;
            $ano = $request->ano;
            $saldos = [];

            if ($mes == 1) {
                $mes2 = 13;
                $ano2 = $ano - 1;
            } else {
                $mes2 = $mes - 1;
                $ano2 = $ano;
            }

            // Preparar sql
            $sql = "
                SELECT plancuentas_nombre, plancuentas_cuenta, plancuentas_naturaleza, plancuentas_nivel,
                (select (CASE when plancuentas_naturaleza = 'D'
                        THEN (saldoscontables_debito_inicial - saldoscontables_credito_inicial)
                        ELSE (saldoscontables_credito_inicial - saldoscontables_debito_inicial)
                        END)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes2
                    and saldoscontables_ano = $ano2
                    and saldoscontables_cuenta = koi_plancuentas.id
                ) as inicial,
                (select (saldoscontables_debito_mes)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes
                    and saldoscontables_ano = $ano
                    and saldoscontables_cuenta = koi_plancuentas.id
                ) as debitomes,
                (select (saldoscontables_credito_mes)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes
                    and saldoscontables_ano = $ano
                    and saldoscontables_cuenta = koi_plancuentas.id
                ) as creditomes
                FROM koi_plancuentas
                WHERE koi_plancuentas.id IN (
                    SELECT s.saldoscontables_cuenta
                    FROM koi_saldoscontables as s
                    WHERE s.saldoscontables_mes = $mes AND s.saldoscontables_ano = $ano
                    UNION
                    SELECT s.saldoscontables_cuenta
                    FROM koi_saldoscontables as s
                    WHERE s.saldoscontables_mes = $mes2 AND s.saldoscontables_ano = $ano2
                )";

            // Filters
            if ($request->has('cuenta_inicio')) {
                $sql .= "AND RPAD(koi_plancuentas.plancuentas_cuenta, 15, 0) >= RPAD({$request->cuenta_inicio}, 15, 0)";
            }
            if ($request->has('cuenta_fin')) {
                $sql .= "AND RPAD(koi_plancuentas.plancuentas_cuenta, 15, 0) <= RPAD({$request->cuenta_fin}, 15, 0) ";
            }
            $sql .= " ORDER BY plancuentas_cuenta ASC";
            $saldos = DB::select($sql);

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s_%s', 'mayor_y_balance', $request->ano, $request->mes, date('Y_m_d H_i_s')), function($excel) use($saldos, $title, $type) {
                        $excel->sheet('Excel', function ($sheet) use ($saldos, $title, $type) {
                            $sheet->loadView('reports.accounting.mayorbalance.report', compact('saldos', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new MayorBalance('L','mm','Letter');
                    $pdf->buldReport($saldos, $title);
                break;
            }
        }

        return view('reports.accounting.mayorbalance.index');
    }
}
