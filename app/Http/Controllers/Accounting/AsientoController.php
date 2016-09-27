<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Auth;

use App\Classes\AsientoContableDocumento;

use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta, App\Models\Base\Tercero, App\Models\Accounting\Documento;

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
            $asiento2 = new Asiento2;
            if ($asiento->isValid($data)) {
                if ($asiento2->isValid($data)) {
                    DB::beginTransaction();
                    try {
                        // Recuperar tercero
                        $tercero = Tercero::where('tercero_nit', $request->asiento1_beneficiario)->first();
                        if(!$tercero instanceof Tercero) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        // Permitir solo un asiento preguardado por documento
                        $preguardado = Asiento::where('asiento1_preguardado', true)->where('asiento1_folder', $request->asiento1_folder)->where('asiento1_documento', $request->asiento1_documento)->first();
                        if($preguardado instanceof Asiento) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'Existe un asiento preguardado para este documento, por favor terminarlo para poder generar uno nuevo.']);
                        }

                        // Recuerar documento
                        $documento = Documento::where('id', $request->asiento1_documento)->first();
                        if(!$documento instanceof Documento) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        // Asiento1
                        $asiento->fill($data);

                        // Consecutivo
                        if($documento->documento_tipo_consecutivo == 'A'){
                            $asiento->asiento1_numero = $documento->documento_consecutivo + 1;
                        }

                        $asiento->asiento1_beneficiario = $tercero->id;
                        $asiento->asiento1_preguardado = true;
                        $asiento->asiento1_usuario_elaboro = Auth::user()->id;
                        $asiento->asiento1_fecha_elaboro = date('Y-m-d H:m:s');
                        $asiento->save();

                        // Asiento2
                        $cuenta = [];
                        $cuenta['Cuenta'] = $request->plancuentas_cuenta;
                        $cuenta['Tercero'] = $request->tercero_nit;
                        $cuenta['Detalle'] = $request->asiento2_detalle;
                        $cuenta['Naturaleza'] = $request->asiento2_naturaleza;
                        $cuenta['CentroCosto'] = $request->asiento2_centro;
                        $cuenta['Base'] = $request->asiento2_base;
                        $cuenta['Credito'] = $request->asiento2_naturaleza == 'C' ? $request->asiento2_valor: 0;
                        $cuenta['Debito'] = $request->asiento2_naturaleza == 'D' ? $request->asiento2_valor: 0;

                        $result = $asiento2->store($asiento, $cuenta);
                        if(!$result->success) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result->error]);
                        }

                        // Insertar movimiento asiento
                        $result = $asiento2->movimiento($request);
                        if(!$result->success) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result->error]);
                        }

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => $asiento->id]);
                    }catch(\Exception $e){
                        DB::rollback();
                        Log::error($e->getMessage());
                        return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                    }
                }
                return response()->json(['success' => false, 'errors' => $asiento2->errors]);
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
                    // Preparar cuentas
                    // Recupero items asiento 2
                    $query = Asiento2::query();
                    $query->select('koi_asiento2.*', 'plancuentas_cuenta', 'plancuentas_tipo', 'tercero_nit',
                        DB::raw("(CASE WHEN asiento2_credito != 0 THEN 'C' ELSE 'D' END) as asiento2_naturaleza")
                    );
                    $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
                    $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
                    $query->where('asiento2_asiento', $asiento->id);
                    $asiento2 = $query->get();

                    $cuentas = [];
                    foreach ($asiento2 as $item) {
                        $arCuenta = [];
                        $arCuenta['Id'] = $item->id;
                        $arCuenta['Cuenta'] = $item->plancuentas_cuenta;
                        $arCuenta['Tercero'] = $item->tercero_nit;
                        $arCuenta['Naturaleza'] = $item->asiento2_naturaleza;
                        $arCuenta['CentroCosto'] = $item->asiento2_centro;
                        $arCuenta['Base'] = $item->asiento2_base;
                        $arCuenta['Credito'] = $item->asiento2_credito;
                        $arCuenta['Debito'] = $item->asiento2_debito;
                        $cuentas[] = $arCuenta;
                    }

                    // Validar Carrito
                    if(!isset($cuentas) || $cuentas == null || !is_array($cuentas) || count($cuentas) == 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'Por favor ingrese detalle para el asiento contable.']);
                    }

                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($data, $asiento);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($cuentas);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar asiento
                    $result = $objAsiento->insertarAsiento();
                    if($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar movimientos asiento
                    foreach ($asiento2 as $item) {
                        $result = $item->movimientos();
                        if($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                    }

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
