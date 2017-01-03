<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator, Cache;

class Maquinap extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_maquinap';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_machines_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['maquinap_nombre'];

    public function isValid($data)
    {
        $rules = [
            'maquinap_nombre' => 'required|max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getMaquinas()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Maquinap::query();
            $query->orderBy('maquinap_nombre', 'asc');
            $collection = $query->lists('maquinap_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
