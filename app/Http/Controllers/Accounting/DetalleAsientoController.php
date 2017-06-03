<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, DB;

use App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\Facturap, App\Models\Accounting\Facturap2, App\Models\Accounting\AsientoMovimiento, App\Models\Accounting\PlanCuenta, App\Models\Accounting\CentroCosto, App\Models\Base\Tercero, App\Models\Production\Ordenp;

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

                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asiento2->id,
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
                        'ordenp_codigo' => ($ordenp instanceof Ordenp ? "{$ordenp->orden_numero}-".substr($ordenp->orden_ano,-2) : '')
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

                $query = AsientoMovimiento::query();
                $query->select('koi_asientomovimiento.*', 'producto_codigo', 'producto_nombre', 'koi_producto.id as producto_id', 'sucursal_nombre');
                $query->where('movimiento_asiento2', $request->asiento2);
                $query->leftJoin('koi_producto', 'movimiento_producto', '=', 'koi_producto.id');
                $query->leftJoin('koi_sucursal', 'movimiento_sucursal', '=', 'koi_sucursal.id');

                $movimientos = $query->get();

            }
            return response()->json($movimientos);
        }
    }
}
