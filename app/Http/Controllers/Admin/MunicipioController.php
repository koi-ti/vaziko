<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Datatables, DB;

use App\Models\Base\Municipio;

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

            if( $request->has('datatables') ) {
                $query->select('koi_departamento.departamento_codigo', 'municipio_codigo', 'municipio_nombre', 'departamento_nombre', 'koi_departamento.id as departamento_id');
                return Datatables::of($query)->make(true);
            }

            $data = [];
            $query->select('koi_municipio.id as id', DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as text"));
            if($request->has('id')){
                $query->where('koi_municipio.id', $request->id);
            }

            if($request->has('q')) {
                $query->where( function($query) use($request) {
                    $query->whereRaw("municipio_nombre like '%".$request->q."%'");
                    $query->orWhereRaw("departamento_nombre like '%".$request->q."%'");
                });
            }

            if(empty($request->q) && empty($request->id)) {
                $query->take(50);
            }

            $query->orderby('departamento_nombre','asc');
            $query->orderby('municipio_nombre','asc');
            return response()->json($query->get());

            return $data;
        }
        return view('admin.municipios.index');
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
