<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB;

class PreCotizacion7 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion7';

    public $timestamps = false;

    public static function getPreCotizaciones7($productop = null, $precotizacion2 = null)
    {
        $query = Productop6::query();
        $query->select('koi_acabadop.id as id', 'acabadop_nombre', ($precotizacion2 != null ? DB::raw("CASE WHEN koi_precotizacion7.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );

        $query->join('koi_acabadop', 'productop6_acabadop', '=', 'koi_acabadop.id');
        if($precotizacion2 != null) {
	        $query->leftjoin('koi_precotizacion7', function($join) use($precotizacion2) {
				$join->on('precotizacion7_acabadop', '=', 'koi_acabadop.id')
					->where('precotizacion7_precotizacion2', '=', $precotizacion2);
	        });
	  	}

        $query->where('productop6_productop', $productop);
        $query->orderBy('acabadop_nombre', 'asc');
        return $query->get();
    }

    /**
     * Get the attributes for the acabadospName.
     */
    public function getName()
    {
        return $this->hasOne('App\Models\Production\Acabadop', 'id' , 'precotizacion7_acabadop');
    }
}
