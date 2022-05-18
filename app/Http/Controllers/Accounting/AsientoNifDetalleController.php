<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2,App\Models\Accounting\AsientoNif, App\Models\Accounting\AsientoNif2, App\Models\Treasury\Facturap1, App\Models\Treasury\Facturap2, App\Models\Accounting\AsientoMovimiento, App\Models\Accounting\PlanCuenta,App\Models\Accounting\PlanCuentaNif, App\Models\Accounting\CentroCosto, App\Models\Base\Tercero, App\Models\Production\Ordenp;
use Log, DB;

class AsientoNifDetalleController extends Controller
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
                $data = AsientoNif2::getAsientoNif2($request->asiento);
            }
            return response()->json($data);
        }
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

            $asiento2 = new AsientoNif2;
            if ($asiento2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar asiento
                    $asiento = AsientoNif::find($request->asienton1_id);
                    if (!$asiento instanceof AsientoNif) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar asiento, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Recuperar cuenta
                    $objCuenta = PlanCuentaNif::where('plancuentasn_cuenta', $request->plancuentasn_cuenta)->first();
                    if (!$objCuenta instanceof PlanCuentaNif) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta NIF, por favor verifique la información del asiento o consulte al administrador.']);
                    }
                    // Recuperar centro costo
                    $centrocosto = $ordenp = null;
                    if ($request->has('asienton2_centro')) {
                        $centrocosto = CentroCosto::find($request->asienton2_centro);
                        if (!$centrocosto instanceof CentroCosto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro costo, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        if ($centrocosto->centrocosto_codigo == 'OP') {
                            // Validate orden
                            if ($request->has('asienton2_orden')) {
                                $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->asienton2_orden}'")->first();
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
                    $result = AsientoNif2::validarAsientoNif2($request, $objCuenta);
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    $cuenta = [];
                    $cuenta['Cuenta'] = $objCuenta->plancuentasn_cuenta;
                    $cuenta['Tercero'] = $request->tercero_nit;
                    $cuenta['Detalle'] = $request->asienton2_detalle;
                    $cuenta['Naturaleza'] = $request->asienton2_naturaleza;
                    $cuenta['CentroCosto'] = $request->asienton2_centro;
                    $cuenta['Base'] = $request->asienton2_base;
                    $cuenta['Credito'] = $request->asienton2_naturaleza == 'C' ? $request->asienton2_valor: 0;
                    $cuenta['Debito'] = $request->asienton2_naturaleza == 'D' ? $request->asienton2_valor: 0;
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

                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asiento2->id,
                        'asienton2_cuenta' => $objCuenta->id,
                        'plancuentasn_cuenta' => $objCuenta->plancuentasn_cuenta,
                        'plancuentasn_nombre' => $objCuenta->plancuentasn_nombre,
                        'centrocosto_codigo' => ($centrocosto instanceof CentroCosto ? $centrocosto->getCode() : ''),
                        'centrocosto_nombre' => ($centrocosto instanceof CentroCosto ? $centrocosto->centrocosto_nombre : ''),
                        'asienton2_beneficiario' => ($tercero instanceof Tercero ? $tercero->id : ''),
                        'tercero_nit' => ($tercero instanceof Tercero ? $tercero->tercero_nit : ''),
                        'tercero_nombre' => ($tercero instanceof Tercero ? $tercero->getName() : ''),
                        'asienton2_credito' => $asiento2->asienton2_credito,
                        'asienton2_debito' => $asiento2->asienton2_debito,
                        'asienton2_ordenp' => ($ordenp instanceof Ordenp ? $ordenp->id : ''),
                        'ordenp_codigo' => ($ordenp instanceof Ordenp ? "{$ordenp->orden_numero}-".substr($ordenp->orden_ano,-2) : ''),
                        'ordenp_beneficiario' => $request->asienton2_orden_beneficiario
                    ]);
                }catch(\Exception $e){
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

                $asiento2 = AsientoNif2::find($id);
                if (!$asiento2 instanceof AsientoNif2){
                    return response()->json(['success' => false, 'errors' => 'No es posible definir beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                }
                // Eliminar movimiento
                AsientoMovimiento::where('movimiento_asiento2', $asiento2->id)->delete();

                // Eliminar item asiento2
                $asiento2->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
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
        if ($request->has('plancuentasn_cuenta')) {
            $cuenta = PlanCuentaNif::where('plancuentasn_cuenta', $request->plancuentasn_cuenta)->first();
        }
        if (!$cuenta instanceof PlanCuentaNif) {
            $response->errors = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            return response()->json($response);
        }

        // Validate asiento2
        $result = AsientoNif2::validarAsientoNif2($request, $cuenta);
        if ($result != 'OK') {
            $response->errors = $result;
            return response()->json($response);
        }

        // Evaluate actions centro costo
        if ($request->has('asienton2_centro')) {
            $centrocosto = CentroCosto::find($request->asienton2_centro);
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
        if ($cuenta->plancuentasn_tipo && $cuenta->plancuentasn_tipo == 'P') {
            $action->action = 'facturap';
            $action->success = false;
            $response->actions[] = $action;

        // Inventario
        }elseif ($cuenta->plancuentasn_tipo && $cuenta->plancuentasn_tipo == 'I') {
            $action->action = 'inventario';
            $action->success = false;
            $response->actions[] = $action;

        // Cartera
        }elseif ($cuenta->plancuentasn_tipo && $cuenta->plancuentasn_tipo == 'C') {
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
        $response->asiento2_valor = $request->asienton2_valor;

        // Recuperar cuenta
        $cuenta = null;
        if ($request->has('plancuentasn_cuenta')) {
            $cuenta = PlanCuentaNif::where('plancuentasn_cuenta', $request->plancuentasn_cuenta)->first();
        }

        if (!$cuenta instanceof PlanCuentaNif) {
            $response->errors = 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.';
            return response()->json($response);
        }

        if ($request->has('action'))
        {
            switch ($request->action) {
                case 'ordenp':
                    // Valido movimiento ordenp
                    $result = AsientoNif2::validarOrdenp($request);
                    if ($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }
                    $response->success = true;
                    return response()->json($response);
                break;

                case 'facturap':
                    // Valido movimiento facturap
                    $result = AsientoNif2::validarFacturap($request);
                    if ($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }
                    $response->success = true;
                    return response()->json($response);
                break;

                case 'cartera':
                    // Valido movimiento cartera
                    $result = AsientoNif2::validarFactura($request);
                    if ($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }

                    $response->success = true;
                    return response()->json($response);
                break;

                case 'inventario':
                    // Valido movimiento inventario
                    $result = AsientoNif2::validarInventario($request);
                    if ($result->success != true) {
                        $response->errors = $result->errors;
                        return response()->json($response);
                    }

                    // Inventario modifica valor item asiento por el valor del costo del movimiento
                    if (isset($result->asiento2_valor) && $result->asiento2_valor != $request->asienton2_valor){
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

    /**
     * Display a listing movimientos of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function movimientos(Request $request)
    {
        if ($request->ajax()) {
            $movimientos = [];
            if ($request->has('asiento2')) {
                $query = AsientoMovimiento::query();
                $query->select('koi_asientomovimiento.*', 'producto_codigo', 'producto_nombre', 'koi_producto.id as producto_id', 'koi_factura1.*', 'koi_factura1.id as factura1_id', 'sucursal_nombre', 'puntoventa_nombre', 'puntoventa_prefijo', 'factura4_cuota', 'factura4_factura1', 'facturap2_cuota', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                        ELSE tercero_razonsocial END)
                    AS tercero_nombre"), DB::raw("
                        CASE
                            WHEN productop_3d != 0 THEN
                                    CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') 3D(',
                                    COALESCE(orden2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                            WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN
                                    CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                                    COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                                    COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                            WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN
                                    CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                                    COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                            WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN
                                    CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') C(',
                                    COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                            ELSE
                                    CONCAT(
                                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                            END AS productop_nombre
                        ")
                    );
                $query->where('movimiento_asiento2', $request->asiento2);
                $query->leftJoin('koi_producto', 'movimiento_producto', '=', 'koi_producto.id');
                $query->leftJoin('koi_sucursal', 'movimiento_sucursal', '=', 'koi_sucursal.id');

                // Factura
                $query->leftJoin('koi_factura1', 'movimiento_factura', '=', 'koi_factura1.id');
                $query->leftJoin('koi_factura4', 'movimiento_factura4', '=', 'koi_factura4.id');
                $query->leftJoin('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id');
                $query->leftJoin('koi_ordenproduccion2', 'movimiento_ordenp2', '=', 'koi_ordenproduccion2.id');
                $query->leftJoin('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');

                // Facturap
                $query->leftJoin('koi_facturap2', 'movimiento_item', '=', 'koi_facturap2.id');

                // Joins producto
                $query->leftJoin('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
                $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
                $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
                $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
                $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
                $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
                $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
                $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');

                $movimientos = $query->get();
            }
            return response()->json($movimientos);
        }
    }
}
