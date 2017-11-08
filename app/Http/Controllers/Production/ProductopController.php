<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Production\Productop, App\Models\Production\Productop2, App\Models\Production\Productop3, App\Models\Production\Productop4, App\Models\Production\Productop5, App\Models\Production\Productop6, App\Models\Production\TipoProductop, App\Models\Production\SubtipoProductop;
use Auth, DB, Log, Datatables, Cache;

class ProductopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Productop::query();
            $query->select('koi_productop.id as id', 'koi_productop.id as productop_codigo', 'productop_nombre');

            if($request->has('datatables')){
                // Persistent data filter
                if($request->has('persistent') && $request->persistent) {
                    session(['search_productop_codigo' => $request->has('productop_codigo') ? $request->productop_codigo : '']);
                    session(['search_productop_nombre' => $request->has('productop_nombre') ? $request->productop_nombre : '']);
                }

                return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Codigo
                    if($request->has('id')) {
                        $query->where('koi_productop.id', $request->id);
                    }

                    // Nombre
                    if($request->has('productop_nombre')) {
                        $query->whereRaw("productop_nombre LIKE '%{$request->productop_nombre}%'");
                    }
                })
                ->make(true);
            }

            // TypeProduct
            if( $request->has('typeproduct') && $request->has('subtypeproduct') )  {
                $query->where('productop_subtipoproductop', $request->subtypeproduct);
                $query->where('productop_tipoproductop', $request->typeproduct);
            }
            return response()->json($query->get());
        }
        return view('production.productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.productos.create');
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

            $producto = new Productop;
            if ($producto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tipo Productop
                    $typeproduct = TipoProductop::find( $request->productop_tipoproductop );
                    if(!$typeproduct instanceof TipoProductop){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de producto, por favor verifique la informacion ó consulte al administrador.']);
                    }

                    // Subtipo Productop
                    $subtypeproduct = SubtipoProductop::find( $request->productop_subtipoproductop );
                    if(!$subtypeproduct instanceof SubtipoProductop){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el subtipo de producto, por favor verifique la informacion ó consulte al administrador.']);
                    }

                    if($subtypeproduct->subtipoproductop_tipoproductop != $typeproduct->id){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "El subtipo $subtypeproduct->subtipoproductop_nombre no se encuentra asociado a $typeproduct->tipoproductop_nombre, por favor verifique la informacion ó consulte al administrador."]);
                    }

                    // grupo
                    $producto->fill($data);
                    $producto->fillBoolean($data);
                    $producto->setProperties();
                    $producto->productop_tipoproductop = $typeproduct->id;
                    $producto->productop_subtipoproductop = $subtypeproduct->id;
                    $producto->productop_usuario_elaboro = Auth::user()->id;
                    $producto->productop_fecha_elaboro = date('Y-m-d H:m:s');
                    $producto->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( Productop::$key_cache );
                    return response()->json(['success' => true, 'id' => $producto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $producto->errors]);
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
        $producto = Productop::getProduct($id);
        if($producto instanceof Productop){
            if ($request->ajax()) {
                return response()->json($producto);
            }
            return view('production.productos.show', ['producto' => $producto]);
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
        $producto = Productop::findOrFail($id);
        return view('production.productos.create', ['producto' => $producto]);
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

            $producto = Productop::findOrFail($id);
            if ($producto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tipo Productop
                    $typeproduct = TipoProductop::find( $request->productop_tipoproductop );
                    if(!$typeproduct instanceof TipoProductop){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de producto, por favor verifique la informacion ó consulte al administrador.']);
                    }

                    // Subtipo Productop
                    $subtypeproduct = SubtipoProductop::find( $request->productop_subtipoproductop );
                    if(!$subtypeproduct instanceof SubtipoProductop){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el subtipo de producto, por favor verifique la informacion ó consulte al administrador.']);
                    }

                    if($subtypeproduct->subtipoproductop_tipoproductop != $typeproduct->id){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "El subtipo $subtypeproduct->subtipoproductop_nombre no se encuentra asociado a $typeproduct->tipoproductop_nombre, por favor verifique la informacion ó consulte al administrador."]);
                    }

                    // Productop
                    $producto->fill($data);
                    $producto->fillBoolean($data);
                    $producto->setProperties();
                    $producto->productop_tipoproductop = $typeproduct->id;
                    $producto->productop_subtipoproductop = $subtypeproduct->id;
                    $producto->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( Productop::$key_cache );
                    return response()->json(['success' => true, 'id' => $producto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $producto->errors]);
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
     * Search orden2.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        dd($request->all());
        // if($request->has('orden2_id')) {
        //     $ordenp2 = Productop::getDetail($request->orden2_id);
        //     if($ordenp2 instanceof Ordenp2) {
        //         return response()->json(['success' => true, 'productop_nombre' => $ordenp2->productop_nombre, 'id' => $ordenp2->id]);
        //     }
        // }
        // return response()->json(['success' => false]);
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

            $productop = Productop::findOrFail($id);
            DB::beginTransaction();
            try {
                // Cotizacion
                $newproductop = $productop->replicate();
                $newproductop->productop_nombre = sprintf('%s - %s', $newproductop->productop_nombre, 'COPIA');
                $newproductop->productop_usuario_elaboro = Auth::user()->id;
                $newproductop->productop_fecha_elaboro = date('Y-m-d H:m:s');
                $newproductop->save();

                // Productop2
                $productosp2 = Productop2::where('productop2_productop', $productop->id)->orderBy('id', 'asc')->get();
                foreach ($productosp2 as $productop2) {
                    $newproductop2 = $productop2->replicate();
                    $newproductop2->productop2_productop = $newproductop->id;
                    $newproductop2->save();
                }

                // Productop3
                $productosp3 = Productop3::where('productop3_productop', $productop->id)->orderBy('id', 'asc')->get();
                foreach ($productosp3 as $productop3) {
                    $newproductop3 = $productop3->replicate();
                    $newproductop3->productop3_productop = $newproductop->id;
                    $newproductop3->save();
                }

                // Productop4
                $productosp4 = Productop4::where('productop4_productop', $productop->id)->orderBy('id', 'asc')->get();
                foreach ($productosp4 as $productop4) {
                    $newproductop4 = $productop4->replicate();
                    $newproductop4->productop4_productop = $newproductop->id;
                    $newproductop4->save();
                }

                // Productop5
                $productosp5 = Productop5::where('productop5_productop', $productop->id)->orderBy('id', 'asc')->get();
                foreach ($productosp5 as $productop5) {
                    $newproductop5 = $productop5->replicate();
                    $newproductop5->productop5_productop = $newproductop->id;
                    $newproductop5->save();
                }

                // Productop6
                $productosp6 = Productop6::where('productop6_productop', $productop->id)->orderBy('id', 'asc')->get();
                foreach ($productosp6 as $productop6) {
                    $newproductop6 = $productop6->replicate();
                    $newproductop6->productop6_productop = $newproductop->id;
                    $newproductop6->save();
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $newproductop->id, 'msg' => 'Producto clonado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
