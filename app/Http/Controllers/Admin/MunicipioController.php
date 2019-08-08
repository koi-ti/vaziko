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
            $query->join('koi_departamento', 'koi_municipio.departamento_codigo', '=', 'koi_departamento.departamento_codigo');

            if ($request->has('datatables')) {
                $query->select('koi_departamento.departamento_codigo', 'municipio_codigo', 'municipio_nombre', 'departamento_nombre', 'koi_departamento.id as departamento_id');
                return Datatables::of($query)->make(true);
            }

            $query->select('koi_municipio.id as id', DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as text"));
            if ($request->has('id')) {
                $query->where('koi_municipio.id', $request->id);
            }

            if ($request->has('q')) {
                $query->where( function($query) use($request) {
                    $query->whereRaw("municipio_nombre like '%".$request->q."%'");
                    $query->orWhereRaw("departamento_nombre like '%".$request->q."%'");
                });
            }

            if (empty($request->q) && empty($request->id)) {
                $query->take(50);
            }

            $query->orderby('departamento_nombre','asc');
            $query->orderby('municipio_nombre','asc');
            return response()->json($query->get());
        }
        return view('admin.municipios.index', ['empresa' => parent::getPaginacion()]);
    }
}
