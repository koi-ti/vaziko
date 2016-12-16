<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use Validator, DB;

class Productop extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_productop';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['productop_nombre', 'productop_observaciones'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['productop_tiro', 'productop_retiro'];

    public function isValid($data)
    {
        $rules = [
            'productop_nombre' => 'required|max:250',
         //    'orden_cliente' => 'required',
         //    'orden_contacto' => 'required',
         //    'tcontacto_telefono' => 'required',
         //    'orden_formapago' => 'required',
	        // 'orden_fecha_inicio' => 'required|date_format:Y-m-d',
	        // 'orden_suministran' => 'max:200',
         //    'orden_fecha_entrega' => 'required|date_format:Y-m-d',
         //    'orden_hora_entrega' => 'required|date_format:H:m'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getProduct($id)
    {
        $query = Productop::query();
        $query->select('koi_productop.*');
        // $query->join('koi_producto as referencia', 'koi_producto.producto_referencia', '=', 'referencia.id');
        // $query->join('koi_grupo', 'koi_producto.producto_grupo', '=', 'koi_grupo.id');
        // $query->join('koi_subgrupo', 'koi_producto.producto_subgrupo', '=', 'koi_subgrupo.id');
        // $query->leftJoin('koi_unidadmedida', 'koi_producto.producto_unidadmedida', '=', 'koi_unidadmedida.id');
        $query->where('koi_productop.id', $id);
        return $query->first();
    }

    public function setProductopObservacionesAttribute($observaciones)
    {
        $this->attributes['productop_observaciones'] = strtoupper($observaciones);
    }
}
