<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use App\Models\Inventory\Producto;
use App\Models\Treasury\Facturap;
use App\Models\Receivable\Factura1;
use DB;

class AsientoMovimiento extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_asientomovimiento';

    public $timestamps = false;

    public function store(Asiento2 $asiento2, Array $data)
    {
        $response = new \stdClass();
        $response->success = false;

        // Validar factura
        if (!isset($data['Tipo']) || trim($data['Tipo']) == '') {
            $response->error = "Tipo es obligatorio para generar movimiento, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Movimientos factura proveedor FP
        if ( $data['Tipo'] == 'FP') {
            $result = $this->storeFacturap($asiento2, $data);
            if ($result != 'OK') {
                $response->error = $result;
                return $response;
            }

        // Movimientos inventario padre IP, inventario hijos IH
        } else if (in_array($data['Tipo'], ['IP', 'IH'])) {

            $result = $this->storeInventario($asiento2, $data);
            if ($result != 'OK') {
                $response->error = $result;
                return $response;
            }

        // Movimientos factura padre F, factura hijos FH
        } else if (in_array($data['Tipo'], ['F', 'FH'])) {
            $result = $this->storeFactura($asiento2, $data);
            if ($result != 'OK') {
                $response->error = $result;
                return $response;
            }
        }

        $this->movimiento_tipo = $data['Tipo'];
        $this->movimiento_asiento2 = $asiento2->id;
        $this->save();

        $response->success = true;
        return $response;
    }

    public function storeFacturap(Asiento2 $asiento2, Array $data) {
        // Validar valor
        if (!isset($data['Valor']) || !is_numeric($data['Valor']) || $data['Valor'] <= 0) {
            return "Valor no puede ser menor o igual a 0.";
        }

        // Validar factura
        if (!isset($data['Factura']) || trim($data['Factura']) == '') {
            return "Factura es obligatoria.";
        }

        // Validar factura
        if (!isset($data['Naturaleza']) || trim($data['Naturaleza']) == '') {
            return "Naturaleza es obligatoria.";
        }

        // Validar naturaleza
        if ($data['Naturaleza'] == 'D') {
            $facturap = Facturap::where('facturap1_factura', $data['Factura'])->where('facturap1_tercero', $asiento2->asiento2_beneficiario)->first();
            if (!$facturap instanceof Facturap) {
                return "Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.";
            }
        }

        // Validar cuotas
        if (!isset($data['Cuotas']) || !is_numeric($data['Cuotas']) || $data['Cuotas'] <= 0) {
            return "Cuotas no pueden ser menor o igual a 0.";
        }

        if ($data['Nuevo'] == true) {
            // Validar sucursal
            if (!isset($data['Sucursal']) || !is_numeric($data['Sucursal']) || $data['Sucursal'] <= 0) {
                return "Sucursal es obligatoria.";
            }

            // Validar fecha
            if (!isset($data['Fecha']) || trim($data['Fecha']) == '') {
                return "Fecha es obligatoria.";
            }

            // Validar periodo
            if (!isset($data['Periodicidad']) || !is_numeric($data['Periodicidad']) || $data['Periodicidad'] <= 0) {
                return "Periodicidad (días) para cuotas no puede ser menor o igual a 0.";
            }

            $this->movimiento_sucursal = $data['Sucursal'];
            $this->movimiento_fecha = $data['Fecha'];
            $this->movimiento_periodicidad = $data['Periodicidad'];
        }

        $this->movimiento_facturap = $data['Factura'];
        $this->movimiento_nuevo = $data['Nuevo'];
        $this->movimiento_valor = $data['Valor'];
        $this->movimiento_item = $data['Cuotas'];
        $this->movimiento_observaciones = isset($data['Detalle']) ? $data['Detalle']: '';

        return 'OK';
    }

    public function storeInventario(Asiento2 $asiento2, Array $data) {
        switch ($data['Tipo']) {
            // Inventario padre
            case 'IP':
                // Validar valor
                if (!isset($data['Valor']) || !is_numeric($data['Valor']) || $data['Valor'] <= 0) {
                    return "Valor no puede ser menor o igual a 0.";
                }

                // Validar sucursal
                if (!isset($data['Sucursal']) || !is_numeric($data['Sucursal']) || $data['Sucursal'] <= 0) {
                    return "Sucursal es obligatoria.";
                }

                // Validar naturaleza
                if (!isset($data['Naturaleza']) || trim($data['Naturaleza']) == '') {
                    return "Naturaleza es obligatoria.";
                }

                // Validar producto
                if (!isset($data['Producto']) || trim($data['Producto']) == '') {
                    return "Producto es obligatoria.";
                }

                if ($data['Naturaleza'] == 'C') {
                    $this->movimiento_serie = $data['Serie'];
                }

                $this->movimiento_valor = $data['Valor'];
                $this->movimiento_sucursal = $data['Sucursal'];
                $this->movimiento_producto = $data['Producto'];
            break;

            // Inventario hijos
            case 'IH':
                // Validar producto
                if (!isset($data['Item']) || trim($data['Item']) == '') {
                    return "Item es obligatorio.";
                }

                if (isset($data['Serie']) && trim($data['Serie']) != '') {
                    $this->movimiento_serie = $data['Serie'];
                }

                if (isset($data['Valor']) && trim($data['Valor']) != '') {
                    $this->movimiento_valor = $data['Valor'];
                }

                $this->movimiento_item = $data['Item'];
            break;
        }
        return 'OK';
    }

    public function storeFactura(Asiento2 $asiento2, Array $data) {
        switch ($data['Tipo']) {
            // Factura padre
            case 'F':
                // Validar factura
                if (!isset($data['Factura']) || trim($data['Factura']) == '') {
                    return "Factura es obligatoria.";
                }

                $this->movimiento_factura = $data['Factura'];
            break;

             // Factura hijo
            case 'FH':
                // Validar factura -> child
                if (isset($data['FacturaChild']) && trim($data['FacturaChild']) != '') {
                    $this->movimiento_factura4 = $data['FacturaChild'];
                }

                if (isset($data['Valor']) && trim($data['Valor']) != '') {
                    $this->movimiento_valor = $data['Valor'];
                }
            break;
        }
        $this->movimiento_nuevo = $data['Nuevo'];
        return 'OK';
    }

    public static function getMovements ($asiento2) {
        $query = self::query();
        $query->select('koi_asientomovimiento.*', 'koi_asientomovimiento.id as movimiento_id', 'producto_codigo', 'producto_nombre', 'koi_producto.id as producto_id', 'koi_factura1.*', 'sucursal_nombre', 'puntoventa_nombre', 'puntoventa_prefijo', 'facturap2_saldo', 'factura4_cuota', 'factura4_saldo', 'factura4_factura1', 'facturap2_cuota', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N'
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
            if ($item->movimiento_tipo == 'F') {
                $data['type'] = $item->movimiento_tipo;
                $data['father'] = [
                    'movimiento_id' => $item->movimiento_id,
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
            if ($item->movimiento_tipo == 'FH') {
                $data['childrens'][] = [
                    'movimiento_id' => $item->movimiento_id,
                    'factura4_cuota' => $item->factura4_cuota,
                    'factura4_saldo' => $item->factura4_saldo,
                    'movimiento_factura4' => $item->movimiento_factura4,
                    'movimiento_valor' => $item->movimiento_valor
                ];
            }

            if ($item->movimiento_tipo == 'FP') {
                $data['type'] = $item->movimiento_tipo;
                $data['father'][] = [
                    'movimiento_id' => $item->movimiento_id,
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

            if ($item->movimiento_tipo == 'IP') {
                $data['type'] = $item->movimiento_tipo;
                $data['father'] = [
                    'movimiento_id' => $item->movimiento_id,
                    'producto_codigo' => $item->producto_codigo,
                    'producto_nombre' => $item->producto_nombre,
                    'sucursal_nombre' => $item->sucursal_nombre,
                    'movimiento_valor' => $item->movimiento_valor
                ];
            }
            if ($item->movimiento_tipo == 'IH') {
                $data['childrens'][] = [
                    'movimiento_id' => $item->movimiento_id,
                    'movimiento_serie' => $item->movimiento_serie,
                    'movimiento_item' => $item->movimiento_item,
                    'movimiento_valor' => $item->movimiento_valor,
                ];
            }
        }
        return $data;
    }
}
