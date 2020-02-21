<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Actividadp;
use Datatables, Cache, DB;

class ActividadpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Actividadp::query())->make(true);
        }
        return view('production.actividadesp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.actividadesp.create');
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
            $actividadp = new Actividadp;
            if ($actividadp->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Actividadp
                    $actividadp->fill($data);
                    $actividadp->fillBoolean($data);
                    $actividadp->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(Actividadp::$key_cache);
                    return response()->json(['success' => true, 'id' => $actividadp->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $actividadp->errors]);
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
        $actividadp = Actividadp::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($actividadp);
        }
        return view('production.actividadesp.show', compact('actividadp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actividadp = Actividadp::findOrFail($id);
        return view('production.actividadesp.edit', compact('actividadp'));
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
            $actividadp = Actividadp::findOrFail($id);
            if ($actividadp->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Actividadp
                    $actividadp->fill($data);
                    $actividadp->fillBoolean($data);
                    $actividadp->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(Actividadp::$key_cache);
                    return response()->json(['success' => true, 'id' => $actividadp->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $actividadp->errors]);
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
