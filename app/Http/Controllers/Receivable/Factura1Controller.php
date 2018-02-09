<?php

namespace App\Http\Controllers\Receivable;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;

use App\Models\Receivable\Factura1, App\Models\Receivable\Factura2, App\Models\Receivable\Factura4;
use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Base\Tercero, App\Models\Base\PuntoVenta, App\Models\Base\Empresa, App\Models\Receivable\ReteFuente, App\Models\Receivable\ReteIva;
use App\Models\Accounting\ReglaAsiento;

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
            $query->select('koi_factura1.*', 'tercero_nit', 'puntoventa_prefijo', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id');
            $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchfactura_tercero' => $request->has('tercero_nit') ? $request->tercero_nit : '']);
                session(['searchfactura_tercero_nombre' => $request->has('tercero_nombre') ? $request->tercero_nombre : '']);
                session(['searchfactura_numero' => $request->has('id') ? $request->id : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {

                    // Numero
                    if($request->has('factura1_numero')){
                        $query->whereRaw("factura1_numero LIKE '%{$request->factura1_numero}%'");
                    }

                    // Documento
                    if($request->has('tercero_nit')) {
                        $query->whereRaw("tercero_nit LIKE '%{$request->tercero_nit}%'");
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
                    $factura->factura1_numero = $puntoventa->puntoventa_numero;
                    $factura->factura1_prefijo = $puntoventa->puntoventa_prefijo;
                    $factura->factura1_porcentaje_iva = $empresa->empresa_iva;
                    $factura->factura1_usuario_elaboro = Auth::user()->id;
                    $factura->factura1_fh_elaboro = date('Y-m-d H:m:s');
                    $factura->save();

                    // Calcular subtotal factura
                    $subtotal = 0;

                    // Validate cantidad
                    $cantidad = 0;

                    $detail = null;

                    // Recuperar ordenesp2
                    $ordenp2 = Ordenp2::getDetails()->get();
                    foreach ($ordenp2 as $child) {

                        if( $request->has("detail.facturado_cantidad_$child->id") ) {
                            // Declarar variable request->get($array, $default = null, depp->mantener)
                            $detail = $request->get("detail[facturado_cantidad_$child->id]", null, true);

                            if( $detail > $child->orden2_cantidad || $detail < 0){
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "La cantidad ingresada en la orden No. $child->id no es correcta, por favor verifique la información o consulte al administrador."]);
                            }

                            if( $detail != 0 ){
                                $factura2 = new Factura2;
                                $factura2->factura2_factura1 = $factura->id;
                                $factura2->factura2_orden2 = $child->id;
                                $factura2->factura2_cantidad = $detail;
                                $factura2->save();

                                $subtotal += $detail * $child->orden2_total_valor_unitario;
                                $cantidad += $detail;

                                // Actualizar orden2_facturado de Orden2
                                $child->orden2_facturado = $child->orden2_facturado + $detail;
                                $child->save();
                            }
                        }
                    }

                    // Validar que se ingrese un item en el detalle de la factura
                    if($cantidad == 0){
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
                    // $reglaAsiento = $factura->prepararAsiento();
                    $reglaAsiento = ReglaAsiento::createAsiento($factura->id, 'FS', $factura->factura1_tercero);
                    if (!$reglaAsiento->success) {
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>$reglaAsiento->error]);
                    }
                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($reglaAsiento->data);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($reglaAsiento->cuentas);
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
                    // AsientoNif
                    if (!empty($reglaAsiento->dataNif)) {
                        // Creo el objeto para manejar el asiento
                        $objAsientoNif = new AsientoNifContableDocumento($reglaAsiento->dataNif);
                        if($objAsientoNif->asientoNif_error) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $objAsiento->asientoNif_error]);
                        }

                        // Preparar asiento
                        $result = $objAsientoNif->asientoCuentas($reglaAsiento->cuentas);
                        if($result != 'OK'){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }

                        // Insertar asiento
                        $result = $objAsientoNif->insertarAsientoNif();
                        if($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                        // Recuperar el Id del asiento y guardar en la factura
                        $factura->factura1_asienton1 = $objAsientoNif->asientoNif->id;
                    }
                    // Recuperar el Id del asiento y guardar en la factura
                    $factura->factura1_asiento = $objAsiento->asiento->id;
                    $factura->save();

                    if( !isset($factura->factura1_asiento) || $factura->id == null ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el asiento de la factura.']);
                    }

                    // Commit Transaction
                    // DB::rollback();
                    // return response()->json(['success' => false, 'errors' => "TODO ok"]);
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
    // public function search(Request $request)
    // {
    //     if($request->has('factura_numero')) {
    //         $factura = Factura1::select('koi_factura1.id',
    //             DB::raw("(CASE WHEN tercero_persona = 'N'
    //                 THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
    //                         (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
    //                     )
    //                 ELSE tercero_razonsocial END)
    //             AS tercero_nombre")
    //         )
    //         ->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id')
    //         ->where('koi_factura1.id', $request->factura_numero)->first();
    //
    //         if($factura instanceof Factura1) {
    //             return response()->json(['success' => true, 'tercero_nombre' => $factura->tercero_nombre, 'id' => $factura->id]);
    //         }
    //     }
    //     return response()->json(['success' => false]);
    // }

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
        $pdf->loadHTML( View::make('receivable.facturas.export.export',  compact('factura', 'detalle', 'title'))->render() );
        return $pdf->stream( sprintf('%s_%s_%s_%s.pdf', 'factura', $factura->id, date('Y_m_d'), date('H_m_s')) );
    }
}
