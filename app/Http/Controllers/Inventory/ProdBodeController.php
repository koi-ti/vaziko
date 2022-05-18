<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
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
        if ($request->ajax()) {
            $data = [];
            if ($request->has('producto')) {
                $producto = Producto::find($request->producto);
                if (!$producto instanceof Producto) {
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
                $data = $query->get();
            }
            return response()->json($data);
        }
    }
}
