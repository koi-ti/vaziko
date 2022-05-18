<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Rol, App\Models\Base\Permiso;
use DB, Log, Datatables, Cache;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Rol::query())->make(true);
        }
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
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
            $rol = new Rol;
            if ($rol->isValid($data)) {
                DB::beginTransaction();
                try {
                    // roles
                    $rol->fill($data);

                    // Validate if exists unique key
                    $validateUniqueName = Rol::where('name', $rol->name)->first();
                    if ($validateUniqueName instanceof Rol) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El rol ya se encuentra registrado.']);
                    }

                    $rol->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(Rol::$key_cache);
                    return response()->json(['success' => true, 'id' => $rol->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $rol->errors]);
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
        $rol = Rol::findOrFail($id);
        if ($request->ajax()) {
            if (!in_array($rol->name, ['admin'])) {
                $rol->permissions = Permiso::get()->toArray();
            }
            return response()->json($rol);
        }
        return view('admin.roles.show', compact('rol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol = Rol::findOrFail($id);
        return view('admin.roles.create', compact('rol'));
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
            $rol = Rol::findOrFail($id);
            if ($rol->isValid($data)) {
                DB::beginTransaction();
                try {
                    // rol
                    $rol->fill($data);
                    $rol->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget(Rol::$key_cache);
                    return response()->json(['success' => true, 'id' => $rol->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $rol->errors]);
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
