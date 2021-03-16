<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Reports\Accounting\BalanceGeneral;
use DB, Excel;

class BalanceGeneralController extends Controller
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
            $title = sprintf('%s %s %s', 'Balance general ',  config('koi.meses')[$request->filter_mes], $request->filter_ano);
            $type = $request->type;
            $mes = $request->filter_mes;
            $ano = $request->filter_ano;
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
                (select (saldoscontables_debito_inicial - saldoscontables_credito_inicial)
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
            if ($request->has('filter_cuenta_inicio')) {
                $sql .= "AND RPAD(koi_plancuentas.plancuentas_cuenta, 15, 0) >= RPAD({$request->filter_cuenta_inicio}, 15, 0)";
            }

            if ($request->has('filter_cuenta_fin')) {
                $sql .= "AND RPAD(koi_plancuentas.plancuentas_cuenta, 15, 0) <= RPAD({$request->filter_cuenta_fin}, 15, 0) ";
            }

            $sql .= " ORDER BY plancuentas_cuenta ASC";
            $saldos = DB::select($sql);

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s_%s', 'balance_general', $request->filter_ano, $request->filter_mes, date('Y_m_d H_i_s')), function($excel) use($saldos, $title, $type) {
                        $excel->sheet('Excel', function ($sheet) use ($saldos, $title, $type) {
                            $sheet->loadView('reports.accounting.balancegeneral.report', compact('saldos', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new BalanceGeneral('L','mm','Letter');
                    $pdf->buldReport($saldos, $title);
                break;
            }
        }

        return view('reports.accounting.balancegeneral.index');
    }
}
