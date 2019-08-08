<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\TipoMaterialp;
use DB, Log, Datatables, Cache;

class TipoMaterialespController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(TipoMaterialp::query())->make(true);
        }
        return view('production.tipomaterialesp.index', ['empresa' => parent::getPaginacion()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.tipomaterialesp.create');
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
            $tipomaterialp = new TipoMaterialp;
            if ($tipomaterialp->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tipo de material
                    $tipomaterialp->fill($data);
                    $tipomaterialp->fillBoolean($data);
                    $tipomaterialp->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(TipoMaterialp::$key_cache);
                    return response()->json(['success' => true, 'id' => $tipomaterialp->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipomaterialp->errors]);
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
        $tipomaterialp = TipoMaterialp::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($tipomaterialp);
        }
        return view('production.tipomaterialesp.show', compact('tipomaterialp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipomaterialp = TipoMaterialp::findOrFail($id);
        return view('production.tipomaterialesp.edit', compact('tipomaterialp'));
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
            $tipomaterialp = TipoMaterialp::findOrFail($id);
            if ($tipomaterialp->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Material
                    $tipomaterialp->fill($data);
                    $tipomaterialp->fillBoolean($data);
                    $tipomaterialp->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(TipoMaterialp::$key_cache);
                    return response()->json(['success' => true, 'id' => $tipomaterialp->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipomaterialp->errors]);
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
