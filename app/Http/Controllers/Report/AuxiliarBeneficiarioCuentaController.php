<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Reports\Accounting\AuxBeneficiarioCuenta;
use App\Models\Base\Tercero;
use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use Excel, DB;

class AuxiliarBeneficiarioCuentaController extends Controller
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
            $query = Asiento2::query();
            $query->select('asiento2_detalle AS detalle', 'asiento2_debito AS debito', 'asiento2_credito AS credito', DB::raw("CONCAT(asiento1_ano, '-', asiento1_mes, '-', asiento1_dia) as fecha"), 'documento_nombre', 'folder_nombre', 'plancuentas_cuenta', 'plancuentas_nombre');
            $query->tercero();
            $query->join('koi_asiento1', 'asiento2_asiento', '=', 'koi_asiento1.id');
            $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
            $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
            $query->leftJoin('koi_folder', 'koi_documento.documento_folder', '=', 'koi_folder.id');
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes) >= '{$request->filter_ano_inicial}-{$request->filter_mes_inicial}'");
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes) <= '{$request->filter_ano_final}-{$request->filter_mes_final}'");

            // Filter plan de cuentas
            if ($request->has('filter_cuenta')) {
                $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->filter_cuenta)->first();
                if (!$cuenta instanceof PlanCuenta) {
                    session()->flash('errors', ['No es posible recuperar plan de cuenta, por favor verifique la información o consulte al administrador.']);
                    return redirect('/rauxbeneficiariocuenta')->withInput();
                }
                $query->where('asiento2_cuenta', $cuenta->id);
            }

            // Filter tercero
            if ($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit', $request->filter_tercero)->first();
                if (!$tercero instanceof Tercero) {
                    session()->flash('errors', ['No es posible recuperar tercero, por favor verifique la información o consulte al administrador.']);
                    return redirect('/rauxbeneficiariocuenta')->withInput();
                }
                $query->where('asiento2_beneficiario', $tercero->id);
            }

            $query->orderBy('koi_asiento2.asiento2_beneficiario', 'asc');
            $query->orderBy('koi_asiento1.asiento1_ano', 'desc');
            $query->orderBy('koi_asiento1.asiento1_mes', 'asc');
            $query->orderBy('koi_asiento1.asiento1_dia', 'asc');
            $data = $query->get();

            $monthNameInicial = config('koi.meses')[$request->filter_mes_inicial];
            $monthNameFinal = config('koi.meses')[$request->filter_mes_final];

            $title = sprintf('%s %s', "Libro auxiliar beneficiario-cuenta {$monthNameInicial} {$request->filter_ano_inicial}", " hasta {$monthNameFinal} {$request->filter_ano_final}");
            $titleTercero = !isset($tercero) ? 'TODOS LOS TERCEROS' : $tercero->getName();
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s-%s', "Libro auxiliar beneficiario/cuenta {$monthNameInicial} {$request->filter_ano_inicial}", "{$monthNameFinal} {$request->filter_ano_final}"), function ($excel) use ($data, $title, $titleTercero, $type) {
                        $excel->sheet('Excel', function ($sheet) use ($data, $title, $titleTercero, $type) {
                            $sheet->loadView('reports.accounting.auxbeneficiariocuenta.report', compact('data', 'title', 'titleTercero', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new AuxBeneficiarioCuenta('L', 'mm', 'A4');
                    $pdf->buldReport($data, $title, $titleTercero);
                break;
            }
        }
        return view('reports.accounting.auxbeneficiariocuenta.index');
    }
}
