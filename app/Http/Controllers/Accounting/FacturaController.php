<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Accounting\Factura1, App\Models\Accounting\Factura4;
use App\Models\Production\Ordenp;

use DB, Log, Datatables;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Factura1::query();
            $query->select('koi_factura1.*',DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as factura_ordenp"), 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id');
            $query->join('koi_ordenproduccion', 'factura1_orden', '=', 'koi_ordenproduccion.id');

            return Datatables::of($query)
                ->filter(function($query) use($request) {

                    // Numero 
                    if($request->has('id')){
                        $query->whereRaw("koi_factura1.id LIKE '%{$request->id}%'");
                    }

                    // Orden
                    if($request->has('factura_orden')){
                        $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->factura_orden}'");
                    }

                    // Documento
                    if($request->has('factura_tercero_nit')) {
                        $query->whereRaw("tercero_nit LIKE '%{$request->factura_tercero_nit}%'");
                    }
                })
                ->make(true);
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

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function facturadas(Request $request)
    {
        if ($request->ajax())
        {
            $facturadas = [];
            if($request->has('factura1_orden')) {
                $orden = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->factura1_orden}'")->first();
                if($orden instanceof Ordenp){
                    $facturadas = $orden->paraFacturar();
                }
            }

            if($request->has('factura1_id')){
                $query = Factura4::query();
                $query->select('koi_factura4.*', 'koi_factura1.factura1_fecha');
                $query->join('koi_factura1', 'factura4_factura1', '=', 'koi_factura1.id');
                $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');
                $query->where('factura4_saldo', '<>',  0);
                $query->where('factura4_factura1', $request->factura1_id);
                $facturadas = $query->get();
            }
            return response()->json( $facturadas );
        }
        abort(404);
    }


    /**
     * Search factura.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->has('factura_numero')) {
            $factura = Factura1::select('koi_factura1.id',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            )
            ->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id')
            ->where('koi_factura1.id', $request->factura_numero)->first();

            if($factura instanceof Factura1) {
                return response()->json(['success' => true, 'tercero_nombre' => $factura->tercero_nombre, 'id' => $factura->id]);
            }
        }
        return response()->json(['success' => false]);
    }

}
