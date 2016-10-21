<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, DB;

use App\Models\Inventory\Producto, App\Models\Inventory\Traslado2;

class DetalleTrasladoController extends Controller
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
            if($request->has('traslado')) {
                $query = Traslado2::query();
                $query->select('koi_producto.id', 'traslado2_cantidad', 'traslado2_costo', 'producto_codigo', 'producto_nombre');
                $query->join('koi_producto', 'traslado2_producto', '=', 'koi_producto.id');
                $query->where('traslado2_traslado', $request->traslado);
                $detalle = $query->get();
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
    public function create()
    {
        //
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

            $traslado2 = new Traslado2;
            if ($traslado2->isValid($data)) {
                try {
                    // Recuperar producto
                    $producto = Producto::where('producto_codigo', $request->producto_codigo)->first();
                    if(!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    return response()->json(['success' => true, 'id' => uniqid()]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }

            return response()->json(['success' => false, 'errors' => $traslado2->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
