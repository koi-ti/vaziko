<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator, DB;

class Ordenp extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['orden_referencia', 'orden_fecha_inicio', 'orden_fecha_entrega', 'orden_observaciones', 'orden_terminado'];

    public function isValid($data)
    {
        $rules = [
            'orden_referencia' => 'required|max:200',
            'orden_cliente' => 'required',
            'orden_contacto' => 'required',
	        'orden_fecha_inicio' => 'required|date_format:Y-m-d',
	        'orden_fecha_entrega' => 'required|date_format:Y-m-d',
	        'orden_hora_entrega' => 'required|date_format:H:m'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
