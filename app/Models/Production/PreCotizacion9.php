<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class PreCotizacion9 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion9';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['precotizacion9_medidas', 'precotizacion9_cantidad', 'precotizacion9_valor_unitario', 'precotizacion9_valor_total'];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = ['precotizacion9_producto'];

    public function isValid($data)
    {
        $rules = [
            'precotizacion9_materialp' => 'required',
            'precotizacion9_producto' => 'required',
            'precotizacion9_medidas' => 'required',
            'precotizacion9_valor_unitario' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPreCotizaciones9($precotizacion2 = null)
    {
        $query = self::query();
        $query->select('koi_precotizacion9.*', 'materialp_nombre as empaque_nombre', 'producto_nombre');
        $query->leftJoin('koi_materialp', 'precotizacion9_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'precotizacion9_producto', '=', 'koi_producto.id');
        $query->where('precotizacion9_precotizacion2', $precotizacion2);
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
