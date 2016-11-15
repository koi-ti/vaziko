<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventarioRollo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_inventariorollo';

    public $timestamps = false;

    public static function movimiento(Inventario $inventario, $item, $costo = 0, $mentrada = 0, $msalida = 0)
    {
    	// Validar item
        if(!is_numeric($item) || $item <= 0){
            return "No es posible recuperar item movimiento rollo, por favor verifique la información o consulte al administrador.";
        }

        // Validar unidades
        if($mentrada <= 0 && $msalida <= 0){
            return "No es posible recuperar metros movimiento rollo, por favor verifique la información o consulte al administrador.";
        }

        $inventariorollo = new InventarioRollo;
        $inventariorollo->inventariorollo_inventario = $inventario->id;
        $inventariorollo->inventariorollo_item = $item;
        $inventariorollo->inventariorollo_metros_entrada = $mentrada;
        $inventariorollo->inventariorollo_metros_salida = $msalida;
        $inventariorollo->inventariorollo_costo = $costo;
        $inventariorollo->save();

        return $inventariorollo;
    }
}
