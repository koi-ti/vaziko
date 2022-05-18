<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB;

class PreCotizacion3 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion3';

    public $timestamps = false;

    public static function getPreCotizaciones3($precotizacion2 = null) {
        $query = PreCotizacion3::query();
        $query->select('koi_precotizacion3.*', 'materialp_nombre', 'producto_nombre');
        $query->join('koi_materialp', 'precotizacion3_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'precotizacion3_producto', '=', 'koi_producto.id');
        $query->where('precotizacion3_precotizacion2', $precotizacion2);
        $query->orderBy('materialp_nombre', 'asc');
        return $query->get();
    }

    /**
    *  Select materiales dependiendo del productop
    **/
    public static function getMaterials($productop = null) {
        $query = Productop5::query();
        $query->select('koi_materialp.id as id', 'materialp_nombre');
        $query->join('koi_materialp', 'productop5_materialp', '=', 'koi_materialp.id');
        $query->where('productop5_productop', $productop);
        $query->orderBy('materialp_nombre', 'asc');
        return $query->lists('materialp_nombre', 'id');
    }
}
