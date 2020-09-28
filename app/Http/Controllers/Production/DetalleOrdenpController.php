<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Base\Bitacora;
use App\Models\Inventory\Producto, App\Models\Inventory\ProductoHistorial;
use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Production\Ordenp3, App\Models\Production\Ordenp4, App\Models\Production\Ordenp5, App\Models\Production\Ordenp6, App\Models\Production\Ordenp8, App\Models\Production\Ordenp9, App\Models\Production\Ordenp10, App\Models\Production\PreCotizacion2, App\Models\Production\Cotizacion2, App\Models\Production\Productop, App\Models\Production\Productop4, App\Models\Production\Productop5, App\Models\Production\Productop6, App\Models\Production\Despachop2, App\Models\Production\Areap, App\Models\Production\Materialp;
use DB, Log, Datatables, Storage;

class DetalleOrdenpController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,consultar', ['only' => ['index', 'show']]);
        $this->middleware('ability:admin,crear|editar', ['only' => ['create', 'store']]);
        $this->middleware('ability:admin,editar', ['only' => ['edit', 'update']]);
        $this->middleware('ability:admin,eliminar', ['only' => 'destroy']);
        $this->middleware('ability:admin,clonar', ['only' => 'clonar']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('orden2_orden')) {
                $data = Ordenp2::getOrdenesp2($request->orden2_orden);
            }
            return response()->json($data);
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Recuperar orden
        $orden = $request->has('ordenp') ? Ordenp::getOrden($request->ordenp) : null;
        if (!$orden instanceof Ordenp) {
            abort(404);
        }

        // Recuperar producto
        $producto = $request->has('productop') ? Productop::getProduct($request->productop) : null;
        if (!$producto instanceof Productop) {
            abort(404);
        }

        // Lazy Eager Loading
        $orden->load(['vendedor' => function ($q) {
            $q->select('id', 'tercero_comision');
        }]);

        $producto->load('tips');

        if (!$orden->orden_abierta || $orden->orden_anulada) {
            return redirect()->route('ordenes.show', compact('orden'));
        }
        return view('production.ordenes.productos.create', compact('orden', 'producto'));
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

            $data['materialesp'] = json_decode($data['materialesp']);
            $data['areasp'] = json_decode($data['areasp']);
            $data['empaques'] = json_decode($data['empaques']);
            $data['transportes'] = json_decode($data['transportes']);

            $orden2 = new Ordenp2;
            if ($orden2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $producto = Productop::find($request->orden2_productop);
                    if (!$producto instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar orden
                    $orden = Ordenp::find($request->orden2_orden);
                    if (!$orden instanceof Ordenp) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden, por favor verifique la información o consulte al administrador.']);
                    }

                    // Orden2
                    $orden2->fill($data);
                    $orden2->fillBoolean($data);
                    $orden2->orden2_productop = $producto->id;
                    $orden2->orden2_orden = $orden->id;
                    $orden2->orden2_cantidad = $request->orden2_cantidad;
                    $orden2->orden2_saldo = $orden2->orden2_cantidad;
                    $orden2->orden2_usuario_elaboro = auth()->user()->id;
                    $orden2->orden2_fecha_elaboro = date('Y-m-d H:i:s');
                    $orden2->save();

                    // Maquinas
                    $maquinas = Ordenp3::getOrdenesp3($orden2->orden2_productop, $orden2->id);
                    foreach ($maquinas as $maquina) {
                        if ($request->has("orden3_maquinap_$maquina->id")) {
                            $orden3 = new Ordenp3;
                            $orden3->orden3_orden2 = $orden2->id;
                            $orden3->orden3_maquinap = $maquina->id;
                            $orden3->save();
                        }
                    }

                    // Acabados
                    $acabados = Ordenp5::getOrdenesp5($orden2->orden2_productop, $orden2->id);
                    foreach ($acabados as $acabado) {
                        if ($request->has("orden5_acabadop_$acabado->id")) {
                            $orden5 = new Ordenp5;
                            $orden5->orden5_orden2 = $orden2->id;
                            $orden5->orden5_acabadop = $acabado->id;
                            $orden5->save();
                        }
                    }

                    // Recuperar imagenes y almacenar en storage/app/cotizacines
                    $files = [];
                    $images = isset( $data['imagenes'] ) ? $data['imagenes'] : [];
                    foreach ($images as $key => $image) {
                        // Recovery name
                        $name = str_random(4)."_{$image->getClientOriginalName()}";

                        // Insertar imagen
                        $imagen = new Ordenp8;
                        $imagen->orden8_archivo = $name;
                        $imagen->orden8_orden2 = $orden2->id;
                        $imagen->orden8_fh_elaboro = date('Y-m-d H:i:s');
                        $imagen->orden8_usuario_elaboro = auth()->user()->id;
                        $imagen->save();

                        // Crear objecto para mantener la imagen para guardar cuando se complete la transaccion, de lo contrario guardara la imagen asi no se complete la transaccion
                        $object = new \stdClass();
                        $object->route = "ordenes/orden_$orden2->orden2_orden/producto_$orden2->id/$name";
                        $object->file = file_get_contents($image->getRealPath());

                        $files[] = $object;
                    }

                    // Materialesp
                    $totalmaterialesp = $totalareasp = $totalempaques = $totaltransportes = 0;
                    $materiales = isset($data['materialesp']) ? $data['materialesp'] : null;
                    foreach ($materiales as $material) {
                        $materialp = Materialp::find($material->orden4_materialp);
                        if (!$materialp instanceof Materialp) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        $producto = Producto::find($material->orden4_producto);
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del material, por favor verifique la información o consulte al administrador.']);
                        }

                        // Guardar individual porque sale error por ser objeto decodificado
                        $orden4 = new Ordenp4;
                        $orden4->orden4_orden2 = $orden2->id;
                        $orden4->orden4_materialp = $materialp->id;
                        $orden4->orden4_producto = $producto->id;
                        $orden4->orden4_medidas = $material->orden4_medidas;
                        $orden4->orden4_cantidad = $material->orden4_cantidad;
                        $orden4->orden4_valor_unitario = $material->orden4_valor_unitario;
                        $orden4->orden4_valor_total = $material->orden4_valor_total;
                        $orden4->orden4_fh_elaboro = date('Y-m-d H:i:s');
                        $orden4->orden4_usuario_elaboro = auth()->user()->id;
                        $orden4->save();

                        // Historial
                        $historial = new ProductoHistorial;
                        $historial->productohistorial_tipo = 'M';
                        $historial->productohistorial_modulo = 'O';
                        $historial->productohistorial_producto = $orden4->orden4_producto;
                        $historial->productohistorial_valor = $orden4->orden4_valor_unitario;
                        $historial->productohistorial_fh_elaboro = $orden4->orden4_fh_elaboro;
                        $historial->save();

                        // Actualizar producto
                        $producto->producto_precio = $orden4->orden4_valor_unitario;
                        $producto->save();

                        $totalmaterialesp += round($orden4->orden4_valor_total);
                    }

                    // Areap
                    $areasp = isset($data['areasp']) ? $data['areasp'] : null;
                    foreach ($areasp as $areap) {
                        $orden6 = new Ordenp6;
                        $orden6->orden6_valor = $areap->orden6_valor;
                        if (!empty($areap->orden6_areap)) {
                            $orden6->orden6_areap = $areap->orden6_areap;
                        } else {
                            $orden6->orden6_nombre = $areap->orden6_nombre;
                        }
                        $orden6->orden6_tiempo = "{$areap->orden6_horas}:{$areap->orden6_minutos}";
                        $orden6->orden6_orden2 = $orden2->id;
                        $orden6->save();

                        $tiempo = intval($areap->orden6_horas) + (intval($areap->orden6_minutos) / 60);
                        $totalareasp += round($orden6->orden6_valor * $tiempo);
                    }

                    // Empaques
                    $empaques = isset($data['empaques']) ? $data['empaques'] : null;
                    foreach ($empaques as $empaque) {
                        $materialp = Materialp::find($empaque->orden9_materialp);
                        if (!$materialp instanceof Materialp) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        $producto = Producto::find($empaque->orden9_producto);
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del empaque, por favor verifique la información o consulte al administrador.']);
                        }

                        // Guardar individual porque sale error por ser objeto decodificado
                        $orden9 = new Ordenp9;
                        $orden9->orden9_orden2 = $orden2->id;
                        $orden9->orden9_producto = $producto->id;
                        $orden9->orden9_materialp = $materialp->id;
                        $orden9->orden9_medidas = $empaque->orden9_medidas;
                        $orden9->orden9_cantidad = $empaque->orden9_cantidad;
                        $orden9->orden9_valor_unitario = $empaque->orden9_valor_unitario;
                        $orden9->orden9_valor_total = $empaque->orden9_valor_total;
                        $orden9->orden9_fh_elaboro = date('Y-m-d H:i:s');
                        $orden9->orden9_usuario_elaboro = auth()->user()->id;
                        $orden9->save();

                        // Historial
                        $historial = new ProductoHistorial;
                        $historial->productohistorial_tipo = 'E';
                        $historial->productohistorial_modulo = 'O';
                        $historial->productohistorial_producto = $orden9->orden9_producto;
                        $historial->productohistorial_valor = $orden9->orden9_valor_unitario;
                        $historial->productohistorial_fh_elaboro = $orden9->orden9_fh_elaboro;
                        $historial->save();

                        // Actualizar producto
                        $producto->producto_precio = $orden9->orden9_valor_unitario;
                        $producto->save();

                        $totalempaques += round($orden9->orden9_valor_total);
                    }

                    // Transportes
                    $transportes = isset($data['transportes']) ? $data['transportes'] : null;
                    foreach ($transportes as $transporte) {
                        $orden10 = new Ordenp10;
                        $orden10->orden10_orden2 = $orden2->id;
                        if (!empty($transporte->orden10_transporte)) {
                            $orden10->orden10_transporte = $transporte->orden10_transporte;
                        } else {
                            $orden10->orden10_nombre = $transporte->orden10_nombre;
                        }
                        $orden10->orden10_tiempo = $transporte->orden10_tiempo;
                        $orden10->orden10_valor_unitario = $transporte->orden10_valor_unitario;
                        $orden10->orden10_valor_total = $transporte->orden10_valor_total;
                        $orden10->orden10_fh_elaboro = date('Y-m-d H:i:s');
                        $orden10->orden10_usuario_elaboro = auth()->user()->id;
                        $orden10->save();

                        $totaltransportes += round($orden10->orden10_valor_total);
                    }

                    // Operacion para calcular el total del producto
                    $precio = $orden2->orden2_precio_venta;
                    $viaticos = round($orden2->orden2_viaticos / $orden2->orden2_cantidad);
                    $materiales = round($totalmaterialesp / $orden2->orden2_cantidad) / ((100 - $orden2->orden2_margen_materialp) / 100);
                    $areas = round($totalareasp / $orden2->orden2_cantidad) / ((100 - $orden2->orden2_margen_areap) / 100);
                    $empaques = round($totalempaques / $orden2->orden2_cantidad) / ((100 - $orden2->orden2_margen_empaque) / 100);
                    $transportes = round($totaltransportes / $orden2->orden2_cantidad) / ((100 - $orden2->orden2_margen_transporte) / 100);
                    $subtotal = $precio + $viaticos + $materiales + $areas + $empaques + $transportes;
                    $porcentajedescuento = $subtotal * ($orden2->orden2_descuento / 100);
                    $totaldescuento = $subtotal - $porcentajedescuento;
                    $totalcomision = $totaldescuento / ((100 - $orden2->orden2_comision) / 100);
                    $subtotal = $totalcomision;
                    $volumen = ($subtotal / ((100 - $orden2->orden2_volumen) / 100)) * (1 - (((100 - $orden2->orden2_volumen) / 100)));
                    $total = round(($subtotal + $volumen), $orden2->orden2_round);

                    // Actualizar valores
                    $orden2->orden2_vtotal = $volumen;
                    $orden2->orden2_total_valor_unitario = $total;
                    $orden2->save();

                    // Guardar imagenes si todo sale bien
                    if (count($files)) {
                        foreach ($files as $file) {
                            Storage::put($file->route, $file->file);
                        }
                    }

                    // Actualizar Bitacora
                    Bitacora::createBitacora($orden, [], "Código: {$orden2->id}\r\nReferencia: {$orden2->orden2_referencia}\r\nCantidad: {$orden2->orden2_saldo}", 'Productos', 'C', $request->ip());

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id_orden' => $orden->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden2->errors]);
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
        // Recuperar orden2
        $ordenp2 = Ordenp2::getOrdenp2($id);
        if (!$ordenp2 instanceof Ordenp2) {
            abort(404);
        }

        // Validate users 312->N, 756->D
        if (in_array(auth()->user()->id, [312, 756])) {
            $ordenp2->continue = true;
        }

        // Recuperar producto
        $producto = Productop::getProduct($ordenp2->orden2_productop);
        if (!$producto instanceof Productop) {
            abort(404);
        }

        // Lazy Eager Loading
        $producto->load('tips');
        $ordenp2->producto = $producto;

        if ($request->ajax()) {
            $ordenp2->archivos = auth()->user()->ability('admin', 'archivos', ['module' => 'ordenes']);

            return response()->json($ordenp2);
        }

        // Recuperar orden
        $orden = Ordenp::getOrden($ordenp2->orden2_orden);
        if (!$orden instanceof Ordenp) {
            abort(404);
        }

        // Validar orden
        if ($orden->orden_abierta == true && auth()->user()->ability('admin', 'editar', ['module' => 'ordenes'])) {
            return redirect()->route('ordenes.productos.edit', ['productos' => $ordenp2->id]);
        }
        return view('production.ordenes.productos.show', compact('orden', 'producto', 'ordenp2'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Recuperar orden2
        $ordenp2 = Ordenp2::findOrFail($id);

        // Recuperar orden
        $orden = Ordenp::getOrden($ordenp2->orden2_orden);
        if (!$orden instanceof Ordenp) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct($ordenp2->orden2_productop);
        if (!$producto instanceof Productop) {
            abort(404);
        }

        // Lazy Eager Loading
        $producto->load('tips');

        // Validar orden
        if (!$orden->orden_abierta) {
            return redirect()->route('ordenes.productos.show', ['productos' => $ordenp2->id]);
        }
        return view('production.ordenes.productos.create', compact('orden', 'producto', 'ordenp2'));
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

            // Recuperar orden2
            $orden2 = Ordenp2::findOrFail($id);

            // Recuperar orden
            $orden = Ordenp::findOrFail($orden2->orden2_orden);
            if ($orden->orden_abierta) {
                if ($orden2->isValid($data)) {
                    DB::beginTransaction();
                    try {
                        // Validar despachos
                        $query = Despachop2::query();
                        $query->select(DB::raw('COALESCE(sum(despachop2_cantidad),0) as despachadas'));
                        $query->join('koi_despachop1', 'despachop2_despacho', '=', 'koi_despachop1.id');
                        $query->where('despachop2_orden2', $orden2->id);
                        $query->where('despachop1_anulado', false);
                        $despacho = $query->first();

                        if ($request->orden2_cantidad < $despacho->despachadas) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => "No es posible actualizar unidades, cantidad mínima despachos ($despacho->despachadas), por favor verifique la información o consulte al administrador."]);
                        }

                        // Traer datos originales
                        $original = $orden2->getOriginal();

                        // Orden2
                        $orden2->fill($data);
                        $orden2->fillBoolean($data);
                        $orden2->orden2_cantidad = $request->orden2_cantidad;
                        $orden2->orden2_saldo = $orden2->orden2_cantidad - $despacho->despachadas;
                        // Cambios
                        $changes = $orden2->getDirty();
                        // Guardar
                        $orden2->save();

                        // Maquinas
                        $maquinas = Ordenp3::getOrdenesp3($orden2->orden2_productop, $orden2->id);
                        foreach ($maquinas as $maquina) {
                            $orden3 = Ordenp3::where('orden3_orden2', $orden2->id)->where('orden3_maquinap', $maquina->id)->first();
                            if ($request->has("orden3_maquinap_$maquina->id")) {
                                if (!$orden3 instanceof Ordenp3) {
                                    $orden3 = new Ordenp3;
                                    $orden3->orden3_orden2 = $orden2->id;
                                    $orden3->orden3_maquinap = $maquina->id;
                                    $orden3->save();
                                }
                            } else {
                                if ($orden3 instanceof Ordenp3) {
                                    $orden3->delete();
                                }
                            }
                        }

                        // Acabados
                        $acabados = Ordenp5::getOrdenesp5($orden2->orden2_productop, $orden2->id);
                        foreach ($acabados as $acabado) {
                            $orden5 = Ordenp5::where('orden5_orden2', $orden2->id)->where('orden5_acabadop', $acabado->id)->first();
                            if ($request->has("orden5_acabadop_$acabado->id")) {
                                if (!$orden5 instanceof Ordenp5) {
                                    $orden5 = new Ordenp5;
                                    $orden5->orden5_orden2 = $orden2->id;
                                    $orden5->orden5_acabadop = $acabado->id;
                                    $orden5->save();
                                }
                            } else {
                                if ($orden5 instanceof Ordenp5) {
                                    $orden5->delete();
                                }
                            }
                        }

                        // Materiales
                        $keys = [];
                        $totalmaterialesp = $totalareasp = $totalempaques = $totaltransportes = 0;
                        $materiales = isset($data['materialesp']) ? $data['materialesp'] : null;
                        foreach ($materiales as $material) {
                            $orden4 = Ordenp4::find( is_numeric($material['id']) ? $material['id'] : null);
                            if (!$orden4 instanceof Ordenp4) {
                                $materialp = Materialp::find($material['orden4_materialp']);
                                if (!$materialp instanceof Materialp) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                                }

                                $insumo = Producto::find($material['orden4_producto']);
                                if (!$insumo instanceof Producto) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del material, por favor verifique la información o consulte al administrador.']);
                                }

                                $orden4 = new Ordenp4;
                                $orden4->fill($material);
                                $orden4->orden4_producto = $insumo->id;
                                $orden4->orden4_orden2 = $orden2->id;
                                $orden4->orden4_materialp = $materialp->id;
                                $orden4->orden4_fh_elaboro = date('Y-m-d H:i:s');
                                $orden4->orden4_usuario_elaboro = auth()->user()->id;
                                $orden4->save();
                            } else {
                                $orden4->fill($material);
                                $orden4->save();
                            }

                            // asociar id a un array para validar
                            $keys[] = $orden4->id;
                            $totalmaterialesp += round($orden4->orden4_valor_total);
                        }

                        // Remover registros que no existan
                        $deletemateriales = Ordenp4::whereNotIn('id', $keys)->where('orden4_orden2', $orden2->id)->delete();

                        // Areasp
                        $keys = [];
                        $areasp = isset($data['areasp']) ? $data['areasp'] : [];
                        foreach ($areasp as $areap) {
                            $orden6 = Ordenp6::find( is_numeric($areap['id']) ? $areap['id'] : null);
                            if (!$orden6 instanceof Ordenp6) {
                                $orden6 = new Ordenp6;
                                $orden6->fill($areap);
                                if (!empty($areap['orden6_areap'])) {
                                    $orden6->orden6_areap = $areap['orden6_areap'];
                                } else {
                                    $orden6->orden6_nombre = $areap['orden6_nombre'];
                                }
                                $orden6->orden6_tiempo = "{$areap['orden6_horas']}:{$areap['orden6_minutos']}";
                                $orden6->orden6_orden2 = $orden2->id;
                                $orden6->save();
                            } else {
                                $orden6->orden6_tiempo = "{$areap['orden6_horas']}:{$areap['orden6_minutos']}";
                                $orden6->save();
                            }

                            $keys[] = $orden6->id;
                            $tiempo = intval($areap['orden6_horas']) + (intval($areap['orden6_minutos']) / 60);
                            $totalareasp += round($orden6->orden6_valor * $tiempo);
                        }

                        // Remover registros que no existan
                        $deleteareasp = Ordenp6::whereNotIn('id', $keys)->where('orden6_orden2', $orden2->id)->delete();

                        // Empaques
                        $keys = [];
                        $empaques = isset($data['empaques']) ? $data['empaques'] : [];
                        foreach ($empaques as $empaque) {
                            $orden9 = Ordenp9::find( is_numeric($empaque['id']) ? $empaque['id'] : null);
                            if (!$orden9 instanceof Ordenp9) {
                                $materialp = Materialp::find($empaque['orden9_materialp']);
                                if (!$materialp instanceof Materialp) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                                }

                                $producto = Producto::find($empaque['orden9_producto']);
                                if (!$producto instanceof Producto) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del empaque, por favor verifique la información o consulte al administrador.']);
                                }

                                $orden9 = new Ordenp9;
                                $orden9->fill($empaque);
                                $orden9->orden9_producto = $producto->id;
                                $orden9->orden9_materialp = $materialp->id;
                                $orden9->orden9_orden2 = $orden2->id;
                                $orden9->orden9_fh_elaboro = date('Y-m-d H:i:s');
                                $orden9->orden9_usuario_elaboro = auth()->user()->id;
                                $orden9->save();
                            } else {
                                $orden9->fill($empaque);
                                $orden9->save();
                            }

                            // asociar id a un array para validar
                            $keys[] = $orden9->id;
                            $totalempaques += round($orden9->orden9_valor_total);
                        }

                        // Remover registros que no existan
                        $deleteempaques = Ordenp9::whereNotIn('id', $keys)->where('orden9_orden2', $orden2->id)->delete();


                        // Transportes
                        $keys = [];
                        $transportes = isset($data['transportes']) ? $data['transportes'] : [];
                        foreach ($transportes as $transporte) {
                            if (isset($transporte['success'])) {
                                $orden10 = new Ordenp10;
                                $orden10->fill($transporte);
                                $orden10->orden10_orden2 = $orden2->id;
                                $orden10->orden10_fh_elaboro = date('Y-m-d H:i:s');
                                $orden10->orden10_usuario_elaboro = auth()->user()->id;
                                $orden10->save();
                            } else {
                                $orden10 = Ordenp10::find($transporte['id']);
                                if ($orden10 instanceof Ordenp10) {
                                    $orden10->fill($transporte);
                                    $orden10->save();
                                }
                            }

                            $keys[] = $orden10->id;
                            $totaltransportes += round($orden10->orden10_valor_total);
                        }

                        // Remover registros que no existan
                        $deletetransportes = Ordenp10::whereNotIn('id', $keys)->where('orden10_orden2', $orden2->id)->delete();


                        // Operacion para recalcular el total del producto
                        $precio = $orden2->orden2_precio_venta;
                        $viaticos = round($orden2->orden2_viaticos / $orden2->orden2_cantidad);
                        $materiales = round($totalmaterialesp / $orden2->orden2_cantidad) / ((100 - $orden2->orden2_margen_materialp) / 100);
                        $areas = round($totalareasp / $orden2->orden2_cantidad) / ((100 - $orden2->orden2_margen_areap) / 100);
                        $empaques = round($totalempaques / $orden2->orden2_cantidad) / ((100 - $orden2->orden2_margen_empaque) / 100);
                        $transportes = round($totaltransportes / $orden2->orden2_cantidad) / ((100 - $orden2->orden2_margen_transporte) / 100);
                        $subtotal = $precio + $viaticos + $materiales + $areas + $empaques + $transportes;
                        $porcentajedescuento = $subtotal * ($orden2->orden2_descuento / 100);
                        $totaldescuento = $subtotal - $porcentajedescuento;
                        $totalcomision = $totaldescuento / ((100 - $orden2->orden2_comision) / 100);
                        $subtotal = $totalcomision;
                        $volumen = ($subtotal / ((100 - $orden2->orden2_volumen) / 100)) * (1 - (((100 - $orden2->orden2_volumen) / 100)));
                        $total = round(($subtotal + $volumen), $orden2->orden2_round);

                        // Actualizar valores
                        $orden2->orden2_vtotal = $volumen;
                        $orden2->orden2_total_valor_unitario = $total;
                        $orden2->save();

                        // Si hay cambios en la ordenp
                        if ($changes) {
                            Bitacora::createBitacora($orden, $original, $changes, 'Productos', 'U', $request->ip());
                        }

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => $orden2->id, 'id_orden' => $orden->id]);
                    } catch(\Exception $e) {
                        DB::rollback();
                        Log::error($e->getMessage());
                        return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                    }
                }
                return response()->json(['success' => false, 'errors' => $orden2->errors]);
            }
            abort(403);
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $orden2 = Ordenp2::find($id);
                if (!$orden2 instanceof Ordenp2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar detalle orden, por favor verifique la información o consulte al administrador.']);
                }

                $orden = Ordenp::find($orden2->orden2_orden);
                if (!$orden instanceof Ordenp) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden, por favor verifique la información o consulte al administrador.']);
                }

                // Validar despachos
                $despacho = Despachop2::where('despachop2_orden2', $orden2->id)->first();
                if ($despacho instanceof Despachop2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible eliminar producto, contiene despachos asociados, por favor verifique la información o consulte al administrador.']);
                }

                // Maquinas
                DB::table('koi_ordenproduccion3')->where('orden3_orden2', $orden2->id)->delete();

                // Materiales
                DB::table('koi_ordenproduccion4')->where('orden4_orden2', $orden2->id)->delete();

                // Acabados
                DB::table('koi_ordenproduccion5')->where('orden5_orden2', $orden2->id)->delete();

                // Areasp
                DB::table('koi_ordenproduccion6')->where('orden6_orden2', $orden2->id)->delete();

                // Imagenes
                DB::table('koi_ordenproduccion8')->where('orden8_orden2', $orden2->id)->delete();

                // Empaques
                DB::table('koi_ordenproduccion9')->where('orden9_orden2', $orden2->id)->delete();

                // Transportes
                DB::table('koi_ordenproduccion10')->where('orden10_orden2', $orden2->id)->delete();

                // Si hay cambios en la cotizacion
                Bitacora::createBitacora($orden, [], "Código: {$orden2->id}\r\nReferencia: {$orden2->orden2_referencia}\r\nCantidad: {$orden2->orden2_saldo}", 'Productos', 'D', $request->ip());

                // Eliminar item orden2
                $orden2->delete();

                if (Storage::has("ordenes/orden_{$orden2->orden2_orden}/producto_{$orden2->id}")) {
                    Storage::deleteDirectory("ordenes/orden_{$orden2->orden2_orden}/producto_{$orden2->id}");
                }

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'DetalleOrdenpController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
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
            $orden2 = Ordenp2::findOrFail($id);
            $orden = Ordenp::findOrFail($orden2->orden2_orden);
            DB::beginTransaction();
            try {
                $neworden2 = $orden2->replicate();
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
                $files = [];
                $images = Ordenp8::where('orden8_orden2', $orden2->id)->get();
                foreach ($images as $orden8) {
                     $neworden8 = $orden8->replicate();
                     $neworden8->orden8_orden2 = $neworden2->id;
                     $neworden8->orden8_usuario_elaboro = auth()->user()->id;
                     $neworden8->orden8_fh_elaboro = date('Y-m-d H:i:s');
                     $neworden8->save();

                     if (Storage::has("ordenes/orden_{$orden2->orden2_orden}/producto_{$orden2->id}/{$orden8->orden8_archivo}")) {
                         $object = new \stdClass();
                         $object->copy = "ordenes/orden_{$orden2->orden2_orden}/producto_{$orden2->id}/{$orden8->orden8_archivo}";
                         $object->paste = "ordenes/orden_{$neworden2->orden2_orden}/producto_{$neworden2->id}/{$neworden8->orden8_archivo}";

                         $files[] = $object;
                     }
                }

                // Materiales
                $materiales = Ordenp4::where('orden4_orden2', $orden2->id)->get();
                foreach ($materiales as $orden4) {
                     $neworden4 = $orden4->replicate();
                     $neworden4->orden4_orden2 = $neworden2->id;
                     $neworden4->orden4_usuario_elaboro = auth()->user()->id;
                     $neworden4->orden4_fh_elaboro = date('Y-m-d H:i:s');
                     $neworden4->save();
                }

                // Areasp
                $areasp = Ordenp6::where('orden6_orden2', $orden2->id)->get();
                foreach ($areasp as $orden6) {
                     $neworden6 = $orden6->replicate();
                     $neworden6->orden6_orden2 = $neworden2->id;
                     $neworden6->save();
                }

                // Empaques
                $empaques = Ordenp9::where('orden9_orden2', $orden2->id)->get();
                foreach ($empaques as $orden9) {
                     $neworden9 = $orden9->replicate();
                     $neworden9->orden9_orden2 = $neworden2->id;
                     $neworden9->orden9_usuario_elaboro = auth()->user()->id;
                     $neworden9->orden9_fh_elaboro = date('Y-m-d H:i:s');
                     $neworden9->save();
                }

                // Transportes
                $transportes = Ordenp10::where('orden10_orden2', $orden2->id)->get();
                foreach ($transportes as $orden10) {
                     $neworden10 = $orden10->replicate();
                     $neworden10->orden10_orden2 = $neworden2->id;
                     $neworden10->orden10_usuario_elaboro = auth()->user()->id;
                     $neworden10->orden10_fh_elaboro = date('Y-m-d H:i:s');
                     $neworden10->save();
                }

                // Guardar imagenes si todo sale bien
                if (count($files)) {
                    foreach ($files as $file) {
                        Storage::copy($file->copy, $file->paste);
                    }
                }

                // Si hay cambios en la cotizacion
                Bitacora::createBitacora($orden, [], "Se clono el producto {$orden2->id}", 'Productos', 'U', $request->ip());

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $neworden2->id, 'msg' => 'Producto orden clonado con exito.']);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function producto(Request $request)
    {
        if ($request->ajax()) {
            $orden = Ordenp::find($request->ordenp);
            if (!$orden instanceof Ordenp) {
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la orden de producción']);
            }

            if (!in_array($request->option, ['P', 'C', 'O'])) {
                return response()->json(['success' => false, 'errors' => 'La opción no es valida.']);
            }

            DB::beginTransaction();
            try {
                if ($request->option == 'O') {
                    $ordenp2 = Ordenp2::find($request->productop);
                    if (!$ordenp2 instanceof Ordenp2) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el producto de la orden de producción']);
                    }
                    $producto = $ordenp2->crearProductoOrden($orden->id);
                } else {
                    $cotizacion2 = Cotizacion2::find($request->productop);
                    if (!$cotizacion2 instanceof Cotizacion2) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el producto de la cotización']);
                    }
                    $producto = $cotizacion2->crearProductoOrden($orden->id);
                }

                DB::commit();
                return response()->json(['success' => 'true', 'id' => $producto->id]);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'DetalleOrdenpController', 'producto', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
    }
}
