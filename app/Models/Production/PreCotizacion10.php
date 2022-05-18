<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB;

class PreCotizacion10 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion10';

    public $timestamps = false;

    public static function getPreCotizaciones10($precotizacion2 = null) {
        $query = self::query();
        $query->select('koi_precotizacion10.*', 'materialp_nombre as transporte_nombre', 'producto_nombre');
        $query->leftJoin('koi_materialp', 'precotizacion10_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'precotizacion10_producto', '=', 'koi_producto.id');
        $query->where('precotizacion10_precotizacion2', $precotizacion2);
        $query->orderBy('transporte_nombre', 'asc');
        return $query->get();
    }
}
