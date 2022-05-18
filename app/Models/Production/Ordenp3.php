<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ordenp3 extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion3';

    public $timestamps = false;

    public static function getOrdenesp3($productop = null, $ordenp2 = null) {
        $query = Productop4::query();
        $query->select('koi_maquinap.id as id', 'maquinap_nombre', ($ordenp2 != null ? DB::raw("CASE WHEN koi_ordenproduccion3.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );

        $query->join('koi_maquinap', 'productop4_maquinap', '=', 'koi_maquinap.id');
        if ($ordenp2 != null) {
	        $query->leftjoin('koi_ordenproduccion3', function($join) use($ordenp2) {
				$join->on('orden3_maquinap', '=', 'koi_maquinap.id')
					->where('orden3_orden2', '=', $ordenp2);
	        });
	  	}

        $query->where('productop4_productop', $productop);
        $query->orderBy('maquinap_nombre', 'asc');
        return $query->get();
    }

    public function maquina () {
        return $this->belongsTo(Maquinap::class, 'orden3_maquinap', 'id');
    }
}
