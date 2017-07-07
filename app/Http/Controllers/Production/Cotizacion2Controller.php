<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion1, App\Models\Production\Materialp;
use DB, Log;

class Cotizacion2Controller extends Controller
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
            $query = Cotizacion2::query();

            if($request->has('cotizacion')) {
                $query->select('koi_cotizacion2.*', 'materialp_nombre');
                $query->leftJoin('koi_materialp', 'cotizacion2_materialp', '=', 'koi_materialp.id');
                $query->where('cotizacion2_cotizacion1', $request->cotizacion);
                $query->orderBy('cotizacion2_productoc', 'asc');

            }else if( $request->has('cotizacion_id') ){
                $query = Cotizacion2::query();
                $query->whereNotNull('cotizacion2_productoc')->whereNull('cotizacion2_materialp');
                $query->where('cotizacion2_cotizacion1', $request->cotizacion_id);

            }

            $cotizacion = $query->get();
            return response()->json($cotizacion);
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

            $cotizacion2 = new Cotizacion2;
            if ($cotizacion2->isValid($data)) {
                DB::beginTransaction();
                try {
                    $materialp_nombre = null;

                    //Recuperar Cotizacion
                    $cotizacion = Cotizacion1::find($request->cotizacion1);
                    if(!$cotizacion instanceof Cotizacion1){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar la cotizacion, por favor verifique la informacion o consulte al administrador.']);
                    }

                    $cotizacion2->fill($data);
                    $cotizacion2->cotizacion2_cotizacion1 = $cotizacion->id;

                    // Recuperar materialp
                    if( !empty($request->cotizacion2_materialp) ){

                        $materialp = Materialp::find( $request->cotizacion2_materialp );
                        if(!$materialp instanceof Materialp){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el material.']);
                        }

                        // Validar padre y update valor
                        $result = $cotizacion2->whenMaterial();
                        if($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }

                        $cotizacion2->cotizacion2_materialp = $materialp->id;
                        $materialp_nombre = $materialp;
                    }else{
                        // Validar padre que no exista en db
                        $result = $cotizacion2->whenProducto();
                        if($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                    }

                    $cotizacion2->save();

                    // Commit Transaction
                    DB::commit();

                    return response()->json(['success' => true, 'id' => $cotizacion2->id, 'materialp_nombre'=>$materialp_nombre]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion2->errors]);
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
                // Recuperar Cotizacion2
                $cotizacion2 = Cotizacion2::find($id);
                if(!$cotizacion2 instanceof Cotizacion2){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar cotizacion, por favor verifique la información o consulte al administrador.']);
                }

                // Delete father and update valor
                $result = $cotizacion2->whenDelete();
                if( $result != 'OK'){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => $result]);
                }

                // Eliminar item Cotizacion2
                $cotizacion2->delete();

                DB::commit();
                return response()->json(['success' => true]);
                
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Cotizacion2Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
