<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\AsientoNif, App\Models\Accounting\AsientoNif2, App\Models\Accounting\AsientoMovimiento, App\Models\Accounting\PlanCuenta, App\Models\Accounting\PlanCuentaNif, App\Models\Accounting\CentroCosto;
use App\Models\Treasury\Facturap, App\Models\Treasury\Facturap2;
use App\Models\Inventory\Producto;
use App\Models\Receivable\Factura4;
use App\Models\Production\Ordenp;
use App\Models\Base\Tercero;
use Log, DB;

class DetalleAsientoController extends Controller
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
            if ($request->has('asiento')) {
                $data = Asiento2::getAsiento2($request->asiento);
            }

            if ($request->has('orden2_orden')) {
                $data = Asiento2::getAsiento2Ordenp($request->orden2_orden);
            }
            return response()->json($data);
        }
        return view('admin.actividades.index');
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
            $asiento2 = new Asiento2;
            if ($asiento2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar asiento
                    $asiento = Asiento::find($request->asiento);
                    if (!$asiento instanceof Asiento) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar asiento, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Recuperar cuenta
                    $objCuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
                    if (!$objCuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Recuperar centro costo
                    $centrocosto = $ordenp = null;
                    if ($request->has('asiento2_centro')) {
                        $centrocosto = CentroCosto::find($request->asiento2_centro);
                        if (!$centrocosto instanceof CentroCosto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro costo, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        if ($centrocosto->centrocosto_codigo == 'OP') {
                            // Validate orden
                            if ($request->has('asiento2_orden')) {
                                $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->asiento2_orden}'")->first();
                            }
                            if (!$ordenp instanceof Ordenp) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "No es posible recuperar orden de producción para centro de costo OP, por favor verifique la información del asiento o consulte al administrador."]);
                            }
                        }
                    }

                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->tercero_nit)->first();
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Validate asiento2
                    $result = Asiento2::validarAsiento2($request, $objCuenta);
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    $cuenta = [];
                    $cuenta['Cuenta'] = $objCuenta->plancuentas_cuenta;
                    $cuenta['Tercero'] = $request->tercero_nit;
                    $cuenta['Detalle'] = $request->asiento2_detalle;
                    $cuenta['Naturaleza'] = $request->asiento2_naturaleza;
                    $cuenta['CentroCosto'] = $request->asiento2_centro;
                    $cuenta['Base'] = $request->asiento2_base;
                    $cuenta['Credito'] = $request->asiento2_naturaleza == 'C' ? $request->asiento2_valor: 0;
                    $cuenta['Debito'] = $request->asiento2_naturaleza == 'D' ? $request->asiento2_valor: 0;
                    $cuenta['Orden'] = ($ordenp instanceof Ordenp ? $ordenp->id : '');

                    $result = $asiento2->store($asiento, $cuenta);
                    if (!$result->success) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result->error]);
                    }

                    // Insertar movimiento asiento
                    $result = $asiento2->movimiento($request);
                    if (!$result->success) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result->error]);
                    }

                    // Asiento Nif
                    $asientoNif = AsientoNif::where('asienton1_asiento', $asiento->id)->first();
                    $asientoNif2 = null;
                    if ($asientoNif instanceof AsientoNif) {
                        $cuentaNif = PlanCuentaNif::find($objCuenta->plancuentas_equivalente);
                        if (!$cuentaNif instanceof PlanCuentaNif) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta NIF, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        $cuenta = [];
                        $cuenta['Cuenta'] = $cuentaNif->plancuentasn_cuenta;
                        $cuenta['Tercero'] = $request->tercero_nit;
                        $cuenta['Detalle'] = $request->asiento2_detalle;
                        $cuenta['Naturaleza'] = $request->asiento2_naturaleza;
                        $cuenta['CentroCosto'] = $request->asiento2_centro;
                        $cuenta['Base'] = $request->asiento2_base;
                        $cuenta['Credito'] = $request->asiento2_naturaleza == 'C' ? $request->asiento2_valor: 0;
                        $cuenta['Debito'] = $request->asiento2_naturaleza == 'D' ? $request->asiento2_valor: 0;
                        $cuenta['Orden'] = ($ordenp instanceof Ordenp ? $ordenp->id : '');

                        $asientoNif2 = new AsientoNif2;
                        $result = $asientoNif2->store($asientoNif, $cuenta);
                        if (!$result->success) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result->error]);
                        }
                    }

                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asiento2->id,
                        'asiento1_numero' => $asiento->asiento1_numero,
                        'asiento2_cuenta' => $objCuenta->id,
                        'plancuentas_cuenta' => $objCuenta->plancuentas_cuenta,
                        'plancuentas_nombre' => $objCuenta->plancuentas_nombre,
                        'plancuentas_tipo' => $objCuenta->plancuentas_tipo,
                        'centrocosto_codigo' => ($centrocosto instanceof CentroCosto ? $centrocosto->getCode() : ''),
                        'centrocosto_nombre' => ($centrocosto instanceof CentroCosto ? $centrocosto->centrocosto_nombre : ''),
                        'asiento2_beneficiario' => ($tercero instanceof Tercero ? $tercero->id : ''),
                        'tercero_nit' => ($tercero instanceof Tercero ? $tercero->tercero_nit : ''),
                        'tercero_nombre' => ($tercero instanceof Tercero ? $tercero->getName() : ''),
                        'asiento2_credito' => $asiento2->asiento2_credito,
                        'asiento2_debito' => $asiento2->asiento2_debito,
                        'asiento2_ordenp' => ($ordenp instanceof Ordenp ? $ordenp->id : ''),
                        'ordenp_codigo' => ($ordenp instanceof Ordenp ? "{$ordenp->orden_numero}-".substr($ordenp->orden_ano,-2) : ''),
                        'ordenp_beneficiario' => $request->asiento2_orden_beneficiario,
                        'asiento1_documentos' => $request->asiento1_documentos,
                        'asientoNif2_id' => ($asientoNif2 instanceof AsientoNif2 ? $asientoNif2->id : ''),
                        'asiento2_nuevo' => $asiento2->asiento2_nuevo
                    ]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error(sprintf('%s -> %s: %s', 'DetalleAsientoController', 'store', $e->getMessage()));
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $asiento2->errors]);
        }
        abort(403);
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
        if ($request->ajax()) {
            $asiento2 = Asiento2::find($id);
            if ($asiento2 instanceof Asiento2) {
                DB::beginTransaction();
                try {
                    // Validar valor
                    if (empty($request->movimiento_valor)) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'Por favor ingrese el valor.']);
                    }

                    // Recuperar beneficiario
                    $beneficiario = Tercero::where('tercero_nit', $request->movimiento_beneficiario)->first();
                    if (!$beneficiario instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Naturaleza
                    $naturaleza = $request->movimiento_naturaleza;

                    // Update movimiento
                    $asiento2->asiento2_beneficiario = $beneficiario->id;
                    $asiento2->asiento2_detalle = $request->movimiento_detalle;
                    $asiento2->asiento2_debito = $naturaleza == 'D' ? $request->movimiento_valor : 0;
                    $asiento2->asiento2_credito = $naturaleza == 'C' ? $request->movimiento_valor : 0;
                    $asiento2->save();

                    // Si maneja movimiento
                    $movimientos = AsientoMovimiento::where('movimiento_asiento2', $asiento2->id)->get();
                    foreach ($movimientos as $movimiento) {
                        if ($movimiento->movimiento_tipo == 'FP') {
                            // Recuperar factura
                            $facturap = Facturap::where('facturap1_factura', $movimiento->movimiento_facturap)->first();
                            if (!$facturap instanceof Facturap) {
                                return 'No es posible recuperar la factura del proveedor.';
                            }

                            // Si el movimiento es nuevo
                            if (!$movimiento->movimiento_nuevo) {
                                // Recuperar cuotas
                                $cuota = Facturap2::where('facturap2_factura', $facturap->id)->where('facturap2_cuota', $movimiento->movimiento_item)->first();
                                if ($cuota instanceof Facturap2) {
                                    // Validar que existan valores
                                    if ($request->has("movimiento_valor_{$cuota->facturap2_cuota}") && $request->get("movimiento_valor_{$cuota->facturap2_cuota}") != '') {
                                        $movimiento->movimiento_valor = $request->get("movimiento_valor_{$cuota->facturap2_cuota}");
                                        $movimiento->save();
                                    }
                                }
                            }
                        }

                        if ($movimiento->movimiento_tipo == 'F') {
                            $childs = AsientoMovimiento::where('movimiento_asiento2', $asiento2->id)->where('movimiento_tipo', 'FH')->get();
                            foreach ($childs as $child) {
                                if ($request->has("movimiento_valor_{$child->id}") && $request->get("movimiento_valor_{$child->id}") != '') {
                                    $prevValor = $child->movimiento_valor;
                                    $child->movimiento_valor = $request->get("movimiento_valor_{$child->id}");
                                    $child->save();

                                    // Si el movimiennto no es nuevo
                                    if (!$asiento2->asiento2_nuevo) {
                                        $factura4 = Factura4::find($child->movimiento_factura4);
                                        if ($factura4 instanceof Factura4) {
                                            if ($naturaleza == 'D') {
                                                $factura4->factura4_saldo += $prevValor + $child->movimiento_valor;
                                            } else {
                                                $factura4->factura4_saldo += $prevValor - $child->movimiento_valor;
                                            }
                                            $factura4->save();
                                        }
                                    }
                                }
                            }
                        }
                    }

                    DB::commit();
                    return response()->json(['success' => true]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error(sprintf('%s -> %s: %s', 'DetalleAsientoController', 'update', $e->getMessage()));
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el movimiento, por favor verifique la información del asiento o consulte al administrador.']);
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                // Recuperar item
                $asiento2 = Asiento2::find($id);
                if (!$asiento2 instanceof Asiento2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible definir beneficiario, por favor verifique la información del asiento o consulte al administrador.'], 500);
                }

                $plancuenta = PlanCuenta::find($asiento2->asiento2_cuenta);
                if (!$plancuenta instanceof PlanCuenta) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cuenta, por favor verifique la información del asiento o consulte al administrador.'], 500);
                }

                // Si existe asiento NIF
                $asientoNif = AsientoNif::where('asienton1_asiento', $asiento2->asiento2_asiento)->first();
                if ($asientoNif instanceof AsientoNif) {
                    $asientoNif2 = AsientoNif2::query()->where('asienton2_asiento',$asientoNif->id)->where('asienton2_item', $asiento2->asiento2_item)->first();
                    $asientoNif2->delete();
                }

                // Remover movimientos del asiento
                AsientoMovimiento::where('movimiento_asiento2', $asiento2->id)->delete();

                // Eliminar item asiento2
                $asiento2->delete();

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'DetalleAsientoController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Evaluate actions detail asiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluate(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->actions = [];
        $response->success = false;

        // Recuperar plancuentas
        $cuenta = null;
        if ($request->has('plancuentas_cuenta')) {
            $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        }

        if (!$cuenta instanceof PlanCuenta) {
            $response->errors = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            return response()->json($response);
        }

        // Validate asiento2
        $result = Asiento2::validarAsiento2($request, $cuenta);
        if ($result != 'OK') {
            $response->errors = $result;
            return response()->json($response);
        }

        // Evaluate actions centro costo
        if ($request->has('asiento2_centro')) {
            $centrocosto = CentroCosto::find($request->asiento2_centro);
            if ($centrocosto instanceof CentroCosto) {
                if ($centrocosto->centrocosto_codigo == 'OP') {
                    $action = new \stdClass();
                    $action->action = 'ordenp';
                    $action->success = false;
                    $response->actions[] = $action;
                }
            }
        }

        // Evaluate actions plancuentas
        $action = new \stdClass();

        // Proveedores
        if ($cuenta->plancuentas_tipo && $cuenta->plancuentas_tipo == 'P') {
            $action->action = 'facturap';
            $action->success = false;
            $response->actions[] = $action;

        // Inventario
        } else if ($cuenta->plancuentas_tipo && $cuenta->plancuentas_tipo == 'I') {
            $action->action = 'inventario';
            $action->success = false;
            $response->actions[] = $action;

        // Cartera
        } else if ($cuenta->plancuentas_tipo && $cuenta->plancuentas_tipo == 'C') {
            $action->action = 'cartera';
            $action->success = false;
            $response->actions[] = $action;
        }

        $response->success = true;
        return response()->json($response);
    }

    /**
     * Validate actions detail asiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function validation(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->success = false;
        $response->asiento2_valor = $request->asiento2_valor;

        // Recuperar cuenta
        $cuenta = null;
        if ($request->has('plancuentas_cuenta')) {
            $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        }

        if (!$cuenta instanceof PlanCuenta) {
            $response->errors = 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.';
            return response()->json($response);
        }

        if ($request->has('action')) {
            switch ($request->action) {
                case 'ordenp':
                    // Valido movimiento ordenp
                    $result = Asiento2::validarOrdenp($request);
                    if($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }
                    $response->success = true;
                    return response()->json($response);
                break;

                case 'facturap':
                    // Valido movimiento facturap
                    $result = Asiento2::validarFacturap($request);
                    if($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }
                    $response->success = true;
                    return response()->json($response);
                break;

                case 'cartera':
                    // Valido movimiento cartera
                    $result = Asiento2::validarFactura($request);
                    if($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }

                    $response->success = true;
                    return response()->json($response);
                break;

                case 'inventario':
                    // Valido movimiento inventario
                    $result = Asiento2::validarInventario($request);
                    if($result->success != true) {
                        $response->errors = $result->errors;
                        return response()->json($response);
                    }

                    // Inventario modifica valor item asiento por el valor del costo del movimiento
                    if(isset($result->asiento2_valor) && $result->asiento2_valor != $request->asiento2_valor){
                        $response->asiento2_valor = $result->asiento2_valor;
                    }

                    $response->success = true;
                    return response()->json($response);
                break;
            }
        }

        $response->errors = 'No es posible definir acción a validar, por favor verifique la información del asiento o consulte al administrador.';
        return response()->json($response);
    }
}
