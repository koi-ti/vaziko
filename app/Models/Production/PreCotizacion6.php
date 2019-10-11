<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

class PreCotizacion6 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion6';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'precotizacion6_tiempo', 'precotizacion6_valor'
    ];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = [
        'precotizacion6_areap', 'precotizacion6_nombre'
    ];

    public function isValid($data) {
        $rules = [
            'precotizacion6_horas' => 'required|min:0|max:9999|numeric',
            'precotizacion6_minutos' => 'required|min:0|max:59|numeric',
            'precotizacion6_valor' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPreCotizaciones6($precotizacion2 = null) {
        $query = PreCotizacion6::query();
        $query->select('koi_precotizacion6.*', DB::raw("SUBSTRING_INDEX(precotizacion6_tiempo, ':', 1) as precotizacion6_horas, SUBSTRING_INDEX(precotizacion6_tiempo, ':', -1) as precotizacion6_minutos"), 'areap_nombre');
        $query->leftJoin('koi_areap', 'precotizacion6_areap', '=', 'koi_areap.id');
        $query->where('precotizacion6_precotizacion2', $precotizacion2);
        $query->orderBy('areap_nombre', 'asc');
        return $query->get();
    }
}
