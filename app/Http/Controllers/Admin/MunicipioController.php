<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Municipio;
use Datatables, DB;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Municipio::query();
            $query->select('koi_departamento.departamento_codigo', 'municipio_codigo', 'municipio_nombre', 'departamento_nombre', 'koi_departamento.id as departamento_id');
            $query->join('koi_departamento', 'koi_municipio.departamento_codigo', '=', 'koi_departamento.departamento_codigo');
            return Datatables::of($query)->make(true);
        }
        return view('admin.municipios.index');
    }
}
