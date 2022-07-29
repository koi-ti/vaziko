<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounting\SaldoTercero, App\Models\Accounting\SaldoContable;
use App\Models\Accounting\PlanCuenta;
use Excel, DB;

class MedioMagneticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            $cuenta_aditional = [];
            if ($request->has('filter_cuenta_aditional_nombre')) {
                foreach ($request->filter_cuenta_aditional_nombre as $key => $value) {
                    $cuenta_aditional[$key] = trim(explode("-", $value)[1]);
                }
            }
            // Preparar datos reporte
            $mes = $request->filter_mes_start;
            $ano = $request->filter_ano_start;

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
               
                $query = PlanCuenta::query();
                $query->select('koi_plancuentas.*');
                $query->with(['saldosterceros' => function ($q) use ($mes, $ano, $request) {
                    $q->select('koi_saldosterceros.*');
                    $q->where('saldosterceros_mes', '>=', $request->filter_mes_start);
                    $q->where('saldosterceros_ano', '>=', $request->filter_ano_start);
                    $q->where('saldosterceros_mes', '<=', $request->filter_mes_end);
                    $q->where('saldosterceros_ano', '<=', $request->filter_ano_end);
                    $q->addSelect(
                        DB::raw("saldosterceros_debito_mes AS debitomes"),
                        DB::raw("saldosterceros_credito_mes AS creditomes"),
                        DB::raw("'' AS inicial")
                    );
                    $q->with(['cuenta' => function ($qcuenta) use ($request) {
                        $qcuenta->select(
                            'id',
                            'plancuentas_cuenta',
                            'plancuentas_nombre',
                            'plancuentas_naturaleza',
                            'plancuentas_nivel',
                        );
                    }]);
                    $q->with(['tercero' => function ($qtercerco) {
                        $qtercerco->select('id', 'tercero_nit');
                        $qtercerco->nombre($qtercerco);
                    }]);
                }]);
                $query->whereIn('plancuentas_cuenta', $cuenta_aditional);
                $union = $query;

                $query = PlanCuenta::query();
                $query->select('koi_plancuentas.*');
                $query->with(['saldosterceros' => function ($q) use ($mes, $ano, $request) {
                    $q->select('koi_saldosterceros.*');
                    $q->where('saldosterceros_mes', '>=', $request->filter_mes_start);
                    $q->where('saldosterceros_ano', '>=', $request->filter_ano_start);
                    $q->where('saldosterceros_mes', '<=', $request->filter_mes_end);
                    $q->where('saldosterceros_ano', '<=', $request->filter_ano_end);
                    $q->addSelect(
                        DB::raw("saldosterceros_debito_mes AS debitomes"),
                        DB::raw("saldosterceros_credito_mes AS creditomes"),
                        DB::raw("'' AS inicial")
                    );
                    $q->with(['cuenta' => function ($qcuenta) use ($request) {
                        $qcuenta->select(
                            'id',
                            'plancuentas_cuenta',
                            'plancuentas_nombre',
                            'plancuentas_naturaleza',
                            'plancuentas_nivel',
                        );
                    }]);
                    $q->with(['tercero' => function ($qtercerco) {
                        $qtercerco->select('id', 'tercero_nit');
                        $qtercerco->nombre($qtercerco);
                    }]);
                }]);
                $query->where('plancuentas_cuenta', '>=', $request->filter_cuenta_inicio);
                $query->where('plancuentas_cuenta', '<=', $request->filter_cuenta_fin);
                $query->union($union);
                $query->orderBy('plancuentas_cuenta', 'asc');
                $saldos = $query->get();
            }
            $tercero = null;
            $title = sprintf('%s %s %s', $tercero ? 'Medios magneticos terceros ' : 'Medios magneticos ',  config('koi.meses')[$request->filter_mes_start], $request->filter_ano_start);
            $titleDownload = $tercero ? 'medios_magneticos_tercero' : 'medios_magneticos';
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    if ($tercero) {
                       
                    } else {
                        Excel::create(sprintf('%s_%s_%s_%s', $titleDownload, $request->filter_ano_start, $request->filter_mes_start, date('Y_m_d H_i_s')), function ($excel) use ($saldos, $title, $type, $tercero, $mes2, $ano2) {
                            $excel->sheet('Excel', function ($sheet) use ($saldos, $title, $type, $tercero, $mes2, $ano2) {
                                $sheet->loadView('reports.accounting.mediomagnetico.report.tercero', compact('saldos', 'title', 'type', 'tercero', 'mes2', 'ano2'));
                            });
                        })->download('xls');
                    }
                    break;

                case 'pdf':
                    $pdf = new BalanceGeneral('L', 'mm', 'Letter');
                    $pdf->buldReport($saldos, $title);
                    break;
            }
        }


        return view('reports.accounting.mediomagnetico.index');
    }
}
