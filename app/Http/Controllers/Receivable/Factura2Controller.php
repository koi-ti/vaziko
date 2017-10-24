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
                $query = Factura2::query();
                $query->select('koi_factura2.*', 'koi_ordenproduccion2.id as orden2_id', 'orden2_total_valor_unitario', DB::raw("
                    CASE
                        WHEN productop_3d != 0 THEN
                                CONCAT(
                                COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') 3D(',
                                COALESCE(orden2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                        WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN
                                CONCAT(
                                COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                                COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                                COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                        WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN
                                CONCAT(
                                COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                                COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                        WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN
                                CONCAT(
                                COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') C(',
                                COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                        ELSE
                                CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                        END AS productop_nombre
                    ")
                );
                $query->join('koi_factura1', 'factura2_factura1', '=', 'koi_factura1.id');
                $query->join('koi_ordenproduccion2', 'factura2_orden2', '=', 'koi_ordenproduccion2.id');

                // Joins producto
                $query->leftJoin('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
                $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
                $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
                $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
                $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
                $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
                $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
                $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');

                $query->where('factura2_factura1', $request->factura2);
                $detalle = $query->get();
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
            $data = $request->all();

            $factura2 = new Factura2;
            DB::beginTransaction();
            try {
                //Recuperar ordenp2
                $ordenp2 = Ordenp2::getDetail($request->factura1_orden);
                if(!$ordenp2 instanceof Ordenp2){
                    DB::rollback();
                    return response()->json(['success'=>false, 'errors'=>'No es posible recuperar la orden, por favor verifique la informacion o consulte al administrador.']);
                }

                // Commit Transaction
                DB::commit();

                return response()->json(['success' => true,
                    'id' => $ordenp2->id,
                    'productop_nombre' => $ordenp2->productop_nombre,
                    'orden2_cantidad' => $ordenp2->orden2_cantidad,
                    'orden2_facturado' => $ordenp2->orden2_facturado,
                    'orden2_total_valor_unitario' => $ordenp2->orden2_total_valor_unitario,
                    'orden_codigo' => $ordenp2->orden_codigo]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
            return response()->json(['success' => false, 'errors' => $factura2->errors]);
        }
        abort(403);
    }

}
