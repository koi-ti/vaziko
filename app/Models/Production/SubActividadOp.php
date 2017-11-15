<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class SubActividadOp extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_subactividadop';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_subactividadop_cache';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subactividadop_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['subactividadop_activo'];

    public function isValid($data)
    {
        $rules = [
            'subactividadop_nombre' => 'required|max:50',
            'subactividadop_actividad' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getSubActividadesop()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = SubActividadOp::query();
            $query->orderBy('subactividadop_nombre', 'asc');
            $collection = $query->lists('subactividadop_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }

    /**
     * Get the attributes for the actividadesop.
     */
    public function actividadop()
    {
        return $this->hasOne('App\Models\Production\ActividadOp', 'id' , 'subactividadop_actividad');
    }
}
