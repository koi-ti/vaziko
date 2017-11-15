<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\ActividadOp;
use Datatables, Cache, DB;

class ActividadOpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = ActividadOp::query();
            return Datatables::of($query)->make(true);
        }
        return view('production.actividadesop.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.actividadesop.create');
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
            $actividadop = new ActividadOp;

            if( $actividadop->isValid($data) ) {
                DB::beginTransaction();
                try {
                    // ActividadOp
                    $actividadop->fill($data);
                    $actividadop->fillBoolean($data);
                    $actividadop->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( ActividadOp::$key_cache );

                    return response()->json(['success' => true, 'id' => $actividadop->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $actividadop->errors]);
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
        $actividadop = ActividadOp::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($actividadop);
        }
        return view('production.actividadesop.show', ['actividadop' => $actividadop]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actividadop = ActividadOp::findOrFail($id);
        return view('production.actividadesop.edit', ['actividadop' => $actividadop]);
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
            $actividadop = ActividadOp::findOrFail($id);

            if( $actividadop->isValid($data) ) {
                DB::beginTransaction();
                try {
                    // ActividadOp
                    $actividadop->fill($data);
                    $actividadop->fillBoolean($data);
                    $actividadop->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( ActividadOp::$key_cache );

                    return response()->json(['success' => true, 'id' => $actividadop->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $actividadop->errors]);
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
