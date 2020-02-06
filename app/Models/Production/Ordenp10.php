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
        'orden10_medidas', 'orden10_cantidad', 'orden10_valor_unitario', 'orden10_valor_total'
    ];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = [
        'orden10_producto'
    ];

    public function isValid($data) {
        $rules = [
            'orden10_materialp' => 'required',
            'orden10_producto' => 'required',
            'orden10_medidas' => 'required',
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
        $query->select('koi_ordenproduccion10.*', 'materialp_nombre as transporte_nombre', 'producto_nombre');
        $query->leftJoin('koi_materialp', 'orden10_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'orden10_producto', '=', 'koi_producto.id');
        $query->where('orden10_orden2', $orden2);
        $query->orderBy('transporte_nombre', 'asc');
        return $query->get();
    }

    public function transporte () {
        return $this->belongsTo(Materialp::class, 'orden10_materialp', 'id');
    }
}
