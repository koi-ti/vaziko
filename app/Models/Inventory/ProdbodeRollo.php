<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal;

class ProdbodeRollo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_prodboderollo';

    public $timestamps = false;

    public static function actualizar (Producto $producto, $sucursal, $tipo, $item, $metros = 0, $costo = 0) {
        // Validar sucursal
        $sucursal = Sucursal::find($sucursal);
        if (!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal prodbode rollo, por favor verifique la información o consulte al administrador.";
        }

    	// Validar item
        if (!is_numeric($item) || $item <= 0) {
            return "No es posible recuperar item prodbode rollo, por favor verifique la información o consulte al administrador.";
        }

        // Validar metros
        if ($metros <= 0) {
            return "No es posible recuperar metros prodbode rollo, por favor verifique la información o consulte al administrador.";
        }

        // Recuperar prodbode rollo
    	$prodboderollo = ProdbodeRollo::where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $sucursal->id)->where('prodboderollo_item', $item)->first();
		if (!$prodboderollo instanceof ProdbodeRollo) {
        	$prodboderollo = new ProdbodeRollo;
	        $prodboderollo->prodboderollo_producto = $producto->id;
	        $prodboderollo->prodboderollo_sucursal = $sucursal->id;
	        $prodboderollo->prodboderollo_item = $item;
	        $prodboderollo->prodboderollo_metros = $metros;
            $prodboderollo->prodboderollo_saldo = $metros;
	        $prodboderollo->prodboderollo_costo = $costo;
    	} else {
	    	switch ($tipo) {
	    		case 'E':
			        $prodboderollo->prodboderollo_saldo = ($prodboderollo->prodboderollo_saldo + $metros);
				break;

				case 'S':
					// Validar disponibles
                    if ($metros > $prodboderollo->prodboderollo_saldo) {
                        return "No existen suficientes unidades para salida item rollo producto {$producto->producto_codigo}, item {$item}, por favor verifique la información o consulte al administrador.";
                    }
			        $prodboderollo->prodboderollo_saldo = ($prodboderollo->prodboderollo_saldo - $metros);
                break;

	    		default:
	    			return "No es posible recuperar tipo movimiento prodbode rollo, por favor verifique la información o consulte al administrador.";
				break;
	    	}
	    }
		$prodboderollo->save();
        return 'OK';
    }
}
