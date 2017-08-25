<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

class Cotizacion6 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion6';

    public $timestamps = false;

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['cotizacion6_areap', 'cotizacion6_nombre'];

    public static function getCotizaciones6($productop = null, $cotizacion2 = null)
    {
        $query = Productop3::query();
        $query->select('koi_areap.id as id', 'areap_nombre', ($cotizacion2 != null ? DB::raw("CASE WHEN koi_cotizacion6.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')) );

        $query->join('koi_areap', 'productop3_areap', '=', 'koi_areap.id');
        if($cotizacion2 != null) {
	        $query->leftjoin('koi_cotizacion6', function($join) use($cotizacion2) {
				$join->on('cotizacion6_areap', '=', 'koi_areap.id')
					->where('cotizacion6_cotizacion2', '=', $cotizacion2);
	        });
            $query->select('koi_areap.id as id', 'areap_nombre', ($cotizacion2 != null ? DB::raw("CASE WHEN koi_cotizacion6.id IS NOT NULL THEN true ELSE false END as activo") : DB::raw('false AS activo')), 'cotizacion6_horas', 'cotizacion6_valor', 'cotizacion6_nombre');
	  	}

        $query->where('productop3_productop', $productop);
        $query->orderBy('areap_nombre', 'asc');
        return $query->get();
    }
}
