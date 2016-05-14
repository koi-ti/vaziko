<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use Validator, Cache;

class CentroCosto extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_centrocosto';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['centrocosto_codigo', 'centrocosto_nombre'];

    public function isValid($data)
    {
        $rules = [
            'centrocosto_codigo' => 'required|max:20|min:1|unique:koi_centrocosto',
            'centrocosto_nombre' => 'required|max:200'
        ];

        if ($this->exists){
            $rules['centrocosto_codigo'] .= ',centrocosto_codigo,' . $this->id;
        }else{
            $rules['centrocosto_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function setCentrocostoNombreAttribute($name)
    {
        $this->attributes['centrocosto_nombre'] = strtoupper($name);
    }

    public static function getCentrosCosto()
    {
        if (Cache::has('_centroscosto')) {
            return Cache::get('_centroscosto');    
        }

        return Cache::rememberForever('_centroscosto', function() {
            $query = CentroCosto::query();
            $query->select('id', 'centrocosto_nombre');
            $query->orderby('centrocosto_nombre', 'asc');
            $collection = $query->lists('centrocosto_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
