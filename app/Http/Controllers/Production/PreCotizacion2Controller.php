<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion1, App\Models\Production\PreCotizacion2, App\Models\Production\PreCotizacion3, App\Models\Production\PreCotizacion4, App\Models\Production\PreCotizacion5, App\Models\Production\PreCotizacion6, App\Models\Production\PreCotizacion7, App\Models\Production\PreCotizacion8, App\Models\Production\Productop, App\Models\Base\Tercero, App\Models\Production\Materialp, App\Models\Production\Areap, App\Models\Inventory\Producto;
use Auth, DB, Log, Datatables, Storage;

class PreCotizacion2Controller extends Controller
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
            if($request->has('precotizacion2_precotizacion1')) {
                $detalle = PreCotizacion2::getPreCotizaciones2($request->precotizacion2_precotizacion1);
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
        // Recuperar precotizacion
        $precotizacion = $request->has('precotizacion') ? PreCotizacion1::getPreCotizacion($request->precotizacion) : null;
        if(!$precotizacion instanceof PreCotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = $request->has('productop') ? Productop::getProduct($request->productop) : null;
        if(!$producto instanceof Productop) {
            abort(404);
        }

        if( $precotizacion->precotizacion1_abierta == false ) {
            return redirect()->route('precotizaciones.show', ['precotizacion' => $precotizacion]);
        }

        return view('production.precotizaciones.productos.create', ['precotizacion' => $precotizacion, 'producto' => $producto]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){

            $data = $request->all();
            $data['impresiones'] = json_decode($data['impresiones']);
            $data['materialesp'] = json_decode($data['materialesp']);
            $data['areasp'] = json_decode($data['areasp']);

            $precotizacion2 = new PreCotizacion2;
            if ($precotizacion2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $producto = Productop::find($request->precotizacion2_productop);
                    if(!$producto instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar cotizacion
                    $precotizacion = PreCotizacion1::find($request->precotizacion2_precotizacion1);
                    if(!$precotizacion instanceof PreCotizacion1) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar pre-cotizacion, por favor verifique la información o consulte al administrador.']);
                    }

                    // Cotizacion2
                    $precotizacion2->fill($data);
                    $precotizacion2->fillBoolean($data);
                    $precotizacion2->precotizacion2_precotizacion1 = $precotizacion->id;
                    $precotizacion2->precotizacion2_productop = $producto->id;
                    $precotizacion2->save();

                    // Materialesp
                    $materiales = isset($data['materialesp']) ? $data['materialesp'] : null;
                    foreach ($materiales as $material) {
                        // Validar tercero y materialp
                        $tercero = Tercero::where('tercero_nit', $material->precotizacion3_proveedor)->first();
                        if(!$tercero instanceof Tercero){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el proveedor, por favor verifique la información o consulte al administrador.']);
                        }

                        $materialp = Materialp::find($material->precotizacion3_materialp);
                        if(!$materialp instanceof Materialp){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        $insumo = Producto::find($material->precotizacion3_producto);
                        if(!$insumo instanceof Producto){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del material, por favor verifique la información o consulte al administrador.']);
                        }

                        // Guardar individual porque sale error por ser objeto decodificado
                        $precotizacion3 = new PreCotizacion3;
                        $precotizacion3->precotizacion3_cantidad = $material->precotizacion3_cantidad;
                        $precotizacion3->precotizacion3_medidas = $material->precotizacion3_medidas;
                        $precotizacion3->precotizacion3_valor_unitario = $material->precotizacion3_valor_unitario;
                        $precotizacion3->precotizacion3_valor_total = $material->precotizacion3_valor_total;
                        $precotizacion3->precotizacion3_producto = $insumo->id;
                        $precotizacion3->precotizacion3_precotizacion2 = $precotizacion2->id;
                        $precotizacion3->precotizacion3_materialp = $materialp->id;
                        $precotizacion3->precotizacion3_proveedor = $tercero->id;
                        $precotizacion3->precotizacion3_fh_elaboro = date('Y-m-d H:m:s');
                        $precotizacion3->precotizacion3_usuario_elaboro = Auth::user()->id;
                        $precotizacion3->save();
                    }

                    // Impresiones
                    $impresiones = isset($data['impresiones']) ? $data['impresiones'] : null;
                    foreach ($impresiones as $impresion) {
                        $precotizacion5 = new PreCotizacion5;
                        $precotizacion5->precotizacion5_texto = $impresion->precotizacion5_texto;
                        $precotizacion5->precotizacion5_alto = $impresion->precotizacion5_alto;
                        $precotizacion5->precotizacion5_ancho = $impresion->precotizacion5_ancho;
                        $precotizacion5->precotizacion5_precotizacion2 = $precotizacion2->id;
                        $precotizacion5->save();
                    }

                    // Areap
                    $areasp = isset($data['areasp']) ? $data['areasp'] : null;
                    foreach ($areasp as $areap)
                    {
                        // Recuperar tiempo
                        $newtime = "{$areap->precotizacion6_horas}:{$areap->precotizacion6_minutos}";

                        $precotizacion6 = new PreCotizacion6;
                        $precotizacion6->precotizacion6_valor = $areap->precotizacion6_valor;
                        (!empty($areap->precotizacion6_areap)) ? $precotizacion6->precotizacion6_areap = $areap->precotizacion6_areap : $precotizacion6->precotizacion6_nombre = $areap->precotizacion6_nombre;
                        $precotizacion6->precotizacion6_tiempo = $newtime;
                        $precotizacion6->precotizacion6_precotizacion2 = $precotizacion2->id;
                        $precotizacion6->save();
                    }

                    // Reuperar imagenes y almacenar en storage/app/precotizacines
                    $images = isset($data['imagenes']) ? $data['imagenes'] : [];
                    foreach ($images as $image) {
                        // Recuperar nombre de archivo
                        $name = str_random(4)."_{$image->getClientOriginalName()}";

                        // Insertar imagen
                        $imagen = new PreCotizacion4;
                        $imagen->precotizacion4_archivo = $name;
                        $imagen->precotizacion4_precotizacion2 = $precotizacion2->id;
                        $imagen->precotizacion4_fh_elaboro = date('Y-m-d H:m:s');
                        $imagen->precotizacion4_usuario_elaboro = Auth::user()->id;
                        $imagen->save();

                        Storage::put("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id/$name", file_get_contents($image->getRealPath()));
                    }

                    // Acabados
                    $acabados = PreCotizacion7::getPreCotizaciones7($precotizacion2->precotizacion2_productop, $precotizacion2->id);
                    foreach ($acabados as $acabado) {
                        if($request->has("precotizacion7_acabadop_$acabado->id")) {
                            $precotizacion7 = new PreCotizacion7;
                            $precotizacion7->precotizacion7_precotizacion2 = $precotizacion2->id;
                            $precotizacion7->precotizacion7_acabadop = $acabado->id;
                            $precotizacion7->save();
                        }
                    }

                    // Maquinas
                    $maquinas = PreCotizacion8::getPreCotizaciones8($precotizacion2->precotizacion2_productop, $precotizacion2->id);
                    foreach ($maquinas as $maquina) {
                        if($request->has("precotizacion8_maquinap_$maquina->id")) {
                            $precotizacion8 = new PreCotizacion8;
                            $precotizacion8->precotizacion8_precotizacion2 = $precotizacion2->id;
                            $precotizacion8->precotizacion8_maquinap = $maquina->id;
                            $precotizacion8->save();
                        }
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $precotizacion2->id, 'id_precotizacion' => $precotizacion->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion2->errors]);
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
        // Recuperar precotizacion2
        $precotizacion2 = PreCotizacion2::getPreCotizacion2($id);
        if(!$precotizacion2 instanceof PreCotizacion2) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($precotizacion2);
        }

        // Recuperar precotizacion
        $precotizacion = PreCotizacion1::getPreCotizacion( $precotizacion2->precotizacion2_precotizacion1 );
        if(!$precotizacion instanceof PreCotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct($precotizacion2->precotizacion2_productop);
        if(!$producto instanceof Productop) {
            abort(404);
        }

        // Validar precotizacion
        if( $precotizacion->precotizacion1_abierta == true ){
            return redirect()->route('precotizaciones.productos.edit', ['productos' => $precotizacion2->id]);
        }
        return view('production.precotizaciones.productos.show', ['precotizacion' => $precotizacion, 'producto' => $producto, 'precotizacion2' => $precotizacion2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // Recuperar precotizacion2
        $precotizacion2 = PreCotizacion2::findOrFail($id);

        // Recuperar cotizacion
        $precotizacion = PreCotizacion1::getPreCotizacion( $precotizacion2->precotizacion2_precotizacion1 );
        if(!$precotizacion instanceof PreCotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct( $precotizacion2->precotizacion2_productop );
        if(!$producto instanceof Productop) {
            abort(404);
        }

        // Validar cotizacion
        if($precotizacion->precotizacion1_abierta == false) {
            return redirect()->route('precotizaciones.productos.show', ['productos' => $precotizacion2->id]);
        }
        return view('production.precotizaciones.productos.create', ['precotizacion' => $precotizacion, 'producto' => $producto, 'precotizacion2' => $precotizacion2]);
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

            // Recuperar precotizacion2
            $precotizacion2 = PreCotizacion2::findOrFail($id);

            // Recuperar cotizacion
            $precotizacion = PreCotizacion1::findOrFail($precotizacion2->precotizacion2_precotizacion1);
            if($precotizacion->precotizacion1_abierta)
            {
                if ($precotizacion2->isValid($data)) {
                    DB::beginTransaction();
                    try {
                        // Cotizacion2
                        $precotizacion2->fill($data);
                        $precotizacion2->fillBoolean($data);
                        $precotizacion2->save();

                        // Materiales
                        $materiales = isset($data['materialesp']) ? $data['materialesp'] : null;
                        foreach ($materiales as $material) {
                            // Validar que el id sea entero(los temporales tienen letras)

                            if( isset( $material['success']) ){
                                // Validar tercero y materialp
                                $tercero = Tercero::where('tercero_nit', $material['precotizacion3_proveedor'])->first();
                                if(!$tercero instanceof Tercero){
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el proveedor, por favor verifique la información o consulte al administrador.']);
                                }

                                $materialp = Materialp::find($material['precotizacion3_materialp']);
                                if(!$materialp instanceof Materialp){
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                                }

                                $insumo = Producto::find($material['precotizacion3_producto']);
                                if(!$insumo instanceof Producto){
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del material, por favor verifique la información o consulte al administrador.']);
                                }

                                $newprecotizacion3 = new PreCotizacion3;
                                $newprecotizacion3->fill($material);
                                $newprecotizacion3->precotizacion3_producto = $insumo->id;
                                $newprecotizacion3->precotizacion3_precotizacion2 = $precotizacion2->id;
                                $newprecotizacion3->precotizacion3_materialp = $materialp->id;
                                $newprecotizacion3->precotizacion3_proveedor = $tercero->id;
                                $newprecotizacion3->precotizacion3_fh_elaboro = date('Y-m-d H:m:s');
                                $newprecotizacion3->precotizacion3_usuario_elaboro = Auth::user()->id;
                                $newprecotizacion3->save();
                            }

                            if( isset($material['change']) ){
                                // Recuperar material y actuzalizr
                                $precotizacion3 = PreCotizacion3::findOrFail($material['id']);
                                if(!$precotizacion3 instanceof PreCotizacion3){
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material, por favor verifique la información o consulte al administrador.']);
                                }

                                $precotizacion3->fill($material);
                                $precotizacion3->save();
                            }
                        }

                        // Impresiones
                        $impresiones = isset($data['impresiones']) ? $data['impresiones'] : null;
                        foreach ($impresiones as $impresion) {
                            if( isset($impresion['success']) ){
                                $newprecotizacion5 = new PreCotizacion5;
                                $newprecotizacion5->fill($impresion);
                                $newprecotizacion5->precotizacion5_precotizacion2 = $precotizacion2->id;
                                $newprecotizacion5->save();
                            }
                        }

                        // Areasp
                        $areasp = isset($data['areasp']) ? $data['areasp'] : null;
                        foreach($areasp as $areap) {
                            if( isset($areap['success']) ){
                                // Recuperar tiempo
                                $newtime = "{$areap['precotizacion6_horas']}:{$areap['precotizacion6_minutos']}";

                                $newprecotizacion6 = new PreCotizacion6;
                                $newprecotizacion6->fill($areap);
                                ( !empty($areap['precotizacion6_areap']) ) ? $newprecotizacion6->precotizacion6_areap = $areap['precotizacion6_areap'] : $newprecotizacion6->precotizacion6_nombre = $areap['precotizacion6_nombre'];
                                $newprecotizacion6->precotizacion6_tiempo = $newtime;
                                $newprecotizacion6->precotizacion6_precotizacion2 = $precotizacion2->id;
                                $newprecotizacion6->save();
                            }else{
                                if( !empty($areap['precotizacion6_areap']) ){
                                    $area = Areap::find($areap['precotizacion6_areap']);
                                    if(!$area instanceof Areap){
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => 'No es posible actualizar las areas, por favor consulte al administrador.']);
                                    }

                                    $precotizacion6 = PreCotizacion6::where('precotizacion6_precotizacion2', $precotizacion2->id)->where('precotizacion6_areap', $area->id)->first();
                                }else{
                                    $precotizacion6 = PreCotizacion6::where('precotizacion6_precotizacion2', $precotizacion2->id)->where('precotizacion6_nombre', $areap['precotizacion6_nombre'])->first();
                                }
                                $newtime = "{$areap['precotizacion6_horas']}:{$areap['precotizacion6_minutos']}";

                                if( $precotizacion6 instanceof PreCotizacion6 ) {
                                    if($newtime != $areap['precotizacion6_tiempo']){
                                        $precotizacion6->fill($areap);
                                        $precotizacion6->precotizacion6_tiempo = $newtime;
                                        $precotizacion6->save();
                                    }
                                }
                            }
                        }

                        // Acabados
                        $acabados = PreCotizacion7::getPreCotizaciones7($precotizacion2->precotizacion2_productop, $precotizacion2->id);
                        foreach ($acabados as $acabado) {
                            $precotizacion7 = PreCotizacion7::where('precotizacion7_precotizacion2', $precotizacion2->id)->where('precotizacion7_acabadop', $acabado->id)->first();
                            if($request->has("precotizacion7_acabadop_$acabado->id")) {
                                if(!$precotizacion7 instanceof PreCotizacion7) {
                                    $precotizacion7 = new PreCotizacion7;
                                    $precotizacion7->precotizacion7_precotizacion2 = $precotizacion2->id;
                                    $precotizacion7->precotizacion7_acabadop = $acabado->id;
                                    $precotizacion7->save();
                                }
                            }else{
                                if($precotizacion7 instanceof PreCotizacion7) {
                                    $precotizacion7->delete();
                                }
                            }
                        }

                        // Maquinas
                        $maquinas = PreCotizacion8::getPreCotizaciones8($precotizacion2->precotizacion2_productop, $precotizacion2->id);
                        foreach ($maquinas as $maquina) {
                            $precotizacion8 = PreCotizacion8::where('precotizacion8_precotizacion2', $precotizacion2->id)->where('precotizacion8_maquinap', $maquina->id)->first();
                            if($request->has("precotizacion8_maquinap_$maquina->id")) {
                                if(!$precotizacion8 instanceof PreCotizacion8) {
                                    $precotizacion8 = new PreCotizacion8;
                                    $precotizacion8->precotizacion8_precotizacion2 = $precotizacion2->id;
                                    $precotizacion8->precotizacion8_maquinap = $maquina->id;
                                    $precotizacion8->save();
                                }
                            }else{
                                if($precotizacion8 instanceof PreCotizacion8) {
                                    $precotizacion8->delete();
                                }
                            }
                        }

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => $precotizacion2->id, 'id_precotizacion' => $precotizacion->id]);
                    }catch(\Exception $e){
                        DB::rollback();
                        Log::error($e->getMessage());
                        return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                    }
                }
                return response()->json(['success' => false, 'errors' => $precotizacion2->errors]);
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
                $precotizacion2 = PreCotizacion2::find( $id );
                if(!$precotizacion2 instanceof PreCotizacion2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar de la pre-cotización, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Materiales
                DB::table('koi_precotizacion3')->where('precotizacion3_precotizacion2', $precotizacion2->id)->delete();

                // Imagenes
                DB::table('koi_precotizacion4')->where('precotizacion4_precotizacion2', $precotizacion2->id)->delete();

                // Impresiones
                DB::table('koi_precotizacion5')->where('precotizacion5_precotizacion2', $precotizacion2->id)->delete();

                // Areasp
                DB::table('koi_precotizacion6')->where('precotizacion6_precotizacion2', $precotizacion2->id)->delete();

                // Acabados
                DB::table('koi_precotizacion7')->where('precotizacion7_precotizacion2', $precotizacion2->id)->delete();

                // Maquinas
                DB::table('koi_precotizacion8')->where('precotizacion8_precotizacion2', $precotizacion2->id)->delete();

                // Eliminar item precotizacion2
                $precotizacion2->delete();

                // Recuperar cartepta y eliminar
                if( Storage::has("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id") ) {
                    Storage::deleteDirectory("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id");
                }

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Precotizacion2Controller', 'destroy', $e->getMessage()));
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
            $precotizacion2 = PreCotizacion2::findOrFail($id);
            DB::beginTransaction();
            try {
                $newprecotizacion2 = $precotizacion2->replicate();
                $newprecotizacion2->save();

                // Proveedor
                $proveedores = PreCotizacion3::where('precotizacion3_precotizacion2', $precotizacion2->id)->get();
                foreach ($proveedores as $precotizacion3) {
                     $newprecotizacion3 = $precotizacion3->replicate();
                     $newprecotizacion3->precotizacion3_precotizacion2 = $newprecotizacion2->id;
                     $newprecotizacion3->precotizacion3_usuario_elaboro = Auth::user()->id;
                     $newprecotizacion3->precotizacion3_fh_elaboro = date('Y-m-d H:m:s');
                     $newprecotizacion3->save();
                }

                // Imagenes
                $imagenes = PreCotizacion4::where('precotizacion4_precotizacion2', $precotizacion2->id)->get();
                foreach ($imagenes as $precotizacion4) {
                     $newprecotizacion4 = $precotizacion4->replicate();
                     $newprecotizacion4->precotizacion4_precotizacion2 = $newprecotizacion2->id;
                     $newprecotizacion4->precotizacion4_usuario_elaboro = Auth::user()->id;
                     $newprecotizacion4->precotizacion4_fh_elaboro = date('Y-m-d H:m:s');
                     $newprecotizacion4->save();

                     // Recuperar imagen y copy
                     if( Storage::has("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id/$precotizacion4->precotizacion4_archivo") ) {

                         $oldfile = "pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id/$precotizacion4->precotizacion4_archivo";
                         $newfile = "pre-cotizaciones/precotizacion_$newprecotizacion2->precotizacion2_precotizacion1/producto_$newprecotizacion2->id/$newprecotizacion4->precotizacion4_archivo";

                         // Copy file storege laravel
                         Storage::copy($oldfile, $newfile);
                     }
                }

                // Impresiones
                $impresiones = PreCotizacion5::where('precotizacion5_precotizacion2', $precotizacion2->id)->get();
                foreach ($impresiones as $precotizacion5) {
                     $newprecotizacion5 = $precotizacion5->replicate();
                     $newprecotizacion5->precotizacion5_precotizacion2 = $newprecotizacion2->id;
                     $newprecotizacion5->save();
                }

                // Areasp
                $areasp = PreCotizacion6::where('precotizacion6_precotizacion2', $precotizacion2->id)->get();
                foreach ($areasp as $precotizacion6) {
                     $newprecotizacion6 = $precotizacion6->replicate();
                     $newprecotizacion6->precotizacion6_precotizacion2 = $newprecotizacion2->id;
                     $newprecotizacion6->save();
                }

                // Acabados
                $acabados = PreCotizacion7::where('precotizacion7_precotizacion2', $precotizacion2->id)->get();
                foreach ($acabados as $precotizacion7) {
                     $newprecotizacion7 = $precotizacion7->replicate();
                     $newprecotizacion7->precotizacion7_precotizacion2 = $newprecotizacion2->id;
                     $newprecotizacion7->save();
                }

                // Mquinas
                $maquinas = PreCotizacion8::where('precotizacion8_precotizacion2', $precotizacion2->id)->get();
                foreach ($maquinas as $precotizacion8) {
                     $newprecotizacion8 = $precotizacion8->replicate();
                     $newprecotizacion8->precotizacion8_precotizacion2 = $newprecotizacion2->id;
                     $newprecotizacion8->save();
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $newprecotizacion2->id, 'msg' => 'Producto de pre-cotización clonado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
