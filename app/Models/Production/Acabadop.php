<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache;

class Acabadop extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_acabadop';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_acabados_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'acabadop_nombre', 'acabadop_descripcion'
    ];

    public function isValid($data) {
        $rules = [
            'acabadop_nombre' => 'required|max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function setAcabadopDescripcionAttribute($descripcion) {
        $this->attributes['acabadop_descripcion'] = strtoupper($descripcion);
    }

    public static function getAcabados() {
        if (Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever(self::$key_cache, function() {
            $query = Acabadop::query();
            $query->orderBy('acabadop_nombre', 'asc');
            $collection = $query->lists('acabadop_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
