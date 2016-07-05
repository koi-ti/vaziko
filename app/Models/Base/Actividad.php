<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use DB, Cache, Validator;

class Actividad extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_actividad';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['actividad_codigo', 'actividad_nombre', 'actividad_tarifa', 'actividad_categoria'];

    public function isValid($data)
    {
        $rules = [
            'actividad_codigo' => 'required|max:11|min:1|unique:koi_actividad',
            'actividad_nombre' => 'required',
            'actividad_tarifa' => 'required|numeric|max:100|min:0'
        ];

        if ($this->exists){
            $rules['actividad_codigo'] .= ',actividad_codigo,' . $this->id;
        }else{
            $rules['actividad_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getActividades()
    {
        if (Cache::has('_actividades')) {
            return Cache::get('_actividades');    
        }

        return Cache::rememberForever('_actividades', function() {
            $query = Actividad::query();
            $query->select('id', DB::raw("UPPER(CONCAT(actividad_codigo, ' - ', actividad_nombre)) as actividad_nombre"));
            $query->orderby('actividad_codigo', 'asc');
            $collection = $query->lists('actividad_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
