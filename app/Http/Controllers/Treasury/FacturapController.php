<?php

namespace App\Http\Controllers\Treasury;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Treasury\Facturap;
use DB, Log, Datatables, Cache;

class FacturapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Facturap::query();
            $query->select('koi_facturap1.*', 'sucursal_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('koi_sucursal', 'facturap1_sucursal', '=', 'koi_sucursal.id');
            $query->join('koi_tercero', 'facturap1_tercero', '=', 'koi_tercero.id');

            // Persistent data filter
            if ($request->has('persistent') && $request->persistent) {
                session(['searchfacturap_tercero' => $request->has('tercero_nit') ? $request->tercero_nit : '']);
                session(['searchfacturap_tercero_nombre' => $request->has('tercero_nombre') ? $request->tercero_nombre : '']);
                session(['searchfacturap_facturap' => $request->has('facturap') ? $request->facturap : '']);
                session(['searchfacturap_fecha' => $request->has('facturap_fecha') ? $request->facturap_fecha : '']);
            }

            return Datatables::of($query)
                ->filter(function ($query) use ($request){
                    // Referencia
                    if ($request->has('facturap')) {
                        $query->whereRaw("facturap1_factura LIKE '%{$request->facturap}%'");
                    }

                    // Fecha
                    if ($request->has('facturap_fecha')) {
                        $query->whereRaw("facturap1_fecha LIKE '%{$request->facturap_fecha}%'");
                    }

                    // Documento Tercero
                    if ($request->has('tercero_nit')) {
                        $query->whereRaw("tercero_nit LIKE '%{$request->tercero_nit}%'");
                    }
                })
                ->make(true);
        }
        return view('treasury.facturasp.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
       $facturap = Facturap::getFacturap($id);
        if ($request->ajax()) {
            return response()->json($facturap);
        }
        return view('treasury.facturasp.show', compact('facturap'));
    }
}
