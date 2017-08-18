<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use DB;

class Cotizacion3 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion3';

    public $timestamps = false;

    public static function getCotizaciones3($productop = null, $cotizacion2 = null)
    {
        $query = Productop4::query();
        $query->select('koi_maquinap.id as id', 'maquinap_nombre', ($cotizacion2 != null ? DB::raw("CASE WHEN koi_cotizacion3.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );

        $query->join('koi_maquinap', 'productop4_maquinap', '=', 'koi_maquinap.id');
        if($cotizacion2 != null) {
	        $query->leftjoin('koi_cotizacion3', function($join) use($cotizacion2) {
				$join->on('cotizacion3_maquinap', '=', 'koi_maquinap.id')
					->where('cotizacion3_cotizacion2', '=', $cotizacion2);
	        });
	  	}

        $query->where('productop4_productop', $productop);
        $query->orderBy('maquinap_nombre', 'asc');
        return $query->get();
    }
}
