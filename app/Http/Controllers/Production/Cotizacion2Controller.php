<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Cotizacion5, App\Models\Production\Cotizacion6, App\Models\Production\Cotizacion7, App\Models\Production\Cotizacion8, App\Models\Production\Cotizacion9, App\Models\Production\Productop, App\Models\Production\Productop4, App\Models\Production\Productop5, App\Models\Production\Productop6, App\Models\Production\Areap, App\Models\Base\Tercero, App\Models\Inventory\Producto, App\Models\Production\Materialp;
use Auth, DB, Log, Datatables, Storage;

class Cotizacion2Controller extends Controller
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
            if($request->has('cotizacion2_cotizacion')) {
                $detalle = Cotizacion2::getCotizaciones2($request->cotizacion2_cotizacion);
            }
            return response()->json($detalle);
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
        // Recuperar cotizacion
        $cotizacion = $request->has('cotizacion') ? Cotizacion1::getCotizacion($request->cotizacion) : null;
        if(!$cotizacion instanceof Cotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = $request->has('productop') ? Productop::getProduct($request->productop) : null;
        if(!$producto instanceof Productop) {
            abort(404);
        }

        if($cotizacion->cotizacion1_abierta == false || $cotizacion->cotizacion1_anulada == true) {
            return redirect()->route('cotizaciones.show', ['cotizacion' => $cotizacion]);
        }

        return view('production.cotizaciones.productos.create', ['cotizacion' => $cotizacion, 'producto' => $producto]);
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
            $data['empaques'] = json_decode($data['empaques']);
            $data['areasp'] = json_decode($data['areasp']);

            $cotizacion2 = new Cotizacion2;
            if ($cotizacion2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $producto = Productop::find($request->cotizacion2_productop);
                    if (!$producto instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar cotizacion
                    $cotizacion = Cotizacion1::find($request->cotizacion2_cotizacion);
                    if (!$cotizacion instanceof Cotizacion1) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cotizacion, por favor verifique la información o consulte al administrador.']);
                    }

                    // Cotizacion2
                    $cotizacion2->fill($data);
                    $cotizacion2->fillBoolean($data);
                    $cotizacion2->cotizacion2_productop = $producto->id;
                    $cotizacion2->cotizacion2_cotizacion = $cotizacion->id;
                    $cotizacion2->cotizacion2_cantidad = $request->cotizacion2_cantidad;
                    $cotizacion2->cotizacion2_saldo = $cotizacion2->cotizacion2_cantidad;
                    $cotizacion2->cotizacion2_usuario_elaboro = Auth::user()->id;
                    $cotizacion2->cotizacion2_fecha_elaboro = date('Y-m-d H:i:s');
                    $cotizacion2->save();

                    // Maquinas
                    $maquinas = Cotizacion3::getCotizaciones3($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                    foreach ($maquinas as $maquina) {
                        if ($request->has("cotizacion3_maquinap_$maquina->id")) {
                            $cotizacion3 = new Cotizacion3;
                            $cotizacion3->cotizacion3_cotizacion2 = $cotizacion2->id;
                            $cotizacion3->cotizacion3_maquinap = $maquina->id;
                            $cotizacion3->save();
                        }
                    }

                    // Acabados
                    $acabados = Cotizacion5::getCotizaciones5($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                    foreach ($acabados as $acabado) {
                        if ($request->has("cotizacion5_acabadop_$acabado->id")) {
                            $cotizacion5 = new Cotizacion5;
                            $cotizacion5->cotizacion5_cotizacion2 = $cotizacion2->id;
                            $cotizacion5->cotizacion5_acabadop = $acabado->id;
                            $cotizacion5->save();
                        }
                    }

                    // Recuperar imagenes y almacenar en storage/app/cotizacines
                    $files = [];
                    $images = isset( $data['imagenes'] ) ? $data['imagenes'] : [];
                    foreach ($images as $key => $image) {
                        // Validar si viene check para imprimir
                        $filename = $image->getClientOriginalName();
                        if ( strpos($filename, '(true)') ) {
                            $explode = explode('(true)', $filename);
                            $name = str_random(4)."_{$explode[0]}";
                            $imprimir = true;

                        } else if (strpos($filename, '(false)')) {
                            $explode = explode('(false)', $filename);
                            $name = str_random(4)."_{$explode[0]}";
                            $imprimir = false;
                        }

                        // Insertar imagen
                        $imagen = new Cotizacion8;
                        $imagen->cotizacion8_archivo = $name;
                        $imagen->cotizacion8_cotizacion2 = $cotizacion2->id;
                        $imagen->cotizacion8_imprimir = $imprimir;
                        $imagen->cotizacion8_fh_elaboro = date('Y-m-d H:i:s');
                        $imagen->cotizacion8_usuario_elaboro = Auth::user()->id;
                        $imagen->save();

                        // Crear objecto para mantener la imagen para guardar cuando se complete la transaccion, de lo contrario guardara la imagen asi no se complete la transaccion
                        $object = new \stdClass();
                        $object->route = "cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$name";
                        $object->file = file_get_contents($image->getRealPath());

                        $files[] = $object;
                    }

                    // Materialesp
                    $totalmaterialesp = $totalempaques = $totalareasp = 0;
                    $materiales = isset($data['materialesp']) ? $data['materialesp'] : null;
                    foreach ($materiales as $material) {
                        $materialp = Materialp::find($material->cotizacion4_materialp);
                        if (!$materialp instanceof Materialp) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        $insumo = Producto::find($material->cotizacion4_producto);
                        if (!$insumo instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del material, por favor verifique la información o consulte al administrador.']);
                        }

                        // Guardar individual porque sale error por ser objeto decodificado
                        $cotizacion4 = new Cotizacion4;
                        $cotizacion4->cotizacion4_cotizacion2 = $cotizacion2->id;
                        $cotizacion4->cotizacion4_materialp = $materialp->id;
                        $cotizacion4->cotizacion4_producto = $insumo->id;
                        $cotizacion4->cotizacion4_cantidad = $material->cotizacion4_cantidad;
                        $cotizacion4->cotizacion4_medidas = $material->cotizacion4_medidas;
                        $cotizacion4->cotizacion4_valor_unitario = $material->cotizacion4_valor_unitario;
                        $cotizacion4->cotizacion4_valor_total = $material->cotizacion4_valor_total;
                        $cotizacion4->cotizacion4_fh_elaboro = date('Y-m-d H:i:s');
                        $cotizacion4->cotizacion4_usuario_elaboro = Auth::user()->id;
                        $cotizacion4->save();

                        $totalmaterialesp += $cotizacion4->cotizacion4_valor_total;
                    }

                    // Empaques
                    $empaques = isset($data['empaques']) ? $data['empaques'] : null;
                    foreach ($empaques as $empaque) {
                        $materialp = Materialp::find($empaque->cotizacion9_materialp);
                        if (!$materialp instanceof Materialp) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        $insumo = Producto::find($empaque->cotizacion9_producto);
                        if (!$insumo instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del empaque, por favor verifique la información o consulte al administrador.']);
                        }

                        // Guardar individual porque sale error por ser objeto decodificado
                        $cotizacion9 = new Cotizacion9;
                        $cotizacion9->cotizacion9_cotizacion2 = $cotizacion2->id;
                        $cotizacion9->cotizacion9_materialp = $materialp->id;
                        $cotizacion9->cotizacion9_producto = $insumo->id;
                        $cotizacion9->cotizacion9_cantidad = $empaque->cotizacion9_cantidad;
                        $cotizacion9->cotizacion9_medidas = $empaque->cotizacion9_medidas;
                        $cotizacion9->cotizacion9_valor_unitario = $empaque->cotizacion9_valor_unitario;
                        $cotizacion9->cotizacion9_valor_total = $empaque->cotizacion9_valor_total;
                        $cotizacion9->cotizacion9_fh_elaboro = date('Y-m-d H:i:s');
                        $cotizacion9->cotizacion9_usuario_elaboro = Auth::user()->id;
                        $cotizacion9->save();

                        $totalempaques += $cotizacion9->cotizacion9_valor_total;
                    }

                    // Areap
                    $areasp = isset($data['areasp']) ? $data['areasp'] : null;
                    foreach ($areasp as $areap) {
                        $cotizacion6 = new Cotizacion6;
                        $cotizacion6->cotizacion6_valor = $areap->cotizacion6_valor;
                        if (!empty($areap->cotizacion6_areap)) {
                            $cotizacion6->cotizacion6_areap = $areap->cotizacion6_areap;
                        } else {
                            $cotizacion6->cotizacion6_nombre = $areap->cotizacion6_nombre;
                        }
                        $cotizacion6->cotizacion6_tiempo = "{$areap->cotizacion6_horas}:{$areap->cotizacion6_minutos}";
                        $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
                        $cotizacion6->save();

                        $tiempo = intval($areap->cotizacion6_horas) + (intval($areap->cotizacion6_minutos) / 60);
                        $totalareasp += $cotizacion6->cotizacion6_valor * $tiempo;
                    }

                    // Operacion para calcular el total del producto
                    $precio = $cotizacion2->cotizacion2_precio_venta;
                    $transporte = round($cotizacion2->cotizacion2_transporte/$cotizacion2->cotizacion2_cantidad);
                    $viaticos = round($cotizacion2->cotizacion2_viaticos/$cotizacion2->cotizacion2_cantidad);
                    $materiales = ($totalmaterialesp/$cotizacion2->cotizacion2_cantidad)/((100-$cotizacion2->cotizacion2_margen_materialp)/100);
                    $empaques = ($totalempaques/$cotizacion2->cotizacion2_cantidad)/((100-$cotizacion2->cotizacion2_margen_empaque)/100);
                    $areas = round($totalareasp/$cotizacion2->cotizacion2_cantidad);

                    $subtotal = $precio + $transporte + $viaticos + $materiales + $empaques + $areas;
                    $comision = ($subtotal/((100-$cotizacion2->cotizacion2_volumen)/100)) * (1-(((100-$cotizacion2->cotizacion2_volumen)/100)));
                    $total = round(($subtotal+$comision), $cotizacion2->cotizacion2_round);

                    // Actualizar valores
                    $cotizacion2->cotizacion2_vtotal = $comision;
                    $cotizacion2->cotizacion2_total_valor_unitario = $total;
                    $cotizacion2->save();

                    // Guardar imagenes si todo sale bien
                    if (count($files)) {
                        foreach ($files as $file) {
                            Storage::put($file->route, $file->file);
                        }
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cotizacion2->id, 'id_cotizacion' => $cotizacion->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion2->errors]);
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
        // Recuperar cotizacion2
        $cotizacion2 = Cotizacion2::getCotizacion2($id);
        if(!$cotizacion2 instanceof Cotizacion2) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($cotizacion2);
        }

        // Recuperar cotizacion
        $cotizacion = Cotizacion1::getCotizacion($cotizacion2->cotizacion2_cotizacion);
        if(!$cotizacion instanceof Cotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct($cotizacion2->cotizacion2_productop);
        if(!$producto instanceof Productop) {
            abort(404);
        }

        // Validar cotizacion
        if( $cotizacion->cotizacion1_abierta == true && Auth::user()->ability('admin', 'editar', ['module' => 'cotizaciones']) ) {
            return redirect()->route('cotizaciones.productos.edit', ['productos' => $cotizacion2->id]);
        }
        return view('production.cotizaciones.productos.show', ['cotizacion' => $cotizacion, 'producto' => $producto, 'cotizacion2' => $cotizacion2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id3
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Recuperar cotizacion2
        $cotizacion2 = Cotizacion2::findOrFail($id);

        // Recuperar cotizacion
        $cotizacion = Cotizacion1::getCotizacion($cotizacion2->cotizacion2_cotizacion);
        if(!$cotizacion instanceof Cotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct($cotizacion2->cotizacion2_productop);
        if(!$producto instanceof Productop) {
            abort(404);
        }

        // Validar cotizacion
        if($cotizacion->cotizacion1_abierta == false) {
            return redirect()->route('cotizaciones.productos.show', ['productos' => $cotizacion2->id]);
        }
        return view('production.cotizaciones.productos.create', ['cotizacion' => $cotizacion, 'producto' => $producto, 'cotizacion2' => $cotizacion2]);
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

            // Recuperar cotizacion2
            $cotizacion2 = Cotizacion2::findOrFail($id);

            // Recuperar cotizacion
            $cotizacion = Cotizacion1::findOrFail($cotizacion2->cotizacion2_cotizacion);
            if($cotizacion->cotizacion1_abierta) {

                if ($cotizacion2->isValid($data)) {
                    DB::beginTransaction();
                    try {
                        // Cotizacion2
                        $cotizacion2->fill($data);
                        $cotizacion2->fillBoolean($data);
                        $cotizacion2->cotizacion2_cantidad = $request->cotizacion2_cantidad;
                        $cotizacion2->cotizacion2_saldo = $request->cotizacion2_cantidad;
                        $cotizacion2->save();

                        // Maquinas
                        $maquinas = Cotizacion3::getCotizaciones3($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                        foreach ($maquinas as $maquina) {
                            $cotizacion3 = Cotizacion3::where('cotizacion3_cotizacion2', $cotizacion2->id)->where('cotizacion3_maquinap', $maquina->id)->first();
                            if ($request->has("cotizacion3_maquinap_$maquina->id")) {
                                if (!$cotizacion3 instanceof Cotizacion3) {
                                    $cotizacion3 = new Cotizacion3;
                                    $cotizacion3->cotizacion3_cotizacion2 = $cotizacion2->id;
                                    $cotizacion3->cotizacion3_maquinap = $maquina->id;
                                    $cotizacion3->save();
                                }
                            } else {
                                if ($cotizacion3 instanceof Cotizacion3) {
                                    $cotizacion3->delete();
                                }
                            }
                        }

                        // Acabados
                        $acabados = Cotizacion5::getCotizaciones5($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                        foreach ($acabados as $acabado) {
                            $cotizacion5 = Cotizacion5::where('cotizacion5_cotizacion2', $cotizacion2->id)->where('cotizacion5_acabadop', $acabado->id)->first();
                            if ($request->has("cotizacion5_acabadop_$acabado->id")) {
                                if (!$cotizacion5 instanceof Cotizacion5) {
                                    $cotizacion5 = new Cotizacion5;
                                    $cotizacion5->cotizacion5_cotizacion2 = $cotizacion2->id;
                                    $cotizacion5->cotizacion5_acabadop = $acabado->id;
                                    $cotizacion5->save();
                                }
                            } else {
                                if ($cotizacion5 instanceof Cotizacion5) {
                                    $cotizacion5->delete();
                                }
                            }
                        }

                        // imagenes
                        $imagenes = Cotizacion8::where('cotizacion8_cotizacion2', $cotizacion2->id)->get();
                        foreach ($imagenes as $imagen) {
                            $cotizacion8 = Cotizacion8::find($imagen->id);
                            if ($imagen instanceof Cotizacion8) {
                                $imagen->cotizacion8_imprimir = $request->has("cotizacion8_imprimir_$imagen->id") ?: false;
                                $imagen->save();
                            }
                        }

                        // Materiales
                        $keys = [];
                        $totalmaterialesp = $totalempaques = $totalareasp = 0;
                        $materiales = isset($data['materialesp']) ? $data['materialesp'] : [];
                        foreach ($materiales as $material) {
                            $cotizacion4 = Cotizacion4::find( is_numeric($material['id']) ? $material['id'] : null);
                            if (!$cotizacion4 instanceof Cotizacion4) {
                                $materialp = Materialp::find($material['cotizacion4_materialp']);
                                if (!$materialp instanceof Materialp) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                                }

                                $insumo = Producto::find($material['cotizacion4_producto']);
                                if (!$insumo instanceof Producto) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del material, por favor verifique la información o consulte al administrador.']);
                                }

                                $cotizacion4 = new Cotizacion4;
                                $cotizacion4->fill($material);
                                $cotizacion4->cotizacion4_producto = $insumo->id;
                                $cotizacion4->cotizacion4_cotizacion2 = $cotizacion2->id;
                                $cotizacion4->cotizacion4_materialp = $materialp->id;
                                $cotizacion4->cotizacion4_fh_elaboro = date('Y-m-d H:i:s');
                                $cotizacion4->cotizacion4_usuario_elaboro = Auth::user()->id;
                                $cotizacion4->save();

                            } else {
                                $cotizacion4->fill($material);
                                $cotizacion4->save();

                            }

                            // asociar id a un array para validar
                            $keys[] = $cotizacion4->id;
                            $totalmaterialesp += $cotizacion4->cotizacion4_valor_total;
                        }

                        // Remover registros que no existan
                        $deletemateriales = Cotizacion4::whereNotIn('id', $keys)->where('cotizacion4_cotizacion2', $cotizacion2->id)->delete();

                        // Empaques
                        $keys = [];
                        $empaques = isset($data['empaques']) ? $data['empaques'] : [];
                        foreach ($empaques as $empaque) {
                            $cotizacion9 = Cotizacion9::find( is_numeric($empaque['id']) ? $empaque['id'] : null);
                            if (!$cotizacion9 instanceof Cotizacion9) {
                                $materialp = Materialp::find($empaque['cotizacion9_materialp']);
                                if (!$materialp instanceof Materialp) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                                }

                                $insumo = Producto::find($empaque['cotizacion9_producto']);
                                if (!$insumo instanceof Producto) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del empaque, por favor verifique la información o consulte al administrador.']);
                                }

                                $cotizacion9 = new Cotizacion9;
                                $cotizacion9->fill($empaque);
                                $cotizacion9->cotizacion9_producto = $insumo->id;
                                $cotizacion9->cotizacion9_cotizacion2 = $cotizacion2->id;
                                $cotizacion9->cotizacion9_materialp = $materialp->id;
                                $cotizacion9->cotizacion9_fh_elaboro = date('Y-m-d H:i:s');
                                $cotizacion9->cotizacion9_usuario_elaboro = Auth::user()->id;
                                $cotizacion9->save();

                            } else {
                                $cotizacion9->fill($empaque);
                                $cotizacion9->save();

                            }

                            // asociar id a un array para validar
                            $keys[] = $cotizacion9->id;
                            $totalempaques += $cotizacion9->cotizacion9_valor_total;
                        }

                        // Remover registros que no existan
                        $deleteempaques = Cotizacion9::whereNotIn('id', $keys)->where('cotizacion9_cotizacion2', $cotizacion2->id)->delete();

                        // Areasp
                        $keys = [];
                        $areasp = isset($data['areasp']) ? $data['areasp'] : [];
                        foreach ($areasp as $areap) {
                            $cotizacion6 = Cotizacion6::find( is_numeric($areap['id']) ? $areap['id'] : null);
                            if (!$cotizacion6 instanceof Cotizacion6) {
                                $cotizacion6 = new Cotizacion6;
                                $cotizacion6->fill($areap);
                                if (!empty($areap['cotizacion6_areap'])) {
                                    $cotizacion6->cotizacion6_areap = $areap['cotizacion6_areap'];
                                } else {
                                    $cotizacion6->cotizacion6_nombre = $areap['cotizacion6_nombre'];
                                }
                                $cotizacion6->cotizacion6_tiempo = "{$areap['cotizacion6_horas']}:{$areap['cotizacion6_minutos']}";
                                $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
                                $cotizacion6->save();
                            } else {
                                $cotizacion6->cotizacion6_tiempo = "{$areap['cotizacion6_horas']}:{$areap['cotizacion6_minutos']}";
                                $cotizacion6->save();
                            }

                            $keys[] = $cotizacion6->id;
                            $tiempo = intval($areap['cotizacion6_horas']) + (intval($areap['cotizacion6_minutos']) / 60);
                            $totalareasp += $cotizacion6->cotizacion6_valor * $tiempo;
                        }

                        // Remover registros que no existan
                        $deleteareasp = Cotizacion6::whereNotIn('id', $keys)->where('cotizacion6_cotizacion2', $cotizacion2->id)->delete();

                        // Operacion para recalcular el total del producto
                        $precio = $cotizacion2->cotizacion2_precio_venta;
                        $transporte = round($cotizacion2->cotizacion2_transporte/$cotizacion2->cotizacion2_cantidad);
                        $viaticos = round($cotizacion2->cotizacion2_viaticos/$cotizacion2->cotizacion2_cantidad);
                        $materiales = ($totalmaterialesp/$cotizacion2->cotizacion2_cantidad)/((100-$cotizacion2->cotizacion2_margen_materialp)/100);
                        $empaques = ($totalempaques/$cotizacion2->cotizacion2_cantidad)/((100-$cotizacion2->cotizacion2_margen_empaque)/100);
                        $areas = round($totalareasp/$cotizacion2->cotizacion2_cantidad);

                        $subtotal = $precio + $transporte + $viaticos + $materiales + $empaques + $areas;
                        $volumen = ($subtotal/((100-$cotizacion2->cotizacion2_volumen)/100)) * (1-(((100-$cotizacion2->cotizacion2_volumen)/100)));
                        $total = round(($subtotal+$volumen), $cotizacion2->cotizacion2_round);

                        // Actualizar valores
                        $cotizacion2->cotizacion2_vtotal = $volumen;
                        $cotizacion2->cotizacion2_total_valor_unitario = $total;
                        $cotizacion2->save();

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => $cotizacion2->id, 'id_cotizacion' => $cotizacion->id]);
                    }catch(\Exception $e){
                        DB::rollback();
                        Log::error($e->getMessage());
                        return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                    }
                }
                return response()->json(['success' => false, 'errors' => $cotizacion2->errors]);

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
                $cotizacion2 = Cotizacion2::find($id);
                if(!$cotizacion2 instanceof Cotizacion2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar detalle la cotizacion, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Maquinas
                DB::table('koi_cotizacion3')->where('cotizacion3_cotizacion2', $cotizacion2->id)->delete();

                // Materiales
                DB::table('koi_cotizacion4')->where('cotizacion4_cotizacion2', $cotizacion2->id)->delete();

                // Acabados
                DB::table('koi_cotizacion5')->where('cotizacion5_cotizacion2', $cotizacion2->id)->delete();

                // Areasp
                DB::table('koi_cotizacion6')->where('cotizacion6_cotizacion2', $cotizacion2->id)->delete();

                // Impresiones
                DB::table('koi_cotizacion7')->where('cotizacion7_cotizacion2', $cotizacion2->id)->delete();

                // Imagens
                DB::table('koi_cotizacion8')->where('cotizacion8_cotizacion2', $cotizacion2->id)->delete();

                // Empaques
                DB::table('koi_cotizacion9')->where('cotizacion9_cotizacion2', $cotizacion2->id)->delete();

                // Eliminar item cotizacion2
                $cotizacion2->delete();

                if( Storage::has("cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id") ) {
                    Storage::deleteDirectory("cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id");
                }

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Cotizacion2Controller', 'destroy', $e->getMessage()));
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
            $cotizacion2 = Cotizacion2::findOrFail($id);
            DB::beginTransaction();
            try {
                $newcotizacion2 = $cotizacion2->replicate();
                $newcotizacion2->cotizacion2_saldo = $newcotizacion2->cotizacion2_cantidad;
                $newcotizacion2->cotizacion2_entregado = 0;
                $newcotizacion2->cotizacion2_usuario_elaboro = Auth::user()->id;
                $newcotizacion2->cotizacion2_fecha_elaboro = date('Y-m-d H:i:s');
                $newcotizacion2->save();

                // Maquinas
                $maquinas = Cotizacion3::where('cotizacion3_cotizacion2', $cotizacion2->id)->get();
                foreach ($maquinas as $cotizacion3) {
                     $newcotizacion3 = $cotizacion3->replicate();
                     $newcotizacion3->cotizacion3_cotizacion2 = $newcotizacion2->id;
                     $newcotizacion3->save();
                }

                // Acabados
                $acabados = Cotizacion5::where('cotizacion5_cotizacion2', $cotizacion2->id)->get();
                foreach ($acabados as $cotizacion5) {
                    $newcotizacion5 = $cotizacion5->replicate();
                    $newcotizacion5->cotizacion5_cotizacion2 = $newcotizacion2->id;
                    $newcotizacion5->save();
                }

                // Imagenes
                $files = [];
                $images = Cotizacion8::where('cotizacion8_cotizacion2', $cotizacion2->id)->get();
                foreach ($images as $cotizacion8) {
                     $newcotizacion8 = $cotizacion8->replicate();
                     $newcotizacion8->cotizacion8_cotizacion2 = $newcotizacion2->id;
                     $newcotizacion8->cotizacion8_usuario_elaboro = Auth::user()->id;
                     $newcotizacion8->cotizacion8_fh_elaboro = date('Y-m-d H:i:s');
                     $newcotizacion8->save();

                     // Recuperar imagen y copiar
                     if( Storage::has("cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$cotizacion8->cotizacion8_archivo") ) {
                         $object = new \stdClass();
                         $object->copy = "cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$cotizacion8->cotizacion8_archivo";
                         $object->paste = "cotizaciones/cotizacion_$newcotizacion2->cotizacion2_cotizacion/producto_$newcotizacion2->id/$newcotizacion8->cotizacion8_archivo";

                         $files[] = $object;
                     }
                }

                // Impresiones
                $impresiones = Cotizacion7::where('cotizacion7_cotizacion2', $cotizacion2->id)->get();
                foreach ($impresiones as $cotizacion7) {
                    $newcotizacion7 = $cotizacion7->replicate();
                    $newcotizacion7->cotizacion7_cotizacion2 = $newcotizacion2->id;
                    $newcotizacion7->save();
                }

                // Materiales
                $materiales = Cotizacion4::where('cotizacion4_cotizacion2', $cotizacion2->id)->get();
                foreach ($materiales as $cotizacion4) {
                     $newcotizacion4 = $cotizacion4->replicate();
                     $newcotizacion4->cotizacion4_cotizacion2 = $newcotizacion2->id;
                     $newcotizacion4->cotizacion4_usuario_elaboro = Auth::user()->id;
                     $newcotizacion4->cotizacion4_fh_elaboro = date('Y-m-d H:i:s');
                     $newcotizacion4->save();
                }

                // Empaques
                $empaques = Cotizacion9::where('cotizacion9_cotizacion2', $cotizacion2->id)->get();
                foreach ($empaques as $cotizacion9) {
                     $newcotizacion9 = $cotizacion9->replicate();
                     $newcotizacion9->cotizacion9_cotizacion2 = $newcotizacion2->id;
                     $newcotizacion9->cotizacion9_usuario_elaboro = Auth::user()->id;
                     $newcotizacion9->cotizacion9_fh_elaboro = date('Y-m-d H:i:s');
                     $newcotizacion9->save();
                }

                // Areasp
                $areasp = Cotizacion6::where('cotizacion6_cotizacion2', $cotizacion2->id)->get();
                foreach ($areasp as $cotizacion6) {
                     $newcotizacion6 = $cotizacion6->replicate();
                     $newcotizacion6->cotizacion6_cotizacion2 = $newcotizacion2->id;
                     $newcotizacion6->save();
                }

                if (count($files)) {
                    foreach ($files as $file) {
                        Storage::copy($file->copy, $file->paste);
                    }
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $newcotizacion2->id, 'msg' => 'Producto de cotización clonado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
