<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento, App\Classes\AsientoContableDocumentoDevolver;
use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\AsientoMovimiento, App\Models\Accounting\AsientoNif, App\Models\Accounting\AsientoNif2, App\Models\Accounting\PlanCuenta, App\Models\Accounting\PlanCuentaNif, App\Models\Base\Tercero, App\Models\Accounting\Documento, App\Models\Accounting\Folder, App\Models\Production\Ordenp, App\Models\Accounting\CentroCosto, App\Models\Base\Empresa, App\Models\Receivable\Factura1, App\Models\Treasury\Facturap;
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
            if ($request->has('persistent') && $request->persistent) {
                session(['search_tercero' => $request->has('asiento_tercero_nit') ? $request->asiento_tercero_nit : '']);
                session(['search_tercero_nombre' => $request->has('asiento_tercero_nombre') ? $request->asiento_tercero_nombre : '']);
                session(['search_documento' => $request->has('asiento_documento') ? $request->asiento_documento : '']);
                session(['search_numero' => $request->has('asiento_numero') ? $request->asiento_numero : '']);
                session(['search_fecha_asiento' => $request->has('asiento_fecha_asiento') ? $request->asiento_fecha_asiento : '']);
                session(['search_fecha_elaboro' => $request->has('asiento_fecha_elaboro') ? $request->asiento_fecha_elaboro : '']);
            }

            return Datatables::of($query)
                ->filter(function ($query) use ($request){
                    // Tercero nit
                    if ($request->has('asiento_numero')) {
                        $query->where('asiento1_numero', $request->asiento_numero);
                    }

                    // Tercero nit
                    if ($request->has('asiento_tercero_nit')) {
                        $query->where('tercero_nit', $request->asiento_tercero_nit);
                    }

                    // Documento
                    if ($request->has('asiento_documento')) {
                        $query->where('asiento1_documento', $request->asiento_documento);
                    }

                    // Fecha asiento
                    if ($request->has('asiento_fecha_asiento')) {
                        $query->where(DB::raw("CAST(CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) AS DATE)"), $request->asiento_fecha_asiento);
                    }

                    // Fecha elaboro
                    if ($request->has('asiento_fecha_elaboro')) {
                        $query->where(DB::raw("SUBSTRING_INDEX(asiento1_fecha_elaboro, ' ', 1)"), $request->asiento_fecha_elaboro);
                    }
                })
                ->make(true);
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
            $asientoNif = null;
            $asientoNif2 = null;
            if ($asiento->isValid($data)) {
                if ($asiento2->isValid($data)) {
                    DB::beginTransaction();
                    try {
                        // Recuperar tercero
                        $tercero = Tercero::where('tercero_nit', $request->asiento1_beneficiario)->first();
                        if (!$tercero instanceof Tercero) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        // Permitir solo un asiento preguardado por documento
                        $preguardado = Asiento::where('asiento1_preguardado', true)->where('asiento1_folder', $request->asiento1_folder)->where('asiento1_documento', $request->asiento1_documento)->first();
                        if ($preguardado instanceof Asiento) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'Existe un asiento preguardado para este documento, por favor terminarlo para poder generar uno nuevo.']);
                        }

                        // Recuerar documento
                        $documento = Documento::where('id', $request->asiento1_documento)->first();
                        if (!$documento instanceof Documento) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        if (!$documento->documento_nif && !$documento->documento_actual) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible realizar asiento, documento no tiene tipo de asiento, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        // Recuperar centro costo
                        $centrocosto = $ordenp = null;
                        if ($request->has('asiento2_centro')) {
                            $centrocosto = CentroCosto::find($request->asiento2_centro);
                            if (!$centrocosto instanceof CentroCosto) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro costo, por favor verifique la información del asiento o consulte al administrador.']);
                            }

                            if ($centrocosto->centrocosto_codigo == 'OP') {
                                // Validate orden
                                if ($request->has('asiento2_orden')) {
                                    $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->asiento2_orden}'")->first();
                                }

                                if (!$ordenp instanceof Ordenp) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => "No es posible recuperar orden de producción para centro de costo OP, por favor verifique la información del asiento o consulte al administrador."]);
                                }
                            }
                        }

                        if ($documento->documento_actual) {
                            // Asiento1
                            $asiento->fill($data);

                            // Consecutivo
                            if ($documento->documento_tipo_consecutivo == 'A') {
                                $asiento->asiento1_numero = $documento->documento_consecutivo + 1;
                            }

                            $asiento->asiento1_beneficiario = $tercero->id;
                            $asiento->asiento1_preguardado = true;
                            $asiento->asiento1_usuario_elaboro = auth()->user()->id;
                            $asiento->asiento1_fecha_elaboro = date('Y-m-d H:i:s');
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
                            if (!$result->success) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result->error]);
                            }

                            // Insertar movimiento asiento
                            $result = $asiento2->movimiento($request);
                            if (!$result->success) {
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
                            $asientoNif->asienton1_usuario_elaboro = auth()->user()->id;
                            $asientoNif->asienton1_fecha_elaboro = date('Y-m-d H:i:s');

                            // Consecutivo
                            if ($documento->documento_tipo_consecutivo == 'A'){
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
                            if (!$result->success) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result->error]);
                            }

                            if ($asientoNif->asienton1_asiento == null) {
                                // Insertar movimiento asiento
                                $result = $asientoNif2->movimiento($request, $plancuentaNif->plancuentasn_cuenta);
                                if (!$result->success) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => $result->error]);
                                }
                            }
                        }

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => (isset($asiento->id)) ? $asiento->id : '', 'nif' => (isset($asientoNif->id)) ? $asientoNif->id : '' ]);
                    } catch(\Exception $e) {
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
        if (!$asiento instanceof Asiento) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($asiento);
        }

        return view('accounting.asiento.show', compact('asiento'));
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
        if (!$asiento->asiento1_preguardado || $asiento->asiento1_documentos != NULL) {
            return redirect()->route('asientos.show', compact('asiento'));
        }
        return view('accounting.asiento.create', compact('asiento'));
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
                    // Preparar cuentas && Recupero items asiento 2
                    $query = Asiento2::query();
                    $query->select('koi_asiento2.*', 'plancuentas_cuenta', 'plancuentas_tipo', 'tercero_nit', DB::raw("(CASE WHEN asiento2_credito != 0 THEN 'C' ELSE 'D' END) as asiento2_naturaleza"));
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
                    if (!isset($cuentas) || $cuentas == null || !is_array($cuentas) || count($cuentas) == 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'Por favor ingrese detalle para el asiento contable.']);
                    }

                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($data, $asiento);
                    if ($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($cuentas);
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar asiento
                    $result = $objAsiento->insertarAsiento();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar movimientos asiento
                    foreach ($asiento2 as $item) {
                        if ($item->asiento2_nuevo) {
                            $result = $item->movimientos();
                            if ($result != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result]);
                            }

                            // Actualizar el estado de nuevo movmiento a falso
                            $item->asiento2_nuevo = false;
                            $item->save();
                        }
                    }

                    // Validar no cambio de documento
                    if ($asientoNif instanceof AsientoNif) {
                        if ($asiento->asiento1_documento != $request->asiento1_documento ) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'Documento no puede ser modificado']);
                        }

                        $query = AsientoNif2::query();
                        $query->select('koi_asienton2.*', 'plancuentasn_cuenta', 'plancuentasn_tipo', 'tercero_nit', DB::raw("(CASE WHEN asienton2_credito != 0 THEN 'C' ELSE 'D' END) as asienton2_naturaleza"));
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
                        if ($objAsiento->asientoNif_error) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $objAsiento->asientoNif_error]);
                        }

                        // Preparar asiento
                        $result = $objAsiento->asientoCuentas($cuentas);
                        if ($result != 'OK'){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }

                        // Insertar asiento
                        $result = $objAsiento->insertarAsientoNif();
                        if ($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asiento->id]);
                } catch(\Exception $e) {
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
     * Reverse the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reverse(Request $request, $id)
    {
        if ($request->ajax()) {
            $asiento = Asiento::find($id);
            if (!$asiento instanceof Asiento) {
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar el asiento.']);
            }

            if (!$asiento->asiento1_preguardado) {
                // Si no esta en preguardado revertir movimientos
                DB::beginTransaction();
                try {
                    $asiento->asiento1_preguardado = true;
                    $asiento->save();

                    // Preparar cuentas
                    $query = Asiento2::query();
                    $query->select('koi_asiento2.*', 'plancuentas_cuenta', 'plancuentas_tipo', 'tercero_nit', DB::raw("(CASE WHEN asiento2_credito != 0 THEN 'C' ELSE 'D' END) as asiento2_naturaleza"));
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

                    if ($cuentas) {
                        // Crear instancia del asiento documento devovler
                        $objAsiento = new AsientoContableDocumentoDevolver($asiento, $cuentas);
                        if ($objAsiento->asiento_error) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                        }

                        // Validar que se pueda devolver el inventario
                        $result = $objAsiento->revertirMovimientos();
                        if ($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                    }

                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asiento->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => true, 'id' => $asiento->id]);
        }
        abort(404);
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
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'asiento', $asiento->id, date('Y_m_d'), date('H_i_s')));
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
        if (!in_array($request->file->guessClientExtension(), ['xls', 'xlsx', 'csv'])) {
            return response()->json(['success' => false, 'errors' => "Por favor, seleccione un archivo con algunas de estas extensiones .xls .xlsx .csv"]);
        }

        DB::beginTransaction();
        try {
            // Individual
            if ($request->has('tercero')) {
                // Recuperar tercero
                $tercero = Tercero::where('tercero_nit', $request->tercero)->first();
                if (!$tercero instanceof Tercero) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => "No es posible recuperar beneficiario con nit $request->tercero, por favor verifique la información del asiento o consulte al administrador."]);
                }

                // Recuerar folder
                $folder = Folder::find($request->folder);
                if (!$folder instanceof Folder) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar folder, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Recuerar documento
                $documento = Documento::find($request->documento);
                if (!$documento instanceof Documento) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.']);
                }
                $consecutive = $documento->documento_consecutivo;

                // Uploaded file
                $cuentas = [];
                $excel = new \stdClass();
                $excel->success =  true;

                Excel::filter('chunk')->load($request->file->getRealPath())->chunk(250, function($results) use (&$excel, &$cuentas, $tercero) {
                    $headers = $results->getHeading();
                    $defaultHeaders = array_combine($headers, $headers);

                    $validator = \Validator::make($defaultHeaders, [
                        'cuenta' => 'required',
                        'centro_costo' => 'required',
                        'beneficiario' => 'required',
                        'debito' => 'required',
                        'credito' => 'required',
                        'base' => 'required',
                        'detalle' => 'required'
                    ]);

                    if ($validator->fails()) {
                        $validator->errors()->add('comment', 'Estos campos mencionados no estan presentes en el encabezado del archivo');
                        $excel->success = false;
                        $excel->msg = $validator->errors();
                        return;
                    }

                    foreach ($results as $row) {
                        // Asiento2
                        $arCuenta = [];
                        $arCuenta['Cuenta'] = intval($row->cuenta);
                        $arCuenta['Tercero'] = !intval($row->beneficiario) ? $tercero->tercero_nit : intval($row->beneficiario);
                        $arCuenta['Detalle'] = $row->detalle;
                        $arCuenta['Naturaleza'] = $row->debito != 0 ? 'D': 'C';
                        $arCuenta['CentroCosto'] = intval($row->centro_costo) > 0 ? intval($row->centro_costo) : '';
                        $arCuenta['Base'] = $row->base;
                        $arCuenta['Credito'] = $row->credito;
                        $arCuenta['Debito'] = $row->debito;
                        $arCuenta['Orden'] = '';
                        $cuentas[] = $arCuenta;
                    }
                }, false);

                if ($documento->documento_actual) {
                    $asiento = new Asiento;
                    $consecutive++;

                    // Encabezado por defecto
                    $asiento->asiento1_ano = $request->ano;
                    $asiento->asiento1_mes = $request->mes;
                    $asiento->asiento1_dia = $request->dia;
                    $asiento->asiento1_numero = $consecutive;
                    $asiento->asiento1_folder = $folder->id;
                    $asiento->asiento1_documento = $documento->id;
                    $asiento->asiento1_beneficiario = $tercero->id;
                    $asiento->asiento1_preguardado = false;
                    $asiento->asiento1_usuario_elaboro = auth()->user()->id;
                    $asiento->asiento1_fecha_elaboro = date('Y-m-d H:i:s');

                    // Creo el objeto para manejar el asiento
                    $asiento->asiento1_beneficiario = $tercero->tercero_nit;
                    $objAsiento = new AsientoContableDocumento($asiento->toArray(), $asiento, true);
                    if ($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($cuentas);
                    if ($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar asiento
                    $result = $objAsiento->insertarAsiento();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }
                }

                $documento->documento_consecutivo = $consecutive;
                $documento->save();
            } else {
                // Uploaded file
                $excel = new \stdClass();
                $excel->success =  true;

                Excel::filter('chunk')->load($request->file->getRealPath())->chunk(250, function($results) use (&$excel) {
                    $headers = $results->getHeading();
                    $defaultHeaders = array_combine($headers, $headers);

                    // Grupal
                    $validator = \Validator::make($defaultHeaders, [
                        'dia' => 'required',
                        'mes' => 'required',
                        'ano' => 'required',
                        'documento_beneficiario' => 'required',
                        'codigo_folder' => 'required',
                        'codigo_documento' => 'required',
                        'cuenta' => 'required',
                        'centro_costo' => 'required',
                        'beneficiario' => 'required',
                        'base' => 'required',
                        'debito' => 'required',
                        'credito' => 'required',
                        'detalle' => 'required'
                    ]);

                    if ($validator->fails()) {
                        $validator->errors()->add('comment', 'Estos campos mencionados no estan presentes en el encabezado del archivo');
                        $excel->success = false;
                        $excel->errors = $validator->errors();
                        return;
                    }


                    $lastRow = '';
                    $asientos = [];
                    foreach ($results as $key => $row) {
                        // Prepare data
                        if (!empty($row->dia)) {
                            // Recuperar tercero
                            $tercero = Tercero::where('tercero_nit', $row->documento_beneficiario)->first();
                            if (!$tercero instanceof Tercero) {
                                $excel->success = false;
                                $excel->errors = "No es posible recuperar beneficiario con nit {$row->documento_beneficiario}, por favor verifique la información del asiento o consulte al administrador.";
                                return;
                            }

                            // Recuerar folder
                            $folder = Folder::where('folder_codigo', $row->codigo_folder)->first();
                            if (!$folder instanceof Folder) {
                                $excel->success = false;
                                $excel->errors = 'No es posible recuperar folder, por favor verifique la información del asiento o consulte al administrador.';
                                return;
                            }

                            // Recuerar documento
                            $documento = Documento::where('documento_codigo', $row->codigo_documento)->first();
                            if (!$documento instanceof Documento) {
                                $excel->success = false;
                                $excel->errors = 'No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.';
                                return;
                            }

                            if (empty($row->numero_documento)) {
                                $consecutive = $documento->documento_consecutivo;
                                $consecutive += 1;
                            } else {
                                $consecutive = $row->numero_documento;
                            }

                            // Centro costo
                            if ($row->centro_costo) {
                                $centroCosto = CentroCosto::whereRaw("CONCAT(centrocosto_codigo,'-',centrocosto_centro) = '{$row->centro_costo}'")->first();
                                if (!$centroCosto instanceof CentroCosto) {
                                    $excel->success = false;
                                    $excel->errors = 'No es posible recuperar el centro de costo, por favor verifique la información del asiento o consulte al administrador.';
                                    return;
                                }
                            }

                            // Orden
                            if ($row->orden) {
                                $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$row->orden}'")->first();
                                if (!$ordenp instanceof Ordenp) {
                                    $excel->success = false;
                                    $excel->errors = 'No es posible recuperar la orden de produccion, por favor verifique la información del asiento o consulte al administrador.';
                                    return;
                                }
                            }

                            // Asiento
                            $objAsiento = new \stdClass;
                            $objAsiento->asiento1_ano = "$row->ano";
                            $objAsiento->asiento1_mes = "$row->mes";
                            $objAsiento->asiento1_dia = "$row->dia";
                            $objAsiento->asiento1_numero = $consecutive;
                            $objAsiento->asiento1_folder = $folder->id;
                            $objAsiento->asiento1_documento = $documento->id;
                            $objAsiento->asiento1_beneficiario = $tercero->tercero_nit;
                            $objAsiento->asiento1_detalle = "$row->descripcion_documento";
                            $objAsiento->asiento1_preguardado = false;
                            $objAsiento->asiento1_usuario_elaboro = auth()->user()->id;
                            $objAsiento->asiento1_fecha_elaboro = date('Y-m-d H:i:s');

                            // Cuentas
                            $objCuenta = [];
                            $objCuenta['Cuenta'] = $row->cuenta;
                            $objCuenta['Tercero'] = $row->beneficiario;
                            $objCuenta['Detalle'] = $row->detalle;
                            $objCuenta['Naturaleza'] = $row->debito != 0 ? 'D': 'C';
                            $objCuenta['CentroCosto'] = $row->centro_costo ? $centroCosto->id : '';
                            $objCuenta['Base'] = (double) $row->base;
                            $objCuenta['Credito'] = (double) $row->credito;
                            $objCuenta['Debito'] = (double) $row->debito;
                            $objCuenta['Orden'] = $row->orden ? $ordenp->id : '';

                            // Prepare
                            $objAsiento->cuentas[] = $objCuenta;

                            $asientos[$key] = $objAsiento;
                            $lastRow = $key;

                            if (empty($row->numero_documento)) {
                                $documento->documento_consecutivo = $consecutive;
                                $documento->save();
                            }
                        } else {
                            // Centro costo
                            if ($row->centro_costo) {
                                $centroCosto = CentroCosto::whereRaw("CONCAT(centrocosto_codigo,'-',centrocosto_centro) = '{$row->centro_costo}'")->first();
                                if (!$centroCosto instanceof CentroCosto) {
                                    $excel->success = false;
                                    $excel->errors = 'No es posible recuperar el centro de costo, por favor verifique la información del asiento o consulte al administrador.';
                                    return;
                                }
                            }

                            // Orden
                            if ($row->orden) {
                                $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$row->orden}'")->first();
                                if (!$ordenp instanceof Ordenp) {
                                    $excel->success = false;
                                    $excel->errors = 'No es posible recuperar la orden de produccion, por favor verifique la información del asiento o consulte al administrador.';
                                    return;
                                }
                            }

                            // Cuentas
                            $objCuenta = [];
                            $objCuenta['Cuenta'] = $row->cuenta;
                            $objCuenta['Tercero'] = $row->beneficiario;
                            $objCuenta['Detalle'] = $row->detalle;
                            $objCuenta['Naturaleza'] = $row->debito != 0 ? 'D': 'C';
                            $objCuenta['CentroCosto'] = $row->centro_costo ? $centroCosto->id : '';
                            $objCuenta['Base'] = (double) $row->base;
                            $objCuenta['Credito'] = (double) $row->credito;
                            $objCuenta['Debito'] = (double) $row->debito;
                            $objCuenta['Orden'] = $row->orden ? $ordenp->id : '';

                            $asientos[$lastRow]->cuentas[] = $objCuenta;
                        }
                    }

                    // Save asientos
                    foreach ($asientos as $asiento) {
                        $newAsiento = new Asiento;
                        $newAsiento->asiento1_ano = $asiento->asiento1_ano;
                        $newAsiento->asiento1_mes = $asiento->asiento1_mes;
                        $newAsiento->asiento1_dia = $asiento->asiento1_dia;
                        $newAsiento->asiento1_beneficiario = $asiento->asiento1_beneficiario;
                        $newAsiento->asiento1_numero = $asiento->asiento1_numero;
                        $newAsiento->asiento1_folder = $asiento->asiento1_folder;
                        $newAsiento->asiento1_documento = $asiento->asiento1_documento;
                        $newAsiento->asiento1_beneficiario = $asiento->asiento1_beneficiario;
                        $newAsiento->asiento1_detalle = $asiento->asiento1_detalle;
                        $newAsiento->asiento1_preguardado = $asiento->asiento1_preguardado;
                        $newAsiento->asiento1_usuario_elaboro = $asiento->asiento1_usuario_elaboro;
                        $newAsiento->asiento1_fecha_elaboro = $asiento->asiento1_fecha_elaboro;

                        // Creo el objeto para manejar el asiento
                        $objAsiento = new AsientoContableDocumento($newAsiento->toArray(), $newAsiento, true);
                        if ($objAsiento->asiento_error) {
                            $excel->success = false;
                            $excel->errors = $objAsiento->asiento_error;
                            return;
                        }

                        // Preparar asiento
                        $result = $objAsiento->asientoCuentas($asiento->cuentas);
                        if ($result != 'OK'){
                            $excel->success = false;
                            $excel->errors = $result;
                            return;
                        }

                        // Insertar asiento
                        $result = $objAsiento->insertarAsiento();
                        if ($result != 'OK') {
                            $excel->success = false;
                            $excel->errors = $result;
                            return;
                        }
                    }
                }, false);

                if (!$excel->success) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => $excel->errors]);
                }
            }

            DB::commit();
            return response()->json(['success'=> true, 'msg'=> 'Se ha importado con exito los datos']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'errors' => trans('app.exception')]);
        }
    }
}
