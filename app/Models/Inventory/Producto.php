<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use Validator;

class Producto extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_producto';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['producto_codigo', 'producto_codigoori', 'producto_nombre', 'producto_grupo', 'producto_subgrupo', 'producto_unidadmedida', 'producto_vidautil'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['producto_serie', 'producto_metrado', 'producto_unidades'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['producto_unidadmedida', 'producto_vidautil'];

    public function isValid($data)
    {
        $rules = [
            'producto_codigo' => 'required|max:15|min:1|unique:koi_producto',
            'producto_codigoori' => 'required|max:15|min:1',
            'producto_nombre' => 'required|max:200',
            'producto_grupo' => 'required',
            'producto_subgrupo' => 'required',
            'producto_unidades' => 'required'
        ];

        if ($this->exists){
            $rules['producto_codigo'] .= ',producto_codigo,' . $this->id;
        }else{
            $rules['producto_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            if(isset($data['producto_serie']) && $data['producto_serie'] == 'producto_serie' && isset($data['producto_metrado']) && $data['producto_metrado'] == 'producto_metrado') {
                $this->errors = 'Producto no puede ser metrado y manejar serie al mismo tiempo, por favor verifique la información del asiento o consulte al administrador.';
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getProduct($id)
    {
        $query = Producto::query();
        $query->select('koi_producto.*', 'grupo_nombre', 'subgrupo_nombre', 'unidadmedida_sigla', 'unidadmedida_nombre');
        $query->join('koi_grupo', 'producto_grupo', '=', 'koi_grupo.id');
        $query->join('koi_subgrupo', 'producto_subgrupo', '=', 'koi_subgrupo.id');
        $query->leftJoin('koi_unidadmedida', 'producto_unidadmedida', '=', 'koi_unidadmedida.id');
        $query->where('koi_producto.id', $id);
        return $query->first();
    }
}
