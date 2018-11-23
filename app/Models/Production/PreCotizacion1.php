<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

class PreCotizacion1 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['precotizacion1_referencia', 'precotizacion1_fecha', 'precotizacion1_observaciones', 'precotizacion1_suministran'];

    public function isValid($data)
    {
        $rules = [
            'precotizacion1_referencia' => 'required|max:100',
            'precotizacion1_cliente' => 'required',
            'precotizacion1_contacto' => 'required',
            'tcontacto_telefono' => 'required',
  	        'precotizacion1_fecha' => 'required|date_format:Y-m-d',
            'precotizacion1_suministran' => 'max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPreCotizacion($id)
    {
        $query = PreCotizacion1::query();
        $query->select('koi_precotizacion1.*', DB::raw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"), 'u.username as username_elaboro', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono', 't.tercero_nit', DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2) ELSE t.tercero_razonsocial END) as tercero_nombre"), 'tcontacto_email', DB::raw("CONCAT(u.tercero_nombre1,' ',u.tercero_apellido1) AS usuario_nombre"), 't.tercero_formapago', 'uc.username as username_culminada');
        $query->join('koi_tercero as t', 'precotizacion1_cliente', '=', 't.id');
        $query->join('koi_tercero as u', 'precotizacion1_usuario_elaboro', '=', 'u.id');
        $query->leftJoin('koi_tercero as uc', 'precotizacion1_usuario_culminada', '=', 'uc.id');
        $query->join('koi_tcontacto', 'precotizacion1_contacto', '=', 'koi_tcontacto.id');
        $query->where('koi_precotizacion1.id', $id);
        return $query->first();
    }
}
