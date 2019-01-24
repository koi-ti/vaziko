<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\AuxBeneficiarioCuenta;
use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use App\Models\Base\Tercero;
use View, App, Excel, DB, Validator;

class AuxBeneficiarioCuentaController extends Controller
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
            $query->select('asiento2_detalle', 'asiento2_debito as debito', 'asiento2_credito as credito', 'asiento1_numero', DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date"),'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'documento_nombre', 'folder_nombre', 'plancuentas_cuenta', 'plancuentas_nombre');
            $query->join('koi_asiento1','asiento2_asiento','=','koi_asiento1.id');
            $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
            $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
            $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
            $query->leftJoin('koi_folder', 'koi_documento.documento_folder', '=', 'koi_folder.id');
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes) >= '$request->ano_inicial-$request->mes_inicial'");
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes) <= '$request->ano_final-$request->mes_final'");

            if ($request->has('filter_cuenta')) {
                $cuenta = PlanCuenta::where('plancuentas_cuenta',$request->filter_cuenta)->first();
                // Validate Plan Cuenta
                if (!$cuenta instanceof PlanCuenta) {
                    return redirect('/rauxbeneficiariocuenta')
                    ->withErrors("No es posible recuperar plan  de cuenta, por favor verifique la información o consulte al administrador.")
                    ->withInput();
                }
                $query->where('asiento2_cuenta', $cuenta->id);
            }

            if ($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                // Validate Tercero
                if (!$tercero instanceof Tercero) {
                    return redirect('/rauxbeneficiariocuenta')
                    ->withErrors("No es posible recuperar tercero, por favor verifique la información o consulte al administrador.")
                    ->withInput();
                }
                $query->where('asiento2_beneficiario', $tercero->id);
            }
            $query->orderBy('koi_asiento2.asiento2_beneficiario', 'asc');
            $query->orderBy('koi_asiento1.asiento1_ano', 'desc');
            $query->orderBy('koi_asiento1.asiento1_mes', 'asc');
            $query->orderBy('koi_asiento1.asiento1_dia', 'asc');

            // Prepare data
            $auxcontable = $query->get();
            $title = sprintf('%s %s %s %s %s %s', 'Libro auxiliar beneficiario-cuenta en el lapso de tiempo de ',  config('koi.meses')[$request->mes_inicial], $request->ano_inicial,'hasta ', config('koi.meses')[$request->mes_final], $request->ano_final );
            $subtitleTercero = !isset($tercero) ? 'TODOS LOS TERCEROS' : $tercero->getName();
            $type = $request->type;
            // dd($auxcontable);
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'auxbeneficiariocuenta', date('Y_m_d'), date('H_i_s')), function($excel) use($auxcontable, $title, $subtitleTercero,$type) {
                        $excel->sheet('Excel', function($sheet) use($auxcontable, $title, $subtitleTercero, $type) {
                            $sheet->loadView('reports.accounting.auxbeneficiariocuenta.report', compact('auxcontable', 'title', 'subtitleTercero', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new AuxBeneficiarioCuenta('L','mm','A4');
                    $pdf->buldReport($auxcontable, $title, $subtitleTercero);
                break;
            }
        }
        return view('reports.accounting.auxbeneficiariocuenta.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
