<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Validator, Cache;

class Materialp extends BaseModel
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
    protected $fillable = [
        'materialp_nombre', 'materialp_descripcion'
    ];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = [
        'materialp_empaque'
    ];

    public function isValid($data) {
        $rules = [
            'materialp_nombre' => 'required|max:200|unique:koi_materialp'
        ];

        if ($this->exists) {
            $rules['materialp_nombre'] .= ",materialp_nombre,{$this->id}";
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getMateriales() {
        if (Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever(self::$key_cache, function() {
            $query = Materialp::query();
            $query->orderBy('materialp_nombre', 'asc');
            $collection = $query->lists('materialp_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }

    /**
     * Get the attributes for the acabadospName.
     */
    public function tipomaterial() {
        return $this->hasOne('App\Models\Production\TipoMaterialp', 'id' , 'materialp_tipomaterial');
    }
}
