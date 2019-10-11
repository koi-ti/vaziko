<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache;

class Unidad extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_unidadmedida';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_measurement_units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unidadmedida_nombre', 'unidadmedida_sigla'
    ];

    public function isValid($data) {
        $rules = [
            'unidadmedida_sigla' => 'required|max:15|min:1|unique:koi_unidadmedida',
            'unidadmedida_nombre' => 'required|max:100'
        ];

        if ($this->exists) {
            $rules['unidadmedida_sigla'] .= ',unidadmedida_sigla,' . $this->id;
        } else {
            $rules['unidadmedida_sigla'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getUnidades() {
        if (Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever(self::$key_cache, function() {
            $query = Unidad::query();
            $query->orderby('unidadmedida_nombre', 'asc');
            return $query->lists('unidadmedida_nombre', 'id');
        });
    }
}
