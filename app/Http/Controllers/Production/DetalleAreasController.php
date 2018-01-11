<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp6, App\Models\Production\Ordenp2, App\Models\Production\Areap;
use DB, Log;

class DetalleAreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $orden = [];
            if($request->has('orden2')) {
                $orden = Ordenp6::getOrdenesp6($request->orden2);
            }
            return response()->json($orden);
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
            $orden6 = new Ordenp6;
            if ( $orden6->isValid($data) ) {
                try {
                    $areap_nombre = null;

                    if(empty(trim($request->orden6_valor)) || is_null(trim($request->orden6_valor))){
                        return response()->json(['success' => false, 'errors' => 'El campo valor es obligatorio.']);
                    }

                    // Recuperar areap
                    if( !empty($request->orden6_areap) ){
                        $areap = Areap::find($request->orden6_areap);
                        if( !$areap instanceof Areap){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el area.']);
                        }
                        $areap_nombre = $areap->areap_nombre;
                    }else{
                        if(empty(trim($request->orden6_nombre)) || is_null(trim($request->orden6_nombre))){
                            return response()->json(['success' => false, 'errors' => 'El campo nombre es obligatorio cuando no tiene area.']);
                        }
                    }

                    $tiempo = sprintf('%s:%s', $request->orden6_horas, $request->orden6_minutos);

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'areap_nombre' => $areap_nombre, 'orden6_tiempo' => $tiempo]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden6->errors]);
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
                $orden6 = Ordenp6::find($id);
                if(!$orden6 instanceof Ordenp6){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar area, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Recuperar orden2
                $orden2 = Ordenp2::find($orden6->orden6_orden2);
                if(!$orden2 instanceof Ordenp2){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información del asiento o consulte al administrador.']);
                }

                $tiempo = explode(':', $orden6->orden6_tiempo); // explode input tiempo 00:00
                $horas = $tiempo[0];  // value for hour
                $minutos = $tiempo[1]; // value for minutes

                // Regla de tres para pasa min a horas
                $newhour = intval($horas) + (intval($minutos) / 60);

                $areap = $orden6->orden6_valor * $newhour;
                $unitario = $areap / $orden2->orden2_cantidad;
                $totalunitario = $orden2->orden2_total_valor_unitario - round($unitario);

                // Quitar orden2
                $orden2->orden2_total_valor_unitario = $totalunitario;
                $orden2->save();

                // Eliminar item productop4
                $orden6->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Ordenp6Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}