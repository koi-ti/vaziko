<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Departamento;
use Datatables;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Departamento::query())->make(true);
        }
        return view('admin.departamentos.index', ['empresa' => parent::getPaginacion()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($departamento);
        }
        return view('admin.departamentos.show', compact('departamento'));
    }
}
