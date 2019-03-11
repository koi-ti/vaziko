<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class Cotizacion9 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion9';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cotizacion9_medidas', 'cotizacion9_cantidad', 'cotizacion9_valor_unitario', 'cotizacion9_valor_total'];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = ['cotizacion9_producto'];

    public function isValid($data)
    {
        $rules = [
            'cotizacion9_materialp' => 'required',
            'cotizacion9_producto' => 'required',
            'cotizacion9_medidas' => 'required',
            'cotizacion9_valor_unitario' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getCotizaciones9($cotizacion2 = null)
    {
        $query = self::query();
        $query->select('koi_cotizacion9.*', 'materialp_nombre as empaque_nombre', 'producto_nombre');
        $query->leftJoin('koi_materialp', 'cotizacion9_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'cotizacion9_producto', '=', 'koi_producto.id');
        $query->where('cotizacion9_cotizacion2', $cotizacion2);
        $query->orderBy('empaque_nombre', 'asc');
        return $query->get();
    }

    /**
    *  Select materiales dependiendo del productop
    **/
    public static function getPackaging($productop = null)
    {
        $query = Productop5::query();
        $query->select('koi_materialp.id as id', 'materialp_nombre as empaque_nombre');
        $query->join('koi_materialp', 'productop5_materialp', '=', 'koi_materialp.id');
        $query->where('materialp_empaque', true);
        $query->where('productop5_productop', $productop);
        return $query->lists('empaque_nombre', 'id');
    }
}
