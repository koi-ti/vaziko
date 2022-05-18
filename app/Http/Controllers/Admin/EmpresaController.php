<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Empresa, App\Models\Base\Tercero;
use Log, DB;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(Empresa::getEmpresa());
        }
        return view('admin.empresa.main');
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
            $empresa = Empresa::findOrFail($id);
            $tercero = Tercero::findOrFail($empresa->empresa_tercero);
            if ($tercero->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tercero
                    $tercero->fill($data);
                    $tercero->fillBoolean($data);
                    $tercero->save();

                    // Empresa
                    $empresa->fill($data);
                    $empresa->fillBoolean($data);
                    $empresa->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tercero->errors]);
        }
        abort(403);
    }
}
