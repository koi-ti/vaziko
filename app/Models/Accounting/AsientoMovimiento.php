<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use App\Models\Inventory\Producto;

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
        if(!isset($data['Tipo']) || trim($data['Tipo']) == '') {
            $response->error = "Tipo es obligatorio para generar movimiento, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Movimientos factura proveedor FP
        if( $data['Tipo'] == 'FP')
        {
            $result = $this->storeFacturap($asiento2, $data);
            if($result != 'OK') {
                $response->error = $result;
                return $response;
            }

        // Movimientos inventario padre IP, inventario hijos IH
        }else if( in_array($data['Tipo'], ['IP', 'IH']) ) {

            $result = $this->storeInventario($asiento2, $data);
            if($result != 'OK') {
                $response->error = $result;
                return $response;
            }

        // Movimientos factura padre F, factura hijos FH
        }else if( in_array($data['Tipo'], ['F', 'FH'])){
            $result = $this->storeFactura($asiento2, $data);
            if($result != 'OK') {
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

    public function storeFacturap(Asiento2 $asiento2, Array $data)
    {
        // Validar valor
        if(!isset($data['Valor']) || !is_numeric($data['Valor']) || $data['Valor'] <= 0) {
            return "Valor no puede ser menor o igual a 0.";
        }

        // Validar factura
        if(!isset($data['Factura']) || trim($data['Factura']) == '') {
            return "Factura es obligatoria.";
        }

        // Validar factura
        if(!isset($data['Naturaleza']) || trim($data['Naturaleza']) == '') {
            return "Naturaleza es obligatoria.";
        }

        // Validar naturaleza
        if($data['Naturaleza'] == 'D') {
            $facturap = Facturap::where('facturap1_factura', $data['Factura'])->where('facturap1_tercero', $asiento2->asiento2_beneficiario)->first();
            if(!$facturap instanceof Facturap) {
                return "Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.";
            }
        }

        // Validar cuotas
        if(!isset($data['Cuotas']) || !is_numeric($data['Cuotas']) || $data['Cuotas'] <= 0) {
            return "Cuotas no pueden ser menor o igual a 0.";
        }

        if($data['Nuevo'] == true)
        {
            // Validar sucursal
            if(!isset($data['Sucursal']) || !is_numeric($data['Sucursal']) || $data['Sucursal'] <= 0) {
                return "Sucursal es obligatoria.";
            }

            // Validar fecha
            if(!isset($data['Fecha']) || trim($data['Fecha']) == '') {
                return "Fecha es obligatoria.";
            }

            // Validar periodo
            if(!isset($data['Periodicidad']) || !is_numeric($data['Periodicidad']) || $data['Periodicidad'] <= 0) {
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

    public function storeInventario(Asiento2 $asiento2, Array $data)
    {
        switch ($data['Tipo']) {
            // Inventario padre
            case 'IP':
                // Validar valor
                if(!isset($data['Valor']) || !is_numeric($data['Valor']) || $data['Valor'] <= 0) {
                    return "Valor no puede ser menor o igual a 0.";
                }

                // Validar sucursal
                if(!isset($data['Sucursal']) || !is_numeric($data['Sucursal']) || $data['Sucursal'] <= 0) {
                    return "Sucursal es obligatoria.";
                }

                // Validar naturaleza
                if(!isset($data['Naturaleza']) || trim($data['Naturaleza']) == '') {
                    return "Naturaleza es obligatoria.";
                }

                // Validar producto
                if(!isset($data['Producto']) || trim($data['Producto']) == '') {
                    return "Producto es obligatoria.";
                }

                $this->movimiento_valor = $data['Valor'];
                $this->movimiento_sucursal = $data['Sucursal'];
                $this->movimiento_producto = $data['Producto'];
            break;

            // Inventario hijos
            case 'IH':
                // Validar producto
                if(!isset($data['Item']) || trim($data['Item']) == '') {
                    return "Item es obligatorio.";
                }

                if(isset($data['Serie']) && trim($data['Serie']) != '') {
                    $this->movimiento_serie = $data['Serie'];
                }

                if(isset($data['Valor']) && trim($data['Valor']) != '') {
                    $this->movimiento_valor = $data['Valor'];
                }

                $this->movimiento_item = $data['Item'];
            break;
        }
        return 'OK';
    }

    public function storeFactura(Asiento2 $asiento2, Array $data)
    {
        if($data['Nuevo'] == true) 
        {
            switch ($data['Tipo']) {
                // Factura padre
                case 'F':
                    // Validar valor
                    if(!isset($data['Valor']) || !is_numeric($data['Valor']) || $data['Valor'] <= 0) {
                        return "Valor no puede ser menor o igual a 0.";
                    }

                    // Validar naturaleza
                    if(!isset($data['Naturaleza']) || trim($data['Naturaleza']) == '') {
                        return "Naturaleza es obligatoria.";
                    }

                    // Validar fecha
                    if(!isset($data['Fecha']) || trim($data['Fecha']) == '') {
                        return "Fecha es obligatoria.";
                    }

                    // Validar Ordenp
                    if(!isset($data['Orden']) || trim($data['Orden']) == '') {
                        return "Orden es obligatoria.";
                    }

                    // Validar vencimiento
                    if(!isset($data['Vencimiento']) || trim($data['Vencimiento']) == '') {
                        return "Vencimiento es obligatoria.";
                    }

                $this->movimiento_fecha = $data['Fecha'];
                $this->movimiento_vencimiento = $data['Vencimiento'];
                $this->movimiento_puntoventa = $data['PuntoVenta'];
                $this->movimiento_ordenp = $data['Orden'];
                $this->movimiento_valor = $data['Valor'];
                break;

                // Factura hijo
                case 'FH':
                    // Validar ordenp2
                    if(isset($data['Orden']) || trim($data['Orden']) != '') {
                        $this->movimiento_ordenp2 = $data['Orden'];
                    }

                    if(isset($data['Cantidad']) && trim($data['Cantidad']) != '') {
                        $this->movimiento_item = $data['Cantidad'];
                    }
                break;
            }

            $this->movimiento_nuevo = $data['Nuevo'];
            return 'OK';
        }
    }
}