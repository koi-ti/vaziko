<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache;

class Grupo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_grupo';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_groups_inventory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grupo_nombre'
    ];

    public function isValid($data) {
        $rules = [
            'grupo_nombre' => 'required|max:50|unique:koi_grupo'
        ];

        if ($this->exists) {
            $rules['grupo_nombre'] .= ",grupo_nombre,{$this->id}";
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getGrupos() {
        if (Cache::has(self::$key_cache)) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever(self::$key_cache, function() {
            $query = Grupo::query();
            $query->orderby('grupo_nombre', 'asc');
            $collection = $query->lists('grupo_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
