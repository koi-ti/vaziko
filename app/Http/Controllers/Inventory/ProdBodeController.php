<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Prodbode, App\Models\Inventory\Producto;

class ProdBodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $producto = Producto::find($request->producto);
            if(!$producto instanceof Producto){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información ó consulte al administrador.']);
            }

            // Querie Prodbode
            $query = Prodbode::query();
            $query->select('producto_codigo','producto_nombre','prodbode_cantidad','sucursal_nombre');
            $query->join('koi_producto', 'prodbode_producto', '=', 'koi_producto.id');
            $query->join('koi_sucursal', 'prodbode_sucursal', '=', 'koi_sucursal.id');
            $query->where('producto_referencia', $producto->id);
            $query->where('koi_producto.id' ,'<>' ,$producto->id);
            $query->whereRaw('prodbode_cantidad > 0');
            $query->orderBy('sucursal_nombre', 'asc');
            $prodbode = $query->get();
            return response()->json($prodbode);
        }
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
        //
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
