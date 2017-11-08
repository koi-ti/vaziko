<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use Validator, Cache;

class TipoMaterial extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_tipomaterial';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_typemachines_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tipomaterial_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['tipomaterial_activo'];

    public function isValid($data)
    {
        $rules = [
            'tipomaterial_nombre' => 'required|max:25',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiposMaterial()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoMaterial::query();
            $query->orderBy('tipomaterial_nombre', 'asc');
            $query->where('tipomaterial_activo', true);
            $collection = $query->lists('tipomaterial_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
