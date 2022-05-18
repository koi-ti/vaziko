<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class Cotizacion10 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion10';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cotizacion10_transporte', 'cotizacion10_nombre', 'cotizacion10_tiempo', 'cotizacion10_valor_unitario', 'cotizacion10_valor_total'
    ];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = [
        'cotizacion10_transporte', 'cotizacion10_nombre'
    ];

    public function isValid($data) {
        $rules = [
            'cotizacion10_transporte' => 'required_without:cotizacion10_nombre',
            'cotizacion10_horas' => 'required|min:0|max:9999|numeric',
            'cotizacion10_minutos' => 'required|min:0|max:59|numeric',
            'cotizacion10_valor_unitario' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getCotizaciones10($cotizacion2 = null) {
        $query = self::query();
        $query->select('koi_cotizacion10.*', 'areap_nombre as transporte_nombre');
        $query->tiempo();
        $query->leftJoin('koi_areap', 'cotizacion10_transporte', '=', 'koi_areap.id');
        $query->where('cotizacion10_cotizacion2', $cotizacion2);
        $query->orderBy('transporte_nombre', 'asc');
        return $query->get();
    }

    public function scopeTiempo ($query) {
        return $query->addSelect(DB::raw("SUBSTRING_INDEX(cotizacion10_tiempo, ':', '-1') AS cotizacion10_minutos, SUBSTRING_INDEX(cotizacion10_tiempo, ':', '1') AS cotizacion10_horas"));
    }
}
