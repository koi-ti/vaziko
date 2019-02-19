<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use App\Models\Inventory\Producto;
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
    protected $fillable = ['precotizacion9_medidas', 'precotizacion9_valor_unitario', 'precotizacion9_valor_total'];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = ['precotizacion9_producto'];

    public function isValid($data)
    {
        $rules = [
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
        $query->select('koi_precotizacion9.*', 'producto_nombre');
        $query->join('koi_producto', 'precotizacion9_producto', '=', 'koi_producto.id');
        $query->where('precotizacion9_precotizacion2', $precotizacion2);
        $query->orderBy('producto_nombre', 'asc');
        return $query->get();
    }

    /**
    *  Select materiales dependiendo del productop
    **/
    public static function getPackaging()
    {
        $query = Producto::query();
        $query->select('koi_producto.id as id', 'producto_nombre');
        $query->where('producto_empaque', true);
        return $query->lists('producto_nombre', 'id');
    }
}
