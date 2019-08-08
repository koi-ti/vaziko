<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\TipoProductop;
use DB, Log, Datatables, Cache;

class TipoProductopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(TipoProductop::query())->make(true);
        }
        return view('production.tipoproductosp.index', ['empresa' => parent::getPaginacion()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.tipoproductosp.create');
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
            $tipoproductop = new TipoProductop;
            if ($tipoproductop->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tipo de productop
                    $tipoproductop->fill($data);
                    $tipoproductop->fillBoolean($data);
                    $tipoproductop->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(TipoProductop::$key_cache);
                    return response()->json(['success' => true, 'id' => $tipoproductop->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoproductop->errors]);
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
        $tipoproductop = TipoProductop::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($tipoproductop);
        }
        return view('production.tipoproductosp.show', compact('tipoproductop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoproductop = TipoProductop::findOrFail($id);
        return view('production.tipoproductosp.edit', compact('tipoproductop'));
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
            $tipoproductop = TipoProductop::findOrFail($id);
            if ($tipoproductop->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Material
                    $tipoproductop->fill($data);
                    $tipoproductop->fillBoolean($data);
                    $tipoproductop->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(TipoProductop::$key_cache);
                    return response()->json(['success' => true, 'id' => $tipoproductop->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoproductop->errors]);
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
