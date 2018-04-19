<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\AuxiliarContable;
use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use App\Models\Base\Tercero;
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

            // Prepare dates
            list($año, $mes, $dia) = (explode('-',$request->filter_fecha_inicial));
            list($añoF, $mesF, $diaF) = (explode('-',$request->filter_fecha_final));
            $fechaI = sprintf('%s-%s-%s', intval($año), intval($mes), intval($dia));
            $fechaF = sprintf('%s-%s-%s', intval($añoF), intval($mesF), intval($diaF));

            // Query
            $query = Asiento2::query();
            $query->select('asiento2_debito as debito', 'asiento2_credito as credito', 'asiento2_base as base', 'asiento1_numero', DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date"),'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'documento_nombre', 'plancuentas_cuenta as cuenta', 'plancuentas_nombre');
            $query->join('koi_asiento1','asiento2_asiento','=','koi_asiento1.id');
            $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
            $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
            $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) >= '$fechaI'");
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) <= '$fechaF'");

            // Filters
            if ($request->has('filter_cuenta_inicio')) {
                $query->whereRaw("plancuentas_cuenta >= '$request->filter_cuenta_inicio'");
            }
            if ($request->has('filter_cuenta_fin')) {
                $query->whereRaw("plancuentas_cuenta <= '$request->filter_cuenta_fin'");
            }
            if ($request->has('filter_tercero')) {
                $query->where('tercero_nit', $request->filter_tercero);
            }

            // Orders
            $query->orderBy('koi_asiento1.asiento1_ano', 'desc');
            $query->orderBy('koi_asiento1.asiento1_mes', 'asc');
            $query->orderBy('koi_asiento1.asiento1_dia', 'asc');

            // Prepare data
            $auxcontable = $query->get();
            $title = "Auxiliar contable desde $request->filter_fecha_inicial hasta $request->filter_fecha_final";
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
