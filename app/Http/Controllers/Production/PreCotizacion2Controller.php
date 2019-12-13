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
            if ($request->has('datatables')) {
                $query = PreCotizacion2::getPreCotizaciones2();
                return Datatables::of($query)
                            ->filter(function($query) use ($request) {
                                // Cotizacion
                                if ($request->has('search_precotizacion')) {
                                    $query->whereRaw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) LIKE '%{$request->search_precotizacion}%'");
                                }

                                if ($request->has('search_precotizacion_estado')) {
                                    if ($request->search_precotizacion_estado == 'A') {
                                        $query->where('precotizacion1_abierta', true);
                                    }

                                    if ($request->search_precotizacion_estado == 'C') {
                                        $query->where('precotizacion1_abierta', false);
                                    }

                                    if ($request->search_precotizacion_estado == 'T') {
                                        $query->where('precotizacion1_anulada', true);
                                    }
                                }
                            })
                            ->make(true);
            }

            if ($request->has('precotizacion')) {
                $data = PreCotizacion2::getPreCotizaciones2($request->precotizacion);
            }
            return response()->json($data);
        }
        abort(404);
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

        // Recuperar producto
        $producto = Productop::getProduct($precotizacion2->precotizacion2_productop);
        if (!$producto instanceof Productop) {
            abort(404);
        }

        // Lazy Eager Loading
        $producto->load('tips');
        $precotizacion2->producto = $producto;

        if ($request->ajax()) {
            return response()->json($precotizacion2);
        }

        // Recuperar precotizacion
        $precotizacion = PreCotizacion1::getPreCotizacion($precotizacion2->precotizacion2_precotizacion1);
        if (!$precotizacion instanceof PreCotizacion1) {
            abort(404);
        }

        return view('production.precotizaciones.productos.show', compact('precotizacion', 'producto', 'precotizacion2'));
    }
}
