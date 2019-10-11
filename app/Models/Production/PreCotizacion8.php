<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB;

class PreCotizacion8 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion8';

    public $timestamps = false;

    public static function getPreCotizaciones8($productop = null, $precotizacion2 = null) {
        $query = Productop4::query();
        $query->select('koi_maquinap.id as id', 'maquinap_nombre', ($precotizacion2 != null ? DB::raw("CASE WHEN koi_precotizacion8.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );
        $query->join('koi_maquinap', 'productop4_maquinap', '=', 'koi_maquinap.id');

        if ($precotizacion2 != null) {
	        $query->leftjoin('koi_precotizacion8', function ($join) use ($precotizacion2) {
				$join->on('precotizacion8_maquinap', '=', 'koi_maquinap.id')
					->where('precotizacion8_precotizacion2', '=', $precotizacion2);
	        });
	  	}

        $query->where('productop4_productop', $productop);
        $query->orderBy('maquinap_nombre', 'asc');
        return $query->get();
    }

    /**
     * Get the attributes for the maquinaspName.
     */
    public function getName() {
        return $this->hasOne('App\Models\Production\Maquinap', 'id' , 'precotizacion8_maquinap');
    }
}
