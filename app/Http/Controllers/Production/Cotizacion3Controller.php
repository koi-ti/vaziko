<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Production\Cotizacion3, App\Models\Production\Cotizacion1, App\Models\Production\Areap;
use DB, Log;

class Cotizacion3Controller extends Controller
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
            if($request->has('cotizacion')) {
                $query = Cotizacion3::query();
                $query->select('koi_cotizacion3.*', 'areap_nombre');
                $query->leftJoin('koi_areap', 'cotizacion3_areap', '=', 'koi_areap.id');
                $query->where('cotizacion3_cotizacion1', $request->cotizacion);

                $cotizacion = $query->get();
            }
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
            $cotizacion3 = new Cotizacion3;
            if ($cotizacion3->isValid($data)) {
                DB::beginTransaction();
                try {
                    $areap_nombre = null;

                    //Recuperar Cotizacion
                    $cotizacion = Cotizacion1::find($request->cotizacion1);
                    if(!$cotizacion instanceof Cotizacion1){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar la cotizacion, por favor verifique la informacion o consulte al administrador.']);
                    }

                    $cotizacion3->fill($data);
                    $cotizacion3->cotizacion3_cotizacion1 = $cotizacion->id;

                    // Recuperar areap
                    if( !empty($request->cotizacion3_areap) ){
                        $areap = Areap::find($request->cotizacion3_areap);
                        if(!$areap instanceof Areap){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el area.']);
                        }

                        $areap_nombre = $areap->areap_nombre;

                        $cotizacion3->cotizacion3_areap = $areap->id;
                    }

                    $cotizacion3->save();

                    // Commit Transaction
                    DB::commit();

                    return response()->json(['success' => true, 'id' => $cotizacion3->id, 'areap_nombre'=>$areap_nombre]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion3->errors]);
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
                // Recuperar Cotizacion3
                $cotizacion3 = Cotizacion3::find($id);
                if(!$cotizacion3 instanceof Cotizacion3){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar cotizacion, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item Cotizacion3
                $cotizacion3->delete();

                DB::commit();
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Cotizacion3Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
