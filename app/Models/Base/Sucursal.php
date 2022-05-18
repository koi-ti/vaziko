<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache;

class Sucursal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_sucursal';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_offices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_nombre'
    ];

    public function isValid($data) {
        $rules = [
            'sucursal_nombre' => 'required|max:100|unique:koi_sucursal'
        ];

        if ($this->exists) {
            $rules['sucursal_nombre'] .= ",sucursal_nombre,{$this->id}";
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }


    public static function getSucursales() {
        if (Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever(self::$key_cache, function() {
            $query = Sucursal::query();
            $query->orderby('sucursal_nombre', 'asc');
            $collection = $query->lists('sucursal_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
