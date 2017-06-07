<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Validator, Auth, DB;

use App\Models\Base\Tercero, App\Models\Production\Ordenp, App\Models\Production\Ordenp2,App\Models\Inventory\Producto, App\Models\Inventory\Inventario, App\Models\Inventory\InventarioRollo, App\Models\Inventory\Prodbode, App\Models\Inventory\ProdbodeRollo, App\Models\Base\PuntoVenta, App\Models\Accounting\Factura1, App\Models\Accounting\Factura2;

class Asiento2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_asiento2';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'plancuentas_cuenta' => 'required|integer',
            'asiento2_naturaleza' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getAsiento2($asiento)
    {
        $query = Asiento2::query();
        $query->select('koi_asiento2.*', 'plancuentas_cuenta', 'plancuentas_naturaleza', 'plancuentas_nombre', DB::raw('centrocosto_codigo as centrocosto_codigo'), 'centrocosto_nombre', 'tercero_nit',
            DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
                AS tercero_nombre"),
            DB::raw("(CASE WHEN asiento2_credito != 0 THEN 'C' ELSE 'D' END) as asiento2_naturaleza"),
            DB::raw("CONCAT(COALESCE(orden_numero, ''),'-',SUBSTRING(COALESCE(orden_ano,''), -2)) as orden_codigo")
        );
        $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
        $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
        $query->leftJoin('koi_centrocosto', 'asiento2_centro', '=', 'koi_centrocosto.id');
        // Temporal join
        $query->leftJoin('koi_ordenproduccion', 'asiento2_ordenp', '=', 'koi_ordenproduccion.id');
        $query->where('asiento2_asiento', $asiento);
        return $query->get();
    }

    public function store(Asiento $asiento, Array $data)
    {
        $response = new \stdClass();
        $response->success = false;

        // Recuperar cuenta
        $objCuenta = PlanCuenta::where('plancuentas_cuenta', $data['Cuenta'])->first();
        if(!$objCuenta instanceof PlanCuenta) {
            $response->error = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Recuperar niveles cuenta
        $niveles = PlanCuenta::getNivelesCuenta($objCuenta->plancuentas_cuenta);
        if(!is_array($niveles)) {
            $response->error = "Error al recuperar niveles para la cuenta {$objCuenta->plancuentas_cuenta}.";
            return $response;
        }

        // Recuperar tercero
        $objTercero = Tercero::where('tercero_nit', $data['Tercero'])->first();
        if(!$objTercero instanceof Tercero) {
            $response->error = "No es posible recuperar beneficiario {$data['Tercero']}, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Recuperar centro costo
        $objCentroCosto = null;
        if(isset($data['CentroCosto']) && !empty($data['CentroCosto'])) {
            $objCentroCosto = CentroCosto::find($data['CentroCosto']);
            if(!$objCentroCosto instanceof CentroCosto) {
                $response->error = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
                return $response;
            }
        }

        // Validar valores
        if($data['Naturaleza'] == 'C') {
            if(!is_numeric($data['Credito']) || $data['Credito'] <= 0) {
                $response->error = "Valor no puede ser menor o igual a 0.";
                return $response;
            }
        }

        if($data['Naturaleza'] == 'D') {
            if(!is_numeric($data['Debito']) || $data['Debito'] <= 0) {
                $response->error = "Valor no puede ser menor o igual a 0 ({$data['Debito']}).";
                return $response;
            }
        }

        // Insert si no existe asiento2
        if(!isset($data['Id']) || empty($data['Id']))
        {
            $this->asiento2_asiento = $asiento->id;
            $this->asiento2_cuenta = $objCuenta->id;
            $this->asiento2_beneficiario = $objTercero->id;
            $this->asiento2_nivel1 = $niveles['nivel1'] ?: 0;
            $this->asiento2_nivel2 = $niveles['nivel2'] ?: 0;
            $this->asiento2_nivel3 = $niveles['nivel3'] ?: 0;
            $this->asiento2_nivel4 = $niveles['nivel4'] ?: 0;
            $this->asiento2_nivel5 = $niveles['nivel5'] ?: 0;
            $this->asiento2_nivel6 = $niveles['nivel6'] ?: 0;
            $this->asiento2_nivel7 = $niveles['nivel7'] ?: 0;
            $this->asiento2_nivel8 = $niveles['nivel8'] ?: 0;
            if($objCentroCosto instanceof CentroCosto)
            {
                $this->asiento2_centro = $objCentroCosto->id;
                if($objCentroCosto->centrocosto_codigo == 'OP') {

                    $objOrdenp = Ordenp::find($data['Orden']);
                    if(!$objOrdenp instanceof Ordenp) {
                        $response->error = "No es posible recuperar orden de producción para centro de costo OP, por favor verifique la información del asiento o consulte al administrador..";
                        return $response;
                    }

                    $this->asiento2_ordenp = $objOrdenp->id;
                }
            }
            $this->asiento2_detalle = $data['Detalle'] ?: '';
            $this->asiento2_credito = $data['Credito'] ?: 0;
            $this->asiento2_debito = $data['Debito'] ?: 0;
            $this->asiento2_base = $data['Base'] ?: 0;
            $this->save();
        }

        $response->success = true;
        return $response;
    }

    public static function validarAsiento2(Request $request, PlanCuenta $cuenta)
    {
        // Verifico que no existan subniveles de la cuenta que estoy realizando el asiento
        $result = $cuenta->validarSubnivelesCuenta();
        if($result != 'OK') {
            return $result;
        }

        // Recuperar niveles cuenta
        $niveles = PlanCuenta::getNivelesCuenta($cuenta->plancuentas_cuenta);
        if(!is_array($niveles)) {
            return "Error al recuperar niveles para la cuenta {$cuenta->plancuentas_cuenta}.";
        }

        // Validar base
        if( !empty($cuenta->plancuentas_tasa) && $cuenta->plancuentas_tasa > 0 && (!$request->has('asiento2_base') || $request->asiento2_base == 0) ) {
            return "Para la cuenta {$cuenta->plancuentas_cuenta} debe existir base.";
        }

        // Validar tercero
        $tercero = null;
        if($request->has('tercero_nit')) {
            $tercero = Tercero::where('tercero_nit', $request->tercero_nit)->first();
        }

        if(!$tercero instanceof Tercero) {
            return "No es posible recuperar beneficiario {$request->tercero_nit}, por favor verifique la información del asiento o consulte al administrador.";
        }

        // Validar centro de costo
        $centrocosto = null;
        if($request->has('asiento2_centro')) {
            $centrocosto = CentroCosto::find($request->asiento2_centro);
            if(!$centrocosto instanceof CentroCosto) {
                return "No es posible recuperar centro de costo, por favor verifique la información del asiento o consulte al administrador.";
            }
        }

        // Validar valor
        if(!$request->has('asiento2_valor') || !is_numeric($request->asiento2_valor) || $request->asiento2_valor <= 0) {
            return "Valor no puede ser menor o igual a 0, por favor verifique la información del asiento o consulte al administrador";
        }

        return 'OK';
    }

    public static function validarOrdenp(Request $request)
    {
        // Validate centro costo
        if($request->has('asiento2_centro')) {
            $centrocosto = CentroCosto::find($request->asiento2_centro);
            if(!$centrocosto instanceof CentroCosto || $centrocosto->centrocosto_codigo != 'OP') {
                return 'Para asociar orden de producción a ítem asiento se requiere centro costo OP, por favor verifique la información del asiento o consulte al administrador.';
            }
        }

        // Validate orden
        $ordenp = null;
        if($request->has('asiento2_orden')) {
            $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->asiento2_orden}'")->first();
        }
        if(!$ordenp instanceof Ordenp) {
            return 'No es posible recuperar orden de producción, por favor verifique la información o consulte al administrador.';
        }

        return 'OK';
    }

    public static function validarFacturap(Request $request)
    {
        // Recuperar tercero
        $tercero = null;
        if($request->has('tercero_nit')) {
            // Recuperar tercero
            $tercero = Tercero::where('tercero_nit', $request->tercero_nit)->first();
            if(!$tercero instanceof Tercero) {
                return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
            }
        }

        if(!$tercero instanceof Tercero) {
            return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
        }

        // Recuperar factura
        $facturap = Facturap::where('facturap1_factura', $request->facturap1_factura)->where('facturap1_tercero', $tercero->id)->first();
        // Validar naturaleza
        if($request->asiento2_naturaleza == 'D') {
            if(!$facturap instanceof Facturap) {
                return "Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.";
            }
        }

        if($facturap instanceof Facturap) {
            // En caso de existir factura se afectan cuotas
            $cuotas = Facturap2::where('facturap2_factura', $facturap->id)->get();
            if($cuotas->count() <= 0) {
                return "No es posible recuperar cuotas para la factura {$facturap->facturap1_factura}, por favor verifique la información del asiento o consulte al administrador.";
            }

            // Validar valor distribucion cuotas
            $suma_valor = 0;
            foreach ($cuotas as $cuota) {
                if($request->has("movimiento_valor_{$cuota->id}")) {
                    $suma_valor += $request->get("movimiento_valor_{$cuota->id}");
                }
            }
            if($suma_valor != $request->asiento2_valor) {
                return "Las suma de los valores debe ser igual al valor del item del asiento: valor {$request->asiento2_valor}, suma $suma_valor, diferencia ".abs($request->asiento2_valor - $suma_valor);
            }
        }else{
            // Validar sucursal
            if(!isset($request->facturap1_sucursal) || !is_numeric($request->facturap1_sucursal) || $request->facturap1_sucursal <= 0) {
                return "No es posible recuperar sucursal, por favor verifique la información del asiento o consulte al administrador.";
            }

            // Validar fecha
            if(!isset($request->facturap1_vencimiento) || trim($request->facturap1_vencimiento) == '') {
                return "Fecha vencimiento es obligatoria.";
            }

            // Validar periodo
            if(!isset($request->facturap1_periodicidad) || !is_numeric($request->facturap1_periodicidad) || $request->facturap1_periodicidad <= 0) {
                return "Periodicidad (días) para cuotas no puede ser menor o igual a 0.";
            }
        }
        return 'OK';
    }
    
    public static function validarFactura(Request $request)
    {
        if ($request->factura_nueva == 'N'){
            // Recuperar tercero
            $tercero = null;
            if($request->has('tercero_nit')) {
                // Recuperar tercero
                $tercero = Tercero::where('tercero_nit', $request->tercero_nit)->first();
                if(!$tercero instanceof Tercero) {
                    return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
                }
            }

            if(!$tercero instanceof Tercero) {
                return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
            }
            
            // Recuperar puntoventa
            $puntoventa = PuntoVenta::findOrFail($request->factura1_puntoventa);
            if(!$puntoventa instanceof PuntoVenta) {
                return "No es posible recuperar punto de venta, por favor verifique la información del asiento o consulte al administrador.";
            }

            // Validar fecha
            if(!isset($request->factura1_fecha) || trim($request->factura1_fecha) == '') {
                return "Fecha es obligatoria.";
            }

            // Validar fecha_vencimiento
            if(!isset($request->factura1_fecha_vencimiento) || trim($request->factura1_fecha_vencimiento) == '') {
                return "Fecha vencimiento es obligatoria.";
            }

            // Validar cuotas
            if(!isset($request->factura1_cuotas) || !is_numeric($request->factura1_cuotas) || $request->factura1_cuotas <= 0) {
                return "Cuotas es obligatoria y no puede ser menor a 0.";
            }

            // Recuperar Ordenp
            $orden = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->factura1_orden}'")->first();
            if(!$orden instanceof Ordenp){
                return "No es posible recuperar numero de orden, por favor verifique la información del asiento o consulte al administrador.";
            }

            // Recuperar ordenp2
            $orden2 = Ordenp2::getOrdenesf2($orden->id);
            foreach ($orden2 as $item) {
                if($item->orden2_orden != $orden->id){
                    return "El item {$item->id} no corresponde a la orden, por favor verifique la información del asiento o consulte al administrador.";
                }

                if( $request->has("facturado_cantidad_{$item->id}") ){
                    if($request->get("facturado_cantidad_{$item->id}") < 0){
                        return "El numero de unidades debe ser mayor a cero, por favor verifique la información del asiento o consulte al administrador.";
                    }

                    if($request->get("facturado_cantidad_{$item->id}") > $item->orden2_cantidad){
                        return "La cantidad ingresada no puede superar el saldo en esta orden {$item->id}, por favor verifique la información ó consulte al administrador.";
                    }
                }
            }
        }else if($request->factura_nueva == 'E'){
            // Recuperar factura1 -> Padre
            $factura = Factura1::find($request->factura_orden);
            if(!$factura instanceof Factura1){
                return "No es posible recuperar la factura, por favor verifique la información o consulte al administrador.";
            }
        }
        return 'OK';
    }

    public static function validarInventario(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->success = false;

        // Validar producto
        $producto = null;
        if($request->has('producto_codigo')) {
            $producto = Producto::where('producto_codigo', $request->producto_codigo)->first();
        }
        if(!$producto instanceof Producto) {
            $response->errors = "No es posible recuperar producto, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Validar sucursal
        if(!isset($request->movimiento_sucursal) || !is_numeric($request->movimiento_sucursal) || $request->movimiento_sucursal <= 0) {
            $response->errors = "No es posible recuperar sucursal, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Validar unidades
        if(!isset($request->movimiento_cantidad) || !is_numeric($request->movimiento_cantidad) || $request->movimiento_cantidad <= 0) {
            $response->errors = "El numero de unidades debe ser mayor a cero, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        if($producto->producto_unidades == false) {
            // Producto que no manejan unidades
            $response->errors = "No es posible realizar movimientos para productos que no manejan unidades, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        if ($producto->producto_metrado == true) {
            // Producto metrado
            if($request->asiento2_naturaleza == 'D') {
                for ($item = 1; $item <= $request->movimiento_cantidad; $item++) {
                    if(!$request->has("itemrollo_metros_$item") || $request->get("itemrollo_metros_$item") <=0) {
                        $response->errors = "Por favor ingrese valor en metros para el item rollo $item, debe ser mayor a 0.";
                        return $response;
                    }
                }
            }else {
                $items = ProdbodeRollo::where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $request->movimiento_sucursal)->get();

                $chosen = 0;
                $costo = 0;
                foreach ($items as $item) {

                    // Validar items ingresados
                    if($request->has("itemrollo_metros_{$item->id}") && $request->get("itemrollo_metros_{$item->id}") > 0 && $request->get("itemrollo_metros_{$item->id}") != '') {
                        // Validar cantidad
                        if($request->get("itemrollo_metros_{$item->id}") > $item->prodboderollo_saldo) {
                            $response->errors = "Metros debe ser menor o igual a {$item->prodboderollo_saldo}, para el item rollo {$item->prodboderollo_item}.";
                            return $response;
                        }
                        $chosen++;
                    }

                    // Maximo numero items
                    if($chosen > $request->movimiento_cantidad) {
                        $response->errors = "Por favor ingrese metros unicamente para {$request->movimiento_cantidad} items.";
                        return $response;
                    }

                    $costo += $request->get("itemrollo_metros_{$item->id}") * $item->prodboderollo_costo;
                }

                // Minimo numero items
                if($chosen < $request->movimiento_cantidad) {
                    $response->errors = "Por favor ingrese metros para {$request->movimiento_cantidad} items.";
                    return $response;
                }
                // Costo salida
                $response->asiento2_valor = $costo;
            }

        }elseif ($producto->producto_serie == true) {
            // Producto serie
            if($request->asiento2_naturaleza == 'D') {
                $series = [];
                for ($item = 1; $item <= $request->movimiento_cantidad; $item++) {
                    if(!$request->has("producto_serie_$item") || $request->get("producto_serie_$item") == '') {
                        $response->errors = "Por favor ingrese serie para el item $item.";
                        return $response;
                    }

                    // Validar series ingresadas repetidas
                    if(in_array($request->get("producto_serie_$item"), $series)){
                        $response->errors = "No es posible registrar dos números de serie iguales";
                        return $response;
                    }

                    // Validar serie
                    $serie = Producto::where('producto_codigo', $request->get("producto_serie_$item"))->first();
                    if($serie instanceof Producto) {
                        // Si ya existe serie validamos prodbode en cualquier sucursal, serie unica
                        $existencias = DB::table('koi_prodbode')->where('prodbode_producto', $serie->id)->sum('prodbode_cantidad');
                        if($existencias > 0) {
                            $response->errors = "Ya existe un producto con este número de serie {$serie->producto_codigo}.";
                            return $response;
                        }
                    }

                    $series[] = $request->get("producto_serie_$item");
                }
            }else{
                // Recuperar prodbode
                $prodbode = Prodbode::prodbode($producto, $request->movimiento_sucursal);
                if(!$prodbode instanceof Prodbode || $request->movimiento_cantidad > $prodbode->disponibles) {
                    $response->errors = "No existen suficientes unidades para salida, unidades disponibles ".($prodbode instanceof Prodbode ? $prodbode->prodbode_cantidad  : 0).", por favor verifique la información o consulte al administrador.";
                    return $response;
                }

                // Costo salida
                $costo = Inventario::primerasEnSalir($producto, $request->movimiento_sucursal, $request->movimiento_cantidad);
                if(!is_numeric($costo)) {
                    $response->errors = $costo;
                    return $response;
                }
            }
        }elseif($producto->producto_unidades == true) {
            // Producto normal
            if($request->asiento2_naturaleza == 'C') {
                // Recuperar prodbode
                $prodbode = Prodbode::prodbode($producto, $request->movimiento_sucursal);
                if(!$prodbode instanceof Prodbode || $request->movimiento_cantidad > $prodbode->disponibles) {
                    $response->errors = "No existen suficientes unidades para salida, unidades disponibles ".($prodbode instanceof Prodbode ? $prodbode->prodbode_cantidad  : 0).", por favor verifique la información o consulte al administrador.";
                    return $response;
                }

                // Costo salida
                $costo = Inventario::primerasEnSalir($producto, $request->movimiento_sucursal, $request->movimiento_cantidad);
                if(!is_numeric($costo)) {
                    $response->errors = $costo;
                    return $response;
                }
                $response->asiento2_valor = $costo;
            }
        }

        $response->success = true;
        return $response;
    }

    public function movimiento(Request $request)
    {
        $response = new \stdClass();
        $response->success = false;

        // Recuperar cuenta
        $objCuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        if(!$objCuenta instanceof PlanCuenta) {
            $response->error = 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.';
            return $response;
        }

        if($objCuenta->plancuentas_tipo == 'P')
        {
            // Preparar movimiento Facturap
            $datamov = [];
            $datamov['Tipo'] = 'FP';
            $datamov['Naturaleza'] = $request->asiento2_naturaleza;
            $datamov['Factura'] = $request->facturap1_factura;

            // Recuperar factura
            $facturap = Facturap::where('facturap1_factura', $request->facturap1_factura)->where('facturap1_tercero', $this->asiento2_beneficiario)->first();
            // Validar naturaleza
            if($request->asiento2_naturaleza == 'D') {
                if(!$facturap instanceof Facturap) {
                    $response->error = 'Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.';
                    return $response;
                }
            }

            if($facturap instanceof Facturap) {
                // En caso de existir factura se afectan cuotas
                $cuotas = Facturap2::where('facturap2_factura', $facturap->id)->get();
                if($cuotas->count() <= 0) {
                    $response->error = "No es posible recuperar cuotas para la factura {$facturap->facturap1_factura}, por favor verifique la información del asiento o consulte al administrador.";
                    return $response;
                }

                // Validar valor distribucion cuotas
                $suma_valor = 0;
                foreach ($cuotas as $cuota) {
                    if($request->has("movimiento_valor_{$cuota->id}")) {
                        $suma_valor += $request->get("movimiento_valor_{$cuota->id}");
                    }
                }
                if($suma_valor != $request->asiento2_valor) {
                    $response->error = "Las suma de los valores debe ser igual al valor del item del asiento: valor {$request->asiento2_valor}, suma $suma_valor, diferencia ".abs($request->asiento2_valor - $suma_valor);
                    return $response;
                }

                // Insertar movimientos
                foreach ($cuotas as $cuota)
                {
                    if($request->has("movimiento_valor_{$cuota->id}"))
                    {
                        $datamov['Cuotas'] = $cuota->id;
                        $datamov['Valor'] = $request->get("movimiento_valor_{$cuota->id}");
                        $datamov['Nuevo'] = false;

                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }
                    }
                }

            }else{
                // En caso no existir factura se crea
                $datamov['Nuevo'] = true;
                $datamov['Valor'] = $request->asiento2_valor;
                $datamov['Sucursal'] = $request->facturap1_sucursal;
                $datamov['Fecha'] = $request->facturap1_vencimiento;
                $datamov['Cuotas'] = $request->facturap1_cuotas;
                $datamov['Periodicidad'] = $request->facturap1_periodicidad;
                $datamov['Detalle'] = $request->facturap1_observaciones;

                $movimiento = new AsientoMovimiento;
                $result = $movimiento->store($this, $datamov);
                if(!$result->success) {
                    $response->error = $result->error;
                    return $response;
                }
            }

        }elseif ($objCuenta->plancuentas_tipo == 'I') {

            // Validar producto
            $producto = null;
            if($request->has('producto_codigo')) {
                $producto = Producto::where('producto_codigo', $request->producto_codigo)->first();
            }
            if(!$producto instanceof Producto) {
                $response->error = "No es posible recuperar producto, por favor verifique la información del asiento o consulte al administrador.";
                return $response;
            }

            // Preparar movimiento padre
            $datamov = [];
            $datamov['Tipo'] = 'IP';
            $datamov['Naturaleza'] = $request->asiento2_naturaleza;
            $datamov['Sucursal'] = $request->movimiento_sucursal;
            $datamov['Producto'] = $producto->id;
            $datamov['Valor'] = $request->movimiento_cantidad;

            $movimiento = new AsientoMovimiento;
            $result = $movimiento->store($this, $datamov);
            if(!$result->success) {
                $response->error = $result->error;
                return $response;
            }

            // Preparar movimientos hijos
            $datamov = [];
            $datamov['Tipo'] = 'IH';
            if ($producto->producto_metrado == true) {
                // Producto metrado
                // Debito
                if($request->asiento2_naturaleza == 'D') {
                    for ($item = 1; $item <= $request->movimiento_cantidad; $item++) {
                        if(!$request->has("itemrollo_metros_$item") || $request->get("itemrollo_metros_$item") <=0) {
                            $response->error = "Por favor ingrese valor en metros para el item rollo $item, debe ser mayor a 0.";
                            return $response;
                        }
                        $datamov['Item'] = $item;
                        $datamov['Valor'] = $request->get("itemrollo_metros_$item");

                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }
                    }
                // Credito
                }else{
                    $items = ProdbodeRollo::where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $request->movimiento_sucursal)->get();
                    // $chosen = 0;
                    foreach ($items as $item) {

                        // Validar items ingresados
                        if($request->has("itemrollo_metros_{$item->id}") && $request->get("itemrollo_metros_{$item->id}") > 0 && $request->get("itemrollo_metros_{$item->id}") != '') {
                            $datamov['Item'] = $item->prodboderollo_item;
                            $datamov['Valor'] = $request->get("itemrollo_metros_{$item->id}");

                            $movimiento = new AsientoMovimiento;
                            $result = $movimiento->store($this, $datamov);
                            if(!$result->success) {
                                $response->error = $result->error;
                                return $response;
                            }
                        }
                    }
                }

            }elseif ($producto->producto_serie == true) {
                // Producto serie
                // Debito
                if($request->asiento2_naturaleza == 'D') {
                    for ($item = 1; $item <= $request->movimiento_cantidad; $item++) {
                        if(!$request->has("producto_serie_$item") || $request->get("producto_serie_$item") == '') {
                            $response->error = "Por favor ingrese serie para el item $item";
                            return $response;
                        }

                        $datamov['Item'] = $item;
                        $datamov['Serie'] = $request->get("producto_serie_$item");

                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }
                    }
                }
            }
        }elseif ($objCuenta->plancuentas_tipo == 'C') {
            if($request->asiento2_naturaleza == 'D'){
                if($request->has('factura_nueva')) {
                    $orden = null;
                    if($request->factura_nueva == 'N'){
                        $orden = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->factura1_orden}'")->first();
                        if(!$orden instanceof Ordenp){
                            $response->error = "No es posible recuperar numero de orden, por favor verifique la información del asiento o consulte al administrador.";
                            return $response;
                        }

                        // Preparar movimiento Factura
                        $datamov = [];
                        $datamov['Tipo'] = 'F';
                        $datamov['Naturaleza'] = $request->asiento2_naturaleza;
                        $datamov['Nuevo'] = true;
                        $datamov['Fecha'] = $request->factura1_fecha;
                        $datamov['Vencimiento'] = $request->factura1_fecha_vencimiento;
                        $datamov['Valor'] = $request->asiento2_valor;
                        $datamov['Cuotas'] = $request->factura1_cuotas;
                        $datamov['PuntoVenta'] = $request->factura1_puntoventa;
                        $datamov['Orden'] = $orden->id;

                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }

                        // Preparar movimientos hijos
                        $datamov = [];
                        $datamov['Tipo'] = 'FH';
                        $datamov['Nuevo'] = true;

                        // Traer ordenp2
                        $orden2 = Ordenp2::getOrdenesp2($orden->id);
                        foreach ($orden2 as $item) {
                            if( $request->has("facturado_cantidad_{$item->id}") ){
                                
                                if($item->orden2_orden != $orden->id){
                                    $response->error = "El item {$item->id} no corresponde a la orden, por favor verifique la información del asiento o consulte al administrador.";
                                    return $response;
                                }

                                if($request->get("facturado_cantidad_{$item->id}") < 0){
                                    $response->error = "El numero de unidades debe ser mayor a cero, por favor verifique la información del asiento o consulte al administrador.";
                                    return $response;
                                }

                                if($request->get("facturado_cantidad_{$item->id}") > 0){
                                    $datamov['Orden'] = $item->id;
                                    $datamov['Cantidad'] = $request->get("facturado_cantidad_{$item->id}");
                                 
                                    $movimiento = new AsientoMovimiento;
                                    $result = $movimiento->store($this, $datamov);
                                    if(!$result->success) {
                                        $response->error = $result->error;
                                        return $response;
                                    }
                                }

                            }
                        }
                    }else if($request->factura_nueva == 'E'){
                        // Preparar movimiento Factura
                        $datamov = [];
                        $datamov['Tipo'] = 'F';
                        $datamov['Naturaleza'] = $request->asiento2_naturaleza;
                        $datamov['Nuevo'] = false;
                        $datamov['Factura'] = $request->factura_orden;
                        $datamov['Valor'] = $request->factura1_pagar;
                        
                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }

                        // Preparar movimientos hijos
                        $datamov = [];
                        $datamov['Tipo'] = 'FH';
                        $datamov['Nuevo'] = false;

                        // Recuperar Factura1 ->Padre
                        $factura = Factura1::find($request->factura_orden);
                        if(!$factura instanceof Factura1){
                            $response->error = "No es posible recuperar la factura, por favor verifique la información o consulte al administrador";
                            return $response;
                        }

                        // Recuperar Factura4 -> Hijo
                        $factura4 = Factura4::where('factura4_factura1', $factura->id)->get();
                        foreach ($factura4 as $item) {
                            if($request->has("factura4_pagar_{$item->id}")){
                                if($request->get("factura4_pagar_{$item->id}") != 0){
                                    $datamov['FacturaChild'] = $item->id;
                                    $datamov['Valor'] = $request->get("factura4_pagar_{$item->id}");
                                 
                                    $movimiento = new AsientoMovimiento;
                                    $result = $movimiento->store($this, $datamov);
                                    if(!$result->success) {
                                        $response->error = $result->error;
                                        return $response;
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                // Preparar movimiento Factura
                $datamov = [];
                $datamov['Tipo'] = 'F';
                $datamov['Naturaleza'] = $request->asiento2_naturaleza;
                $datamov['Nuevo'] = false;
                $datamov['Factura'] = $request->factura_orden;
                $datamov['Valor'] = $request->factura1_pagar;
                
                $movimiento = new AsientoMovimiento;
                $result = $movimiento->store($this, $datamov);
                if(!$result->success) {
                    $response->error = $result->error;
                    return $response;
                }

                // Preparar movimientos hijos
                $datamov = [];
                $datamov['Tipo'] = 'FH';
                $datamov['Nuevo'] = false;

                // Recuperar Factura1 ->Padre
                $factura = Factura1::find($request->factura_orden);
                if(!$factura instanceof Factura1){
                    $response->error = "No es posible recuperar la factura, por favor verifique la información o consulte al administrador";
                    return $response;
                }

                // Recuperar Factura4 -> Hijo
                $factura4 = Factura4::where('factura4_factura1', $factura->id)->get();
                foreach ($factura4 as $item) {
                    if($request->has("factura4_pagar_{$item->id}")){
                        if($request->get("factura4_pagar_{$item->id}") != 0){
                            $datamov['FacturaChild'] = $item->id;
                            $datamov['Valor'] = $request->get("factura4_pagar_{$item->id}");
                         
                            $movimiento = new AsientoMovimiento;
                            $result = $movimiento->store($this, $datamov);
                            if(!$result->success) {
                                $response->error = $result->error;
                                return $response;
                            }
                        }
                    }
                }
            }
        }  

        $response->success = true;
        return $response;
    }

    public function movimientos()
    {
        // Actualizar facturap
        if($this->plancuentas_tipo && $this->plancuentas_tipo == 'P')
        {
            $result = $this->storeFacturap();
            if($result != 'OK') {
                return $result;
            }
        }else if($this->plancuentas_tipo && $this->plancuentas_tipo == 'I') {

            $result = $this->storeInventario();
            if($result != 'OK') {
                return $result;
            }
        }else if($this->plancuentas_tipo && $this->plancuentas_tipo == 'C') {

            $result = $this->storeFactura();
            if($result != 'OK') {
                return $result;
            }
        }
        return 'OK';
    }

    public function storeFacturap()
    {
        // Recuperar movimientos
        $movementsfp = AsientoMovimiento::where('movimiento_asiento2', $this->id)->where('movimiento_tipo', 'FP')->get();
        if ($movementsfp->count() <= 0) {
            return "No es posible recuperar movimientos de inventario para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }

        foreach ($movementsfp as $movefp)
        {
            $facturap = Facturap::where('facturap1_factura', $movefp->movimiento_facturap)->where('facturap1_tercero', $this->asiento2_beneficiario)->first();
            // Nuevo registro en facturap
            if($movefp->movimiento_nuevo == true) {
                if($facturap instanceof Facturap){
                    return "Ya fue generada la factura proveedor número {$facturap->facturap1_factura} para el tercero {$this->tercero_nit}, por favor verifique la información del asiento o consulte al administrador.";
                }

                // Facturap
                $facturap = new Facturap;
                $facturap->facturap1_tercero = $this->asiento2_beneficiario;
                $facturap->facturap1_factura = $movefp->movimiento_facturap;
                $facturap->facturap1_sucursal = $movefp->movimiento_sucursal;
                $facturap->facturap1_fecha = $movefp->movimiento_fecha;
                $facturap->facturap1_cuotas = $movefp->movimiento_item;
                $facturap->facturap1_periodicidad = $movefp->movimiento_periodicidad;
                $facturap->facturap1_observaciones = $movefp->movimiento_observaciones;
                $facturap->facturap1_usuario_elaboro = Auth::user()->id;
                $facturap->facturap1_fecha_elaboro = date('Y-m-d H:m:s');
                $facturap->save();

                // Facturap2 (Cuotas)
                $result = $facturap->storeCuotas($movefp->movimiento_valor);
                if(!$result->success) {
                    return $result->error;
                }

            }else{
                // Actualizar cuota para facturap
                if(!$facturap instanceof Facturap) {
                    return "No es posible recuperar información factura proveedor para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
                }

                $facturap2 = Facturap2::find($movefp->movimiento_item);
                if(!$facturap2 instanceof Facturap2){
                    return "No es posible recuperar información cuota {$movefp->movimiento_item}, por favor verifique la información del asiento o consulte al administrador.";
                }

                if($this->asiento2_naturaleza == 'C') {
                    // Credito cuota
                    $facturap2->facturap2_saldo = ( $facturap2->facturap2_saldo + $movefp->movimiento_valor );

                }else if($this->asiento2_naturaleza == 'D') {

                    // Debito cuota
                    $facturap2->facturap2_saldo = ( $facturap2->facturap2_saldo - $movefp->movimiento_valor );
                }else{
                    return "No es posible recuperar naturaleza para la afectación de la cuota {$movefp->movimiento_item}, por favor verifique la información del asiento o consulte al administrador.";
                }
                $facturap2->save();
            }
        }

        return 'OK';
    }

    public function storeInventario()
    {
        // Recuperar movimientos
        $movements = AsientoMovimiento::where('movimiento_asiento2', $this->id)->whereIn('movimiento_tipo', ['IP', 'IH'])->get();
        if ($movements->count() <= 0) {
            return "No es posible recuperar movimientos de inventario para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }

        $movfather = $movements->where('movimiento_tipo', 'IP')->first();
        if(!$movfather instanceof AsientoMovimiento) {
            return "No es posible recuperar movimiento padre de inventario para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }

        // Validar producto
        $producto = Producto::find($movfather->movimiento_producto);
        if(!$producto instanceof Producto) {
            return "No es posible recuperar producto para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }

        // Valor
        $costo = 0;
        // Actualizar prodbode producto padre (Maneja unidades o Producto metrado)
        if($producto->producto_unidades == true || ($producto->producto_unidades == true && $producto->producto_metrado == true))
        {
            if($this->asiento2_naturaleza == 'D') {
                // Entrada
                $costo = $this->asiento2_debito / $movfather->movimiento_valor;
                $costopromedio = $producto->costopromedio($costo, $movfather->movimiento_valor);

                // Actualizar prodbode
                $result = Prodbode::actualizar($producto, $movfather->movimiento_sucursal, 'E', $movfather->movimiento_valor);
                if($result != 'OK') {
                    return $result;
                }

                // Insertar movimientos inventario
                $inventario = Inventario::movimiento($producto, $movfather->movimiento_sucursal, 'AS', $movfather->movimiento_valor, 0, $costo, $costopromedio);
                if(!$inventario instanceof Inventario) {
                    return $inventario;
                }
            }else{
                // Registrar salida padre productos no metrados
                if(!$producto->producto_metrado)
                {
                    // Validando valor del costo salida
                    $costo = Inventario::primerasEnSalir($producto, $movfather->movimiento_sucursal, $movfather->movimiento_valor, true);
                    if(!is_numeric($costo)) {
                        return $costo;
                    }
                    if($costo != $this->asiento2_credito){
                        return "No es posible realizar salida de inventario para el producto {$producto->producto_codigo}, el costo de la salida a cambiado, por favor verifique la información del asiento o consulte al administrador.";
                    }

                    // Actualizar prodbode
                    $result = Prodbode::actualizar($producto, $movfather->movimiento_sucursal, 'S', $movfather->movimiento_valor);
                    if($result != 'OK') {
                        return $result;
                    }

                    // Insertar movimientos inventario
                    $inventario = Inventario::movimiento($producto, $movfather->movimiento_sucursal, 'AS', 0, $movfather->movimiento_valor, $costo, 0);
                    if(!$inventario instanceof Inventario) {
                        return $inventario;
                    }
                }
            }
        }

        // Validar movimientos (Maneja serie o Producto metrado)
        if ($producto->producto_metrado == true || $producto->producto_serie == true) {
            $movchildren = $movements->where('movimiento_tipo', 'IH');
            if($movchildren->count() != $movfather->movimiento_valor) {
                return "No es posible recuperar movimientos detalle de inventario para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
            }
        }

        if ($producto->producto_metrado == true) {
            // Producto metrado
            // Debito
            if($this->asiento2_naturaleza == 'D') {

                // Consecutivo item
                $item = DB::table('koi_prodboderollo')->where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $movfather->movimiento_sucursal)->max('prodboderollo_item');
                foreach ($movchildren as $children) {
                    // Aumentar item
                    $item++;

                    // Prodbode rollo
                    $costometro = $costo / $children->movimiento_valor;
                    $result = ProdbodeRollo::actualizar($producto, $movfather->movimiento_sucursal, 'E', $item, $children->movimiento_valor, $costometro);
                    if($result != 'OK') {
                        return $result;
                    }

                    // Movimiento rollo
                    $inventariorollo = InventarioRollo::movimiento($inventario, $item, $costo, $children->movimiento_valor);
                    if(!$inventariorollo instanceof InventarioRollo) {
                        return $inventariorollo;
                    }
                }
            // Credito
            }else{
                // Calcular rollos terminados para registrar unidades de salida
                $usalida = 0;
                foreach ($movchildren as $children) {
                    // Recuperar prodboderollo
                    $prodboderollo = ProdbodeRollo::where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $movfather->movimiento_sucursal)->where('prodboderollo_item', $children->movimiento_item)->first();
                    if(!$prodboderollo instanceof ProdbodeRollo) {
                        return "No es posible recuperar prodbode para item rollo, producto {$producto->producto_codigo}, sucursal {$movfather->movimiento_sucursal} y item {$children->movimiento_item}, por favor verifique la información del asiento o consulte al administrador.";
                    }

                    // Si se termina rollo restar una unidad al padre
                    if(($prodboderollo->prodboderollo_saldo - $children->movimiento_valor) == 0 ) {
                        $usalida++;
                    }
                }

                // Insertar movimientos padre (Salida siempre 0), si se termina rollo se registra salida de 1 item
                $inventario = Inventario::movimiento($producto, $movfather->movimiento_sucursal, 'AS', 0, $usalida, $this->asiento2_credito, 0);
                if(!$inventario instanceof Inventario) {
                    return $inventario;
                }

                // Si se termina algun rollo actualizamos prodbode para padre
                if($usalida > 0) {
                    // Actualizar prodbode
                    $result = Prodbode::actualizar($producto, $movfather->movimiento_sucursal, 'S', $usalida);
                    if($result != 'OK') {
                        return $result;
                    }
                }

                // Registrar detalle rollos
                foreach ($movchildren as $children) {
                    // Recuperar prodboderollo
                    $prodboderollo = ProdbodeRollo::where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $movfather->movimiento_sucursal)->where('prodboderollo_item', $children->movimiento_item)->first();
                    if(!$prodboderollo instanceof ProdbodeRollo) {
                        return "No es posible recuperar prodbode para item rollo, producto {$producto->producto_codigo}, sucursal {$movfather->movimiento_sucursal} y item {$children->movimiento_item}, por favor verifique la información del asiento o consulte al administrador.";
                    }
                    // Costo salida rollo
                    $costo = $prodboderollo->prodboderollo_costo * $children->movimiento_valor;

                    // Prodbode rollo
                    $result = ProdbodeRollo::actualizar($producto, $movfather->movimiento_sucursal, 'S', $children->movimiento_item, $children->movimiento_valor);
                    if($result != 'OK') {
                        return $result;
                    }

                    // Movimiento rollo
                    $inventariorollo = InventarioRollo::movimiento($inventario, $children->movimiento_item, $costo, 0, $children->movimiento_valor);
                    if(!$inventariorollo instanceof InventarioRollo) {
                        return $inventariorollo;
                    }
                }
            }

        } elseif ($producto->producto_serie == true) {
            // Producto serie
            // Debito
            if($this->asiento2_naturaleza == 'D') {
                foreach ($movchildren as $children) {

                    // Validar serie
                    $serie = Producto::where('producto_codigo', $children->movimiento_serie)->first();
                    if(!$serie instanceof Producto) {
                        // Crear producto
                        $serie = $producto->serie($children->movimiento_serie);
                        if(!$serie instanceof Producto) {
                            return $serie;
                        }
                    }

                    // Actualizar prodbode
                    $result = Prodbode::actualizar($serie, $movfather->movimiento_sucursal, 'E', 1);
                    if($result != 'OK') {
                        return $result;
                    }

                    // Insertar movimientos inventario (Al ingresar serie costo_promedio es igual a costo de la entrada)
                    $inventario = Inventario::movimiento($serie, $movfather->movimiento_sucursal, 'AS', 1, 0, $costo, $costo);
                    if(!$inventario instanceof Inventario) {
                        return $inventario;
                    }
                }
            }
        }

        return "OK";
    }

    public function storeFactura(){
        // Recuperar movimientos
        $movements = AsientoMovimiento::where('movimiento_asiento2', $this->id)->whereIn('movimiento_tipo', ['F', 'FH'])->get();
        if ($movements->count() <= 0) {
            return "No es posible recuperar movimientos de factura para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }

        $movfather = $movements->where('movimiento_tipo', 'F')->first();
        if(!$movfather instanceof AsientoMovimiento) {
            return "No es posible recuperar movimiento padre de factura para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }

        // Recuperar hijos de factura FH
        $movchildren = $movements->where('movimiento_tipo', 'FH');
        if($movchildren->count() <= 0) {
            return "No es posible recuperar movimientos detalle de factura para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }

        // Nuevo registro en factura
        if($movfather->movimiento_nuevo == true) {

            // Recuperar Tercero
            $tercero = Tercero::where('tercero_nit', $this->tercero_nit)->first();
            if(!$tercero instanceof Tercero){
                return "No es posible recuperar el tercero, para almacenar la factura, por favor verifique la informacion o consulte al administrador.";
            }

            // Consecutivo Punto de venta
            $puntoventa = PuntoVenta::findOrFail($movfather->movimiento_puntoventa);
            if(!$puntoventa instanceof PuntoVenta){
                return "No es posible recuperar el punto de venta, por favor verifique la informacion o consulte al administrador.";
            }
            $consecutive = $puntoventa->puntoventa_numero + 1;

            // Factura
            $factura = new Factura1;
            $factura->factura1_fecha = $movfather->movimiento_fecha;
            $factura->factura1_fecha_vencimiento = $movfather->movimiento_vencimiento;
            $factura->factura1_puntoventa = $movfather->movimiento_puntoventa;
            $factura->factura1_orden = $movfather->movimiento_ordenp;
            $factura->factura1_valor = $movfather->movimiento_valor;
            $factura->factura1_cuotas = $movfather->movimiento_item;
            $factura->factura1_tercero = $tercero->id;
            $factura->save();

            // Factura2 (items)
            $result = $factura->storeFactura2($movchildren, $movfather->movimiento_ordenp);
            if(!$result->success) {
                return $result->error;
            }

            // Factura4 (cuotas)
            $resultFactu4 = $factura->storeFactura4($factura);
            if(!$resultFactu4->success) {
                return $resultFactu4->error;
            }

            // Update consecutive puntoventa_numero
            $puntoventa->puntoventa_numero = $consecutive;
            $puntoventa->save();
        }else{
            // Recuperar factura1 -> Padre
            $factura = Factura1::find($movfather->movimiento_factura);
            if(!$factura instanceof Factura1){
                return "No es posible recuperar la factura, por favor verifique la informacion o consulte con el administrador.";
            }

            // Actualizar factura4 
            $result = $factura->actualizarFactura4($movchildren, $this->asiento2_naturaleza);
            if(!$result->success){
                return $result->error;
            }
        }
        return 'OK';
    }
}
