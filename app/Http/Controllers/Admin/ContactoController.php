<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Departamento;

use DB;

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

            $contacts = DB::table('tercerocontacto')->select('tercerocontacto_item as id', DB::raw("CONCAT(tercerocontacto_nombres,' ',tercerocontacto_apellidos) as tcontacto_nombre"), 'tercerocontacto_direccion as tcontacto_direccion', 'tercerocontacto_telefono as tcontacto_telefono', 'tercerocontacto_celular as tcontacto_celular', 'tercerocontacto_cargo as tcontacto_cargo', 'tercerocontacto_email as tcontacto_email')
                ->join('koi_tercero', 'tercero_nit', '=', 'tercerocontacto_tercero')
                ->where('koi_tercero.id', $request->tercero_id)->get();

            return response()->json($contacts);
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
