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
                 // Recuperar precotizacion5
                 $precotizacion5 = PreCotizacion5::find( $id );
                 if(!$precotizacion5 instanceof PreCotizacion5){
                     return response()->json(['success' => false, 'errors' => 'No es posible recuperar el item a eliminar, por favor verifique la información o consulte al administrador.']);
                 }

                 // Eliminar item precotizacion5
                 $precotizacion5->delete();

                 DB::commit();
                 return response()->json(['success' => true]);
             }catch(\Exception $e){
                 DB::rollback();
                 Log::error(sprintf('%s -> %s: %s', 'PreCotizacion5Controller', 'destroy', $e->getMessage()));
                 return response()->json(['success' => false, 'errors' => trans('app.exception')]);
             }
         }
         abort(403);
     }
}
