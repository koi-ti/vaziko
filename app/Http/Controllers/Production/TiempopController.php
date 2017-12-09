<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Tiempop, App\Models\Production\Actividadp, App\Models\Production\SubActividadp, App\Models\Production\Ordenp, App\Models\Production\Areap;
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
            $tiemposp = Tiempop::getTiemposp();
            return response()->json( $tiemposp );
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
                    $itemcodigo = $itemtercero = $itemsubactividadp = null;

                    // Validar rango hora inicio
                    $query = Tiempop::query();
                    $query->where('tiempop_tercero', Auth::user()->id);
                    $query->where('tiempop_fecha', $request->tiempop_fecha);
                    $query->where(function ($query) use ($request){
                        $query->where('tiempop_hora_inicio', '<=', $request->tiempop_hora_inicio);
                        $query->where('tiempop_hora_fin', '>', $request->tiempop_hora_inicio);
                    });
                    $rango = $query->get();

                    if(count($rango) > 0){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'La hora de inicio no puede interferir con otras ya registradas, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar Actividadop
                    $actividadp = Actividadp::find( $request->tiempop_actividadp );
                    if( !$actividadp instanceof Actividadp ) {
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
                        $ordenp = Ordenp::getOrdenp($request->tiempop_ordenp);
                        if( !$ordenp instanceof Ordenp ){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        $tiempop->tiempop_ordenp = $ordenp->id;
                        $itemcodigo = $ordenp->orden_codigo;
                        $itemtercero = $ordenp->tercero_nombre;
                    }

                    // Recuperar Subactividadp
                    if($request->has('tiempop_subactividadp')){
                        $subactividadp = SubActividadp::find( $request->tiempop_subactividadp );
                        if( !$subactividadp instanceof SubActividadp ) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar subactividad de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        // Validar que sean validas actividadp y subactividadp
                        if( $actividadp->id != $subactividadp->subactividadp_actividadp) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'La actividad no esta relacionada con la subactividad, por favor verifique la información o consulte al administrador.']);
                        }

                        $tiempop->tiempop_subactividadp = $subactividadp->id;
                        $itemsubactividadp = $subactividadp->subactividadp_nombre;
                    }

                    // Tiempop
                    $tiempop->fill($data);
                    $tiempop->tiempop_actividadp = $actividadp->id;
                    $tiempop->tiempop_areap = $areap->id;
                    $tiempop->tiempop_tercero = Auth::user()->id;
                    $tiempop->tiempop_fh_elaboro = date('Y-m-d H:m:s');
                    $tiempop->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tiempop->id, 'actividadp_nombre' => $actividadp->actividadp_nombre, 'areap_nombre' => $areap->areap_nombre, 'tiempop_hora_inicio' => $tiempop->tiempop_hora_inicio, 'tiempop_hora_fin' => $tiempop->tiempop_hora_fin, 'tiempop_fecha' => $tiempop->tiempop_fecha, 'subactividadp_nombre' => $itemsubactividadp, 'orden_codigo' => $itemcodigo, 'tercero_nombre' => $itemtercero]);
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

            $tiempop = Tiempop::findOrFail( $id );
            if( !$tiempop instanceof Tiempop ){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tiempo de la orden, por favor verifique la información o consulte al administrador.']);
            }

            if( $tiempop->tiempop_tercero != Auth::user()->id ){
                return response()->json(['success' => false, 'errors' => 'El tercero que intenta editar no corresponde a este tiempo, por favor verifique la información o consulte al administrador.']);
            }

            // Validar rango hora inicio
            $query = Tiempop::query();
            $query->where('tiempop_tercero', Auth::user()->id);
            $query->where('tiempop_fecha', $request->tiempop_fecha);
            $query->where(function ($query) use ($request, $tiempop){
                $query->where('tiempop_hora_inicio', '<=', $request->tiempop_hora_inicio);
                $query->where('tiempop_hora_fin', '>', $request->tiempop_hora_inicio);
                $query->where('koi_tiempop.id', '!=', $tiempop->id);
            });
            $rango = $query->get();

            if(count($rango) > 0){
                return response()->json(['success' => false, 'errors' => 'La hora de inicio no puede interferir con otras ya registradas, por favor verifique la información o consulte al administrador.']);
            }

            if ( $tiempop->isValid($data) ) {
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
            return response()->json(['success' => false, 'errors' => $tiempop->errors]);
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
