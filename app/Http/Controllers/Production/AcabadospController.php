<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Acabadop;
use DB, Log, Datatables, Cache;

class AcabadospController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of( Acabadop::query() )->make(true);
        }
        return view('production.acabados.index', ['empresa' => parent::getPaginacion()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.acabados.create');
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
            $acabado = new Acabadop;
            if ($acabado->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Acabado
                    $acabado->fill($data);
                    $acabado->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( Acabadop::$key_cache );
                    return response()->json(['success' => true, 'id' => $acabado->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $acabado->errors]);
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
        $acabado = Acabadop::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($acabado);
        }
        return view('production.acabados.show', ['acabado' => $acabado]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $acabado = Acabadop::findOrFail($id);
        return view('production.acabados.edit', ['acabado' => $acabado]);
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
            $acabado = Acabadop::findOrFail($id);
            if ($acabado->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Area
                    $acabado->fill($data);
                    $acabado->save();

                    // Commit Transaction
                    DB::commit();
                    
                    // Forget cache
                    Cache::forget( Acabadop::$key_cache );
                    return response()->json(['success' => true, 'id' => $acabado->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $acabado->errors]);
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
