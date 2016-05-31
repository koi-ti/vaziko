<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables;

use App\Models\Accounting\CentroCosto;

class CentroCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CentroCosto::query();
            return Datatables::of($query)->make(true);
        }
        return view('accounting.centroscosto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.centroscosto.create');
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
            
            $centrocosto = new CentroCosto;
            if ($centrocosto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Centro costo
                    $centrocosto->fill($data);
                    $centrocosto->fillBoolean($data);
                    $centrocosto->save();

                    // Commit Transaction
                    DB::commit();
                    // DB::rollback();
                    return response()->json(['success' => true, 'id' => $centrocosto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $centrocosto->errors]);
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
        $centrocosto = CentroCosto::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($centrocosto);    
        }        
        return view('accounting.centroscosto.show', ['centrocosto' => $centrocosto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $centrocosto = CentroCosto::findOrFail($id);
        return view('accounting.centroscosto.edit', ['centrocosto' => $centrocosto]);
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
            
            $centrocosto = CentroCosto::findOrFail($id);
            if ($centrocosto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Centro costo
                    $centrocosto->fill($data);
                    $centrocosto->fillBoolean($data);
                    $centrocosto->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $centrocosto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $centrocosto->errors]);
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
