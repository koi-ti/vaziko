<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use DB;

class Cotizacion4 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion4';

    public $timestamps = false;

    public static function getCotizaciones4($productop = null, $cotizacion2 = null)
    {
        $query = Productop5::query();
        $query->select('koi_materialp.id as id', 'materialp_nombre', ($cotizacion2 != null ? DB::raw("CASE WHEN koi_cotizacion4.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );

        $query->join('koi_materialp', 'productop5_materialp', '=', 'koi_materialp.id');
        if($cotizacion2 != null) {
	        $query->leftjoin('koi_cotizacion4', function($join) use($cotizacion2) {
				$join->on('cotizacion4_materialp', '=', 'koi_materialp.id')
					->where('cotizacion4_cotizacion2', '=', $cotizacion2);
	        });
	  	}

        $query->where('productop5_productop', $productop);
        $query->orderBy('materialp_nombre', 'asc');
        return $query->get();
    }
}
