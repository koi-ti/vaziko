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
        'cotizacion10_nombre', 'cotizacion10_medidas', 'cotizacion10_cantidad', 'cotizacion10_valor_unitario', 'cotizacion10_valor_total'
    ];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = [
        'cotizacion10_producto'
    ];

    public function isValid($data) {
        $rules = [
            'cotizacion10_producto' => 'required_without:cotizacion10_nombre',
            'cotizacion10_medidas' => 'required',
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
        $query->select('koi_cotizacion10.*', 'producto_nombre as transporte_nombre');
        $query->leftJoin('koi_producto', 'cotizacion10_producto', '=', 'koi_producto.id');
        $query->where('cotizacion10_cotizacion2', $cotizacion2);
        $query->orderBy('transporte_nombre', 'asc');
        return $query->get();
    }
}
