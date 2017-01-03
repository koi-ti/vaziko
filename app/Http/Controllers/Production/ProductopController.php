<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, DB, Log, Datatables, Cache;

use App\Models\Production\Productop;

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

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['search_productop_codigo' => $request->has('productop_codigo') ? $request->productop_codigo : '']);
                session(['search_productop_nombre' => $request->has('productop_nombre') ? $request->productop_nombre : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Codigo
                    if($request->has('productop_codigo')) {
                        $query->where('koi_productop.id', $request->productop_codigo);
                    }

                    // Nombre
                    if($request->has('productop_nombre')) {
                        $query->whereRaw("productop_nombre LIKE '%{$request->productop_nombre}%'");
                    }
                })
                ->make(true);
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
                    // grupo
                    $producto->fill($data);
                    $producto->fillBoolean($data);
                    $producto->setProperties();
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
        return view('production.productos.edit', ['producto' => $producto]);
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
                    // Productop
                    $producto->fill($data);
                    $producto->fillBoolean($data);
                    $producto->setProperties();
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
}
