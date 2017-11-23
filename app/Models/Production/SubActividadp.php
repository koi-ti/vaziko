<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class SubActividadp extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_subactividadp';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_subactividadp_cache';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subactividadp_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['subactividadp_activo'];

    public function isValid($data)
    {
        $rules = [
            'subactividadp_nombre' => 'required|max:50',
            'subactividadp_actividadp' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getSubActividadesp()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = SubActividadp::query();
            $query->orderBy('subactividadp_nombre', 'asc');
            $collection = $query->lists('subactividadp_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }

    /**
     * Get the attributes for the actividadesop.
     */
    public function actividadp()
    {
        return $this->hasOne('App\Models\Production\Actividadp', 'id' , 'subactividadp_actividadp');
    }
}
