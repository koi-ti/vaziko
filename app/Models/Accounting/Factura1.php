<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use App\Models\Production\Ordenp2;

class Factura1 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_factura1';

    public $timestamps = false;

    public function storeFactura2($children)
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

            // Recuperar ordenp2
            $ordenp2 = Ordenp2::getOrdenpf2($item->movimiento_ordenp2);
            if ($item->movimiento_item > $ordenp2->orden2_cantidad){
            	$response->error = "La cantidad no puede superar al saldo que esta registrado, por favor verifique la información del asiento o consulte al administrador.";
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
}
