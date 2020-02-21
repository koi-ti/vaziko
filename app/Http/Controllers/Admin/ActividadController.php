<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
            return Datatables::of(Actividad::query())->make(true);
        }
        return view('admin.actividades.index');
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
                    Cache::forget(Actividad::$key_cache);
                    return response()->json(['success' => true, 'id' => $actividad->id]);
                } catch(\Exception $e) {
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
        return view('admin.actividades.show', compact('actividad'));
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
        return view('admin.actividades.edit', compact('actividad'));
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
                    Cache::forget(Actividad::$key_cache);
                    return response()->json(['success' => true, 'id' => $actividad->id]);
                } catch(\Exception $e) {
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
