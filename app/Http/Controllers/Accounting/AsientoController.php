<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Auth;

use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta, App\Models\Accounting\CentroCosto, App\Models\Accounting\Documento, App\Models\Base\Tercero;

class AsientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Asiento::query();
            $query->select('koi_asiento1.id as id', 'asiento1_numero', 'asiento1_mes', 'asiento1_ano', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre"));
            $query->join('koi_tercero', 'koi_asiento1.asiento1_beneficiario', '=', 'koi_tercero.id');
            return Datatables::of($query)->make(true);
        }
        return view('accounting.asiento.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.asiento.create');
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
             
            $asiento = new Asiento;
            if ($asiento->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->asiento1_beneficiario)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);                    
                    }

                    // Recuerar documento
                    $documento = Documento::where('id', $request->asiento1_documento)->first();
                    if(!$documento instanceof Documento) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.']);                    
                    }
                    $consecutivo = $documento->documento_consecutivo + 1;

                    // Validar Carrito
                    $cuentas = $request->has('cuentas') ? $request->get('cuentas') : null;
                    if(!isset($cuentas) || $cuentas == null || !is_array($cuentas) || count($cuentas) == 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'Por favor ingrese detalle para el asiento contable.']);
                    }

                    // Asiento
                    $asiento->fill($data);
                    $asiento->asiento1_numero = $consecutivo;
                    $asiento->asiento1_beneficiario = $tercero->id;
                    $asiento->asiento1_usuario_elaboro = Auth::user()->id;
                    $asiento->asiento1_fecha_elaboro = date('Y-m-d H:m:s');
                    $asiento->save();

                    // Insertar dellate asiento
                    foreach ($cuentas as $item) {
                        $asiento2 = new Asiento2;
                        if (!$asiento2->isValid($item)) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $asiento2->errors]);
                        }

                        // Recuperar tercero
                        $tercero = Tercero::find($item['asiento2_beneficiario'])->first();
                        if(!$tercero instanceof Tercero) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);                    
                        }

                        // Recuperar cuenta
                        $cuenta = PlanCuenta::where('plancuentas_cuenta', $item['asiento2_cuenta'])->first();
                        if(!$cuenta instanceof PlanCuenta) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.']);                    
                        }

                        // Recuperar centro costo
                        $centrocosto = null;
                        if(isset($item['asiento2_centro']) && !empty($item['asiento2_centro'])) {
                            $centrocosto = CentroCosto::find($item['asiento2_centro'])->first();
                            if(!$centrocosto instanceof CentroCosto) {
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.']);                    
                            }
                        }

                        $asiento2->asiento2_asiento = $asiento->id;
                        $asiento2->asiento2_beneficiario = $tercero->id;
                        $asiento2->asiento2_cuenta = $cuenta->id;
                        if($centrocosto instanceof CentroCosto) {
                            $asiento2->asiento2_centro = $centrocosto->id;
                        }
                        $asiento2->asiento2_credito = $item['asiento2_credito'];
                        $asiento2->asiento2_debito = $item['asiento2_debito'];
                        $asiento2->asiento2_base = $item['asiento2_base'];
                        $asiento2->asiento2_detalle = $item['asiento2_detalle'];
                        $asiento2->save(); 
                    }

                    // Actualizar consecutivo
                    $documento->documento_consecutivo = $consecutivo;
                    $documento->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asiento->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $asiento->errors]);
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
        $asiento = Asiento::getAsiento($id);
        if($asiento instanceof Asiento){       
            return view('accounting.asiento.show', ['asiento' => $asiento]);
        }
        abort(404);
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
