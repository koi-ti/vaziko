<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Materialp, App\Models\Production\Ordenp2, App\Models\Production\Ordenp4, App\Models\Production\Ordenp6, App\Models\Inventory\Producto;
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
            if( $request->has('ordenp2') ){
                $detalle = Ordenp4::getOrdenesp4( $request->ordenp2 );
                return response()->json( $detalle );
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
                $ordenp4 = Ordenp4::find($id);
                if(!$ordenp4 instanceof Ordenp4) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material a eliminar.']);
                }

                // Recuperar orden2
                $ordenp2 = Ordenp2::find( $ordenp4->orden4_orden2 );
                if(!$ordenp2 instanceof Ordenp2){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                }

                // Recuperar valor total de las areasp
                $areasp = Ordenp6::select( DB::raw("SUM( ((SUBSTRING_INDEX(orden6_tiempo, ':', -1) / 60 ) + SUBSTRING_INDEX(orden6_tiempo, ':', 1)) * orden6_valor ) as valor_total"))->where('orden6_orden2', $ordenp2->id)->first();
                $materialesp = Ordenp4::where('orden4_orden2', $ordenp2->id)->sum('orden4_valor_total');

                $transporte = $ordenp2->orden2_transporte / $ordenp2->orden2_cantidad;
                $viaticos = $ordenp2->orden2_viaticos / $ordenp2->orden2_cantidad;
                $materialp = ($materialesp / $ordenp2->orden2_cantidad) - ($ordenp4->orden4_valor_total / $ordenp2->orden2_cantidad);
                $areasp = $areasp->valor_total / $ordenp2->orden2_cantidad;

                $nuevovalorunitario = $ordenp2->orden2_precio_venta + round($transporte) + round($viaticos) + round($materialp) + round($areasp);

                // Recalcular comision (total/(((100-volumen)/100))) * (1-(((100-volumen)/100)))
                if($ordenp2->orden2_round == true){
                    $comision = round(($nuevovalorunitario / (((100-$ordenp2->orden2_volumen)/100))) * (1-(((100-$ordenp2->orden2_volumen)/100))));
                }else{
                    $comision = ($nuevovalorunitario / (((100-$ordenp2->orden2_volumen)/100))) * (1-(((100-$ordenp2->orden2_volumen)/100)));
                }

                // Quitar orden2
                $ordenp2->orden2_total_valor_unitario = $nuevovalorunitario + $comision;
                $ordenp2->orden2_vtotal = $comision;
                $ordenp2->save();

                // Eliminar item orden
                $ordenp4->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Ordenp4Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
