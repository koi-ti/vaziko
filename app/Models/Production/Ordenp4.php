<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use DB;

class Ordenp4 extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion4';

    public $timestamps = false;

    public static function getOrdenesp4($productop = null, $ordenp2 = null)
    {
        $query = Productop5::query();
        $query->select('koi_materialp.id as materialp_id', 'materialp_nombre', ($ordenp2 != null ? DB::raw("CASE WHEN koi_ordenproduccion4.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );

        $query->join('koi_materialp', 'productop5_materialp', '=', 'koi_materialp.id');
        if($ordenp2 != null) {
	        $query->leftjoin('koi_ordenproduccion4', function($join) use($ordenp2) {
				$join->on('orden4_materialp', '=', 'koi_materialp.id')
					->where('orden4_orden2', '=', $ordenp2);
	        });
            $query->addSelect('koi_ordenproduccion4.id as orden4_id');
	  	}

        $query->where('productop5_productop', $productop);
        $query->orderBy('materialp_nombre', 'asc');
        return $query->get();
    }
}
