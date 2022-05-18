<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use DB, Cache, Validator;

class Actividad extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_actividad';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_actividades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'actividad_codigo', 'actividad_nombre', 'actividad_tarifa', 'actividad_categoria'
    ];

    public function isValid($data) {
        $rules = [
            'actividad_codigo' => 'required|min:1|max:11|unique:koi_actividad',
            'actividad_nombre' => 'required',
            'actividad_tarifa' => 'required|numeric|max:100|min:0'
        ];

        if ($this->exists) {
            $rules['actividad_codigo'] .= ",actividad_codigo,{$this->id}";
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getActividades() {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Actividad::query();
            $query->select('id', DB::raw("UPPER(CONCAT(actividad_codigo, ' - ', actividad_nombre)) as actividad_nombre"));
            $query->orderby('actividad_codigo', 'asc');
            $collection = $query->lists('actividad_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
