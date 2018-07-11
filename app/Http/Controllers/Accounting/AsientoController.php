<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;
use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\AsientoNif, App\Models\Accounting\AsientoNif2, App\Models\Accounting\PlanCuenta, App\Models\Accounting\PlanCuentaNif, App\Models\Base\Tercero, App\Models\Accounting\Documento, App\Models\Accounting\Folder, App\Models\Production\Ordenp, App\Models\Accounting\CentroCosto, App\Models\Base\Empresa;
use DB, Log, Datatables, Auth, View, App, Fpdf, Excel;

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
            $query->select('koi_asiento1.id as id', 'asiento1_numero', 'documento_nombre', 'asiento1_mes', 'asiento1_ano', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre"), 'asiento1_preguardado');
            $query->join('koi_tercero', 'asiento1_beneficiario', '=', 'koi_tercero.id');
            $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['search_tercero' => $request->has('asiento_tercero_nit') ? $request->asiento_tercero_nit : '']);
                session(['search_tercero_nombre' => $request->has('asiento_tercero_nombre') ? $request->asiento_tercero_nombre : '']);
                session(['search_documento' => $request->has('asiento_documento') ? $request->asiento_documento : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use ($request){
                    // Tercero nit
                    if($request->has('asiento_tercero_nit')) {
                        $query->where('tercero_nit', $request->asiento_tercero_nit);
                    }

                    // Documento
                    if($request->has('asiento_documento')) {
                        $query->where('asiento1_documento', $request->asiento_documento);
                    }
                })
                ->make(true);
        }
        return view('accounting.asiento.index', ['empresa' => parent::getPaginacion()]);
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
            $asientoNif = null;
            $asientoNif2 = null;
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

                        if (!$documento->documento_nif && !$documento->documento_actual) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible realizar asiento, documento no tiene tipo de asiento, por favor verifique la información del asiento o consulte al administrador.']);
                        }
                        // Recuperar centro costo
                        $centrocosto = $ordenp = null;
                        if($request->has('asiento2_centro')) {
                            $centrocosto = CentroCosto::find($request->asiento2_centro);
                            if(!$centrocosto instanceof CentroCosto) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro costo, por favor verifique la información del asiento o consulte al administrador.']);
                            }

                            if($centrocosto->centrocosto_codigo == 'OP') {
                                // Validate orden
                                if($request->has('asiento2_orden')) {
                                    $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->asiento2_orden}'")->first();
                                }
                                if(!$ordenp instanceof Ordenp) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => "No es posible recuperar orden de producción para centro de costo OP, por favor verifique la información del asiento o consulte al administrador."]);
                                }
                            }
                        }
                        if ($documento->documento_actual) {

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
                            $cuenta['Orden'] = ($ordenp instanceof Ordenp ? $ordenp->id : '');

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
                        }
                        if ($documento->documento_nif) {
                            $asientoNif = new AsientoNif;
                            $asientoNif2 = new AsientoNif2;

                            // AsientoNif1
                            $asientoNif->asienton1_mes = $data['asiento1_mes'];
                            $asientoNif->asienton1_ano = $data['asiento1_ano'];
                            $asientoNif->asienton1_dia = $data['asiento1_dia'];
                            $asientoNif->asienton1_folder = $data['asiento1_folder'];
                            $asientoNif->asienton1_numero = $data['asiento1_numero'];
                            $asientoNif->asienton1_detalle = $data['asiento1_detalle'];
                            $asientoNif->asienton1_asiento =  isset($asiento->id) ? $asiento->id : null;
                            $asientoNif->asienton1_documento = $documento->id;
                            $asientoNif->asienton1_preguardado = true;
                            $asientoNif->asienton1_beneficiario = $tercero->id;
                            $asientoNif->asienton1_usuario_elaboro = Auth::user()->id;
                            $asientoNif->asienton1_fecha_elaboro = date('Y-m-d H:m:s');

                            // Consecutivo
                            if($documento->documento_tipo_consecutivo == 'A'){
                                $asientoNif->asienton1_numero = $documento->documento_consecutivo + 1;
                            }

                            $asientoNif->save();

                            // Recupero plancuenta
                            $plancuenta = Plancuenta::where('plancuentas_cuenta',$request->plancuentas_cuenta)->first();
                            if (!$plancuenta instanceof Plancuenta) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "No es posible recuperar plan de cuenta, por favor verifique la información o consulte a su administrador"]);
                            }

                            $plancuentaNif = PlanCuentaNif::find($plancuenta->plancuentas_equivalente);
                            if (!$plancuentaNif instanceof PlanCuentaNif) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "No es posible encontrar plan de cuenta NIF, por favor verifique la información o consulte a su administrador"]);
                            }
                            // AsientoNif2
                            $cuenta = [];
                            $cuenta['Cuenta'] = $plancuentaNif->plancuentasn_cuenta;
                            $cuenta['Tercero'] = $request->tercero_nit;
                            $cuenta['Detalle'] = $request->asiento2_detalle;
                            $cuenta['Naturaleza'] = $request->asiento2_naturaleza;
                            $cuenta['CentroCosto'] = $request->asiento2_centro;
                            $cuenta['Base'] = $request->asiento2_base;
                            $cuenta['Credito'] = $request->asiento2_naturaleza == 'C' ? $request->asiento2_valor: 0;
                            $cuenta['Debito'] = $request->asiento2_naturaleza == 'D' ? $request->asiento2_valor: 0;
                            $cuenta['Orden'] = ($ordenp instanceof Ordenp ? $ordenp->id : '');

                            $result = $asientoNif2->store($asientoNif, $cuenta);
                            if(!$result->success) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result->error]);
                            }

                            if ($asientoNif->asienton1_asiento == null) {
                                // Insertar movimiento asiento
                                $result = $asientoNif2->movimiento($request, $plancuentaNif->plancuentasn_cuenta);
                                if(!$result->success) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => $result->error]);
                                }
                            }
                        }
                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => ( isset($asiento->id) ) ? $asiento->id : '', 'nif' => ( isset($asientoNif->id) ) ? $asientoNif->id : '' ]);
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

        return view('accounting.asiento.create', ['asiento' => $asiento]);
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
            $asientoNif = AsientoNif::where('asienton1_asiento',$id)->first();
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
                    if ($asientoNif instanceof AsientoNif) {

                        // Validar no cambio de documento
                        if ($asiento->asiento1_documento != $request->asiento1_documento ) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'Documento no puede ser modificado']);
                        }

                        $query = AsientoNif2::query();
                        $query->select('koi_asienton2.*', 'plancuentasn_cuenta', 'plancuentasn_tipo', 'tercero_nit',
                            DB::raw("(CASE WHEN asienton2_credito != 0 THEN 'C' ELSE 'D' END) as asienton2_naturaleza")
                        );
                        $query->join('koi_tercero', 'asienton2_beneficiario', '=', 'koi_tercero.id');
                        $query->join('koi_plancuentasn', 'asienton2_cuenta', '=', 'koi_plancuentasn.id');
                        $query->where('asienton2_asiento', $asientoNif->id);
                        $asientoNif2 = $query->get();

                        $cuentas = [];
                        foreach ($asientoNif2 as $item) {
                            $arCuenta = [];
                            $arCuenta['Id'] = $item->id;
                            $arCuenta['Cuenta'] = $item->plancuentasn_cuenta;
                            $arCuenta['Tercero'] = $item->tercero_nit;
                            $arCuenta['Naturaleza'] = $item->asienton2_naturaleza;
                            $arCuenta['CentroCosto'] = $item->asienton2_centro;
                            $arCuenta['Base'] = $item->asienton2_base;
                            $arCuenta['Credito'] = $item->asienton2_credito;
                            $arCuenta['Debito'] = $item->asienton2_debito;
                            $cuentas[] = $arCuenta;
                        }

                        // Preparo data
                        $dataNif = [];
                        $dataNif['asienton1_ano'] = $data['asiento1_ano'];
                        $dataNif['asienton1_mes'] = $data['asiento1_mes'];
                        $dataNif['asienton1_dia'] = $data['asiento1_dia'];
                        $dataNif['asienton1_folder'] = $data['asiento1_folder'];
                        $dataNif['asienton1_documento'] = $data['asiento1_documento'];
                        $dataNif['asienton1_numero'] = $data['asiento1_numero'];
                        $dataNif['asienton1_beneficiario'] = $data['asiento1_beneficiario'];
                        $dataNif['asienton1_beneficiario_nombre'] = $data['asiento1_beneficiario_nombre'];
                        $dataNif['asienton1_detalle'] = $data['asiento1_detalle'];

                        // Creo el objeto para manejar el asiento
                        $objAsiento = new AsientoNifContableDocumento($dataNif, $asientoNif);
                        if($objAsiento->asientoNif_error) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $objAsiento->asientoNif_error]);
                        }

                        // Preparar asiento
                        $result = $objAsiento->asientoCuentas($cuentas);
                        if($result != 'OK'){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }

                        // Insertar asiento
                        $result = $objAsiento->insertarAsientoNif();
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

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($id)
    {
        $asiento = Asiento::getAsiento($id);
        if(!$asiento instanceof Asiento){
            abort(404);
        }
        $detalle = Asiento2::getAsiento2($asiento->id);
        $title = 'Asiento contable';

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('accounting.asiento.export',  compact('asiento', 'detalle' ,'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'asiento', $asiento->id, date('Y_m_d'), date('H_m_s')));
    }

    /**
     * Import data in Excel .csv the specified resource.
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        // Validate required file
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'errors' => "Por favor, seleccione un archivo"]);
        }
        // Validate file is .csv
        if ($request->file->getClientMimeType() !== 'text/csv' ){
            return response()->json(['success' => false, 'errors' => "Por favor, seleccione un archivo con extensión .csv"]);
        }

        DB::beginTransaction();
        try {
            // Recuperar tercero
            $tercero = Tercero::where('tercero_nit', $request->tercero)->first();
            if(!$tercero instanceof Tercero) {
                DB::rollback();
                return response()->json(['success' => false, 'errors' => "No es posible recuperar beneficiario con nit $request->tercero, por favor verifique la información del asiento o consulte al administrador."]);
            }

            // Recuerar folder
            $folder = Folder::find($request->folder);
            if(!$folder instanceof Folder) {
                DB::rollback();
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar folder, por favor verifique la información del asiento o consulte al administrador.']);
            }
            // Recuerar documento
            $documento = Documento::find($request->documento);
            if(!$documento instanceof Documento) {
                DB::rollback();
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.']);
            }

            // Uploaded file
            $excel = Excel::load($request->file)->get();
            $headers = $excel->first()->keys()->toArray();
            $defaultHeaders = array_combine($headers, $headers);
            $consecutive = $documento->documento_consecutivo;
            $validator = \Validator::make($defaultHeaders, [
                'cuenta' => 'required',
                'centrocosto' => 'required',
                'beneficiario' => 'required',
                'debito' => 'required',
                'credito' => 'required',
                'base' => 'required',
                'detalle' => 'required'
            ]);
            if ($validator->fails()) {
                DB::rollback();
                $validator->errors()->add('comment', 'Estos campos mencionados no estan presentes en el encabezado del archivo');
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            if($documento->documento_actual){
                $asiento = new Asiento;
                $consecutive++;
                // Encabezado por defecto
                $asiento->asiento1_ano = intval( date('Y') );
                $asiento->asiento1_mes = intval( date('m') );
                $asiento->asiento1_dia = intval( date('d') );
                $asiento->asiento1_numero = $consecutive;
                $asiento->asiento1_folder = $folder->id;
                $asiento->asiento1_documento = $documento->id;
                $asiento->asiento1_beneficiario = $tercero->id;
                $asiento->asiento1_preguardado = false;
                $asiento->asiento1_usuario_elaboro = Auth::user()->id;
                $asiento->asiento1_fecha_elaboro = date('Y-m-d H:m:s');

                $cuentas = [];
                foreach ($excel as $row) {
                    // Asiento2
                    $arCuenta = [];
                    $arCuenta['Cuenta'] = intval($row->cuenta);
                    $arCuenta['Tercero'] = intval($row->beneficiario);
                    $arCuenta['Detalle'] = $row->detalle;
                    $arCuenta['Naturaleza'] = $row->debito != 0 ? 'D': 'C';
                    $arCuenta['CentroCosto'] = intval($row->centrocosto) > 0 ? intval($row->centrocosto) : '';
                    $arCuenta['Base'] = $row->base;
                    $arCuenta['Credito'] = $row->credito;
                    $arCuenta['Debito'] = $row->debito;
                    $arCuenta['Orden'] = '';
                    $cuentas[] = $arCuenta;
                }
                // Creo el objeto para manejar el asiento
                $asiento->asiento1_beneficiario = $tercero->tercero_nit;
                $objAsiento = new AsientoContableDocumento($asiento->toArray(), $asiento);
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
            }
            if ($documento->documento_nif) {
                $asientoNif = new AsientoNif;
                $consecutive++;

                // AsientoNif1
                $asientoNif->asienton1_ano = intval( date('Y') );
                $asientoNif->asienton1_mes = intval( date('m') );
                $asientoNif->asienton1_dia = intval( date('d') );
                $asientoNif->asienton1_numero = $consecutive;
                $asientoNif->asienton1_asiento =  isset($asiento->id) ? $asiento->id : null;
                $asientoNif->asienton1_folder = $folder->id;
                $asientoNif->asienton1_documento = $documento->id;
                $asientoNif->asienton1_beneficiario = $tercero->id;
                $asientoNif->asienton1_preguardado = false;
                $asientoNif->asienton1_usuario_elaboro = Auth::user()->id;
                $asientoNif->asienton1_fecha_elaboro = date('Y-m-d H:m:s');

                $cuentas = [];
                foreach ($excel as $row) {

                    // Recupero plancuenta
                    $plancuenta = Plancuenta::where('plancuentas_cuenta',intval($row->cuenta))->first();
                    if (!$plancuenta instanceof Plancuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "No es posible recuperar plan de cuenta, por favor verifique la información o consulte a su administrador"]);
                    }

                    $plancuentaNif = PlanCuentaNif::find($plancuenta->plancuentas_equivalente);
                    if (!$plancuentaNif instanceof PlanCuentaNif) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "No es posible encontrar plan de cuenta NIF, por favor verifique la información o consulte a su administrador"]);
                    }

                    // Asiento2
                    $arCuenta = [];
                    $arCuenta['Cuenta'] = $plancuentaNif->plancuentasn_cuenta;
                    $arCuenta['Tercero'] = intval($row->beneficiario);
                    $arCuenta['Detalle'] = $row->detalle;
                    $arCuenta['Naturaleza'] = $row->debito != 0 ? 'D': 'C';
                    $arCuenta['CentroCosto'] = intval($row->centrocosto) > 0 ? intval($row->centrocosto) : '';
                    $arCuenta['Base'] = $row->base;
                    $arCuenta['Credito'] = $row->credito;
                    $arCuenta['Debito'] = $row->debito;
                    $arCuenta['Orden'] = '';
                    $cuentas[] = $arCuenta;
                }

                // Creo el objeto para manejar el asiento
                $asientoNif->asienton1_beneficiario = $tercero->tercero_nit;
                $objAsiento = new AsientoNifContableDocumento($asientoNif->toArray(), $asientoNif);
                if($objAsiento->asientoNif_error) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => $objAsiento->asientoNif_error]);
                }

                // Preparar asiento
                $result = $objAsiento->asientoCuentas($cuentas);
                if($result != 'OK'){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => $result]);
                }

                // Insertar asiento
                $result = $objAsiento->insertarAsientoNif();
                if($result != 'OK') {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => $result]);
                }
            }
            // Save Consecutive
            $documento->documento_consecutivo = $consecutive;
            $documento->save();
            DB::commit();
            return response()->json(['success'=> true, 'msg'=> 'Se ha importado con exito los datos']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'errors' => trans('app.exception')]);
        }
    }
}
