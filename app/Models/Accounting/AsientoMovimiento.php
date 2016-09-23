<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

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

        // Insertar movimiento
    	switch ($data['Tipo']) {
            // Case Movimientos factura proveedor
    		case 'FP':
                // Validar valor
                if(!is_numeric($data['Valor']) || $data['Valor'] <= 0) {
                    $response->error = "Valor no puede ser menor o igual a 0.";
                    return $response;
                }

    			// Validar factura
                if(!isset($data['Factura']) || trim($data['Factura']) == '') {
                    $response->error = "Factura es obligatoria.";
                    return $response;
                }

                // Validar factura
                if(!isset($data['Naturaleza']) || trim($data['Naturaleza']) == '') {
                    $response->error = "Naturaleza es obligatoria.";
                    return $response;
                }

                // Validar naturaleza
                if($data['Naturaleza'] == 'D') {
                    $facturap = Facturap::where('facturap1_factura', $data['Factura'])->where('facturap1_tercero', $asiento2->asiento2_beneficiario)->first();
                    if(!$facturap instanceof Facturap) {
                        $response->error = "Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.";
                        return $response;
                    }
                }

                // Validar cuotas
                if(!isset($data['Cuotas']) || !is_numeric($data['Cuotas']) || $data['Cuotas'] <= 0) {
                    $response->error = "Cuotas no pueden ser menor o igual a 0.";
                    return $response;
                }

                if($data['Nuevo'] == true)
                {
    		        // Validar sucursal
                    if(!isset($data['Sucursal']) || !is_numeric($data['Sucursal']) || $data['Sucursal'] <= 0) {
                        $response->error = "Sucursal es obligatoria.";
                        return $response;
                    }

                    // Validar fecha
                    if(!isset($data['Fecha']) || trim($data['Fecha']) == '') {
                        $response->error = "Fecha es obligatoria.";
                        return $response;
                    }

    		        // Validar periodo
    		        if(!isset($data['Periodicidad']) || !is_numeric($data['Periodicidad']) || $data['Periodicidad'] <= 0) {
    		            $response->error = "Periodicidad (días) para cuotas no puede ser menor o igual a 0.";
    		            return $response;
    		        }

                    $this->movimiento_sucursal = $data['Sucursal'];
                    $this->movimiento_fecha = $data['Fecha'];
                    $this->movimiento_periodicidad = $data['Periodicidad'];
                }

                $this->movimiento_facturap = $data['Factura'];
                $this->movimiento_nuevo = $data['Nuevo'];
                $this->movimiento_valor = $data['Valor'];
                $this->movimiento_cuota = $data['Cuotas'];
	            $this->movimiento_observaciones = isset($data['Detalle']) ? $data['Detalle']: '';
			break;
    	}

        $this->movimiento_tipo = $data['Tipo'];
        $this->movimiento_asiento2 = $asiento2->id;
        $this->save();

        $response->success = true;
        return $response;
    }
}
