<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion1, App\Models\Production\PreCotizacion2, App\Models\Production\PreCotizacion3, App\Models\Production\Productop, App\Models\Base\Tercero, App\Models\Production\Materialp;
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
                    $precotizacion2->precotizacion2_precotizacion1 = $precotizacion->id;
                    $precotizacion2->precotizacion2_productop = $producto->id;
                    $precotizacion2->save();

                    // Materiales
                    $materiales = isset($data['detalle']) ? $data['detalle'] : null;
                    foreach ($materiales as $material) {
                        // Validar tercero y materialp
                        $tercero = Tercero::where('tercero_nit', $material['precotizacion1_proveedor'])->first();
                        if(!$tercero instanceof Tercero){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el proveedor, por favor verifique la información o consulte al administrador.']);
                        }

                        $materialp = Materialp::find($material['precotizacion3_materialp']);
                        if(!$materialp instanceof Materialp){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        $precotizacion3 = new PreCotizacion3;
                        $precotizacion3->fill($material);
                        $precotizacion3->precotizacion3_precotizacion2 = $precotizacion2->id;
                        $precotizacion3->precotizacion3_materialp = $materialp->id;
                        $precotizacion3->precotizacion3_proveedor = $tercero->id;
                        $precotizacion3->precotizacion3_productop = $producto->id;
                        $precotizacion3->precotizacion3_fh_elaboro = date('Y-m-d H:m:s');
                        $precotizacion3->precotizacion3_usuario_elaboro = Auth::user()->id;
                        $precotizacion3->save();
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $precotizacion2->id]);
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
                        $precotizacion2->save();

                        // Materiales
                        $materiales = isset($data['detalle']) ? $data['detalle'] : null;
                        foreach ($materiales as $material) {
                            // Validar que el id sea entero(los temporales tienen letras)
                            if( isset( $material['precotizacion1_proveedor'] ) ){
                                // Validar tercero y materialp
                                $tercero = Tercero::where('tercero_nit', $material['precotizacion1_proveedor'])->first();
                                if(!$tercero instanceof Tercero){
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el proveedor, por favor verifique la información o consulte al administrador.']);
                                }

                                $materialp = Materialp::find($material['precotizacion3_materialp']);
                                if(!$materialp instanceof Materialp){
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                                }

                                $newprecotizacion3 = new PreCotizacion3;
                                $newprecotizacion3->fill($material);
                                $newprecotizacion3->precotizacion3_precotizacion2 = $precotizacion2->id;
                                $newprecotizacion3->precotizacion3_materialp = $materialp->id;
                                $newprecotizacion3->precotizacion3_proveedor = $tercero->id;
                                $newprecotizacion3->precotizacion3_productop = $precotizacion2->precotizacion2_productop;
                                $newprecotizacion3->precotizacion3_fh_elaboro = date('Y-m-d H:m:s');
                                $newprecotizacion3->precotizacion3_usuario_elaboro = Auth::user()->id;
                                $newprecotizacion3->save();
                            }
                        }

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => $precotizacion2->id]);
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

                DB::table('koi_precotizacion4')->where('precotizacion4_precotizacion2', $precotizacion2->id)->delete();

                if( Storage::has("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1") ) {
                    Storage::deleteDirectory("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1");
                }

                // Eliminar item precotizacion2
                $precotizacion2->delete();

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
}
