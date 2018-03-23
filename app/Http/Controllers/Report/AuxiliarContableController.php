<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use App\Models\Base\Tercero;
use App\Classes\Reports\AuxiliarContable;

use View, App, Excel, DB;

class AuxiliarContableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {

            $query = Asiento2::query();
            $query->select('asiento2_debito as debito', 'asiento2_credito as credito', 'asiento2_base as base', 'asiento1_numero', DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date"),'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'documento_nombre', 'koi_plancuentas.plancuentas_cuenta as cuenta');
            $query->join('koi_asiento1','asiento2_asiento','=','koi_asiento1.id');
            $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
            $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
            $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) >= '$request->filter_fecha_inicial'");
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) <= '$request->filter_fecha_final'");

            $query->where('koi_plancuentas.plancuentas_cuenta', '>=',$request->filter_cuenta_inicio);
            $query->where('koi_plancuentas.plancuentas_cuenta', '<=',$request->filter_cuenta_fin);

            if ($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                // Validate Tercero
                if (!$tercero instanceof Tercero) {
                    return redirect('/rauxcontable')
                    ->withErrors("No es posible recuperar tercero, por favor verifique la información o consulte al administrador.")
                    ->withInput();
                }
                $query->where('asiento2_beneficiario', $tercero->id);
            }
            $query->orderBy('koi_asiento1.asiento1_ano', 'desc');
            $query->orderBy('koi_asiento1.asiento1_mes', 'asc');
            $query->orderBy('koi_asiento1.asiento1_dia', 'asc');

            // Prepare data
            $auxcontable = $query->get();
            $title = "Auxiliar contable $request->filter_fecha_inicial / $request->filter_fecha_final";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'auxcontable', date('Y_m_d'), date('H_m_s')), function($excel) use($auxcontable, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($auxcontable, $title, $type) {
                            $sheet->loadView('reports.accounting.auxcontable.report', compact('auxcontable', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new AuxiliarContable('L','mm','A4');
                    $pdf->buldReport($auxcontable, $title);
                break;
            }
        }
        return view('reports.accounting.auxcontable.index');
    }
}
