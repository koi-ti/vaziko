<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Cache;

use App\Models\Inventory\SubGrupo;

class SubGrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = SubGrupo::query();
            $query->select('koi_subgrupo.id as id', 'subgrupo_codigo', 'subgrupo_nombre');
            return Datatables::of($query)->make(true);
        }
        return view('inventory.subgrupos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.subgrupos.create');
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

            $subgrupo = new SubGrupo;
            if ($subgrupo->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Subgrupo
                    $subgrupo->fill($data);
                    $subgrupo->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( SubGrupo::$key_cache );

                    return response()->json(['success' => true, 'id' => $subgrupo->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subgrupo->errors]);
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
        $subgrupo = SubGrupo::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($subgrupo);
        }
        return view('inventory.subgrupos.show', ['subgrupo' => $subgrupo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subgrupo = SubGrupo::findOrFail($id);
        return view('inventory.subgrupos.edit', ['subgrupo' => $subgrupo]);
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

            $subgrupo = SubGrupo::findOrFail($id);
            if ($subgrupo->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Subgrupo
                    $subgrupo->fill($data);
                    $subgrupo->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( SubGrupo::$key_cache );

                    return response()->json(['success' => true, 'id' => $subgrupo->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subgrupo->errors]);
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
