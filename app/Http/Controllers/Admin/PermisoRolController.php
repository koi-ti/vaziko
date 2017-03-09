<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Datatables, DB;

use App\Models\Base\Modulo, App\Models\Base\PermisoRol;

class PermisoRolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $query = Modulo::query();
            $query->select('koi_modulo.id', 'display_name');
            $query->where('nivel1', '=', $request->nivel1);
            $query->where('nivel2', '=', $request->nivel2);
            $query->where('nivel3', '!=', '0');
            $query->where('nivel4', '=', '0');
            $query->orderBy('nivel3', 'asc');
            $modules = $query->get();

            $data = [];
            foreach ($modules as $module)
            {
                $object = new \stdClass();
                $object->id = $module->id;
                $object->display_name = $module->display_name;

                $query = PermisoRol::query();
                $query->where('role_id', 1);
                $query->where('module_id', $module->id);
                $query->orderBy('permission_id', 'asc');
                $object->mpermissions = $query->lists('permission_id');

                $data[] = $object;
            }
            return response()->json($data);
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
