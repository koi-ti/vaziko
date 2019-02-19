<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion9, App\Models\Inventory\Producto;
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
            $detalle = [];
            if ($request->has('cotizacion2')) {
                $detalle = Cotizacion9::getCotizaciones9( $request->cotizacion2 );
            }
            if ($request->has('insumo')) {
                $detalle = Cotizacion9::select('koi_cotizacion9.id', 'cotizacion9_valor_unitario as valor')->where('cotizacion9_producto', $request->insumo)->orderBy('id', 'desc')->first();
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
            $cotizacion9 = new Cotizacion9;
            if ( $cotizacion9->isValid($data) ) {
                try {
                    $producto = Producto::find($request->cotizacion9_producto);
                    if(!$producto instanceof Producto){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'producto_nombre' => $producto->producto_nombre]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion9->errors]);
        }
        abort(403);
    }
}
