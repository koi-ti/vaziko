<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cotizacion5 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion5';

    public $timestamps = false;

    public static function getCotizaciones5($productop = null, $cotizacion2 = null) {
        $query = Productop6::query();
        $query->select('koi_acabadop.id as id', 'acabadop_nombre', ($cotizacion2 != null ? DB::raw("CASE WHEN koi_cotizacion5.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );

        $query->join('koi_acabadop', 'productop6_acabadop', '=', 'koi_acabadop.id');
        if ($cotizacion2 != null) {
	        $query->leftjoin('koi_cotizacion5', function($join) use($cotizacion2) {
				$join->on('cotizacion5_acabadop', '=', 'koi_acabadop.id')
					->where('cotizacion5_cotizacion2', '=', $cotizacion2);
	        });
	  	}

        $query->where('productop6_productop', $productop);
        $query->orderBy('acabadop_nombre', 'asc');
        return $query->get();
    }

    /**
     * Get the attributes for the acabadospName.
     */
    public function getName() {
        return $this->hasOne('App\Models\Production\Acabadop', 'id' , 'cotizacion5_acabadop');
    }
}
