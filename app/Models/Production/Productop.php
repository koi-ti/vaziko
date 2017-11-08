<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use Validator, Cache, DB;

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
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_pruducts_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['productop_nombre', 'productop_observaciones', 'productop_ancho_med', 'productop_alto_med', 'productop_c_med_ancho', 'productop_c_med_alto', 'productop_3d_profundidad_med', 'productop_3d_ancho_med', 'productop_3d_alto_med'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['productop_ancho_med', 'productop_alto_med', 'productop_c_med_ancho', 'productop_c_med_alto', 'productop_3d_profundidad_med', 'productop_3d_ancho_med', 'productop_3d_alto_med'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['productop_tiro', 'productop_retiro', 'productop_abierto', 'productop_cerrado', 'productop_3d'];

    public function isValid($data)
    {
        $rules = [
            'productop_nombre' => 'required|max:250',
            'productop_tipoproductop' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getProduct($id)
    {
        $query = Productop::query();
        $query->select('koi_productop.*', 'm1.unidadmedida_nombre as m1_nombre', 'm1.unidadmedida_sigla as m1_sigla', 'm2.unidadmedida_nombre as m2_nombre', 'm2.unidadmedida_sigla as m2_sigla', 'm3.unidadmedida_nombre as m3_nombre', 'm3.unidadmedida_sigla as m3_sigla', 'm4.unidadmedida_nombre as m4_nombre', 'm4.unidadmedida_sigla as m4_sigla', 'm5.unidadmedida_nombre as m5_nombre', 'm5.unidadmedida_sigla as m5_sigla', 'm6.unidadmedida_nombre as m6_nombre', 'm6.unidadmedida_sigla as m6_sigla', 'm7.unidadmedida_nombre as m7_nombre', 'm7.unidadmedida_sigla as m7_sigla', 'u.username as username_elaboro', 'tipoproductop_nombre', 'subtipoproductop_nombre');
        $query->join('koi_tercero as u', 'productop_usuario_elaboro', '=', 'u.id');
        $query->leftJoin('koi_unidadmedida as m1', 'productop_ancho_med', '=', 'm1.id');
        $query->leftJoin('koi_unidadmedida as m2', 'productop_alto_med', '=', 'm2.id');
        $query->leftJoin('koi_unidadmedida as m3', 'productop_c_med_ancho', '=', 'm3.id');
        $query->leftJoin('koi_unidadmedida as m4', 'productop_c_med_alto', '=', 'm4.id');
        $query->leftJoin('koi_unidadmedida as m5', 'productop_3d_ancho_med', '=', 'm5.id');
        $query->leftJoin('koi_unidadmedida as m6', 'productop_3d_alto_med', '=', 'm6.id');
        $query->leftJoin('koi_unidadmedida as m7', 'productop_3d_profundidad_med', '=', 'm7.id');
        $query->leftJoin('koi_tipoproductop', 'productop_tipoproductop', '=', 'koi_tipoproductop.id');
        $query->leftJoin('koi_subtipoproductop', 'productop_subtipoproductop', '=', 'koi_subtipoproductop.id');
        $query->where('koi_productop.id', $id);
        return $query->first();
    }

    public function setProductopObservacionesAttribute($observaciones)
    {
        $this->attributes['productop_observaciones'] = strtoupper($observaciones);
    }

    public function setProperties()
    {
        if($this->productop_abierto || $this->productop_cerrado) {
            $this->productop_3d_ancho_med = null;
            $this->productop_3d_alto_med = null;
            $this->productop_3d_profundidad_med = null;

        }else if($this->productop_3d) {
            $this->productop_ancho_med = null;
            $this->productop_alto_med = null;
            $this->productop_c_med_ancho = null;
            $this->productop_c_med_alto = null;
        }
    }

    public static function getProductos()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Productop::query();
            $query->orderBy('productop_nombre', 'asc');
            $collection = $query->lists('productop_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
