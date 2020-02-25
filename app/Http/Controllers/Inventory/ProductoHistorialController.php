<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\ProductoHistorial;
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
            $data = [];
            if ($request->has('tipo') && $request->has('insumo')) {
                $data = ProductoHistorial::where('productohistorial_tipo', $request->tipo)
                                        ->where('productohistorial_producto', $request->insumo)
                                        ->limit(10)
                                        ->get();
            }
            return response()->json($data);
        }
        abort(404);
    }
}
