<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, log, Datatables;

use App\Models\Accounting\Folder;

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
            $query = Folder::query();
            $query->select('koi_folder.id as id','folder_codigo', 'folder_nombre');
            return Datatables::of($query)->make(true);
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
        //
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show (Request $request, $id)
    {
        $folders = Folder::getFolders($id);
        if($folders instanceof Folder){
            if ($request->ajax()) {
                return response ()->json($folders);
            }
            // return view('accounting.plancuentas.show', ['plancuenta' => $plancuenta]);
        }
        abort (404);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        //
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
    
    /**
     * Filter folders.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        if ($request->has('folder')) {
            $data = Folder::select('id', 'folder_nombre')->where('folder_folder', $request->folder)->get();
            return response()->json(['success' => true, 'folders' => $data]);
        }
        return response()->json(['success' => false]);
    }
}