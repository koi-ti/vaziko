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
    protected $fillable = ['name', 'display_name', 'description'];

    public function isValid($data)
    {
        $rules = [
            'name' => 'alpha|unique:koi_rol',
            'display_name' => 'required',
        ];

        if ($this->exists){
            $rules['name'] .= ',name,' . $this->id;
        }else{
            $rules['name'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getRoles()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Rol::query();
            $query->orderBy('display_name', 'asc');
            $collection = $query->lists('display_name', 'koi_rol.id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
