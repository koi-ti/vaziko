<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Materialp, App\Models\Production\Ordenp9, App\Models\Inventory\Producto;
use DB, Log;

class DetalleEmpaquesController extends Controller
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
            if( $request->has('orden2') ){
                $detalle = Ordenp9::getOrdenesp9( $request->orden2 );
            }
            if ($request->has('insumo')) {
                $detalle = Ordenp9::select('orden9_valor_unitario as valor')->where('orden9_producto', $request->insumo)->orderBy('id', 'desc')->first();
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
            $orden9 = new Ordenp9;
            if ( $orden9->isValid($data) ) {
                try {
                    $empaque = Materialp::where('materialp_empaque', true)->find($request->orden9_materialp);
                    if(!$empaque instanceof Materialp){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    $producto = Producto::find($request->orden9_producto);
                    if(!$producto instanceof Producto){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el empaque de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'empaque_nombre' => $empaque->materialp_nombre, 'producto_nombre' => $producto->producto_nombre]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden9->errors]);
        }
        abort(403);
    }
}
