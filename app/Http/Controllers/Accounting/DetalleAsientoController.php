<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2,App\Models\Accounting\AsientoNif, App\Models\Accounting\AsientoNif2, App\Models\Treasury\Facturap, App\Models\Treasury\Facturap2, App\Models\Accounting\AsientoMovimiento, App\Models\Accounting\PlanCuenta,App\Models\Accounting\PlanCuentaNif, App\Models\Accounting\CentroCosto, App\Models\Base\Tercero, App\Models\Production\Ordenp;
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
            $detalle = [];
            if($request->has('asiento')) {
                $detalle = Asiento2::getAsiento2($request->asiento);
            }
            if($request->has('orden2_orden')){
                $detalle = Asiento2::getAsiento2Ordenp($request->orden2_orden);
            }
            return response()->json($detalle);
        }
        return view('admin.actividades.index');
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
        if ($request->ajax()) {
            $data = $request->all();

            $asiento2 = new Asiento2;
            if ($asiento2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar asiento
                    $asiento = Asiento::find($request->asiento1_id);
                    if(!$asiento instanceof Asiento) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar asiento, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Recuperar cuenta
                    $objCuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
                    if(!$objCuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Recuperar centro costo
                    $centrocosto = $ordenp = null;
                    if($request->has('asiento2_centro')) {
                        $centrocosto = CentroCosto::find($request->asiento2_centro);
                        if(!$centrocosto instanceof CentroCosto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro costo, por favor verifique la información del asiento o consulte al administrador.']);
                        }

                        if($centrocosto->centrocosto_codigo == 'OP') {
                            // Validate orden
                            if($request->has('asiento2_orden')) {
                                $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->asiento2_orden}'")->first();
                            }
                            if(!$ordenp instanceof Ordenp) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "No es posible recuperar orden de producción para centro de costo OP, por favor verifique la información del asiento o consulte al administrador."]);
                            }
                        }
                    }

                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->tercero_nit)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Validate asiento2
                    $result = Asiento2::validarAsiento2($request, $objCuenta);
                    if($result != 'OK') {
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
                    if(!$result->success) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result->error]);
                    }

                    // Insertar movimiento asiento
                    $result = $asiento2->movimiento($request);
                    if(!$result->success) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result->error]);
                    }
                    // Asiento Nif
                    $asientoNif = AsientoNif::where('asienton1_asiento', $asiento->id)->first();
                    $asientoNif2 = null;
                    if ($asientoNif instanceof AsientoNif) {

                        $cuentaNif = PlanCuentaNif::find($objCuenta->plancuentas_equivalente);
                        if ( !$cuentaNif instanceof PlanCuentaNif ) {
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
                        if(!$result->success) {
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
                        'asientoNif2_id' => ($asientoNif2 instanceof AsientoNif2 ? $asientoNif2->id : '')
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
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {

                $asiento2 = Asiento2::find($id);
                if(!$asiento2 instanceof Asiento2){
                    return response()->json(['success' => false, 'errors' => 'No es posible definir beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                }
                // Si existe asiento NIF
                $asientoNif = AsientoNif::query()->where('asienton1_asiento',$asiento2->asiento2_asiento)->first();
                if ($asientoNif instanceof AsientoNif) {
                    $asientoNif2 = AsientoNif2::query()->where('asienton2_asiento',$asientoNif->id)->where('asienton2_item', $asiento2->asiento2_item)->first();
                    $asientoNif2->delete();
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
        if($request->has('plancuentas_cuenta')) {
            $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        }

        if(!$cuenta instanceof PlanCuenta) {
            $response->errors = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            return response()->json($response);
        }

        // Validate asiento2
        $result = Asiento2::validarAsiento2($request, $cuenta);
        if($result != 'OK') {
            $response->errors = $result;
            return response()->json($response);
        }

        // Evaluate actions centro costo
        if($request->has('asiento2_centro')) {
            $centrocosto = CentroCosto::find($request->asiento2_centro);
            if($centrocosto instanceof CentroCosto) {
                if($centrocosto->centrocosto_codigo == 'OP') {
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
        if($cuenta->plancuentas_tipo && $cuenta->plancuentas_tipo == 'P') {
            $action->action = 'facturap';
            $action->success = false;
            $response->actions[] = $action;

        // Inventario
        }elseif($cuenta->plancuentas_tipo && $cuenta->plancuentas_tipo == 'I') {
            $action->action = 'inventario';
            $action->success = false;
            $response->actions[] = $action;

        // Cartera
        }elseif($cuenta->plancuentas_tipo && $cuenta->plancuentas_tipo == 'C') {
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
        if($request->has('plancuentas_cuenta')) {
            $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        }

        if(!$cuenta instanceof PlanCuenta) {
            $response->errors = 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.';
            return response()->json($response);
        }

        if($request->has('action'))
        {
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

    /**
     * Display a listing movimientos of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function movimientos(Request $request)
    {
        if ($request->ajax()) {
            $movimientos = [];
            if($request->has('asiento2')) {

                // Recuperar padre
                $asiento2 = Asiento2::find( $request->asiento2 );

                $query = AsientoMovimiento::query();
                $query->select('koi_asientomovimiento.*', 'producto_codigo', 'producto_nombre', 'koi_producto.id as producto_id', 'koi_factura1.*', 'sucursal_nombre', 'puntoventa_nombre', 'puntoventa_prefijo', 'factura4_cuota', 'factura4_factura1', 'facturap2_cuota', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N'
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
                $query->where('movimiento_asiento2', $asiento2->id);
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

                // Object detalle
                $data = [];
                foreach ($movimientos as $item) {
                    if( $item->movimiento_tipo == 'F'){
                        $data['type'] = $item->movimiento_tipo;
                        $data['father'] = [
                            'factura1_puntoventa' => $item->factura1_puntoventa,
                            'factura1_numero' => $item->factura1_numero,
                            'factura1_fecha' => $item->factura1_fecha,
                            'factura1_fecha_vencimiento' => $item->factura1_fecha_vencimiento,
                            'factura1_total' => $item->factura1_total,
                            'factura1_cuotas' => $item->factura1_cuotas,
                            'puntoventa_prefijo' => $item->puntoventa_prefijo,
                            'puntoventa_nombre' => $item->puntoventa_nombre,
                            'movimiento_factura' => $item->movimiento_factura,
                            'tercero_nit' => $item->tercero_nit,
                            'tercero_nombre' => $item->tercero_nombre,
                        ];
                    }
                    if( $item->movimiento_tipo == 'FH'){
                        $data['childrens'][] = [
                            'factura4_cuota' => $item->factura4_cuota,
                            'movimiento_valor' => $item->movimiento_valor
                        ];
                    }

                    if( $item->movimiento_tipo == 'FP'){
                        $data['type'] = $item->movimiento_tipo;
                        $data['father'][] = [
                            'facturap2_cuota' => $item->facturap2_cuota,
                            'movimiento_facturap' => $item->movimiento_facturap,
                            'movimiento_nuevo' => $item->movimiento_nuevo,
                            'movimiento_valor' => $item->movimiento_valor,
                            'movimiento_fecha' => $item->movimiento_fecha,
                            'movimiento_item' => $item->movimiento_item,
                            'movimiento_periodicidad' => $item->movimiento_periodicidad,
                            'movimiento_observaciones' => $item->movimiento_observaciones,
                        ];
                    }

                    if( $item->movimiento_tipo == 'IP'){
                        $data['type'] = $item->movimiento_tipo;
                        $data['father'] = [
                            'producto_codigo' => $item->producto_codigo,
                            'producto_nombre' => $item->producto_nombre,
                            'sucursal_nombre' => $item->sucursal_nombre,
                            'movimiento_valor' => $item->movimiento_valor
                        ];
                    }

                    if( $item->movimiento_tipo == 'IH'){
                        $data['childrens'][] = [
                            'movimiento_serie' => $item->movimiento_serie,
                            'movimiento_item' => $item->movimiento_item,
                            'movimiento_valor' => $item->movimiento_valor,
                        ];
                    }
                }
            }
            return response()->json($data);
        }
    }
}
