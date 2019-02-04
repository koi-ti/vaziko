<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion2, App\Models\Production\PreCotizacion6, App\Models\Production\Areap;
use DB, Log;

class PreCotizacion6Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $detalle = [];
            if($request->has('precotizacion2')) {
                $detalle = PreCotizacion6::getPreCotizaciones6($request->precotizacion2);
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
            $precotizacion6 = new PreCotizacion6;
            if ( $precotizacion6->isValid($data) ) {
                try {
                    $areap_nombre = null;

                    if($request->precotizacion6_horas == 0 && $request->precotizacion6_minutos == 0){
                        return response()->json(['success' => false, 'errors' => 'No puede ingresar horas y minutos en 0.']);
                    }

                    if(empty(trim($request->precotizacion6_valor)) || is_null(trim($request->precotizacion6_valor))){
                        return response()->json(['success' => false, 'errors' => 'El campo valor es obligatorio.']);
                    }

                    // Recuperar areap
                    if( !empty($request->precotizacion6_areap) ){
                        $areap = Areap::find($request->precotizacion6_areap);
                        if( !$areap instanceof Areap){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el area.']);
                        }
                        $areap_nombre = $areap->areap_nombre;
                    }else{
                        if(empty(trim($request->precotizacion6_nombre)) || is_null(trim($request->precotizacion6_nombre))){
                            return response()->json(['success' => false, 'errors' => 'El campo nombre es obligatorio cuando no tiene area.']);
                        }
                    }

                    $tiempo = "{$request->precotizacion6_horas}:{$request->precotizacion6_minutos}";

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'areap_nombre' => $areap_nombre, 'precotizacion6_horas' => $request->precotizacion6_horas, 'precotizacion6_minutos' => $request->precotizacion6_minutos]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion6->errors]);
        }
        abort(403);
    }
}
