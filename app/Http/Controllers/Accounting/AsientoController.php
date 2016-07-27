<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Auth;

use App\Classes\AsientoContableDocumento;

use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2;

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
            $query->select('koi_asiento1.id as id', 'asiento1_numero', 'asiento1_mes', 'asiento1_ano', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre"), 'asiento1_preguardado');
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
                    // Validar Carrito
                    $cuentas = $request->has('cuentas') ? $request->get('cuentas') : null;
                    if(!isset($cuentas) || $cuentas == null || !is_array($cuentas) || count($cuentas) == 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'Por favor ingrese detalle para el asiento contable.']);
                    }

                    // Preparar cuentas
                    $arCuentas = [];
                    foreach ($cuentas as $item) {
                        $asiento2 = new Asiento2;
                        if (!$asiento2->isValid($item)) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $asiento2->errors]);
                        }     

                        $arCuenta['Cuenta'] = $item['plancuentas_cuenta']; 
                        $arCuenta['Tercero'] = $item['asiento2_beneficiario'];
                        $arCuenta['Detalle'] = $item['asiento2_detalle'];  
                        $arCuenta['Naturaleza'] = $item['asiento2_naturaleza'];  
                        $arCuenta['CentroCosto'] = $item['asiento2_centro'];  
                        $arCuenta['Base'] = $item['asiento2_base'];  
                        $arCuenta['Credito'] = $item['asiento2_credito'];
                        $arCuenta['Debito'] = $item['asiento2_debito'];
                        $arCuentas[] = $arCuenta;
                    }

                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($data);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($arCuentas);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    $result = $objAsiento->insertarAsiento();
                    if($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    } 

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $objAsiento->asiento->id]);
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
    public function show(Request $request, $id)
    {
        $asiento = Asiento::getAsiento($id);
        if(!$asiento instanceof Asiento){       
            abort(404);
        }
        
        if ($request->ajax()) {
            return response()->json($asiento);    
        } 

        return view('accounting.asiento.show', ['asiento' => $asiento]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asiento = Asiento::findOrFail($id);
        if($asiento->asiento1_preguardado == false) {
            return redirect()->route('asientos.show', ['asiento' => $asiento]);
        }
        
        return view('accounting.asiento.edit', ['asiento' => $asiento]);
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
        if ($request->ajax()) {
            $data = $request->all();

            $asiento = Asiento::findOrFail($id);
            if ($asiento->isValid($data)) {

                DB::beginTransaction();
                try {
                    // Validar Carrito
                    $cuentas = $request->has('cuentas') ? $request->get('cuentas') : null;
                    if(!isset($cuentas) || $cuentas == null || !is_array($cuentas) || count($cuentas) == 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'Por favor ingrese detalle para el asiento contable.']);
                    }

                    // Preparar cuentas
                    $arCuentas = [];
                    foreach ($cuentas as $item) {
                        $asiento2 = new Asiento2;
                        if (!$asiento2->isValid($item)) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $asiento2->errors]);
                        }     

                        $arCuenta['Cuenta'] = $item['plancuentas_cuenta']; 
                        $arCuenta['Tercero'] = $item['asiento2_beneficiario'];
                        $arCuenta['Detalle'] = $item['asiento2_detalle'];  
                        $arCuenta['Naturaleza'] = $item['asiento2_naturaleza'];  
                        $arCuenta['CentroCosto'] = $item['asiento2_centro'];  
                        $arCuenta['Base'] = $item['asiento2_base'];  
                        $arCuenta['Credito'] = $item['asiento2_credito'];
                        $arCuenta['Debito'] = $item['asiento2_debito'];
                        $arCuentas[] = $arCuenta;
                    }

                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($data, $asiento);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($arCuentas);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    $result = $objAsiento->insertarAsiento();
                    if($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    } 

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $objAsiento->asiento->id]);
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
