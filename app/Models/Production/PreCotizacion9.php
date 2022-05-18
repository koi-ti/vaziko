<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB;

class PreCotizacion9 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion9';

    public $timestamps = false;

    public static function getPreCotizaciones9($precotizacion2 = null) {
        $query = self::query();
        $query->select('koi_precotizacion9.*', 'materialp_nombre as empaque_nombre', 'producto_nombre');
        $query->leftJoin('koi_materialp', 'precotizacion9_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'precotizacion9_producto', '=', 'koi_producto.id');
        $query->where('precotizacion9_precotizacion2', $precotizacion2);
        $query->orderBy('empaque_nombre', 'asc');
        return $query->get();
    }
}
