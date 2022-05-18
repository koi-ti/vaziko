<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\UsuarioRol, App\Models\Base\Tercero, App\Models\Base\Rol;
use DB, Log, Datatables, Cache;

class UsuarioRolController extends Controller
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
                $query = UsuarioRol::query();
                $query->select('koi_usuario_rol.*','koi_rol.display_name', 'koi_rol.name', 'koi_rol.id as id');
                $query->join('koi_rol', 'koi_usuario_rol.role_id', '=', 'koi_rol.id');
                $query->where('user_id', $request->tercero_id);
                $query->orderBy('user_id', 'asc');
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
            DB::beginTransaction();
            try {
                // Validar rol
                $rol = Rol::find($request->role_id);
                if (!$rol instanceof Rol) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar rol, por favor verifique la información o consulte al administrador.']);
                }

                // Validar tercero
                $tercero = Tercero::find($request->user_id);
                if (!$tercero instanceof Tercero) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información o consulte al administrador.']);
                }

                // Validar unique
                $usuariounique = UsuarioRol::where('user_id', $tercero->id)->where('role_id', $rol->id)->first();
                if ($usuariounique instanceof UsuarioRol) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => "El rol {$rol->display_name} ya se encuentra asociada a este tercero."]);
                }

                $tercero->attachRole($rol);

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $rol->id, 'display_name' =>$rol->display_name, 'name' => $rol->name]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                // Validar rol
                $rol = Rol::find($id);
                if (!$rol instanceof Rol) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar rol, por favor verifique la información o consulte al administrador.']);
                }

                // Validar tercero
                $tercero = Tercero::find($request->user_id);
                if (!$tercero instanceof Tercero) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item rol
                $tercero->detachRole($rol);

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'UsuarioRolController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
