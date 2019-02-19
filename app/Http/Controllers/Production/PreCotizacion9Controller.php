<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion9, App\Models\Inventory\Producto;
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
             $detalle = [];
             if ($request->has('precotizacion2')) {
                 $detalle = PreCotizacion9::getPreCotizaciones9( $request->precotizacion2 );
                 return response()->json( $detalle );
             }
             if ($request->has('insumo')) {
                 $detalle = PreCotizacion9::select('koi_precotizacion9.id', 'precotizacion9_valor_unitario as valor')->where('precotizacion9_producto', $request->insumo)->orderBy('id', 'desc')->first();
             }
             return response()->json($detalle);
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
            if ( $precotizacion9->isValid($data) ) {
                try {
                    $producto = Producto::find($request->precotizacion9_producto);
                    if(!$producto instanceof Producto){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque, por favor verifique la información o consulte al administrador.']);
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'producto_nombre' => $producto->producto_nombre]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion9->errors]);
        }
        abort(403);
    }
}
