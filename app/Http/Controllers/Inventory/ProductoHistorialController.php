<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\ProductoHistorial;
use App\Models\Inventory\Producto;
use DB;

class ProductoHistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $producto = Producto::find($request->insumo);
            $tipo = $producto->producto_empaque === 0 ? 'M':'E';

            $data = [];
            if ($request->has('tipo') && $request->has('insumo')) {
                $data = ProductoHistorial::where('productohistorial_tipo', $tipo)
                                        ->where('productohistorial_producto', $request->insumo)
                                        ->orderBy('productohistorial_fh_elaboro', 'asc')
                                        // ->limit(20)
                                        ->get();
            }
            return response()->json($data);
        }
        abort(404);
    }
}
