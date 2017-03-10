<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_modulo';

    public $timestamps = false;

    public static function getModules()
    {
    	$query = Modulo::query();
        $query->select('koi_modulo.id', 'display_name');
        $query->where('nivel1', '!=', '0');
        $query->where('nivel2', '=', '0');
        $query->where('nivel3', '=', '0');
        $query->where('nivel4', '=', '0');
        $query->orderBy('nivel1', 'asc');
        $fathers = $query->get();

        $data = [];
        foreach ($fathers as $fathers) {
            $object = new \stdClass();
            $object->id = $fathers->id;
            $object->display_name = $fathers->display_name;

            $query = Modulo::query();
            $query->select('koi_modulo.id', 'display_name', 'nivel1', 'nivel2', 'nivel3');
            $query->where('nivel1', '=', $fathers->id);
            $query->where('nivel2', '!=', '0');
            $query->where('nivel3', '=', '0');
            $query->where('nivel4', '=', '0');
            $query->orderBy('nivel2', 'asc');
            $object->childrens = $query->get();

            $data[] = $object;
        }

        return $data;
   	}
}
