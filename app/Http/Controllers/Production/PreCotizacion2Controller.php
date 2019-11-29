<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion1, App\Models\Production\PreCotizacion2, App\Models\Production\Productop;
use DB, Log, Datatables, Storage;

class PreCotizacion2Controller extends Controller
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
            if ($request->has('precotizacion')) {
                $data = PreCotizacion2::getPreCotizaciones2($request->precotizacion);
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
    public function create(Request $request)
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
    public function show(Request $request, $id)
    {
        // Recuperar precotizacion2
        $precotizacion2 = PreCotizacion2::getPreCotizacion2($id);
        if (!$precotizacion2 instanceof PreCotizacion2) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($precotizacion2);
        }

        // Recuperar precotizacion
        $precotizacion = PreCotizacion1::getPreCotizacion($precotizacion2->precotizacion2_precotizacion1);
        if (!$precotizacion instanceof PreCotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct($precotizacion2->precotizacion2_productop);
        if (!$producto instanceof Productop) {
            abort(404);
        }

        // Lazy Eager Loading
        $producto->load('tips');
        
        return view('production.precotizaciones.productos.show', compact('precotizacion', 'producto', 'precotizacion2'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
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
    public function destroy(Request $request, $id)
    {
        //
    }
}
