<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Tiempop, App\Models\Production\ActividadOp, App\Models\Production\SubActividadOp, App\Models\Production\Ordenp, App\Models\Production\Areap;
use DB, Log, Auth;

class TiempopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $tiempos = Tiempop::getTiemposp();
            return response()->json(['tiempos' => $tiempos]);
        }
        return view('production.tiemposp.main');
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
            $tiempop = new Tiempop;

            if ( $tiempop->isValid($data) ) {
                DB::beginTransaction();
                try {

                    // Recuperar Actividadop
                    $actividadop = ActividadOp::find( $request->tiempop_actividadop );
                    if( !$actividadop instanceof ActividadOp ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar actividad de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar Areap
                    $areap = Areap::find( $request->tiempop_areap );
                    if( !$areap instanceof Areap ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar area de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    if($request->has('tiempop_ordenp')){
                        // Recuperar Ordenp
                        $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '$request->tiempop_ordenp'")->first();
                        if( !$ordenp instanceof Ordenp ){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        $tiempop->tiempop_ordenp = $ordenp->id;
                    }

                    // Recuperar Subactividadop
                    if($request->has('tiempop_subactividadop')){
                        $subactividadop = SubActividadOp::find( $request->tiempop_subactividadop );
                        if( !$subactividadop instanceof SubActividadOp ) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar subactividad de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        // Validar que sean validas actividadop y subactividadop
                        if( $actividadop->id != $subactividadop->subactividadop_actividad) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'La actividad no esta relacionada con la subactividad, por favor verifique la información o consulte al administrador.']);
                        }

                        $tiempop->tiempop_subactividadop = $subactividadop->id;
                    }

                    // Tiempop
                    $tiempop->fill($data);
                    $tiempop->tiempop_actividadop = $actividadop->id;
                    $tiempop->tiempop_areap = $areap->id;
                    $tiempop->tiempop_tercero = Auth::user()->id;
                    $tiempop->tiempop_fh_elaboro = date('Y-m-d H:m:s');
                    $tiempop->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'msg' => 'El tiempo fue registrado con exito.']);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tiempop->errors]);
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
        if ($request->ajax()) {
            $data = $request->all();

            $tiempop = Tiempop::findOrFail($request->tiempo_id);
            if( !$tiempop instanceof Tiempop ){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tiempo de la orden, por favor verifique la información o consulte al administrador.']);
            }

            if( $tiempop->tiempop_tercero != Auth::user()->id ){
                return response()->json(['success' => false, 'errors' => 'El tercero que intenta editar no corresponde a este tiempo, por favor verifique la información o consulte al administrador.']);
            }

            DB::beginTransaction();
            try{
                // Tiempop
                $tiempop->fill($data);
                $tiempop->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'El tiempo se edito con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
