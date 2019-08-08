<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Materialp, App\Models\Production\PreCotizacion9;
use App\Models\Inventory\Producto;
use DB, Log;

class PreCotizacion9Controller extends Controller
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
                 $data = PreCotizacion9::getPreCotizaciones9($request->precotizacion2);
             }

             if ($request->has('insumo')) {
                 $data = PreCotizacion9::select('koi_precotizacion9.id', 'precotizacion9_valor_unitario as valor')->where('precotizacion9_producto', $request->insumo)->orderBy('id', 'desc')->first();
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
            $precotizacion9 = new PreCotizacion9;
            if ($precotizacion9->isValid($data)) {
                try {
                    $empaque = Materialp::where('materialp_empaque', true)->find($request->precotizacion9_materialp);
                    if (!$empaque instanceof Materialp) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    $producto = Producto::where('producto_empaque', true)->find($request->precotizacion9_producto);
                    if (!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo del empaque, por favor verifique la información o consulte al administrador.']);
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'empaque_nombre' => $empaque->materialp_nombre, 'producto_nombre' => $producto->producto_nombre]);
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion9->errors]);
        }
        abort(403);
    }
}
