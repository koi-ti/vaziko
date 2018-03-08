<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Producto, App\Models\Production\Materialp;
use DB, Log, Datatables;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Producto::query();
            $query->select('koi_producto.id as id', 'producto_codigo', 'producto_nombre');

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['search_producto_codigo' => $request->has('producto_codigo') ? $request->producto_codigo : '']);
                session(['search_producto_nombre' => $request->has('producto_nombre') ? $request->producto_nombre : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Codigo
                    if($request->has('producto_codigo')) {
                        $query->whereRaw("producto_codigo LIKE '%{$request->producto_codigo}%'");
                    }

                    // Nombre
                    if($request->has('producto_nombre')) {
                        $query->whereRaw("producto_nombre LIKE '%{$request->producto_nombre}%'");
                    }
                })
                ->make(true);
        }
        return view('inventory.productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.productos.create');
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

            $producto = new Producto;
            if ($producto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // recuperar Materialp
                    if( $request->has('producto_materialp') ){
                        $materialp = Materialp::find($request->producto_materialp);
                        if(!$materialp instanceof Materialp){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                        }
                        $producto->producto_materialp = $materialp->id;
                    }

                    // Producto
                    $producto->fill($data);
                    $producto->fillBoolean($data);
                    $producto->save();

                    // En la creación siempre producto_referencia = id
                    $producto->producto_referencia = $producto->id;
                    $producto->save();

                    // Commit Transaction
                    DB::commit();
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
        $producto = Producto::getProduct($id);
        if($producto instanceof Producto){
            if ($request->ajax()) {
                return response()->json($producto);
            }
            return view('inventory.productos.show', ['producto' => $producto, 'available' => $producto->available]);
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
        $producto = Producto::findOrFail($id);
        return view('inventory.productos.edit', ['producto' => $producto]);
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

            $producto = Producto::findOrFail($id);
            if ($producto->isValid($data)) {
                if($producto->id != $producto->producto_referencia ) {
                    return response()->json(['success' => false, 'errors' => 'No es posible editar una serie, para modificar comportamiento por favor modifique la referencia padre.']);
                }

                DB::beginTransaction();
                try {
                    // recuperar Materialp
                    if( $request->has('producto_materialp') ){
                        $materialp = Materialp::find($request->producto_materialp);
                        if(!$materialp instanceof Materialp){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                        }
                        $producto->producto_materialp = $materialp->id;
                    }else{
                        $producto->producto_materialp = null;
                    }

                    // Producto
                    $producto->fill($data);
                    $producto->fillBoolean($data);
                    $producto->save();

                    // Commit Transaction
                    DB::commit();
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
     * Search producto.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->has('producto_codigo')) {
            $producto = Producto::select('id', 'producto_nombre', 'producto_metrado', 'producto_serie', 'producto_unidades')->where('producto_codigo', $request->producto_codigo)->first();
            if($producto instanceof Producto) {
                return response()->json(['success' => true, 'id' => $producto->id, 'producto_nombre' => $producto->producto_nombre, 'producto_metrado' => $producto->producto_metrado, 'producto_serie' => $producto->producto_serie, 'producto_unidades' => $producto->producto_unidades]);
            }
        }
        return response()->json(['success' => false]);
    }
    /**
     * Evaluate actions inventory.
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluate(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->action = "";
        $response->tipo = "";
        $response->producto = "";

        // Recuperar producto
        $producto = Producto::where('producto_codigo', $request->producto_codigo)->first();
        if(!$producto instanceof Producto){
            return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
        }

        //Maneja unidaes en inventario
        if ($producto->producto_unidades == true)
        {
            if ($request->tipo === 'S') {
                if ($producto->producto_metrado) {
                    $action = 'metrado';
                }else if ($producto->producto_serie){
                    $action = 'series';
                }else{
                    $action = 'unidades';
                }
                $response->producto = $producto->id;
                $response->tipo = $request->tipo;
                $response->action = $action;
                $response->success = true;
            }
        }else{
            $response->errors = "No es posible realizar movimientos para productos que no manejan unidades";
            $response->success = false;
        }
        // dd($request->all());

        return response()->json($response);
    }
}
