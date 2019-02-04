<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Materialp, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion4, App\Models\Production\Cotizacion6, App\Models\Inventory\Producto;
use DB, Log;

class Cotizacion4Controller extends Controller
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
            if( $request->has('cotizacion2') ){
                $detalle = Cotizacion4::getCotizaciones4( $request->cotizacion2 );
                return response()->json( $detalle );
            }
            if ($request->has('insumo')) {
                $detalle = Cotizacion4::select('cotizacion4_valor_unitario as valor')->where('cotizacion4_producto', $request->insumo)->orderBy('id', 'desc')->first();
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
            $cotizacion4 = new Cotizacion4;
            if ( $cotizacion4->isValid($data) ) {
                try {
                    $materialp = Materialp::find($request->cotizacion4_materialp);
                    if(!$materialp instanceof Materialp){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    $insumo = Producto::find($request->cotizacion4_producto);
                    if(!$insumo instanceof Producto){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el insumo de ese material, por favor verifique la información o consulte al administrador.']);
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'materialp_nombre' => $materialp->materialp_nombre, 'producto_nombre' => $insumo->producto_nombre]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion4->errors]);
        }
        abort(403);
    }
}
