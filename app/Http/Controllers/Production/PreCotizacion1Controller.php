<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion1;
use DB, Log, Datatables, Carbon\Carbon;

class PreCotizacion1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $query = PreCotizacion1::query();
            $query->select('koi_precotizacion1.id', DB::raw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"), 'precotizacion1_fh_elaboro', 'precotizacion1_fh_culminada', 'precotizacion1_culminada', 'precotizacion1_numero', 'precotizacion1_ano', 'precotizacion1_fecha', 'precotizacion1_abierta',
                DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END),
                    ' (', precotizacion1_referencia ,')'
                    ) AS tercero_nombre"
                )
            );
            $query->join('koi_tercero', 'precotizacion1_cliente', '=', 'koi_tercero.id');

            // Persistent data filter
            if ($request->has('persistent') && $request->persistent) {
                session(['searchprecotizacion_numero' => $request->has('precotizacion_numero') ? $request->precotizacion_numero : '']);
                session(['searchprecotizacion_tercero' => $request->has('precotizacion_tercero_nit') ? $request->precotizacion_tercero_nit : '']);
                session(['searchprecotizacion_tercero_nombre' => $request->has('precotizacion_tercero_nombre') ? $request->precotizacion_tercero_nombre : '']);
                session(['searchprecotizacion_referencia' => $request->has('precotizacion_referencia') ? $request->precotizacion_referencia : '']);
                session(['searchprecotizacion_estado' => $request->has('precotizacion_estado') ? $request->precotizacion_estado : '']);
            }


            return Datatables::of($query)
                ->editColumn('precotizacion1_fh_culminada', function ($q) {
                    if ($q->precotizacion1_fh_culminada) {
                        return Carbon::parse($q->precotizacion1_fh_culminada)->diffForHumans($q->precotizacion1_fh_elaboro);
                    } else {
                        return "-";
                    }
                })
                ->filter(function($query) use ($request) {
                    // Cotizacion codigo
                    if ($request->has('precotizacion_numero')) {
                        $query->whereRaw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) LIKE '%{$request->precotizacion_numero}%'");
                    }

                    // Cotizacion codigo
                    if ($request->has('precotizacion_referencia')) {
                        $query->whereRaw("precotizacion1_referencia LIKE '%{$request->precotizacion_referencia}%'");
                    }

                    // Tercero nit
                    if ($request->has('precotizacion_tercero_nit')) {
                        $query->where('tercero_nit', $request->precotizacion_tercero_nit);
                    }

                    // Tercero id
                    if ($request->has('precotizacion_cliente')) {
                        $query->where('precotizacion1_cliente', $request->precotizacion_cliente);
                    }

                    // Estado
                    if ($request->has('precotizacion_estado')) {
                        if ($request->precotizacion_estado == 'A') {
                            $query->where('precotizacion1_abierta', true);
                        }

                        if ($request->precotizacion_estado == 'C') {
                            $query->where('precotizacion1_abierta', false);
                        }

                        if ($request->precotizacion_estado == 'T') {
                            $query->where('precotizacion1_abierta', false);
                            $query->where('precotizacion1_culminada', true);
                        }
                    }

                    // Producto
                    if ($request->has('precotizacion_productop')) {
                        $query->whereRaw("$request->precotizacion_productop IN ( SELECT precotizacion2_productop FROM koi_precotizacion2 WHERE precotizacion2_precotizacion1 = koi_precotizacion1.id) ");
                    }
                })->make(true);
        }
        return view('production.precotizaciones.index', ['empresa' => parent::getPaginacion()]);
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
    public function show(Request $request, $id)
    {
        $precotizacion = PreCotizacion1::getPreCotizacion($id);
        if (!$precotizacion instanceof PreCotizacion1) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($precotizacion);
        }

        return view('production.precotizaciones.show', compact('precotizacion'));
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
