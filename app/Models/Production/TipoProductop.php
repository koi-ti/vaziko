<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator, Cache;

class TipoProductop extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_tipoproductop';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_typeproduct_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tipoproductop_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['tipoproductop_activo'];

    public function isValid($data)
    {
        $rules = [
            'tipoproductop_nombre' => 'required|max:25',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTypeProductsp()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoProductop::query();
            $query->orderBy('tipoproductop_nombre', 'asc');
            $query->where('tipoproductop_activo', true);
            $collection = $query->lists('tipoproductop_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
