<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB;

class PreCotizacion6 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion6';

    public $timestamps = false;

    public static function getPreCotizaciones6($precotizacion2 = null) {
        $query = PreCotizacion6::query();
        $query->select('koi_precotizacion6.*', DB::raw("SUBSTRING_INDEX(precotizacion6_tiempo, ':', 1) as precotizacion6_horas, SUBSTRING_INDEX(precotizacion6_tiempo, ':', -1) as precotizacion6_minutos"), 'areap_nombre');
        $query->leftJoin('koi_areap', 'precotizacion6_areap', '=', 'koi_areap.id');
        $query->where('precotizacion6_precotizacion2', $precotizacion2);
        $query->orderBy('areap_nombre', 'asc');
        return $query->get();
    }
}
