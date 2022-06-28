<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounting\SaldoTercero, App\Models\Accounting\SaldoContable;
use Excel;

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

            $query = SaldoContable::query();
            $query->where('saldoscontables_mes', '=', $mes);
            $query->where('saldoscontables_ano', '=', $ano);
            $data = $query->get();

            $tercero = null;
            $title = sprintf('%s %s %s', $tercero ? 'Medios magneticos terceros ' : 'Medios magneticos ',  config('koi.meses')[$request->filter_mes], $request->filter_ano);
            $titleDownload = $tercero ? 'medios_magneticos_tercero' : 'medios_magneticos';
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    if ($tercero) {
                       
                    } else {
                        Excel::create(sprintf('%s_%s_%s_%s', $titleDownload, $request->filter_ano, $request->filter_mes, date('Y_m_d H_i_s')), function ($excel) use ($data, $title, $type, $tercero) {
                            $excel->sheet('Excel', function ($sheet) use ($saldos, $title, $type, $tercero) {
                                $sheet->loadView('reports.accounting.mediomagnetico.report.normal', compact('data', 'title', 'type', 'tercero'));
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
