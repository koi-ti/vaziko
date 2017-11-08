<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Production\TipoMaterial;

use DB, Log, Datatables, Cache;

class TiposMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = TipoMaterial::query();
            return Datatables::of($query)->make(true);
        }
        return view('production.tiposmaterial.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.tiposmaterial.create');
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

            $tipomaterial = new TipoMaterial;
            if ($tipomaterial->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tipo de material
                    $tipomaterial->fill($data);
                    $tipomaterial->fillBoolean($data);
                    $tipomaterial->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( TipoMaterial::$key_cache );

                    return response()->json(['success' => true, 'id' => $tipomaterial->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipomaterial->errors]);
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
        $tipomaterial = TipoMaterial::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($tipomaterial);
        }
        return view('production.tiposmaterial.show', ['tipomaterial' => $tipomaterial]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipomaterial = TipoMaterial::findOrFail($id);
        return view('production.tiposmaterial.edit', ['tipomaterial' => $tipomaterial]);
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

            $tipomaterial = TipoMaterial::findOrFail($id);
            if ($tipomaterial->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Material
                    $tipomaterial->fill($data);
                    $tipomaterial->fillBoolean($data);
                    $tipomaterial->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( TipoMaterial::$key_cache );

                    return response()->json(['success' => true, 'id' => $tipomaterial->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipomaterial->errors]);
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
