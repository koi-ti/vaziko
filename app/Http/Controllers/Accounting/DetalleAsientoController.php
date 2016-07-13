<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, DB;

use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta, App\Models\Accounting\CentroCosto, App\Models\Base\Tercero;

class DetalleAsientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $detalle = [];
            if($request->has('asiento')) {
                $query = Asiento2::query();
                $query->select('koi_asiento2.*', 'plancuentas_cuenta', DB::raw('centrocosto_codigo as centrocosto_codigo'), 'plancuentas_nombre', 'centrocosto_nombre', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre"));
                $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
                $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
                $query->leftJoin('koi_centrocosto', 'asiento2_centro', '=', 'koi_centrocosto.id');
                $query->where('asiento2_asiento', $request->asiento);
                $detalle = $query->get();
            }
            return response()->json($detalle);
        }
        return view('admin.actividades.index');
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
        if ($request->ajax()) {
            $data = $request->all();
            
            $asiento2 = new Asiento2;
            if ($asiento2->isValid($data)) {
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->asiento2_beneficiario_nit)->first();
                    if(!$tercero instanceof Tercero) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);                    
                    }
                      
                    // Recuperar cuenta
                    $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->asiento2_cuenta)->first();
                    if(!$cuenta instanceof PlanCuenta) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.']);                    
                    }

                    // Verifico que no existan subniveles de la cuenta que estoy realizando el asiento
                    $result = $cuenta->validarSubnivelesCuenta();
                    if($result != 'OK') {
                        return response()->json(['success' => false, 'errors' => $result]);                    
                    }

                    // Validar base 
                    if( !empty($cuenta->plancuentas_tasa) && $cuenta->plancuentas_tasa > 0 && (!$request->has('asiento2_base') || $request->asiento2_base == 0) ) {
                        return response()->json(['success' => false, 'errors' => "Para la cuenta {$cuenta->plancuentas_cuenta} debe existir base."]); 
                    }

                    // Recuperar centro costo
                    $centrocosto = null;
                    if($request->has('asiento2_centro')) {
                        $centrocosto = CentroCosto::find($request->asiento2_centro);
                        if(!$centrocosto instanceof CentroCosto) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.']);                    
                        }
                    }

                    return response()->json(['success' => true, 'id' => uniqid(), 
                        'asiento2_cuenta' => $cuenta->id, 
                        'plancuentas_cuenta' => $cuenta->plancuentas_cuenta, 
                        'plancuentas_nombre' => $cuenta->plancuentas_nombre, 
                        'centrocosto_codigo' => ($centrocosto instanceof CentroCosto ? $centrocosto->getCode() : ''), 
                        'centrocosto_nombre' => ($centrocosto instanceof CentroCosto ? $centrocosto->centrocosto_nombre : ''), 
                        'asiento2_beneficiario' => $tercero->id,
                        'tercero_nit' => $tercero->tercero_nit,
                        'tercero_nombre' => $tercero->getName(),  
                        'asiento2_credito' => $request->asiento2_naturaleza == 'C' ? $request->asiento2_valor: 0, 
                        'asiento2_debito' => $request->asiento2_naturaleza == 'D' ? $request->asiento2_valor: 0
                    ]);

                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $asiento2->errors]);
        }
        abort(403);
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
