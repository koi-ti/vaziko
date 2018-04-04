<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Production\Materialp, App\Models\Production\PreCotizacion3;
use DB, Log;

class PreCotizacion3Controller extends Controller
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
            if( $request->has('precotizacion2') ){
                $detalle = PreCotizacion3::getPreCotizaciones3( $request->precotizacion2 );
                return response()->json( $detalle );
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
            $precotizacion3 = new PreCotizacion3;
            if ( $precotizacion3->isValid($data) ) {
                try {
                    // Validar tercero y materialp
                    $tercero = Tercero::where('tercero_nit', $request->precotizacion1_proveedor)->first();
                    if(!$tercero instanceof Tercero){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el proveedor, por favor verifique la información o consulte al administrador.']);
                    }

                    $materialp = Materialp::find($request->precotizacion3_materialp);
                    if(!$materialp instanceof Materialp){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'materialp_nombre' => $materialp->materialp_nombre, 'tercero_nombre' => $request->precotizacion1_proveedor_nombre]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion3->errors]);
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
                // Recuperar precotizacion3
                $precotizacion3 = PreCotizacion3::find( $id );
                if(!$precotizacion3 instanceof PreCotizacion3){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el item a eliminar, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Eliminar item precotizacion3
                $precotizacion3->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'PreCotizacion3Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
