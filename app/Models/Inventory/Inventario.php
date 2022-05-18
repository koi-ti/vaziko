<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal;

class Inventario extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_inventario';

    public $timestamps = false;

    public static function movimiento (Producto $producto, $sucursal, $documento, $uentrada = 0, $usalida = 0, $costo = 0, $costopromedio = 0) {
        // Validar producto
        $sucursal = Sucursal::find($sucursal);
        if (!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal movimiento inventario, por favor verifique la información o consulte al administrador.";
        }

        if ($documento == 'DAS') {
            $inventario = self::where('inventario_sucursal', $sucursal->id)->where('inventario_producto', $producto->producto_codigo)->where('inventario_documento', 'AS')->first();
            if ($inventario instanceof self) {
                $inventario->inventario_unidad_entrada -= $uentrada;
                $inventario->inventario_unidad_salida -= $usalida;
                ($uentrada > 0) ? $inventario->inventario_unidad_saldo -= $uentrada : '';
                $inventario->save();
            }
        } else {
            $inventario = new Inventario;
            $inventario->inventario_producto = $producto->id;
            $inventario->inventario_sucursal = $sucursal->id;
            $inventario->inventario_documento = $documento;
            $inventario->inventario_unidad_entrada = $uentrada;
            ($uentrada > 0) ? $inventario->inventario_unidad_saldo = $uentrada : '';
            $inventario->inventario_unidad_salida = $usalida;
            $inventario->inventario_costo = $costo;
            $inventario->inventario_costo_promedio = $costopromedio;
            $inventario->inventario_usuario_elaboro = auth()->user()->id;
            $inventario->inventario_fecha_elaboro = date('Y-m-d H:i:s');
            $inventario->save();
        }
        return $inventario;
    }

    public static function primerasEnSalir (Producto $producto, $sucursal, $unidades, $update = false) {
        // Costo
        $costo = 0;

        // Validar producto
        $sucursal = Sucursal::find($sucursal);
        if (!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal movimiento inventario, por favor verifique la información o consulte al administrador.";
        }

        $stocktaking = [];
        while ($unidades > 0) {
            $query = Inventario::query();
            $query->where('inventario_producto', $producto->id);
            $query->where('inventario_sucursal', $sucursal->id);
            $query->whereNotIn('id', $stocktaking);
            $query->whereRaw('inventario_unidad_saldo > 0');
            $query->orderBy('inventario_fecha_elaboro', 'asc');
            $inventario = $query->first();

            if (!$inventario instanceof Inventario) {
                return "No es posible recuperar primeras en salir para producto {$producto->producto_codigo}, por favor verifique la información del asiento o consulte al administrador.";
            }

            $descontadas = $unidades > $inventario->inventario_unidad_saldo ? $inventario->inventario_unidad_saldo : $unidades;
            $costo += ($descontadas * $inventario->inventario_costo);

            if ($update) {
                $inventario->inventario_unidad_saldo = ($inventario->inventario_unidad_saldo - $unidades);
                $inventario->save();
            }

            $unidades -= $descontadas;
            $stocktaking[] = $inventario->id;
        }
        return $costo;
    }
}
