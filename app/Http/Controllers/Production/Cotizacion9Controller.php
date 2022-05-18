<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Materialp, App\Models\Production\Cotizacion9;
use App\Models\Inventory\Producto;
use Log, DB;

class Cotizacion9Controller extends Controller
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
                $data = Cotizacion9::getCotizaciones9($request->cotizacion2);
            }
            if ($request->has('insumo')) {
                $data = Cotizacion9::select('koi_cotizacion9.id', 'cotizacion9_valor_unitario as valor')->where('cotizacion9_producto', $request->insumo)->orderBy('id', 'desc')->first();
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
            $cotizacion9 = new Cotizacion9;
            if ($cotizacion9->isValid($data)) {
                try {
                    $empaque = Materialp::where('materialp_empaque', true)->find($request->cotizacion9_materialp);
                    if (!$empaque instanceof Materialp) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    $producto = Producto::find($request->cotizacion9_producto);
                    if (!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'empaque_nombre' => $empaque->materialp_nombre, 'producto_nombre' => $producto->producto_nombre]);
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion9->errors]);
        }
        abort(403);
    }
}
