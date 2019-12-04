<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Base\Contacto, App\Models\Base\Empresa, App\Models\Base\Bitacora;
use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Production\Ordenp3, App\Models\Production\Ordenp4, App\Models\Production\Ordenp5, App\Models\Production\Ordenp6, App\Models\Production\Ordenp8, App\Models\Production\Ordenp9, App\Models\Production\Ordenp10, App\Models\Production\Tiempop;
use App, View, DB, Log, Datatables, Storage;

class OrdenpController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,consultar');
        $this->middleware('ability:admin,crear', ['only' => ['create', 'store', 'cerrar', 'abrir']]);
        $this->middleware('ability:admin,opcional2', ['only' => ['completar', 'clonar']]);
        $this->middleware('ability:admin,opcional3', ['only' => ['abrir']]);
        $this->middleware('ability:admin,editar', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ordenp::query();
            $query->select('koi_ordenproduccion.id', 'orden_cotizacion', 'cotizacion1_precotizacion', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo, CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo, CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"), 'orden_numero', 'orden_ano', 'orden_fecha_elaboro as orden_fecha', 'orden_fecha_inicio', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_anulada', 'orden_abierta', 'orden_culminada',
                DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END),
                    ' (', orden_referencia ,')'
                    ) AS tercero_nombre"
                )
            );
            $query->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');
            $query->leftjoin('koi_cotizacion1', 'orden_cotizacion', '=', 'koi_cotizacion1.id');
            $query->leftjoin('koi_precotizacion1', 'cotizacion1_precotizacion', '=', 'koi_precotizacion1.id');

            $query->with(['detalle' => function ($producto) {
                $producto->select('orden2_orden', DB::raw('SUM(orden2_total_valor_unitario * orden2_cantidad) as total'))
                                ->groupBy('orden2_orden');
            }]);

            // Permisions mostrar botones crear [close, open]
            if (auth()->user()->ability('admin', 'crear', ['module' => 'ordenes'])) {
                $query->addSelect(DB::raw('TRUE as orden_create'));
            } else {
                $query->addSelect(DB::raw('FALSE as orden_create'));
            }

            if (auth()->user()->hasRole('admin')) {
                $query->addSelect(DB::raw('TRUE as admin'));
            } else {
                $query->addSelect(DB::raw('FALSE as admin'));
            }

            // Permisions mostrar botones opcional2 [complete, clone]
            if (auth()->user()->ability('admin', 'opcional2', ['module' => 'ordenes'])) {
                $query->addSelect(DB::raw('TRUE as orden_opcional'));
            } else {
                $query->addSelect(DB::raw('FALSE as orden_opcional'));
            }

            // Permisions mostrar botones opcional2 [complete, clone]
            if (auth()->user()->ability('admin', 'opcional3', ['module' => 'ordenes'])) {
                $query->addSelect(DB::raw('TRUE as orden_opcional3'));
            } else {
                $query->addSelect(DB::raw('FALSE as orden_opcional3'));
            }

            // Persistent data filter
            if ($request->has('persistent') && $request->persistent) {
                session(['searchordenp_ordenp_numero' => $request->has('orden_numero') ? $request->orden_numero : '']);
                session(['searchordenp_tercero' => $request->has('orden_tercero_nit') ? $request->orden_tercero_nit : '']);
                session(['searchordenp_tercero_nombre' => $request->has('orden_tercero_nombre') ? $request->orden_tercero_nombre : '']);
                session(['searchordenp_ordenp_estado' => $request->has('orden_estado') ? $request->orden_estado : '']);
                session(['searchordenp_ordenp_referencia' => $request->has('orden_referencia') ? $request->orden_referencia : '']);
                session(['searchordenp_ordenp_productop' => $request->has('orden_productop') ? $request->orden_productop : '']);
            }
            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Orden codigo
                    if ($request->has('orden_numero')) {
                        $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) LIKE '%{$request->orden_numero}%'");
                    }

                    // Ordenes a facturar
                    if ($request->has('factura') && $request->factura == 'true') {
                        $query->whereIn('koi_ordenproduccion.id', DB::table('koi_ordenproduccion2')->select('orden2_orden')->whereRaw('(orden2_cantidad - orden2_facturado) > 0'));
                    }

                    // Tercero nit
                    if ($request->has('orden_tercero_nit')) {
                        $query->where('tercero_nit', $request->orden_tercero_nit);
                    }

                    // Tercero id
                    if ($request->has('orden_cliente')) {
                        $query->where('orden_cliente', $request->orden_cliente);
                    }

                    // Estado
                    if ($request->has('orden_estado')) {
                        if ($request->orden_estado == 'A') {
                            $query->where('orden_abierta', true);
                        }

                        if ($request->orden_estado == 'C') {
                            $query->where('orden_abierta', false);
                            $query->where('orden_culminada', false);
                        }

                        if ($request->orden_estado == 'N') {
                            $query->where('orden_anulada', true);
                        }

                        if ($request->orden_estado == 'T') {
                            $query->where('orden_culminada', true);
                        }

                        if ($request->orden_estado == 'AT') {
                            $query->where('orden_abierta', true);
                            $query->orWhere('orden_culminada', true);
                            $query->where('orden_anulada', false);
                        }
                    }

                    // Referencia
                    if ($request->has('orden_referencia')) {
                        $query->whereRaw("orden_referencia LIKE '%{$request->orden_referencia}%'");
                    }

                    // Producto
                    if ($request->has('orden_productop')) {
                        $query->whereRaw("$request->orden_productop IN ( SELECT orden2_productop
                            FROM koi_ordenproduccion2 WHERE orden2_orden = koi_ordenproduccion.id) ");
                    }
                })
                ->make(true);
        }
        return view('production.ordenes.index', ['empresa' => parent::getPaginacion()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.ordenes.create');
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
            $orden = new Ordenp;
            if ($orden->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar empresa
                    $empresa = Empresa::getEmpresa();
                    if (!$empresa instanceof Empresa) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar empresa, por favor verifique la información o consulte al administrador.']);
                    }
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->orden_cliente)->first();
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }
                    // Validar contacto
                    $contacto = Contacto::find($request->orden_contacto);
                    if (!$contacto instanceof Contacto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar contacto, por favor verifique la información o consulte al administrador.']);
                    }
                    // Validar tercero contacto
                    if ($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor seleccione de nuevo el contacto o consulte al administrador.']);
                    }
                    // Actualizar telefono del contacto
                    if ($contacto->tcontacto_telefono != $request->tcontacto_telefono) {
                        $contacto->tcontacto_telefono = $request->tcontacto_telefono;
                        $contacto->save();
                    }

                    // Recuperar numero orden
                    $numero = DB::table('koi_ordenproduccion')->where('orden_ano', date('Y'))->max('orden_numero');
                    $numero = !is_integer(intval($numero)) ? 1 : ($numero + 1);

                    // Orden de produccion
                    $orden->fill($data);
                    $orden->fillBoolean($data);
                    $orden->orden_cliente = $tercero->id;
                    $orden->orden_ano = date('Y');
                    $orden->orden_numero = $numero;
                    $orden->orden_contacto = $contacto->id;
                    $orden->orden_iva = $empresa->empresa_iva;
                    $orden->orden_usuario_elaboro = auth()->user()->id;
                    $orden->orden_fecha_elaboro = date('Y-m-d H:i:s');
                    $orden->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $orden->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden->errors]);
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
        $orden = Ordenp::getOrden($id);
        if (!$orden instanceof Ordenp) {
            abort(404);
        }

        // If role is operario
        $orden->permission = auth()->user()->hasRole('operario');

        if ($request->ajax()) {
            return response()->json($orden);
        }

        if ($orden->orden_abierta && !$orden->orden_anulada && auth()->user()->ability('admin', 'editar', ['module' => 'ordenes']) ) {
            return redirect()->route('ordenes.edit', compact('orden'));
        }

        if (auth()->user()->hasRole('operario')) {
            $productos = Ordenp2::getOrdenesp2($orden->id);
            return view('production.ordenes.show_with_role', compact('orden', 'productos'));
        }
        return view('production.ordenes.show', compact('orden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orden = Ordenp::getOrden($id);
        if (!$orden instanceof Ordenp) {
            abort(404);
        }
        if (!$orden->orden_abierta || $orden->orden_anulada) {
            return redirect()->route('ordenes.show', compact('orden'));
        }
        return view('production.ordenes.create', compact('orden'));
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
            $orden = Ordenp::findOrFail($id);
            if ($orden->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->orden_cliente)->first();
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->orden_contacto);
                    if (!$contacto instanceof Contacto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar contacto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar tercero contacto
                    if ($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor seleccione de nuevo el contacto o consulte al administrador.']);
                    }

                    // Actualizar telefono del contacto
                    if ($contacto->tcontacto_telefono != $request->tcontacto_telefono) {
                        $contacto->tcontacto_telefono = $request->tcontacto_telefono;
                        $contacto->save();
                    }

                    // Traer datos originales
                    $original = $orden->getOriginal();

                    // Orden
                    $orden->fill($data);
                    $orden->fillBoolean($data);
                    $orden->orden_cliente = $tercero->id;
                    $orden->orden_contacto = $contacto->id;
                    // Traer modificaciones
                    $changes = $orden->getDirty();
                    // Guardar
                    $orden->save();

                    // Validar si vienen cambios
                    if ($changes) {
                        Bitacora::createBitacora($orden, $original, $changes, 'Orden', 'U');
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $orden->id, 'orden_iva' => $orden->orden_iva]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden->errors]);
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
     * Search orden.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if ($request->ajax()) {
            // Orden de produccion
            $query = Ordenp::query();
            $query->select('koi_ordenproduccion.id', 'orden_numero', 'orden_ano', DB::raw("CONCAT((CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        ) ELSE tercero_razonsocial END),
                ' (', orden_referencia ,')'
                ) AS tercero_nombre"));
            $query->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');

            // If exists codigo
            if ($request->has('orden_codigo')) {
                $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '$request->orden_codigo'");
            }

            // If exists estados
            if ($request->has('orden_estado')) {
                if ($request->orden_estado == 'A') {
                    $query->where('orden_abierta', true);
                }

                if ($request->orden_estado == 'C') {
                    $query->where('orden_abierta', false);
                    $query->where('orden_culminada', false);
                }

                if ($request->orden_estado == 'N') {
                    $query->where('orden_anulada', true);
                }

                if ($request->orden_estado == 'T') {
                    $query->where('orden_culminada', true);
                }

                if ($request->orden_estado == 'AT') {
                    $query->where('orden_abierta', true);
                    $query->where('orden_anulada', false);
                }
            }
            $ordenp = $query->first();

            if ($ordenp instanceof Ordenp) {
                return response()->json(['success' => true, 'tercero_nombre' => $ordenp->tercero_nombre, 'id' => $ordenp->id]);
            }
            return response()->json(['success' => false]);
        }
        abort(404);
    }

    /**
     * Abrir the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function abrir(Request $request, $id)
    {
        if ($request->ajax()) {
            $orden = Ordenp::findOrFail($id);
            DB::beginTransaction();
            try {
                // Orden
                $orden->orden_abierta = true;
                $orden->orden_culminada = false;
                $orden->save();

                // Actualizar Bitacora
                Bitacora::createBitacora($orden, [], "Se abrió la orden de producción", 'Orden', 'U');

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Orden reabierta con exito.']);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Cerrar the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cerrar(Request $request, $id)
    {
        if ($request->ajax()) {
            $orden = Ordenp::findOrFail($id);
            DB::beginTransaction();
            try {
                // Orden
                $orden->orden_abierta = false;
                $orden->orden_culminada = false;
                $orden->save();

                // Actualizar Bitacora
                Bitacora::createBitacora($orden, [], "Se cerro la orden de producción", 'Orden', 'U');

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Orden cerrada con exito.']);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Cerrar the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function completar(Request $request, $id)
    {
        if ($request->ajax()) {
            $orden = Ordenp::findOrFail($id);
            DB::beginTransaction();
            try {
                // Orden
                $orden->orden_culminada = true;
                $orden->orden_anulada = false;
                $orden->orden_abierta = false;
                $orden->save();

                // Actualizar Bitacora
                Bitacora::createBitacora($orden, [], "Se culmino la orden de producción", 'Orden', 'U');

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Culmino la orden de producción con exito.']);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($id)
    {
        $orden = Ordenp::getOrden($id);
        if (!$orden instanceof Ordenp){
            abort(404);
        }

        $detalle = Ordenp2::getOrdenesp2($orden->id);
        $title = sprintf('Orden de producción %s', $orden->orden_codigo);

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('production.ordenes.export',  compact('orden', 'detalle' ,'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'ordenp', $orden->id, date('Y_m_d'), date('H_i_s')));
    }

    /**
     * Clonar the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clonar(Request $request, $id)
    {
        if ($request->ajax()) {
            $orden = Ordenp::findOrFail($id);
            DB::beginTransaction();
            try {
                // Recuperar numero orden
                $numero = DB::table('koi_ordenproduccion')->where('orden_ano', date('Y'))->max('orden_numero');
                $numero = !is_integer(intval($numero)) ? 1 : ($numero + 1);

                // Orden
                $neworden = $orden->replicate();
                if ($orden->orden_culminada) {
                    $neworden->orden_abierta = false;
                    $neworden->orden_culminada = true;
                } else {
                    $neworden->orden_abierta = true;
                    $neworden->orden_culminada = false;
                }

                $neworden->orden_fecha_inicio = date('Y-m-d');
                $neworden->orden_anulada = false;
                $neworden->orden_ano = date('Y');
                $neworden->orden_numero = $numero;
                $neworden->orden_usuario_elaboro = auth()->user()->id;
                $neworden->orden_fecha_elaboro = date('Y-m-d H:i:s');
                $neworden->save();

                // Orden2
                $files = [];
                $productos = Ordenp2::where('orden2_orden', $orden->id)->orderBy('id', 'asc')->get();
                foreach ($productos as $orden2) {
                    $neworden2 = $orden2->replicate();
                    $neworden2->orden2_orden = $neworden->id;
                    $neworden2->orden2_saldo = $neworden2->orden2_cantidad;
                    $neworden2->orden2_facturado = 0;
                    $neworden2->orden2_entregado = 0;
                    $neworden2->orden2_usuario_elaboro = auth()->user()->id;
                    $neworden2->orden2_fecha_elaboro = date('Y-m-d H:i:s');
                    $neworden2->save();

                    // Maquinas
                    $maquinas = Ordenp3::where('orden3_orden2', $orden2->id)->get();
                    foreach ($maquinas as $orden3) {
                         $neworden3 = $orden3->replicate();
                         $neworden3->orden3_orden2 = $neworden2->id;
                         $neworden3->save();
                    }

                    // Acabados
                    $acabados = Ordenp5::where('orden5_orden2', $orden2->id)->get();
                    foreach ($acabados as $orden5) {
                        $neworden5 = $orden5->replicate();
                        $neworden5->orden5_orden2 = $neworden2->id;
                        $neworden5->save();
                    }

                    // Imagenes
                    $imagenes = Ordenp8::where('orden8_orden2', $orden2->id)->get();
                    foreach ($imagenes as $orden8) {
                        $neworden8 = $orden8->replicate();
                        $neworden8->orden8_orden2 = $neworden2->id;
                        $neworden8->orden8_usuario_elaboro = auth()->user()->id;
                        $neworden8->orden8_fh_elaboro = date('Y-m-d H:i:s');
                        $neworden8->save();

                        // Recuperar imagen y copiar
                        if (Storage::has("ordenes/orden_$orden2->orden2_orden/producto_$orden2->id/$orden8->orden8_archivo") ) {
                            $object = new \stdClass();
                            $object->copy = "ordenes/orden_$orden2->orden2_orden/producto_$orden2->id/$orden8->orden8_archivo";
                            $object->paste = "ordenes/orden_$neworden2->orden2_orden/producto_$neworden2->id/$neworden8->orden8_archivo";

                            $files[] = $object;
                        }
                    }

                    // Areasp
                    $areasp = Ordenp6::where('orden6_orden2', $orden2->id)->get();
                    foreach ($areasp as $orden6) {
                         $neworden6 = $orden6->replicate();
                         $neworden6->orden6_orden2 = $neworden2->id;
                         $neworden6->save();
                    }

                    // Materiales
                    $materiales = Ordenp4::where('orden4_orden2', $orden2->id)->get();
                    foreach ($materiales as $orden4) {
                         $neworden4 = $orden4->replicate();
                         $neworden4->orden4_orden2 = $neworden2->id;
                         $neworden4->save();
                    }

                    // Empaques
                    $empaques = Ordenp9::where('orden9_orden2', $orden2->id)->get();
                    foreach ($empaques as $orden9) {
                         $neworden9 = $orden9->replicate();
                         $neworden9->orden9_orden2 = $neworden2->id;
                         $neworden9->save();
                    }

                    // Transporte
                    $transporte = Ordenp10::where('orden10_orden2', $orden2->id)->get();
                    foreach ($transporte as $orden10) {
                         $neworden10 = $orden10->replicate();
                         $neworden10->orden10_orden2 = $neworden2->id;
                         $neworden10->save();
                    }
                }

                // Si todo esta bien
                if (count($files)) {
                    foreach ($files as $file) {
                        Storage::copy($file->copy, $file->paste);
                    }
                }

                // Actualizar Bitacora
                Bitacora::createBitacora($orden, [], "Se clono la orden de producción", 'Orden', 'U');

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $neworden->id, 'msg' => 'Orden clonada con exito.']);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * function charts ordenesp
     */
    public function charts(Request $request, $id)
    {
        if ($request->ajax()) {
            $ordenp = Ordenp::getOrden($id);
            if (!$ordenp instanceof Ordenp) {
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la orden']);
            }

            // Construir object con graficas
            $object = new \stdClass();
            $sentencia = "(
                    SELECT CONCAT(tercero_nombre1, ' ',tercero_apellido1) AS tercero_nombre, SUM(TIME_TO_SEC(TIMEDIFF(tiempop_hora_fin, tiempop_hora_inicio)))/3600 as tiempo_x_empleado
                    FROM koi_tiempop
                    INNER JOIN koi_tercero ON tiempop_tercero = koi_tercero.id
                    WHERE tiempop_ordenp = $ordenp->id
                    GROUP BY tercero_nombre)";
            $empleados = DB::select($sentencia);

            // Armar objecto para la grafica
            $chartempleado = new \stdClass();
            $chartempleado->labels = array_pluck($empleados, 'tercero_nombre');
            $chartempleado->data = array_pluck($empleados, 'tiempo_x_empleado');
            $object->chartempleado = $chartempleado;

            $sentencia = "(
                    SELECT areap_nombre, SUM(TIME_TO_SEC(TIMEDIFF(tiempop_hora_fin, tiempop_hora_inicio)))/3600 as tiempo_x_area
                    FROM koi_tiempop
                    INNER JOIN koi_areap ON tiempop_areap = koi_areap.id
                    WHERE tiempop_ordenp = $ordenp->id
                    GROUP BY areap_nombre)";
            $areasp = DB::select($sentencia);

            // Armar objecto para la grafica
            $chartareap = new \stdClass();
            $chartareap->labels = array_pluck($areasp, 'areap_nombre');
            $chartareap->data = array_pluck($areasp, 'tiempo_x_area');
            $object->chartareap = $chartareap;

            $sentencia = "
            SELECT areap_nombre, SUM(tiempo_x_areasp) as tiempo_areasp, SUM(tiempo_x_producto) as tiempo_producto
            FROM (
                SELECT (CASE WHEN orden6_areap THEN areap_nombre ELSE orden6_nombre END) AS areap_nombre, SUM(0) as tiempo_x_areasp, SUM(TIME_TO_SEC(orden6_tiempo))/3600 as tiempo_x_producto
                FROM koi_ordenproduccion6
                LEFT JOIN koi_areap ON orden6_areap = koi_areap.id
                INNER JOIN koi_ordenproduccion2 ON orden6_orden2 = koi_ordenproduccion2.id
                WHERE orden2_orden = $ordenp->id
                GROUP BY areap_nombre
            UNION
                SELECT areap_nombre, SUM(TIME_TO_SEC(TIMEDIFF(tiempop_hora_fin, tiempop_hora_inicio)))/3600 as tiempo_x_areasp, SUM(0) as tiempo_x_producto
                FROM koi_tiempop
                INNER JOIN koi_areap ON tiempop_areap = koi_areap.id
                WHERE tiempop_ordenp = $ordenp->id
                GROUP BY areap_nombre
            ) x
            GROUP BY areap_nombre";
            $ordenes = DB::select($sentencia);

            $chartcomparativa = new \stdClass();
            $chartcomparativa->labels = array_pluck($ordenes, 'areap_nombre');
            $chartcomparativa->tiempoproduction = array_pluck($ordenes, 'tiempo_areasp');
            $chartcomparativa->tiempocotizacion = array_pluck($ordenes, 'tiempo_producto');

            $object->chartcomparativa = $chartcomparativa;

            $tiempototal = Tiempop::select(DB::raw("SUM(TIME_TO_SEC(TIMEDIFF(tiempop_hora_fin, tiempop_hora_inicio))) as tiempo_total"))->where('tiempop_ordenp', $ordenp->id)->first();
            $hours = ($tiempototal->tiempo_total / 3600);
            $object->orden_codigo = $ordenp->orden_codigo;
            $object->tiempototal = $hours;

            // Chart productos
            $tprecio = $ttransporte = $tviaticos = $tmateriales = $tareas = $tempaques = $tvolumen = 0;
            $ordenesp2 = Ordenp2::where('orden2_orden', $ordenp->id)->get();
            foreach ($ordenesp2 as $ordenp2) {
                $tprecio += $precio = $ordenp2->orden2_precio_venta;
                $ttransporte += $transporte = round($ordenp2->orden2_transporte/$ordenp2->orden2_cantidad);
                $tviaticos += $viaticos = round($ordenp2->orden2_viaticos/$ordenp2->orden2_cantidad);

                $materiales = Ordenp4::where('orden4_orden2', $ordenp2->id)->sum('orden4_valor_total');
                $tmateriales += $materiales = ($materiales/$ordenp2->orden2_cantidad)/((100-$ordenp2->orden2_margen_materialp)/100);

                $tareas += $areas = Ordenp6::select(DB::raw("SUM(((SUBSTRING_INDEX(orden6_tiempo, ':', 1) + (SUBSTRING_INDEX(orden6_tiempo, ':', -1)/60)) * orden6_valor)/$ordenp2->orden2_cantidad) as total"))->where('orden6_orden2', $ordenp2->id)->value('total');

                $empaques = Ordenp9::where('orden9_orden2', $ordenp2->id)->sum('orden9_valor_total');
                $tempaques += $empaques = ($empaques/$ordenp2->orden2_cantidad)/((100-$ordenp2->orden2_margen_materialp)/100);

                $subtotal = $precio + $transporte + $viaticos + $materiales + round($areas) + $empaques;
                $tvolumen += $comision = ($subtotal/((100-$ordenp2->orden2_volumen)/100)) * (1-(((100-$ordenp2->orden2_volumen)/100)));
            }

            // Make object
            $chartproducto = new \stdClass();
            $chartproducto->labels = [
                'Precio', 'Transporte', 'Viáticos', 'Materiales de producción', 'Áreas de producción', 'Empaques de producción', 'Volumen'
            ];
            $chartproducto->data = [
                $tprecio, $ttransporte, $tviaticos, $tmateriales, $tareas, $tempaques, $tvolumen
            ];
            $object->chartproductos = $chartproducto;

            $object->success = true;
            return response()->json($object);
        }
        return response()->json(['success' => false]);
    }
}
