<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accounting\Documento, App\Models\Accounting\Folder;
use DB, Log, Datatables;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Documento::query();
            $query->select('koi_documento.id as id', 'documento_codigo', 'documento_nombre', 'folder_codigo', 'documento_actual', 'documento_nif');
            $query->leftJoin('koi_folder', 'documento_folder', '=', 'koi_folder.id');
            return Datatables::of($query)->make(true);
        }
        return view('accounting.documentos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.documentos.create');
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
            $documento = new Documento;
            if ($documento->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar folder
                    $folder = Folder::find($request->documento_folder);
                    if (!$folder instanceof Folder) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el folder, por favor verifique la información o consulte al administrador.']);
                    }

                    // Documento
                    $documento->fill($data);
                    $documento->fillBoolean($data);
                    $documento->documento_folder = $folder->id;
                    $documento->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $documento->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $documento->errors]);
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
        $documento = Documento::getDocument($id);
        if ($documento instanceof Documento){
            if ($request->ajax()) {
                return response()->json($documento);
            }
            return view('accounting.documentos.show', compact('documento'));
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documento = Documento::findOrFail($id);
        return view('accounting.documentos.edit', compact('documento'));
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
            $documento = Documento::findOrFail($id);
            if ($documento->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar folder
                    $folder = Folder::find($request->documento_folder);
                    if (!$folder instanceof Folder) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el folder, por favor verifique la información o consulte al administrador.']);
                    }

                    // Documento
                    $documento->fill($data);
                    $documento->fillBoolean($data);
                    $documento->documento_folder = $folder->id;
                    $documento->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $documento->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $documento->errors]);
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
