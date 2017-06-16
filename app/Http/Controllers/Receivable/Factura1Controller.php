<?php

namespace App\Http\Controllers\Receivable;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Receivable\Factura1, App\Models\Receivable\Factura2, App\Models\Receivable\Factura4;
use App\Models\Production\Ordenp;

use App, View, Auth, DB, Log, Datatables;

class Factura1Controller extends Controller
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
            $query->select('koi_factura1.*', 't.tercero_nit', 'puntoventa_prefijo', 'orden_referencia', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), DB::raw("(CASE WHEN t.tercero_persona = 'N'
                    THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                            (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                        )
                    ELSE t.tercero_razonsocial END)
                AS tercero_nombre"), DB::raw("
                    CONCAT(
                        (CASE WHEN to.tercero_persona = 'N'
                            THEN CONCAT(to.tercero_nombre1,' ',to.tercero_nombre2,' ',to.tercero_apellido1,' ',to.tercero_apellido2,
                                (CASE WHEN (to.tercero_razonsocial IS NOT NULL AND to.tercero_razonsocial != '') THEN CONCAT(' - ', to.tercero_razonsocial) ELSE '' END)
                            )
                            ELSE to.tercero_razonsocial
                        END),
                    ' (', orden_referencia ,')'
                    ) AS orden_beneficiario"
                )
            );
            $query->join('koi_tercero as t', 'factura1_tercero', '=', 't.id');
            $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');
            $query->join('koi_ordenproduccion', 'factura1_orden', '=', 'koi_ordenproduccion.id');
            $query->join('koi_tercero as to', 'orden_cliente', '=', 'to.id');

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchfactura_tercero' => $request->has('tercero_nit') ? $request->tercero_nit : '']);
                session(['searchfactura_tercero_nombre' => $request->has('tercero_nombre') ? $request->tercero_nombre : '']);
                session(['searchfactura_numero' => $request->has('id') ? $request->id : '']);
                session(['searchfactura_ordenp' => $request->has('orden_codigo') ? $request->orden_codigo : '']);
                session(['searchfactura_ordenp_beneficiario' => $request->has('orden_tercero') ? $request->orden_tercero : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {

                    // Numero 
                    if($request->has('id')){
                        $query->whereRaw("koi_factura1.id LIKE '%{$request->id}%'");
                    }

                    // Orden
                    if($request->has('orden_codigo')){
                        $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->orden_codigo}'");
                    }

                    // Documento
                    if($request->has('tercero_nit')) {
                        $query->whereRaw("t.tercero_nit LIKE '%{$request->tercero_nit}%'");
                    }
                })
                ->make(true);
        }
        return view('receivable.facturas.index');
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
        $factura = Factura1::getFactura($id);
        if(!$factura instanceof Factura1) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($factura);
        }
        return view('receivable.facturas.show', ['factura' => $factura]);
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

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($id)
    {
        $factura = Factura1::getFactura($id);
        if(!$factura instanceof Factura1){
            abort(404);
        }

        $detalle = Factura2::getFactura2($factura->id);
        $title = sprintf('Factura %s', $factura->factura1_orden);

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('receivable.facturas.export',  compact('factura', 'detalle', 'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'factura', $factura->id, date('Y_m_d'), date('H_m_s')));
    }
}
