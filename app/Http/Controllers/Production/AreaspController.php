<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Cache;

use App\Models\Production\Areap;

class AreaspController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Areap::query();
            return Datatables::of($query)->make(true);
        }
        return view('production.areas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.areas.create');
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

            $area = new Areap;
            if ($area->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Area
                    $area->fill($data);
                    $area->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( Areap::$key_cache );

                    return response()->json(['success' => true, 'id' => $area->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $area->errors]);
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
        $area = Areap::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($area);
        }
        return view('production.areas.show', ['area' => $area]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Areap::findOrFail($id);
        return view('production.areas.edit', ['area' => $area]);
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

            $area = Areap::findOrFail($id);
            if ($area->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Area
                    $area->fill($data);
                    $area->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( Areap::$key_cache );

                    return response()->json(['success' => true, 'id' => $area->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $area->errors]);
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
