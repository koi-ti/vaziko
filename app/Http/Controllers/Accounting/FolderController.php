<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accounting\Folder;
use DB, Log, Datatables;

class FolderController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Folder::query())->make(true);
        }
        return view('accounting.folders.index');
    }

    /**
    * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        return view('accounting.folders.create');
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
            $folder = new Folder;
            if ($folder->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Folder
                    $folder->fill($data);
                    $folder->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $folder->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $folder->errors]);
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
        $folder = Folder::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($folder);
        }
        return view('accounting.folders.show', compact('folder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $folder = Folder::findOrFail($id);
        return view('accounting.folders.edit', compact('folder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $folder = Folder::findOrFail($id);
            if ($folder->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Folder
                    $folder->fill($data);
                    $folder->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $folder->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $folder->errors]);
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
