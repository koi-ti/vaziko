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
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'cotizacion6_tiempo', 'cotizacion6_valor'
    ];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = [
        'cotizacion6_areap', 'cotizacion6_nombre'
    ];

    public function isValid($data) {
        $rules = [
            'cotizacion6_horas' => 'required|min:0|max:9999|numeric',
            'cotizacion6_minutos' => 'required|min:0|max:59|numeric',
            'cotizacion6_valor' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getCotizaciones6($cotizacion2 = null) {
        $query = Cotizacion6::query();
        $query->select('koi_cotizacion6.*', DB::raw("SUBSTRING_INDEX(cotizacion6_tiempo, ':', 1) as cotizacion6_horas, SUBSTRING_INDEX(cotizacion6_tiempo, ':', -1) as cotizacion6_minutos"), 'areap_nombre');
        $query->leftJoin('koi_areap', 'cotizacion6_areap', '=', 'koi_areap.id');
        $query->where('cotizacion6_cotizacion2', $cotizacion2);
        $query->orderBy('areap_nombre', 'asc');
        return $query->get();
    }
}
