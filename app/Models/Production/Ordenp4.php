<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator;

class Ordenp4 extends BaseModel
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion4';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['orden4_cantidad', 'orden4_medidas', 'orden4_valor_unitario', 'orden4_valor_total'];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = ['orden4_producto'];

    public function isValid($data)
    {
        $rules = [
            'orden4_materialp' => 'required',
            'orden4_producto' => 'required',
            'orden4_cantidad' => 'required|min:1',
            'orden4_medidas' => 'required',
            'orden4_valor_unitario' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getOrdenesp4($ordenp2 = null)
    {
        $query = self::query();
        $query->select('koi_ordenproduccion4.*', 'materialp_nombre', 'producto_nombre');
        $query->join('koi_materialp', 'orden4_materialp', '=', 'koi_materialp.id');
        $query->leftJoin('koi_producto', 'orden4_producto', '=', 'koi_producto.id');
        $query->where('orden4_orden2', $ordenp2);
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
