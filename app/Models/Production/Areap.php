<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator, Cache;

class Areap extends Model
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['areap_nombre', 'areap_valor'];

    public function isValid($data)
    {
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

    public static function getAreas()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Areap::query();
            $query->orderBy('areap_nombre', 'asc');
            $collection = $query->lists('areap_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
