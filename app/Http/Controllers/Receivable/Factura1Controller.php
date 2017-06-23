<?php

namespace App\Http\Controllers\Receivable;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\AsientoContableDocumento;

use App\Models\Receivable\Factura1, App\Models\Receivable\Factura2, App\Models\Receivable\Factura4;
use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Base\Tercero, App\Models\Base\PuntoVenta, App\Models\Base\Empresa, App\Models\Receivable\ReteFuente, App\Models\Receivable\ReteIva;

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
        return view('receivable.facturas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $factura = new Factura1;
            if ($factura->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar Tercero
                    $tercero = Tercero::where('tercero_nit', $request->factura1_tercero)->first();
                    if(!$tercero instanceof Tercero){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar orden
                    $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->factura1_orden}'")->first();
                    if(!$ordenp instanceof Ordenp){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar Puntoventa
                    $puntoventa = PuntoVenta::find($request->factura1_puntoventa);
                    if(!$puntoventa instanceof PuntoVenta){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el punto de venta, por favor verifique la información o consulte al administrador.']);
                    }
                    $consecutive = $puntoventa->puntoventa_numero + 1;

                    // Recuperar iva Empresa
                    $empresa = Empresa::getEmpresa();
                    if(!$empresa instanceof Empresa){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar informacion de la empresa, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar Cuotas
                    if($request->factura1_cuotas <= 0){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'La cantidad cuotas no puede ser menor ó igual a 0.']);
                    }

                    $factura->fill($data);
                    $factura->factura1_tercero = $tercero->id;
                    $factura->factura1_puntoventa = $puntoventa->id;
                    $factura->factura1_orden = $ordenp->id;
                    $factura->factura1_numero = $puntoventa->puntoventa_numero;
                    $factura->factura1_prefijo = $puntoventa->puntoventa_prefijo;
                    $factura->factura1_porcentaje_iva = $empresa->empresa_iva;
                    $factura->factura1_usuario_elaboro = Auth::user()->id;
                    $factura->factura1_fh_elaboro = date('Y-m-d H:m:s');
                    $factura->save();

                    // Calcular subtotal factura
                    $subtotal = 0;

                    // Recuperar Ordenp2 para el detalle de la factura
                    $ordenp2 = Ordenp2::getOrdenesf2($ordenp->id);

                    // Validar que no se ingrese factura vacia
                    if( count($ordenp2) == 0 ){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'El detalle de la factura no puede ir vacio, por favor verifique la información o consulte al administrador.']);
                    }

                    foreach ($ordenp2 as $item) {
                        // Validar que no se ingrese factura vacia
                        if( $item->orden2_cantidad == 0 ){
                            DB::rollback();
                            return response()->json(['success'=>false, 'errors'=>'El detalle de la factura no puede ir vacio, por favor verifique la información o consulte al administrador.']);
                        }

                        if( $request->has("facturado_cantidad_{$item->id}") ){
                            if( $request->get("facturado_cantidad_{$item->id}") > $item->orden2_cantidad || $request->get("facturado_cantidad_{$item->id}") < 0){
                                DB::rollback();
                                return response()->json(['success'=>false, 'errors'=>'La cantidad ingresada supera o es menor a la cantidad disponible.']);
                            }

                            if( $request->get("facturado_cantidad_{$item->id}") != 0){
                                $factura2 = new Factura2;
                                $factura2->factura2_factura1 = $factura->id;
                                $factura2->factura2_orden2 = $item->id;
                                $factura2->factura2_cantidad = $request->get("facturado_cantidad_{$item->id}");
                                $factura2->save();

                                $subtotal += $request->get("facturado_cantidad_{$item->id}") * $item->orden2_precio_venta;

                                // Actualizar orden2_facturado de Orden2
                                $item->orden2_facturado = $item->orden2_facturado + $request->get("facturado_cantidad_{$item->id}");
                                $item->save();
                            }
                        }
                    }

                    // Validar que se ingrese un item en el detalle de la factura
                    if($subtotal == 0){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'Por favor ingrese al menos un producto a facturar.']);
                    }

                    // Calcular Retefuente, Reteiva, Reteica, Iva, Total
                    $iva = ( round($subtotal) * $empresa->empresa_iva ) / 100;

                    $rtfuente = 0;
                    if( $tercero->tercero_regimen == 2 && config('koi.terceros.regimen')[$tercero->tercero_regimen] == 'Común' && $subtotal >= $empresa->empresa_base_retefuente_factura){
                        $rtfuente = ($subtotal * $empresa->empresa_porcentaje_retefuente_factura) / 100;
                    }

                    $rtiva = 0;
                    if( $tercero->tercero_gran_contribuyente && $subtotal >= $empresa->empresa_base_reteiva_factura ){
                        $rtiva = ($iva * $empresa->empresa_porcentaje_reteiva_factura) / 100;
                    }

                    $rtica = 0;
                    if( $subtotal >= $empresa->empresa_base_ica_compras && $tercero->tercero_municipio == $empresa->tercero_municipio){
                        $rtica = ($subtotal * $empresa->actividad_tarifa) / 1000;
                    }

                    $total = round($subtotal) + round($iva) - round($rtfuente) - round($rtica) - round($rtiva);

                    // Actualizar factura--iva subtotal
                    $factura->factura1_subtotal = round($subtotal);
                    $factura->factura1_iva = round($iva);
                    $factura->factura1_retefuente = round($rtfuente);
                    $factura->factura1_reteica = round($rtica);
                    $factura->factura1_reteiva = round($rtiva);
                    $factura->factura1_total = round($total);
                    $factura->save();

                    // Crear Factura4 -> cuotas
                    $result = $factura->storeFactura4($factura);
                    if(!$result->success){
                        DB::rollback();
                        return $result->error;
                    }

                    // Update consecutive puntoventa_numero
                    $puntoventa->puntoventa_numero = $consecutive;
                    $puntoventa->save();

                    // Prepara data asiento
                    $dataAsiento = $factura->prepararAsiento();

                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($dataAsiento->data);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($dataAsiento->cuentas);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar asiento
                    $result = $objAsiento->insertarAsiento();
                    if($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Recuperar el Id del asiento y guardar en la factura
                    $factura->factura1_asiento = $objAsiento->asiento->id;
                    $factura->save();
                    
                    if( !isset($factura->factura1_asiento) || $factura->id == null ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el asiento de la factura.']);
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $factura->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $factura->errors]);
        }
        abort(403);
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
        $pdf->loadHTML(View::make('receivable.facturas.export.export',  compact('factura', 'detalle', 'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'factura', $factura->id, date('Y_m_d'), date('H_m_s')));
    }
}
