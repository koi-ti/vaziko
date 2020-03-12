<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Validator, Cache;

class Areap extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_areap';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_areas_production';
    public static $key_cache_transporte = '_transportes_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'areap_nombre', 'areap_valor'
    ];

    /**
     * The attributes that are mass assignable boolean.
     *
     * @var boolean
     */
    protected $boolean = [
        'areap_transporte'
    ];

    public function isValid($data) {
        $rules = [
            'areap_nombre' => 'required|max:200',
            'areap_valor' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getAreas() {
        if (Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever(self::$key_cache, function() {
            $query = self::query();
            $query->orderBy('areap_nombre', 'asc');
            $collection = $query->lists('areap_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }

    public static function getTransportes() {
        if (Cache::has(self::$key_cache_transporte)) {
            return Cache::get(self::$key_cache_transporte);
        }

        return Cache::rememberForever(self::$key_cache_transporte, function() {
            $query = self::query();
            $query->orderBy('areap_nombre', 'asc');
            $query->where('areap_transporte', true);
            $collection = $query->lists('areap_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
