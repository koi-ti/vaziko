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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $cotizacion4 = Cotizacion4::find($id);
                if(!$cotizacion4 instanceof Cotizacion4) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material a eliminar.']);
                }

                // Recuperar cotizacion2
                $cotizacion2 = Cotizacion2::find( $cotizacion4->cotizacion4_cotizacion2 );
                if(!$cotizacion2 instanceof Cotizacion2){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Recuperar valor total de las areasp
                $areasp = Cotizacion6::select( DB::raw("SUM( ((SUBSTRING_INDEX(cotizacion6_tiempo, ':', -1) / 60 ) + SUBSTRING_INDEX(cotizacion6_tiempo, ':', 1)) * cotizacion6_valor ) as valor_total"))->where('cotizacion6_cotizacion2', $cotizacion2->id)->first();
                $materialesp = Cotizacion4::where('cotizacion4_cotizacion2', $cotizacion2->id)->sum('cotizacion4_valor_total');

                $transporte = $cotizacion2->cotizacion2_transporte / $cotizacion2->cotizacion2_cantidad;
                $viaticos = $cotizacion2->cotizacion2_viaticos / $cotizacion2->cotizacion2_cantidad;
                $materialp = ($materialesp / $cotizacion2->cotizacion2_cantidad) - ($cotizacion4->cotizacion4_valor_total / $cotizacion2->cotizacion2_cantidad);
                $areasp = $areasp->valor_total / $cotizacion2->cotizacion2_cantidad;

                $nuevovalorunitario = $cotizacion2->cotizacion2_precio_venta + round($transporte) + round($viaticos) + round($materialp) + round($areasp);

                // Recalcular comision (total/(((100-volumen)/100))) * (1-(((100-volumen)/100)))
                if($cotizacion2->cotizacion2_round == true){
                    $comision = round(($nuevovalorunitario / (((100-$cotizacion2->cotizacion2_volumen)/100))) * (1-(((100-$cotizacion2->cotizacion2_volumen)/100))));
                }else{
                    $comision = ($nuevovalorunitario / (((100-$cotizacion2->cotizacion2_volumen)/100))) * (1-(((100-$cotizacion2->cotizacion2_volumen)/100)));
                }

                // Quitar cotizacion2
                $cotizacion2->cotizacion2_total_valor_unitario = $nuevovalorunitario + $comision;
                $cotizacion2->cotizacion2_vtotal = $comision;
                $cotizacion2->save();

                // Eliminar item cotizacion
                $cotizacion4->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Cotizacion4Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
