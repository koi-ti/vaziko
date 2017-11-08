<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator, DB;

class Cotizacion1 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cotizacion1_referencia', 'cotizacion1_fecha_inicio', 'cotizacion1_iva', 'cotizacion1_suministran', 'cotizacion1_observaciones', 'cotizacion1_terminado'];

    public function isValid($data)
    {
        $rules = [
            'cotizacion1_referencia' => 'required|max:200',
            'cotizacion1_cliente' => 'required',
            'cotizacion1_contacto' => 'required',
            'tcontacto_telefono' => 'required',
            'cotizacion1_iva' => 'integer|min:0|max:19',
	        'cotizacion1_fecha_inicio' => 'required|date_format:Y-m-d',
	        'cotizacion1_suministran' => 'max:200',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getCotizacion($id)
    {
        $query = Cotizacion1::query();
        $query->select('koi_cotizacion1.*', DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"), 'u.username as username_elaboro', 'ua.username as username_anulo', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono', 't.tercero_nit', DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2) ELSE t.tercero_razonsocial END) as tercero_nombre"), 't.tercero_direccion', 't.tercero_dir_nomenclatura', 't.tercero_municipio');
        $query->join('koi_tercero as t', 'cotizacion1_cliente', '=', 't.id');
        $query->join('koi_tercero as u', 'cotizacion1_usuario_elaboro', '=', 'u.id');
        $query->leftJoin('koi_tercero as ua', 'cotizacion1_usuario_anulo', '=', 'ua.id');
        $query->join('koi_tcontacto', 'cotizacion1_contacto', '=', 'koi_tcontacto.id');
        $query->where('koi_cotizacion1.id', $id);
        return $query->first();
    }
}
