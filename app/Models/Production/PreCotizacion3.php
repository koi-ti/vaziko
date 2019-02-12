<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class PreCotizacion3 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion3';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['precotizacion3_medidas', 'precotizacion3_valor_unitario', 'precotizacion3_valor_total'];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = ['precotizacion3_producto'];

    public function isValid($data)
    {
        $rules = [
            'precotizacion3_materialp' => 'required',
            'precotizacion3_producto' => 'required',
            'precotizacion3_medidas' => 'required',
            'precotizacion3_valor_unitario' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPreCotizaciones3($precotizacion2 = null)
    {
        $query = PreCotizacion3::query();
        $query->select('koi_precotizacion3.*', 'materialp_nombre', 'producto_nombre');
        $query->join('koi_materialp', 'precotizacion3_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'precotizacion3_producto', '=', 'koi_producto.id');
        $query->where('precotizacion3_precotizacion2', $precotizacion2);
        $query->orderBy('materialp_nombre', 'asc');
        return $query->get();
    }

    /**
    *  Select materiales dependiendo del productop
    **/
    public static function getMaterials($productop = null)
    {
        $query = Productop5::query();
        $query->select('koi_materialp.id as id', 'materialp_nombre');
        $query->join('koi_materialp', 'productop5_materialp', '=', 'koi_materialp.id');
        $query->where('productop5_productop', $productop);

        $collection = $query->lists('materialp_nombre', 'id');
        return $collection;
    }
}
