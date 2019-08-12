<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal;
use DB;

class Prodbode extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_prodbode';

    public $timestamps = false;

    public static function prodbode (Producto $producto, $sucursal) {
        $query = Prodbode::query();
        $query->select('koi_prodbode.*', DB::raw('(prodbode_cantidad - prodbode_reservada) as disponibles'));
        $query->where('prodbode_producto', $producto->id);
        $query->where('prodbode_sucursal', $sucursal);
        return $query->first();
    }

    public static function actualizar (Producto $producto, $sucursal, $tipo, $unidades) {
        // Validar producto
        $sucursal = Sucursal::find($sucursal);
        if (!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal prodbode, por favor verifique la información o consulte al administrador.";
        }

        // Validar unidades
        if (!is_numeric($unidades) || $unidades <= 0) {
            return "No es posible recuperar unidades prodbode, por favor verifique la información o consulte al administrador.";
        }

        // Recuperar prodbode
    	$prodbode = Prodbode::where('prodbode_producto', $producto->id)->where('prodbode_sucursal', $sucursal->id)->first();
		if (!$prodbode instanceof Prodbode) {
        	$prodbode = new Prodbode;
	        $prodbode->prodbode_producto = $producto->id;
	        $prodbode->prodbode_sucursal = $sucursal->id;
    	}

    	switch ($tipo) {
    		case 'E':
		        $prodbode->prodbode_cantidad = ($prodbode->prodbode_cantidad + $unidades);
			break;

			case 'S':
                // Validar disponibles
                if ($unidades > $prodbode->prodbode_cantidad) {
                    return "No existen suficientes unidades para salida producto {$producto->producto_codigo}, disponibles {$prodbode->prodbode_cantidad}, salida $unidades, por favor verifique la información o consulte al administrador.";
                }
		        $prodbode->prodbode_cantidad = ($prodbode->prodbode_cantidad - $unidades);
			break;

    		default:
    			return "No es posible recuperar tipo movimiento prodbode, por favor verifique la información o consulte al administrador.";
			break;
    	}
		$prodbode->save();

        return 'OK';
    }
}
