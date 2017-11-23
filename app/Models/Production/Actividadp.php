<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class Actividadp extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_actividadp';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_actividadp_cache';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['actividadp_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['actividadp_activo'];

    public function isValid($data)
    {
        $rules = [
            'actividadp_nombre' => 'required|max:50'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getActividadesp()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Actividadp::query();
            $query->where('actividadp_activo', true);
            $query->orderBy('actividadp_nombre', 'asc');
            $collection = $query->lists('actividadp_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
