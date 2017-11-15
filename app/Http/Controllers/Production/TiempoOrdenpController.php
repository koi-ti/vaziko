<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\TiempoOrdenp, App\Models\Production\ActividadOp, App\Models\Production\SubActividadOp, App\Models\Production\Ordenp, App\Models\Production\Areap;
use DB, Log, Auth;

class TiempoOrdenpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $tiempos = TiempoOrdenp::getTiempos();
            return response()->json(['tiempos' => $tiempos]);
        }
        return view('production.tiempoordenesp.main');
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
            $tiempoordenp = new TiempoOrdenp;

            if ( $tiempoordenp->isValid($data) ) {
                DB::beginTransaction();
                try {
                    // Recuperar Ordenp
                    $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '$request->tiempoordenp_ordenp'")->first();
                    if( !$ordenp instanceof Ordenp ){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar Actividadop
                    $actividadop = ActividadOp::find( $request->tiempoordenp_actividadop );
                    if( !$actividadop instanceof ActividadOp ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar actividad de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar Subactividadop
                    $subactividadop = SubActividadOp::find( $request->tiempoordenp_subactividadop );
                    if( !$subactividadop instanceof SubActividadOp ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar subactividad de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar que sean validas actividadop y subactividadop
                    if( $actividadop->id != $subactividadop->subactividadop_actividad) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'La actividad no esta relacionada con la subactividad, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar Areap
                    $areap = Areap::find( $request->tiempoordenp_areap );
                    if( !$areap instanceof Areap ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar area de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // TiempoOrdenp
                    $tiempoordenp->fill($data);
                    $tiempoordenp->tiempoordenp_ordenp = $ordenp->id;
                    $tiempoordenp->tiempoordenp_actividadop = $actividadop->id;
                    $tiempoordenp->tiempoordenp_subactividadop = $subactividadop->id;
                    $tiempoordenp->tiempoordenp_areap = $areap->id;
                    $tiempoordenp->tiempoordenp_tercero = Auth::user()->id;
                    $tiempoordenp->tiempoordenp_fh_elaboro = date('Y-m-d H:m');
                    $tiempoordenp->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'msg' => 'El tiempo fue registrado con exito.']);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tiempoordenp->errors]);
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
    public function destroy($id)
    {
        //
    }
}
