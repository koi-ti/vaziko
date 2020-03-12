<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class Ordenp10 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion10';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orden10_transporte', 'orden10_nombre', 'orden10_tiempo', 'orden10_valor_unitario', 'orden10_valor_total'
    ];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = [
        'orden10_transporte', 'orden10_nombre'
    ];

    public function isValid($data) {
        $rules = [
            'orden10_transporte' => 'required_without:orden10_nombre',
            'orden10_horas' => 'required|min:0|max:9999|numeric',
            'orden10_minutos' => 'required|min:0|max:59|numeric',
            'orden10_valor_unitario' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getOrdenesp10($orden2 = null) {
        $query = self::query();
        $query->select('koi_ordenproduccion10.*', 'areap_nombre as transporte_nombre');
        $query->tiempo();
        $query->leftJoin('koi_areap', 'orden10_transporte', '=', 'koi_areap.id');
        $query->where('orden10_orden2', $orden2);
        $query->orderBy('transporte_nombre', 'asc');
        return $query->get();
    }

    public function transporte () {
        return $this->hasOne(Areap::class, 'id', 'orden10_transporte');
    }

    public function scopeTiempo ($query) {
        return $query->addSelect(DB::raw("SUBSTRING_INDEX(orden10_tiempo, ':', '-1') AS orden10_minutos, SUBSTRING_INDEX(orden10_tiempo, ':', '1') AS orden10_horas"));
    }
}
