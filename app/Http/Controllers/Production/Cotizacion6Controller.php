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

                    $tiempo = sprintf('%s:%s', $request->cotizacion6_horas, $request->cotizacion6_minutos);

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'areap_nombre'=>$areap_nombre, 'cotizacion6_horas' => $tiempo]);
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
                $cotizacion6 = Cotizacion6::find($id);
                if(!$cotizacion6 instanceof Cotizacion6){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar area, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Recuperar cotizacion2
                $cotizacion2 = Cotizacion2::find( $cotizacion6->cotizacion6_cotizacion2 );
                if(!$cotizacion2 instanceof Cotizacion2){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información del asiento o consulte al administrador.']);
                }

                $tiempo = explode(':', $cotizacion6->cotizacion6_horas);
                $hora = $tiempo[0];
                $min = $tiempo[1];

                // Regla de tres para pasa min a horas
                $r3 = intval($min) / 60;
                $total = intval($hora) + $r3;

                $totalarea = $cotizacion6->cotizacion6_valor * $total;
                $unitario = $totalarea / $cotizacion2->cotizacion2_cantidad;
                $totalunitario = $cotizacion2->cotizacion2_total_valor_unitario - round($unitario);

                // Quitar cotizacion2
                $cotizacion2->cotizacion2_total_valor_unitario = $totalunitario;
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
