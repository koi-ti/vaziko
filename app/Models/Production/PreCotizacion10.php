<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class PreCotizacion10 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion10';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'precotizacion10_medidas', 'precotizacion10_cantidad', 'precotizacion10_valor_unitario', 'precotizacion10_valor_total'
    ];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = [
        'precotizacion10_producto'
    ];

    public function isValid($data) {
        $rules = [
            'precotizacion10_materialp' => 'required',
            'precotizacion10_producto' => 'required',
            'precotizacion10_medidas' => 'required',
            'precotizacion10_valor_unitario' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPreCotizaciones10($precotizacion2 = null) {
        $query = self::query();
        $query->select('koi_precotizacion10.*', 'materialp_nombre as transporte_nombre', 'producto_nombre');
        $query->leftJoin('koi_materialp', 'precotizacion10_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'precotizacion10_producto', '=', 'koi_producto.id');
        $query->where('precotizacion10_precotizacion2', $precotizacion2);
        $query->orderBy('transporte_nombre', 'asc');
        return $query->get();
    }
}
