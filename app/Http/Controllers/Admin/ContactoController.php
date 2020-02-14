<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Base\Contacto;
use DB, Log;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('tercero_id')) {
                $query = Contacto::query();
                $query->select('koi_tcontacto.*');
                $query->where('tcontacto_tercero', $request->tercero_id);
                $data = $query->get();
            }
            return response()->json($data);
        }
        abort(404);
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
            $contacto = new Contacto;
            if ($contacto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::find($request->tcontacto_tercero);
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Contacto
                    $contacto->fill($data);
                    $contacto->tcontacto_tercero = $tercero->id;
                    $contacto->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $contacto->id, 'tcontacto_nombre' => "{$contacto->tcontacto_nombres} {$contacto->tcontacto_apellidos}"]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $contacto->errors]);
        }
        abort(403);
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
            $contacto = Contacto::findOrFail($id);
            if ($contacto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Contacto
                    $contacto->fill($data);
                    $contacto->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $contacto->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $contacto->errors]);
        }
        abort(403);
    }
}
