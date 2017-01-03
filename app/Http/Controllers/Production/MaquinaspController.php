<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Cache;

use App\Models\Production\Maquinap;

class MaquinaspController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Maquinap::query();
            return Datatables::of($query)->make(true);
        }
        return view('production.maquinas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.maquinas.create');
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

            $maquina = new Maquinap;
            if ($maquina->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Area
                    $maquina->fill($data);
                    $maquina->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( Maquinap::$key_cache );

                    return response()->json(['success' => true, 'id' => $maquina->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $maquina->errors]);
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
        $maquina = Maquinap::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($maquina);
        }
        return view('production.maquinas.show', ['maquina' => $maquina]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $maquina = Maquinap::findOrFail($id);
        return view('production.maquinas.edit', ['maquina' => $maquina]);
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

            $maquina = Maquinap::findOrFail($id);
            if ($maquina->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Maquina
                    $maquina->fill($data);
                    $maquina->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( Maquinap::$key_cache );

                    return response()->json(['success' => true, 'id' => $maquina->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $maquina->errors]);
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
