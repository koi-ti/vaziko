<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion10;
use App\Models\Inventory\Producto;
use Log, DB;

class Cotizacion10Controller extends Controller
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
            if ($request->has('cotizacion2')) {
                $data = Cotizacion10::getCotizaciones10($request->cotizacion2);
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
            $cotizacion10 = new Cotizacion10;
            if ($cotizacion10->isValid($data)) {
                try {
                    if ($request->has('cotizacion10_producto')) {
                        $producto = Producto::find($request->cotizacion10_producto);
                        if (!$producto instanceof Producto) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el transporte de producción, por favor verifique la información o consulte al administrador.']);
                        }
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'transporte_nombre' => isset($producto) ? $producto->producto_nombre : '-']);
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion10->errors]);
        }
        abort(403);
    }
}
