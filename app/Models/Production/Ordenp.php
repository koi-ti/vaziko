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
    protected $fillable = ['orden_referencia', 'orden_fecha_inicio', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_formapago', 'orden_suministran', 'orden_observaciones', 'orden_terminado'];

    public function isValid($data)
    {
        $rules = [
            'orden_referencia' => 'required|max:200',
            'orden_cliente' => 'required',
            'orden_contacto' => 'required',
            'tcontacto_telefono' => 'required',
            'orden_formapago' => 'required',
	        'orden_fecha_inicio' => 'required|date_format:Y-m-d',
	        'orden_suministran' => 'max:200',
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

    public static function getOrden($id)
    {
        $query = Ordenp::query();
        $query->select('koi_ordenproduccion.*', 'u.username as username_elaboro', 'ua.username as username_anulo', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono', 't.tercero_nit', DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2) ELSE t.tercero_razonsocial END) as tercero_nombre"));
        $query->join('koi_tercero as t', 'orden_cliente', '=', 't.id');
        $query->join('koi_tercero as u', 'orden_usuario_elaboro', '=', 'u.id');
        $query->leftJoin('koi_tercero as ua', 'orden_usuario_anulo', '=', 'ua.id');
        $query->join('koi_tcontacto', 'orden_contacto', '=', 'koi_tcontacto.id');
        $query->where('koi_ordenproduccion.id', $id);
        return $query->first();
    }
}
