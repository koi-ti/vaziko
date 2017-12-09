<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use DB, Validator;

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
            'producto_subgrupo' => 'required'
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
        $query->select('koi_producto.*', 'referencia.id as referencia_id', 'referencia.producto_codigo as referencia_codigo', 'grupo_nombre', 'subgrupo_nombre', 'unidadmedida_sigla', 'unidadmedida_nombre');
        $query->join('koi_producto as referencia', 'koi_producto.producto_referencia', '=', 'referencia.id');
        $query->join('koi_grupo', 'koi_producto.producto_grupo', '=', 'koi_grupo.id');
        $query->join('koi_subgrupo', 'koi_producto.producto_subgrupo', '=', 'koi_subgrupo.id');
        $query->leftJoin('koi_unidadmedida', 'koi_producto.producto_unidadmedida', '=', 'koi_unidadmedida.id');
        $query->where('koi_producto.id', $id);
        return $query->first();
    }

    public function serie($serie)
    {
        $producto = Producto::where('producto_codigo', $serie)->first();
        if($producto instanceof Producto) {
            return "Ya existe un producto con este número de serie {$producto->producto_codigo}, por favor verifique la información del asiento o consulte al administrador.";
        }

        $producto = $this->replicate();
        $producto->producto_codigo = $serie;
        $producto->save();

        return $producto;
    }

    public function costopromedio($costo = 0, $cantidad = 0, $update = true)
    {
        $suma = DB::table('koi_prodbode')
            ->where('prodbode_producto', $this->id)
            ->sum('prodbode_cantidad');

        $totalp1 = $suma * $this->producto_costo;
        $totalp2 = $costo * $cantidad;
        $totalp3 = $cantidad + $suma;
        $costopromedio = ( $totalp1 + $totalp2 ) / $totalp3;

        if($update) {
            // Actualizar producto costo
            $this->producto_costo = $costopromedio;
            $this->save();
        }

        return $costopromedio;
    }

    public function available ()
    {
        if ($this->producto_metrado) {
            return $this->hasMany('App\Models\Inventory\ProdbodeRollo', 'prodboderollo_producto', 'id')
                ->select('koi_prodboderollo.*', DB::raw('SUM(prodboderollo_saldo) AS disponible'), 'sucursal_nombre', 'koi_sucursal.id as sucursal')
                ->join('koi_sucursal','prodboderollo_sucursal','=','koi_sucursal.id')
                ->havingRaw('SUM(prodboderollo_saldo) >= 0')
                ->groupBy('prodboderollo_sucursal')
                ->orderBy('sucursal_nombre', 'asc')
                ->where('prodboderollo_saldo', '>', 0);
        }else{
            return $this->hasMany('App\Models\Inventory\Prodbode', 'prodbode_producto', 'id')
                ->select('koi_prodbode.*','sucursal_nombre', DB::raw('SUM(prodbode_cantidad) AS disponible'),'prodbode_reservada')
                ->join('koi_sucursal','prodbode_sucursal','=','koi_sucursal.id')
                ->havingRaw('SUM(prodbode_cantidad) >= 0')
                ->groupBy('prodbode_sucursal')
                ->orderBy('sucursal_nombre', 'asc')
                ->where('prodbode_cantidad', '>', 0);
        }
    }
}
