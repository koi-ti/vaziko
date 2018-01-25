<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use App\Models\Base\Tercero;

use View, App, Excel, Validator, DB;

class AuxiliarContableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( env('APP_ENV') == 'local'){
            ini_set('memory_limit', '-1');
            set_time_limit(0);
        }
        if ($request->has('type')) {

            $auxcontable = [];

            $cuentas = PlanCuenta::whereBetween('plancuentas_cuenta', [$request->filter_cuenta_inicio, $request->filter_cuenta_fin])->get();
            $startDate = strtotime($request->filter_fecha_inicial);
            $endDate = strtotime($request->filter_fecha_final);
            foreach ($cuentas as $cuenta) {

                while ($startDate <= $endDate) {
                    $query = Asiento2::query();
                    $query->select('asiento2_debito as debito', 'asiento2_credito as credito', 'asiento2_base as base','asiento1_numero',DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date"),'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'documento_nombre', 'koi_plancuentas.plancuentas_cuenta as cuenta');
                    $query->join('koi_asiento1','asiento2_asiento','=','koi_asiento1.id');
                    $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
                    $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
                    $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
                    $query->where('koi_asiento1.asiento1_ano', date('Y', $startDate));
                    $query->where('koi_asiento1.asiento1_mes', date('m', $startDate));
                    $query->where('koi_asiento1.asiento1_dia', date('d', $startDate));
                    $query->where('koi_asiento2.asiento2_cuenta', $cuenta->id);
                    if ($request->has('filter_tercero')) {
                        $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                        // Validate Tercero (?)
                        $query->where('asiento2_beneficiario', $tercero->id);
                    }
                    $query->orderBy('koi_asiento1.asiento1_ano', 'desc');
                    $query->orderBy('koi_asiento1.asiento1_mes', 'asc');
                    $query->orderBy('koi_asiento1.asiento1_dia', 'asc');

                    if (!$query->get()->isEmpty()) {
                        $auxcontable[] = $query->get();
                    }
                    // Increment days
                    $startDate = strtotime("+1 day", $startDate);
                }
                $startDate = strtotime($request->filter_fecha_inicial);
            }
            // Prepare data
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
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reports.accounting.auxcontable.report',  compact('auxcontable', 'title', 'type'))->render());
                    $pdf->setPaper('A4', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'auxcontable', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reports.accounting.auxcontable.index');
    }
}
