<?php

namespace App\Http\Controllers\Receivable;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Receivable\Factura2;
use DB;

class Factura2Controller extends Controller
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
            if($request->has('factura2')) {
                $detalle = Factura2::where('factura2_factura1', $request->factura2)->get();
            }

            if($request->has('factura1_orden')) {
                $orden = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->factura1_orden}'")->first();
                if($orden instanceof Ordenp){
                    $detalle = $orden->paraFacturar();
                }
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
            try {
                //Recuperar ordenp2
                $ordenp2 = Ordenp2::getDetail($request->factura1_orden);
                if(!$ordenp2 instanceof Ordenp2){
                    return response()->json(['success'=>false, 'errors'=>'No es posible recuperar la orden, por favor verifique la informacion o consulte al administrador.']);
                }

                return response()->json(['success' => true, 'id' => uniqid(), 'factura2_orden2' => $ordenp2->id, 'factura2_producto_nombre' => $ordenp2->productop_nombre, 'orden2_cantidad' => $ordenp2->orden2_cantidad, 'orden2_facturado' => $ordenp2->orden2_facturado, 'factura2_producto_valor_unitario' => $ordenp2->orden2_total_valor_unitario, 'orden_codigo' => $ordenp2->orden_codigo]);
            }catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
