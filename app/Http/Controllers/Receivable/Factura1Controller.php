<?php

namespace App\Http\Controllers\Receivable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;
use App\Models\Receivable\Factura1, App\Models\Receivable\Factura2, App\Models\Receivable\Factura4;
use App\Models\Base\Tercero, App\Models\Base\PuntoVenta, App\Models\Base\Empresa;
use App\Models\Accounting\Asiento, App\Models\Accounting\AsientoNif;
use App\Models\Production\Ordenp2;
use App, View, DB, Log, Datatables;

class Factura1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
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
            if ($request->has('persistent') && $request->persistent) {
                session(['searchfactura_tercero' => $request->has('tercero_nit') ? $request->tercero_nit : '']);
                session(['searchfactura_tercero_nombre' => $request->has('tercero_nombre') ? $request->tercero_nombre : '']);
                session(['searchfactura_numero' => $request->has('id') ? $request->id : '']);
            }

            // If permission
            $query->addSelect(DB::raw(auth()->user()->ability('admin', 'precios', ['module' => 'facturas']) ? "factura1_total" : "0" . " AS factura1_total"));

            return Datatables::of($query)
                ->filter(function ($query) use ($request) {
                    // Numero
                    if ($request->has('factura1_numero')) {
                        $query->whereRaw("factura1_numero LIKE '%{$request->factura1_numero}%'");
                    }

                    // Documento
                    if ($request->has('tercero_nit')) {
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
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero.']);
                    }

                    // Recuperar Puntoventa
                    $puntoventa = PuntoVenta::find($request->factura1_puntoventa);
                    if (!$puntoventa instanceof PuntoVenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el punto de venta.']);
                    }
                    $consecutive = $puntoventa->puntoventa_numero + 1;

                    // Recuperar iva Empresa
                    $empresa = Empresa::getEmpresa();
                    if (!$empresa instanceof Empresa) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar informacion de la empresa.']);
                    }

                    $factura->fill($data);
                    $factura->factura1_tercero = $tercero->id;
                    $factura->factura1_puntoventa = $puntoventa->id;
                    $factura->factura1_numero = $consecutive;
                    $factura->factura1_prefijo = $puntoventa->puntoventa_prefijo;
                    $factura->factura1_porcentaje_iva = $empresa->empresa_iva;
                    $factura->factura1_usuario_elaboro = auth()->user()->id;
                    $factura->factura1_fh_elaboro = date('Y-m-d H:i:s');
                    $factura->save();

                    // Detalle de la factura (ordenesp2)
                    $subtotal = $rtfuente = $rtiva = $rtica = $iva = 0;
                    $detalle = isset($data['detalle']) ? $data['detalle'] : null;
                    foreach ($detalle as $item) {
                        // Validar ordenp2
                        $ordenp2 = Ordenp2::find($item['factura2_orden2']);
                        if (!$ordenp2 instanceof Ordenp2) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => "No es posible recuperar el producto No. {$item['factura2_orden2']}, por favor verifique la información o consulte al administrador."]);
                        }

                        // Validar que tenga cantidad
                        if ($item['factura2_cantidad'] <= 0 || $item['factura2_cantidad'] > $ordenp2->orden2_cantidad) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => "La cantidad ingresada en el producto No. {$item['id']} no es correcta, por favor verifique la información o consulte al administrador."]);
                        }

                        // Guardar factura2
                        $factura2 = new Factura2;
                        $factura2->factura2_factura1 = $factura->id;
                        $factura2->factura2_orden2 = $ordenp2->id;
                        $factura2->factura2_producto_nombre = $item['factura2_producto_nombre'];
                        $factura2->factura2_producto_valor_unitario = $item['factura2_producto_valor_unitario'];
                        $factura2->factura2_cantidad = $item['factura2_cantidad'];
                        $factura2->save();

                        $subtotal += round($item['factura2_cantidad'] * $item['factura2_producto_valor_unitario']);

                        // Actualizar orden2_facturado de Orden2
                        $ordenp2->orden2_saldo -= $item['factura2_cantidad'];
                        $ordenp2->orden2_facturado += $item['factura2_cantidad'];
                        $ordenp2->save();
                    }

                    // Calcular Retefuente, Reteiva, Reteica, Iva, Total
                    $iva = isset($request->impuestos['iva-create']) ? $request->impuestos['iva-create'] : ( round($subtotal) * $empresa->empresa_iva ) / 100;
                    if ($tercero->tercero_regimen == 2 && config('koi.terceros.regimen')[$tercero->tercero_regimen] == 'Común' && $subtotal >= $empresa->empresa_base_retefuente_factura) {
                        $rtfuente = ($subtotal * $empresa->empresa_porcentaje_retefuente_factura) / 100;
                    }

                    $rtfuente = isset($request->impuestos['rtefuente-create']) ? $request->impuestos['rtefuente-create'] : $rtfuente;
                    if ($tercero->tercero_gran_contribuyente && $subtotal >= $empresa->empresa_base_reteiva_factura) {
                        $rtiva = ($iva * $empresa->empresa_porcentaje_reteiva_factura) / 100;
                    }

                    $rtiva = isset($request->impuestos['rteiva-create']) ? $request->impuestos['rteiva-create'] : $rtiva;
                    if ($subtotal >= $empresa->empresa_base_ica_compras && $tercero->tercero_municipio == $empresa->tercero_municipio) {
                        $rtica = ($subtotal * $empresa->actividad_tarifa) / 1000;
                    }

                    $rtica = isset($request->impuestos['rteica-create']) ? $request->impuestos['rteica-create'] : $rtica;
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
                    if ($factura->factura1_cuotas > 0) {
                        $valor = $factura->factura1_total / $factura->factura1_cuotas;
                        $fecha = $factura->factura1_fecha_vencimiento;

                        for ($i=1; $i <= $factura->factura1_cuotas; $i++) {
                            $factura4 = new Factura4;
                            $factura4->factura4_factura1 = $factura->id;
                            $factura4->factura4_cuota = $i;
                            $factura4->factura4_valor = round($valor);
                            $factura4->factura4_saldo = round($valor);
                            $factura4->factura4_vencimiento = $fecha;
                            $fechavencimiento = date('Y-m-d',strtotime('+1 months', strtotime($fecha)));
                            $fecha = $fechavencimiento;
                            $factura4->save();
                        }
                    }

                    // Prepara data asiento
                    $dataAsiento = $factura->prepararAsiento();

                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($dataAsiento->data);
                    if ($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($dataAsiento->cuentas);
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar asiento (asiento2_nuevo = false)
                    $result = $objAsiento->insertarAsiento(false);
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // AsientoNif
                    if (!empty($reglaAsiento->dataNif)) {
                        // Creo el objeto para manejar el asiento
                        $objAsientoNif = new AsientoNifContableDocumento($dataAsiento->dataNif);
                        if ($objAsientoNif->asientoNif_error) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $objAsiento->asientoNif_error]);
                        }

                        // Preparar asiento
                        $result = $objAsientoNif->asientoCuentas($dataAsiento->cuentas);
                        if ($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }

                        // Insertar asiento
                        $result = $objAsientoNif->insertarAsientoNif();
                        if ($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }

                        // Recuperar el Id del asiento y guardar en la factura
                        $factura->factura1_asienton1 = $objAsientoNif->asientoNif->id;
                    }

                    // Recuperar el Id del asiento y guardar en la factura
                    $factura->factura1_asiento = $objAsiento->asiento->id;
                    $factura->save();

                    if (!isset($factura->factura1_asiento) || $factura->id == null) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el asiento de la factura.']);
                    }

                    // Actualizar consecutivo del puntoventa
                    $puntoventa->puntoventa_numero = $consecutive;
                    $puntoventa->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $factura->id]);
                } catch(\Exception $e) {
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
        if ($request->ajax()) {
            return response()->json($factura);
        }
        return view('receivable.facturas.show', compact('factura'));
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
        if (!$factura instanceof Factura1) {
            abort(404);
        }

        $detalle = Factura2::getFactura2($factura->id);
        $title = sprintf('Factura %s', $factura->factura1_orden);

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML( View::make('receivable.facturas.export.export',  compact('factura', 'detalle', 'title'))->render() );
        return $pdf->stream( sprintf('%s_%s_%s_%s.pdf', 'factura', $factura->id, date('Y_m_d'), date('H_i_s')) );
    }

    /**
     * Export pdf the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function impuestos(Request $request)
    {
        if ($request->ajax()) {
            // Recuperar Tercero
            $tercero = Tercero::where('tercero_nit', $request->tercero)->first();
            if (!$tercero instanceof Tercero) {
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información o consulte al administrador.']);
            }

            // Recuperar iva Empresa
            $empresa = Empresa::getEmpresa();
            if (!$empresa instanceof Empresa) {
                return response()->json(['success'=>false, 'errors'=>'No es posible recuperar informacion de la empresa, por favor verifique la información o consulte al administrador.']);
            }

            $rtfuente = $rtiva = $rtica = 0;
            $subtotal =  floatval($request->subtotal);
            $iva = ( $subtotal * $empresa->empresa_iva ) / 100;
            $p_iva = $empresa->empresa_iva;

            //  Retefuente
            if ($tercero->tercero_regimen == 2 && config('koi.terceros.regimen')[$tercero->tercero_regimen] == 'Común' && $subtotal >= $empresa->empresa_base_retefuente_factura) {
                $rtfuente = ($subtotal * $empresa->empresa_porcentaje_retefuente_factura) / 100;
            }

            // Reteiva
            if ($tercero->tercero_gran_contribuyente && $subtotal >= $empresa->empresa_base_reteiva_factura) {
                $rtiva = ($iva * $empresa->empresa_porcentaje_reteiva_factura) / 100;
            }

            // Reteica
            if ($subtotal >= $empresa->empresa_base_ica_compras && $tercero->tercero_municipio == $empresa->tercero_municipio) {
                $rtica = ($subtotal * $empresa->actividad_tarifa) / 1000;
            }

            // Total
            $total = round($subtotal) + round($iva) - round($rtfuente) - round($rtica) - round($rtiva);

            return response()->json([
                'success' => true, 'subtotal' => $subtotal, 'iva' => $iva, 'p_iva' => $p_iva,'rtefuente' => $rtfuente, 'rteica' => $rtica, 'rteiva' => $rtiva, 'total' => $total
            ]);
        }
        abort(404);
    }

    /**
    *  Method para anular factura
    */
    public function anular($id)
    {
        // Recuperar factura
        $factura = Factura1::find($id);
        if (!$factura instanceof Factura1) {
            return response()->json(['success' => false, 'errors' => 'No es posible recuperar la factura, por favor verifique la información o consulte al administrador.']);
        }

        DB::beginTransaction();
        try {
            // Recorrer items factura2 y actualizar ordenp2
            $facturas2 = Factura2::where('factura2_factura1', $factura->id)->get();
            foreach ($facturas2 as $factura2) {
                // Devolver facturado a ordenp2
                $ordenp2 = Ordenp2::find($factura2->factura2_orden2);
                if ($ordenp2 instanceof Ordenp2) {
                    $ordenp2->orden2_saldo += $factura2->factura2_cantidad;
                    $ordenp2->orden2_facturado -= $factura2->factura2_cantidad;
                    $ordenp2->save();
                }
            }

            // Recuperar y actualizar factura 4 detalle de la factura
            $facturas4 = Factura4::where('factura4_factura1', $factura->id)->get();
            foreach ($facturas4 as $factura4) {
                // Validar que los valores sean iguales para anular la factura
                if ($factura4->factura4_valor != $factura4->factura4_saldo) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible anular la factura, porque ya tiene movimientos.']);
                }

                $factura4->factura4_saldo = 0;
                $factura4->save();
            }

            // Validar que factura a anular tenga asiento
            if ($factura->factura1_asiento) {
                // Recuperar asiento
                $asiento = Asiento::find($factura->factura1_asiento);
                if (!$asiento instanceof Asiento) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => "No es posible recuperar el asiento contable de esta factura."]);
                }
                $asiento->asiento1_detalle = "Se anulo factura #{$factura->factura1_numero} en la fecha ".date('Y-m-d H:i:s');
                $asiento->save();

                // Recuperar y recorrer detalle de asiento2
                $detalle = $asiento->detalle()->get() ?: null;
                foreach ($detalle as $item) {
                    $item->asiento2_debito = 0;
                    $item->asiento2_credito = 0;
                    $item->asiento2_base = 0;
                    $item->save();
                }
            }

            // Validar que factura a anular tenga asientonif
            if ($factura->factura1_asienton1) {
                // Recuperar asiento
                $asienton = AsientoNif::find($factura->factura1_asienton1);
                if (!$asienton instanceof AsientoNif) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => "No es posible recuperar el asiento nif contable de esta factura."]);
                }
                $asienton->asienton1_detalle = "Se anulo factura #{$factura->factura1_numero} en la fecha ".date('Y-m-d H:i:s');
                $asienton->save();

                // Recuperar y recorrer detalle de asienton2
                $detalle = $asienton->detalle()->get() ?: null;
                foreach ($detalle as $item) {
                    $item->asienton2_debito = 0;
                    $item->asienton2_credito = 0;
                    $item->asienton2_base = 0;
                    $item->save();
                }
            }

            // Anular factura
            $factura->factura1_anulado = true;
            $factura->factura1_usuario_anulo = auth()->user()->id;
            $factura->factura1_fh_anulo = date('Y-m-d H:i:s');
            $factura->save();

            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Se anulo con exito la factura.']);
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'errors' => trans('app.exception')]);
        }
    }
}
