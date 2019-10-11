<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache;

class SubGrupo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_subgrupo';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_subgroups_inventory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subgrupo_nombre'
    ];

    public function isValid($data) {
        $rules = [
            'subgrupo_nombre' => 'required|max:50|unique:koi_subgrupo'
        ];

        if ($this->exists) {
            $rules['subgrupo_nombre'] .= ',subgrupo_nombre,' . $this->id;
        } else {
            $rules['subgrupo_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getSubGrupos() {
        if (Cache::has(self::$key_cache)) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever(self::$key_cache, function() {
            $query = SubGrupo::query();
            $query->orderby('subgrupo_nombre', 'asc');
            $collection = $query->lists('subgrupo_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
