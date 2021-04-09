<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Reports\Accounting\BalanceGeneral;
use App\Models\Base\Tercero, App\Models\Accounting\SaldoTercero;
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
            $mes = $request->filter_mes;
            $ano = $request->filter_ano;

            if ($mes == 1) {
                $mes2 = 13;
                $ano2 = $ano - 1;
            } else {
                $mes2 = $mes - 1;
                $ano2 = $ano;
            }

            // Prepare sql
            $saldos = [];
            $tercero = false;
            if ($request->has('filter_tercero_check')) {
                $addSql = "";
                if ($request->has('filter_tercero')) {
                    $tercero = Tercero::where('tercero_nit', $request->filter_tercero)->first();
                    if ($tercero instanceof Tercero) {
                        $addSql = "AND saldosterceros_tercero = '{$tercero->id}'";
                    }
                }

                $sql = "
                    SELECT
                        s.saldosterceros_debito_mes AS debitomes, s.saldosterceros_credito_mes AS creditomes, plancuentas_cuenta, plancuentas_nombre, plancuentas_naturaleza, plancuentas_nivel, (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                    (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                                )
                            ELSE tercero_razonsocial END)
                        AS tercero_nombre, tercero_nit,
                        (
                            SELECT
                                (CASE WHEN koi_plancuentas.plancuentas_naturaleza = 'C' THEN (saldosterceros_credito_inicial - saldosterceros_debito_inicial) ELSE (saldosterceros_debito_inicial - saldosterceros_credito_inicial) END)
                            FROM
                                koi_saldosterceros
                            WHERE
                                saldosterceros_cuenta = s.saldosterceros_cuenta AND saldosterceros_tercero = s.saldosterceros_tercero AND saldosterceros_mes = {$mes2} AND saldosterceros_ano = {$ano2}
                        ) AS inicial
                    FROM
                        koi_saldosterceros AS s
                    INNER JOIN
                        koi_plancuentas ON s.saldosterceros_cuenta = koi_plancuentas.id
                    INNER JOIN
                        koi_tercero ON s.saldosterceros_tercero = koi_tercero.id
                    WHERE
                        saldosterceros_mes = {$mes} AND saldosterceros_ano = {$ano} {$addSql}
                    ";

                    $tercero = true;
            } else {
                $sql = "
                    SELECT plancuentas_nombre, plancuentas_cuenta, plancuentas_naturaleza, plancuentas_nivel,
                    (SELECT (CASE WHEN koi_plancuentas.plancuentas_naturaleza = 'C' THEN (saldoscontables_credito_inicial - saldoscontables_debito_inicial) ELSE (saldoscontables_debito_inicial - saldoscontables_credito_inicial) END)
                        FROM koi_saldoscontables
                        WHERE saldoscontables_mes = {$mes2} AND saldoscontables_ano = {$ano2} AND saldoscontables_cuenta = koi_plancuentas.id
                    ) AS inicial,
                    (SELECT (saldoscontables_debito_mes)
                        FROM koi_saldoscontables
                        WHERE saldoscontables_mes = {$mes} AND saldoscontables_ano = {$ano} AND saldoscontables_cuenta = koi_plancuentas.id
                    ) AS debitomes,
                    (SELECT (saldoscontables_credito_mes)
                        FROM koi_saldoscontables
                        WHERE saldoscontables_mes = {$mes} AND saldoscontables_ano = {$ano} AND saldoscontables_cuenta = koi_plancuentas.id
                    ) AS creditomes
                    FROM koi_plancuentas
                    WHERE koi_plancuentas.id IN (
                        SELECT s.saldoscontables_cuenta
                        FROM koi_saldoscontables AS s
                        WHERE s.saldoscontables_mes = {$mes} AND s.saldoscontables_ano = {$ano}
                    UNION
                        SELECT s.saldoscontables_cuenta
                        FROM koi_saldoscontables AS s
                        WHERE s.saldoscontables_mes = {$mes2} AND s.saldoscontables_ano = {$ano2}
                    )";
            }

            // Filters
            if ($request->has('filter_cuenta_inicio')) {
                $sql .= "AND RPAD(koi_plancuentas.plancuentas_cuenta, 15, 0) >= RPAD({$request->filter_cuenta_inicio}, 15, 0)";
            }

            if ($request->has('filter_cuenta_fin')) {
                $sql .= "AND RPAD(koi_plancuentas.plancuentas_cuenta, 15, 0) <= RPAD({$request->filter_cuenta_fin}, 15, 0) ";
            }

            $sql .= " ORDER BY plancuentas_cuenta ASC";
            $saldos = DB::select($sql);

            $title = sprintf('%s %s %s', $tercero ? 'Balance general terceros ' : 'Balance general ',  config('koi.meses')[$request->filter_mes], $request->filter_ano);
            $titleDownload = $tercero ? 'balance_general_tercero' : 'balance_general';
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s_%s', $titleDownload, $request->filter_ano, $request->filter_mes, date('Y_m_d H_i_s')), function ($excel) use ($saldos, $title, $type, $tercero) {
                        $excel->sheet('Excel', function ($sheet) use ($saldos, $title, $type, $tercero) {
                            $sheet->loadView('reports.accounting.balancegeneral.report', compact('saldos', 'title', 'type', 'tercero'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new BalanceGeneral('L', 'mm', 'Letter');
                    $pdf->buldReport($saldos, $title);
                break;
            }
        }

        return view('reports.accounting.balancegeneral.index');
    }
}
