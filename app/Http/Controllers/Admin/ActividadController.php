<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Actividad;
use DB, Log, Datatables, Cache;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Actividad::query();

            if( $request->has('datatables') ) {
                return Datatables::of($query)->make(true);
            }

            $data = [];
            $query->select('koi_actividad.id', DB::raw("UPPER(CONCAT(actividad_codigo, ' - ', actividad_nombre)) as text"));
            $query->orderby('actividad_codigo', 'asc');

            if($request->has('id')){
                $query->where('koi_actividad.id', $request->id);
            }

            if($request->has('q')) {
                $query->where( function($query) use($request) {
                    $query->whereRaw("actividad_nombre like '%".$request->q."%'");
                    $query->orWhereRaw("actividad_codigo like '%".$request->q."%'");
                });
            }

            if(empty($request->q) && empty($request->id)) {
                $query->take(50);
            }

            $query->orderby('actividad_nombre','asc');
            return response()->json($query->get());

            return $data;
        }
        return view('admin.actividades.index', ['empresa' => parent::getPaginacion()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.actividades.create');
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

            $actividad = new Actividad;
            if ($actividad->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Actividad
                    $actividad->fill($data);
                    $actividad->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( Actividad::$key_cache );

                    return response()->json(['success' => true, 'id' => $actividad->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $actividad->errors]);
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
        $actividad = Actividad::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($actividad);
        }
        return view('admin.actividades.show', ['actividad' => $actividad]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('admin.actividades.edit', ['actividad' => $actividad]);
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

            $actividad = Actividad::findOrFail($id);
            if ($actividad->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Actividad
                    $actividad->fill($data);
                    $actividad->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( Actividad::$key_cache );

                    return response()->json(['success' => true, 'id' => $actividad->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $actividad->errors]);
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
