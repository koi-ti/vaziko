<?php

namespace App\Models\Base;

use Zizaco\Entrust\EntrustRole;
use Validator, Cache;

class Rol extends EntrustRole
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_rol';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_troles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name', 'description'
    ];

    public function isValid($data) {
        $rules = [
            'display_name' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function setDisplayNameAttribute ($value) {
        $this->attributes['display_name'] = $value;

        if (!$this->exists) {
            $this->attributes['name'] = strtolower(str_slug(preg_replace('/\d+/u', '', $value), ''));
        }
    }

    public static function getRoles() {
        if (Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever(self::$key_cache, function() {
            $query = Rol::query();
            $query->orderBy('display_name', 'asc');
            $collection = $query->lists('display_name', 'koi_rol.id');

            $collection->prepend('', '');
            return $collection;
        });
    }

    //Big block of caching functionality.
    public function cachedPermissions($module = null) {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey = "entrust_permissions_for_role_{$this->$rolePrimaryKey}_$module";
        return Cache::tags(config('entrust.permission_role_table'))->remember($cacheKey, config('cache.ttl'), function () use($module) {
            return $this->perms()->join('koi_modulo', 'koi_modulo.id', '=', 'koi_permiso_rol.module_id')->where('koi_modulo.name', $module)->get();
        });
    }

    /**
     * Many-to-Many relations with the permission model.
     * Named "perms" for backwards compatibility. Also because "perms" is short and sweet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms() {
        return $this->belongsToMany(config('entrust.permission'), config('entrust.permission_role_table'), 'role_id', 'permission_id');
    }
}
