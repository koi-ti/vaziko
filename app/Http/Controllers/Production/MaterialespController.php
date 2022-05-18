<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Materialp, App\Models\Production\TipoMaterialp;
use DB, Log, Datatables, Cache;

class MaterialespController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Materialp::query();
            $query->select('koi_materialp.*', 'tipomaterial_nombre');
            $query->leftJoin('koi_tipomaterial', 'materialp_tipomaterial', '=', 'koi_tipomaterial.id');
            return Datatables::of($query)->make(true);
        }
        return view('production.materiales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.materiales.create');
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
            $material = new Materialp;
            if ($material->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar TipoMaterialp
                    $tipomaterial = TipoMaterialp::find($request->materialp_tipomaterial);
                    if (!$tipomaterial instanceof TipoMaterialp) {
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el tipo de material, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Material
                    $material->fill($data);
                    $material->fillBoolean($data);
                    $material->materialp_tipomaterial = $tipomaterial->id;
                    $material->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(Materialp::$key_cache);
                    return response()->json(['success' => true, 'id' => $material->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $material->errors]);
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
        $material = Materialp::find($id);
        if ($request->ajax()) {
            return response()->json($material);
        }
        return view('production.materiales.show', ['material' => $material]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $material = Materialp::findOrFail($id);
        return view('production.materiales.edit', ['material' => $material]);
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
            $material = Materialp::findOrFail($id);
            if ($material->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar TipoMaterialp
                    $tipomaterial = TipoMaterialp::find($request->materialp_tipomaterial);
                    if (!$tipomaterial instanceof TipoMaterialp) {
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el tipo de material, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Material
                    $material->fill($data);
                    $material->fillBoolean($data);
                    $material->materialp_tipomaterial = $tipomaterial->id;
                    $material->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(Materialp::$key_cache);
                    return response()->json(['success' => true, 'id' => $material->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $material->errors]);
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
