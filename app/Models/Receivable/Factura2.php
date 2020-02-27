<?php

namespace App\Models\Receivable;

use Illuminate\Database\Eloquent\Model;
use DB;

class Factura2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_factura2';

    public $timestamps = false;

    public static function getProductosFactura ($factura) {
       	$query = Factura2::query();
        $query->select('id', 'factura2_orden2', 'factura2_cantidad', 'factura2_producto_nombre',
            DB::raw(
                auth()->user()->ability('admin', 'precios', ['module' => 'facturas']) ?
                    "factura2_producto_valor_unitario, factura2_cantidad * factura2_producto_valor_unitario AS total" :
                    "0 AS factura2_producto_valor_unitario, 0 AS total"
            ));
        $query->where('factura2_factura1', $factura);
        return $query->get();
    }
}
