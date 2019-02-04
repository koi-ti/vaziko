<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Materialp, App\Models\Production\Ordenp4, App\Models\Inventory\Producto;
use DB, Log;

class DetalleMaterialesController extends Controller
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
                $detalle = Ordenp4::getOrdenesp4( $request->orden2 );
            }
            if ($request->has('insumo')) {
                $detalle = Ordenp4::select('orden4_valor_unitario as valor')->where('orden4_producto', $request->insumo)->orderBy('id', 'desc')->first();
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
            $orden4 = new Ordenp4;
            if ( $orden4->isValid($data) ) {
                try {
                    $materialp = Materialp::find($request->orden4_materialp);
                    if(!$materialp instanceof Materialp){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    $insumo = Producto::find($request->orden4_producto);
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
            return response()->json(['success' => false, 'errors' => $orden4->errors]);
        }
        abort(403);
    }
}
