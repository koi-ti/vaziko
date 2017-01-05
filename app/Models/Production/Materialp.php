<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator, Cache;

class Materialp extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_materialp';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_materials_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['materialp_nombre', 'materialp_descripcion'];

    public function isValid($data)
    {
        $rules = [
            'materialp_nombre' => 'required|max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getMateriales()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Materialp::query();
            $query->orderBy('materialp_nombre', 'asc');
            $collection = $query->lists('materialp_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
