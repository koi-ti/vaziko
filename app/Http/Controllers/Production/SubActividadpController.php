<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Actividadp, App\Models\Production\SubActividadp;
use Cache, Datatables, DB, Log;

class SubActividadpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         if($request->ajax()){
             $query = SubActividadp::query();
             $query->select('koi_subactividadp.*', 'actividadp_nombre');
             $query->join('koi_actividadp', 'subactividadp_actividadp', '=', 'koi_actividadp.id');

             if( $request->has('datatables') ) {
                 return Datatables::of($query->get())->make(true);
             }

             if( $request->has('actividadesp') ){
                 $query->where('subactividadp_actividadp', $request->actividadesp);
                 $query->where('subactividadp_activo', true);
             }

             return response()->json($query->get());
         }
         return view('production.subactividadesp.index', ['empresa' => parent::getPaginacion()]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.subactividadesp.create');
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
            $subactividadp = new SubActividadp;

            if( $subactividadp->isValid($data) ) {
                DB::beginTransaction();
                try {
                    // Recuperar actividad
                    $actividadp = Actividadp::find( $request->subactividadp_actividadp );
                    if(!$actividadp instanceof Actividadp) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar actividad de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // SubActividadp
                    $subactividadp->fill($data);
                    $subactividadp->fillBoolean($data);
                    $subactividadp->subactividadp_actividadp = $actividadp->id;
                    $subactividadp->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( SubActividadp::$key_cache );

                    return response()->json(['success' => true, 'id' => $subactividadp->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subactividadp->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $subactividadp = SubActividadp::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($subactividadp);
        }
        return view('production.subactividadesp.show', ['subactividadp' => $subactividadp]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subactividadp = SubActividadp::findOrFail($id);
        return view('production.subactividadesp.edit', ['subactividadp' => $subactividadp]);
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
            $subactividadp = SubActividadp::findOrFail($id);

            if( $subactividadp->isValid($data) ) {
                DB::beginTransaction();
                try {
                    // Recuperar actividad
                    $actividadp = Actividadp::find( $request->subactividadp_actividadp );
                    if(!$actividadp instanceof Actividadp){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar actividad de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // SubActividadp
                    $subactividadp->fill($data);
                    $subactividadp->fillBoolean($data);
                    $subactividadp->subactividadp_actividadp = $actividadp->id;
                    $subactividadp->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( SubActividadp::$key_cache );

                    return response()->json(['success' => true, 'id' => $subactividadp->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subactividadp->errors]);
        }
        abort(403);
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
