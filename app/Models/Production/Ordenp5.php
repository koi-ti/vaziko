<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ordenp5 extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion5';

    public $timestamps = false;

    public static function getOrdenesp5($productop = null, $ordenp2 = null) {
        $query = Productop6::query();
        $query->select('koi_acabadop.id as id', 'acabadop_nombre', ($ordenp2 != null ? DB::raw("CASE WHEN koi_ordenproduccion5.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );

        $query->join('koi_acabadop', 'productop6_acabadop', '=', 'koi_acabadop.id');
        if ($ordenp2 != null) {
	        $query->leftjoin('koi_ordenproduccion5', function($join) use($ordenp2) {
				$join->on('orden5_acabadop', '=', 'koi_acabadop.id')
					->where('orden5_orden2', '=', $ordenp2);
	        });
	  	}

        $query->where('productop6_productop', $productop);
        $query->orderBy('acabadop_nombre', 'asc');
        return $query->get();
    }

    public function acabado () {
        return $this->belongsTo(Acabadop::class, 'orden5_acabadop', 'id');
    }
}
