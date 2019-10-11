<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class Cotizacion4 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion4';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cotizacion4_medidas', 'cotizacion4_cantidad', 'cotizacion4_valor_unitario', 'cotizacion4_valor_total'
    ];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = [
        'cotizacion4_producto'
    ];

    public function isValid($data) {
        $rules = [
            'cotizacion4_materialp' => 'required',
            'cotizacion4_producto' => 'required',
            'cotizacion4_medidas' => 'required',
            'cotizacion4_valor_unitario' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getCotizaciones4($cotizacion2 = null) {
        $query = self::query();
        $query->select('koi_cotizacion4.*', 'materialp_nombre', 'producto_nombre');
        $query->join('koi_materialp', 'cotizacion4_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'cotizacion4_producto', '=', 'koi_producto.id');
        $query->where('cotizacion4_cotizacion2', $cotizacion2);
        $query->orderBy('materialp_nombre', 'asc');
        return $query->get();
    }

    /**
    *  Select materiales dependiendo del productop
    **/
    public static function getMaterials($productop = null) {
        $query = Productop5::query();
        $query->select('koi_materialp.id as id', 'materialp_nombre');
        $query->join('koi_materialp', 'productop5_materialp', '=', 'koi_materialp.id');
        $query->where('productop5_productop', $productop);
        $query->orderBy('materialp_nombre', 'asc');

        $collection = $query->lists('materialp_nombre', 'id');
        return $collection;
    }
}
