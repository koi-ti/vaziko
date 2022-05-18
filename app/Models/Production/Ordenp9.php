<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class Ordenp9 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion9';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orden9_medidas', 'orden9_cantidad', 'orden9_valor_unitario', 'orden9_valor_total'
    ];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = [
        'orden9_producto'
    ];

    public function isValid($data) {
        $rules = [
            'orden9_materialp' => 'required',
            'orden9_producto' => 'required',
            'orden9_medidas' => 'required',
            'orden9_valor_unitario' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getOrdenesp9($orden2 = null) {
        $query = self::query();
        $query->select('koi_ordenproduccion9.*', 'materialp_nombre as empaque_nombre', 'producto_nombre');
        $query->leftJoin('koi_materialp', 'orden9_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'orden9_producto', '=', 'koi_producto.id');
        $query->where('orden9_orden2', $orden2);
        $query->orderBy('empaque_nombre', 'asc');
        return $query->get();
    }

    public function empaque () {
        return $this->belongsTo(Materialp::class, 'orden9_materialp', 'id');
    }
}
