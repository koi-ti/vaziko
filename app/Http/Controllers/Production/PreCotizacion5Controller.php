<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion5;
use DB, Log;

class PreCotizacion5Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            $detalle = [];
            if( $request->has('precotizacion2') ){
                $query = PreCotizacion5::query();
                $query->where('precotizacion5_precotizacion2', $request->precotizacion2);
                $detalle = $query->get();
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
            $precotizacion5 = new PreCotizacion5;
            if ( $precotizacion5->isValid($data) ) {
                try {

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid()]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion5->errors]);
        }
        abort(403);
    }
}
