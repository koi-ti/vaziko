<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use App\Models\Production\Ordenp2, App\Models\Accounting\Asiento2;

class Factura1 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_factura1';

    public $timestamps = false;

    public function storeFactura2($children, $fatherOrdenp)
    {
        $response = new \stdClass();
        $response->success = false;

        foreach ($children as $item) {
        	if ($item->movimiento_item < 0) {
            	$response->error = "La cantidad del item no puede ser menor a 0, por favor verifique la información del asiento o consulte al administrador.";
            	return $response;
            }

            // Insertar factura
            $factura2 = new Factura2;
            $factura2->factura2_orden2 = $item->movimiento_ordenp2;

            // Recuperar Asiento2
            $detalle = Asiento2::find($item->movimiento_asiento2)->select('koi_asiento2.*','plancuentas_cuenta', 'tercero_nit')->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id')->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id')->first();

            // Recuperar ordenp2
            $ordenp2 = Ordenp2::getOrdenpf2($item->movimiento_ordenp2);
            if ($item->movimiento_item > $ordenp2->orden2_cantidad){
            	$response->error = "El saldo ingresado en la cuenta {$detalle->plancuentas_cuenta} del cliente {$detalle->tercero_nit} es de {$item->movimiento_item} y la cantidad disponible es {$ordenp2->orden2_cantidad}, por favor verifique la información o consulte al administrador.";
            	return $response;	
            }

        	$factura2->factura2_cantidad = $item->movimiento_item;
            $factura2->save();

            $ordenp2->orden2_facturado = $ordenp2->orden2_facturado + $item->movimiento_item;
			$ordenp2->save();
        }


        $response->success = true;
        return $response;
    }

    public function storeFactura4(Factura1 $factura)
    {
        $response = new \stdClass();
        $response->success = false;

        if ($factura->factura1_cuotas > 0) {
            $valor = $factura->factura1_valor / $factura->factura1_cuotas;
            $fecha = $factura->factura1_fecha_vencimiento; 
            for ($i=1; $i <= $factura->factura1_cuotas; $i++) {
                $factura4 = new Factura4;
                $factura4->factura4_factura1 = $factura->id;
                $factura4->factura4_cuota = $i;
                $factura4->factura4_valor = $valor;
                $factura4->factura4_saldo = $valor;
                $factura4->factura4_vencimiento = $fecha;
                $fechavencimiento = date('Y-m-d',strtotime('+1 months', strtotime($fecha)));
                $fecha = $fechavencimiento;
                $factura4->save();
            }
        }
        
        $response->success = true;
        return $response;
    }

    public function actualizarFactura4($movchildren, $naturaleza){
        $response = new \stdClass();
        $response->success = false;

        foreach ($movchildren as $item) {
            $factura = Factura4::find($item->movimiento_factura4);
            if($naturaleza == 'D'){
                $factura->factura4_saldo = $factura->factura4_saldo + $item->movimiento_valor;
            }else{
                $factura->factura4_saldo = $factura->factura4_saldo - $item->movimiento_valor;
            }
            $factura->save();
        }

        $response->success = true;
        return $response;
    }
}
