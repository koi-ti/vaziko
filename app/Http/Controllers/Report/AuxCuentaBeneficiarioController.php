<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\AuxCuentaBeneficiario;
use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use App\Models\Base\Tercero;
use Excel, DB, Validator;

class AuxCuentaBeneficiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {

            $data = $request->all();
            $validator = Validator::make($data, [
                'filter_fecha_inicial' => 'required',
                'filter_fecha_inicial' => 'required',
                'filter_cuenta' => 'numeric',
                'filter_tercero' => 'numeric',
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                session()->flash('errors', $validator->errors()->all());
                return redirect('/rauxcuentabeneficiario')->withInput();
            }

            list($año, $mes, $dia) = (explode('-',$request->filter_fecha_inicial));
            list($añoF, $mesF, $diaF) = (explode('-',$request->filter_fecha_final));

            $fechaI = sprintf('%s-%s-%s', intval($año), intval($mes), intval($dia));
            $fechaF = sprintf('%s-%s-%s', intval($añoF), intval($mesF), intval($diaF));

            $query = Asiento2::query();
            $query->select('asiento2_detalle', 'asiento2_debito as debito', 'asiento2_credito as credito', 'asiento1_numero', DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date"),'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'documento_nombre', 'folder_nombre');
            $query->join('koi_asiento1','asiento2_asiento','=','koi_asiento1.id');
            $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
            $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
            $query->leftJoin('koi_folder', 'koi_documento.documento_folder', '=', 'koi_folder.id');
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) >= '$fechaI'");
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) <= '$fechaF'");

            if ($request->has('filter_cuenta')) {
                $cuenta = PlanCuenta::where('plancuentas_cuenta',$request->filter_cuenta)->first();
                // Validate Plan Cuenta
                if (!$cuenta instanceof PlanCuenta) {
                    session()->flash('errors', ['No es posible recuperar plan  de cuenta, por favor verifique la información o consulte al administrador.']);
                    return redirect('/rauxcuentabeneficiario')->withInput();
                }
                $query->where('asiento2_cuenta', $cuenta->id);
            }

            if ($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                // Validate Tercero
                if (!$tercero instanceof Tercero) {
                    session()->flash('errors', ['No es posible recuperar tercero, por favor verifique la información o consulte al administrador.']);
                    return redirect('/rauxcuentabeneficiario')->withInput();

                }
                $query->where('asiento2_beneficiario', $tercero->id);
            }

            $query->orderBy('koi_asiento2.asiento2_beneficiario', 'asc');
            $query->orderBy('koi_asiento1.asiento1_ano', 'desc');
            $query->orderBy('koi_asiento1.asiento1_mes', 'asc');
            $query->orderBy('koi_asiento1.asiento1_dia', 'asc');

            // Prepare data
            $auxcontable = $query->get();
            $title = "Libro auxiliar cuenta-beneficiario $request->filter_fecha_inicial hasta $request->filter_fecha_final";
            $subtitle =  !isset($cuenta) ? 'TODAS LAS CUENTAS' : "$cuenta->plancuentas_cuenta-$cuenta->plancuentas_nombre";
            $subtitleTercero = !isset($tercero) ? 'TODOS LOS TERCEROS' : $tercero->getName();
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'auxcuentabeneficiario', date('Y_m_d'), date('H_i_s')), function($excel) use($auxcontable, $title, $subtitle, $subtitleTercero, $type) {
                        $excel->sheet('Excel', function($sheet) use($auxcontable, $title, $subtitle, $subtitleTercero, $type) {
                            $sheet->loadView('reports.accounting.auxcuentabeneficiario.report', compact('auxcontable', 'title', 'subtitle', 'subtitleTercero', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new AuxCuentaBeneficiario('L','mm','A4');
                    $pdf->buldReport($auxcontable, $title, $subtitle, $subtitleTercero);
                break;
            }
        }
        return view('reports.accounting.auxcuentabeneficiario.index');
    }
}
