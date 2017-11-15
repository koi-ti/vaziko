<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\ActividadOp, App\Models\Production\SubActividadOp;
use Cache, Datatables, DB, Log;

class SubActividadOpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         if($request->ajax()){
             $query = SubActividadOp::query();
             $query->select('koi_subactividadop.*', 'actividadop_nombre');
             $query->join('koi_actividadop', 'subactividadop_actividad', '=', 'koi_actividadop.id');

             if( $request->has('datatables') ) {
                 return Datatables::of($query->get())->make(true);
             }

             if( $request->has('actividadesop') ){
                 $query->where('subactividadop_actividad', $request->actividadesop);
                 $query->where('subactividadop_activo', true);
             }

             return response()->json($query->get());
         }
         return view('production.subactividadesop.index');
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.subactividadesop.create');
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
            $subactividadop = new SubActividadOp;

            if( $subactividadop->isValid($data) ) {
                DB::beginTransaction();
                try {
                    // Recuperar actividad
                    $actividadop = ActividadOp::find( $request->subactividadop_actividad );
                    if(!$actividadop instanceof ActividadOp) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar actividad, por favor verifique la información o consulte al administrador.']);
                    }

                    // SubActividadOp
                    $subactividadop->fill($data);
                    $subactividadop->fillBoolean($data);
                    $subactividadop->subactividadop_actividad = $actividadop->id;
                    $subactividadop->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( SubActividadOp::$key_cache );

                    return response()->json(['success' => true, 'id' => $subactividadop->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subactividadop->errors]);
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

        $subactividadop = SubActividadOp::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($subactividadop);
        }
        return view('production.subactividadesop.show', ['subactividadop' => $subactividadop]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subactividadop = SubActividadOp::findOrFail($id);
        return view('production.subactividadesop.edit', ['subactividadop' => $subactividadop]);
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
            $subactividadop = SubActividadOp::findOrFail($id);

            if( $subactividadop->isValid($data) ) {
                DB::beginTransaction();
                try {
                    // Recuperar actividad
                    $actividadop = ActividadOp::find( $request->subactividadop_actividad );
                    if(!$actividadop instanceof ActividadOp){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar actividad, por favor verifique la información o consulte al administrador.']);
                    }

                    // SubActividadOp
                    $subactividadop->fill($data);
                    $subactividadop->fillBoolean($data);
                    $subactividadop->subactividadop_actividad = $actividadop->id;
                    $subactividadop->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( SubActividadOp::$key_cache );

                    return response()->json(['success' => true, 'id' => $subactividadop->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subactividadop->errors]);
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
