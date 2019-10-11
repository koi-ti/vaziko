<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Materialp, App\Models\Production\PreCotizacion10;
use App\Models\Inventory\Producto;
use DB, Log;

class PreCotizacion10Controller extends Controller
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
            if ($request->has('precotizacion2')) {
                $data = PreCotizacion10::getPreCotizaciones10($request->precotizacion2);
            }
            return response()->json($data);
        }
        abort(404);
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
            $precotizacion10 = new PreCotizacion10;
            if ($precotizacion10->isValid($data)) {
                try {
                    $transporte = Materialp::where('materialp_transporte', true)->find($request->precotizacion10_materialp);
                    if (!$transporte instanceof Materialp) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el transporte de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    $producto = Producto::where('producto_transporte', true)->find($request->precotizacion10_producto);
                    if (!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del transporte, por favor verifique la información o consulte al administrador.']);
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'transporte_nombre' => $transporte->materialp_nombre, 'producto_nombre' => $producto->producto_nombre]);
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion10->errors]);
        }
        abort(403);
    }
}
