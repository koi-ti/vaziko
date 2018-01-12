<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

class Ordenp6 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion6';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['orden6_tiempo', 'orden6_valor'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['orden6_areap', 'orden6_nombre'];

    public function isValid($data)
    {
        $rules = [
            'orden6_horas' => 'required|min:0|max:9999|numeric',
            'orden6_minutos' => 'required|min:0|max:59|numeric',
            'orden6_valor' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getOrdenesp6($ordenp2 = null)
    {
        $query = Ordenp6::query();
        $query->select('koi_ordenproduccion6.*', 'areap_nombre');
        $query->leftJoin('koi_areap', 'orden6_areap', '=', 'koi_areap.id');
        $query->where('orden6_orden2', $ordenp2);
        $query->orderBy('areap_nombre', 'asc');
        return $query->get();
    }
}
