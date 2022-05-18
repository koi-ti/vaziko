<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Reports\Accounting\LibroMayor;
use Excel, DB;

class LibroMayorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
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
            $sql =
                "SELECT plancuentas_nombre AS nombre ,plancuentas_cuenta AS cuenta,
                    (SELECT saldoscontables_debito_inicial FROM koi_saldoscontables WHERE saldoscontables_mes = {$mes2} AND saldoscontables_ano = {$ano2} AND saldoscontables_cuenta = koi_plancuentas.id) AS debitoinicial,
                    (SELECT saldoscontables_credito_inicial FROM koi_saldoscontables WHERE saldoscontables_mes = {$mes2} AND saldoscontables_ano = {$ano2} AND saldoscontables_cuenta = koi_plancuentas.id) AS creditoinicial,
                    (SELECT (saldoscontables_debito_mes) FROM koi_saldoscontables WHERE saldoscontables_mes = {$mes} AND saldoscontables_ano = {$ano} AND saldoscontables_cuenta = koi_plancuentas.id) AS debitomes,
                    (SELECT (saldoscontables_credito_mes) FROM koi_saldoscontables WHERE saldoscontables_mes = {$mes} AND saldoscontables_ano = {$ano} AND saldoscontables_cuenta = koi_plancuentas.id) AS creditomes
                    FROM koi_plancuentas WHERE koi_plancuentas.id IN
                    (
                        SELECT s.saldoscontables_cuenta FROM koi_saldoscontables AS s WHERE s.saldoscontables_mes = {$mes} AND s.saldoscontables_ano = {$ano}
                        UNION
                        SELECT s.saldoscontables_cuenta FROM koi_saldoscontables AS s WHERE s.saldoscontables_mes = {$mes2} AND s.saldoscontables_ano = {$ano2}
                    )
                ORDER BY cuenta";

            // Transaction querie
            $data = DB::select($sql);

            // Prepare data
            $monthName = config('koi.meses')[$mes];
            $title = "Libro Mayor y Balance {$monthName} de {$ano}";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s %s', "Libro Mayor {$monthName}", date('Y')), function ($excel) use ($data, $title, $type) {
                        $excel->sheet('Excel', function ($sheet) use ($data, $title, $type) {
                            $sheet->loadView('reports.accounting.libromayor.report', compact('data', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new LibroMayor('L', 'mm', 'Letter');
                    $pdf->buldReport($data, $title);
                break;
            }
        }
        return view('reports.accounting.libromayor.index');
    }
}
