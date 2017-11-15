<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

use Validator, Cache;

class ActividadOp extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_actividadop';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_actividadop_cache';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['actividadop_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['actividadop_activo'];

    public function isValid($data)
    {
        $rules = [
            'actividadop_nombre' => 'required|max:50'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getActividadesOp()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = ActividadOp::query();
            $query->where('actividadop_activo', true);
            $query->orderBy('actividadop_nombre', 'asc');
            $collection = $query->lists('actividadop_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
