<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion6, App\Models\Production\Cotizacion2, App\Models\Production\Areap;
use DB, Log;

class Cotizacion6Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $cotizacion = [];
            if($request->has('cotizacion2')) {
                $cotizacion = Cotizacion6::getCotizaciones6($request->cotizacion2);
            }
            return response()->json($cotizacion);
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $cotizacion6 = new Cotizacion6;
            if ( $cotizacion6->isValid($data) ) {
                try {
                    $areap_nombre = null;

                    if($request->cotizacion6_horas == 0 && $request->cotizacion6_minutos == 0){
                        return response()->json(['success' => false, 'errors' => 'No puede ingresar horas y minutos en 0.']);
                    }

                    if(empty(trim($request->cotizacion6_valor)) || is_null(trim($request->cotizacion6_valor))){
                        return response()->json(['success' => false, 'errors' => 'El campo valor es obligatorio.']);
                    }

                    // Recuperar areap
                    if( !empty($request->cotizacion6_areap) ){
                        $areap = Areap::find($request->cotizacion6_areap);
                        if( !$areap instanceof Areap){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el area.']);
                        }
                        $areap_nombre = $areap->areap_nombre;
                    }else{
                        if(empty(trim($request->cotizacion6_nombre)) || is_null(trim($request->cotizacion6_nombre))){
                            return response()->json(['success' => false, 'errors' => 'El campo nombre es obligatorio cuando no tiene area.']);
                        }
                    }

                    $tiempo = "{$request->cotizacion6_horas}:{$request->cotizacion6_minutos}";

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'areap_nombre' => $areap_nombre, 'cotizacion6_tiempo' => $tiempo]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion6->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
                $cotizacion6 = Cotizacion6::select('koi_cotizacion6.id as id', 'cotizacion6_cotizacion2', 'cotizacion6_valor', DB::raw("SUBSTRING_INDEX(cotizacion6_tiempo, ':', '-1') AS cotizacion6_minutos"), DB::raw("SUBSTRING_INDEX(cotizacion6_tiempo, ':', '1') AS cotizacion6_horas"))->where('koi_cotizacion6.id', $id)->first();
                if(!$cotizacion6 instanceof Cotizacion6){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar area, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Recuperar cotizacion2
                $cotizacion2 = Cotizacion2::find( $cotizacion6->cotizacion6_cotizacion2 );
                if(!$cotizacion2 instanceof Cotizacion2){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Recuperar valor total de las areasp
                $valorareasp = Cotizacion6::select( DB::raw("SUM( ((SUBSTRING_INDEX(cotizacion6_tiempo, ':', -1) / 60 ) + SUBSTRING_INDEX(cotizacion6_tiempo, ':', 1)) * cotizacion6_valor ) as valor_total"))->where('cotizacion6_cotizacion2', $cotizacion2->id)->first();

                // Convertir minutos a horas y sumar horas
                $tiempo = intval($cotizacion6->cotizacion6_horas) + (intval($cotizacion6->cotizacion6_minutos) / 60);

                // recuperar valor a eliminar (areap * tiempo) / cantidad
                $areaptotal = ($cotizacion6->cotizacion6_valor * $tiempo) / $cotizacion2->cotizacion2_cantidad;

                // Recuperar valor de los campos existentes
                $transporte = $cotizacion2->cotizacion2_transporte / $cotizacion2->cotizacion2_cantidad;
                $viaticos = $cotizacion2->cotizacion2_viaticos / $cotizacion2->cotizacion2_cantidad;
                $areasp = $valorareasp->valor_total / $cotizacion2->cotizacion2_cantidad;

                // Restar area a eliminar con el valor existente
                $areapfinal = $areasp - $areaptotal;

                // Valor recalculado
                $valorunitario = $cotizacion2->cotizacion2_precio_venta + round($transporte) + round($viaticos) + round($areapfinal);

                // Recalcular comision (total/(((100-volumen)/100))) * (1-(((100-volumen)/100)))
                if($cotizacion2->cotizacion2_redondear == true){
                    $comision = round(($valorunitario / (((100-$cotizacion2->cotizacion2_volumen)/100))) * (1-(((100-$cotizacion2->cotizacion2_volumen)/100))));
                }else{
                    $comision = ($valorunitario / (((100-$cotizacion2->cotizacion2_volumen)/100))) * (1-(((100-$cotizacion2->cotizacion2_volumen)/100)));
                }

                // Quitar cotizacion2
                $cotizacion2->cotizacion2_total_valor_unitario = $valorunitario + $comision;
                $cotizacion2->cotizacion2_vtotal = $comision;
                $cotizacion2->save();

                // Eliminar item productop4
                $cotizacion6->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Cotizacion6Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
