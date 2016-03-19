<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use DB, Cache;

class Actividad extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_actividad';

    public $timestamps = false;

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
