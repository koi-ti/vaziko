<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, DB;

class Cotizacion1 extends BaseModel
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
    protected $fillable = ['cotizacion1_referencia', 'cotizacion1_fecha_inicio', 'cotizacion1_iva', 'cotizacion1_suministran', 'cotizacion1_observaciones', 'cotizacion1_terminado', 'cotizacion1_formapago'];

    /**
     * The attributes that are mass nullable.
     *
     * @var array
     */
    protected $nullable = ['cotizacion1_precotizacion'];

    public function isValid($data)
    {
        $rules = [
            'cotizacion1_referencia' => 'required|max:200',
            'cotizacion1_cliente' => 'required',
            'cotizacion1_contacto' => 'required',
            'tcontacto_telefono' => 'required',
            'cotizacion1_iva' => 'integer|min:0|max:19',
            'cotizacion1_formapago' => "required|exists:koi_tercero,tercero_formapago,tercero_nit,{$data['cotizacion1_cliente']}",
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
        $query->select('koi_cotizacion1.*', 't.tercero_telefono1', 't.tercero_telefono2', 't.tercero_celular', DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"), DB::raw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"),'u.username as username_elaboro', 'ua.username as username_anulo', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono', 't.tercero_nit', DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2) ELSE t.tercero_razonsocial END) as tercero_nombre"), 't.tercero_direccion', 't.tercero_dir_nomenclatura', 't.tercero_municipio', 'tcontacto_email', 'municipio_nombre', DB::raw("CONCAT(u.tercero_nombre1,' ',u.tercero_apellido1) AS usuario_nombre"));
        $query->join('koi_tercero as t', 'cotizacion1_cliente', '=', 't.id');
        $query->join('koi_tercero as u', 'cotizacion1_usuario_elaboro', '=', 'u.id');
        $query->leftJoin('koi_tercero as ua', 'cotizacion1_usuario_anulo', '=', 'ua.id');
        $query->leftJoin('koi_municipio', 't.tercero_municipio', '=', 'koi_municipio.id');
        $query->leftJoin('koi_precotizacion1', 'cotizacion1_precotizacion', '=', 'koi_precotizacion1.id');
        $query->join('koi_tcontacto', 'cotizacion1_contacto', '=', 'koi_tcontacto.id');
        $query->where('koi_cotizacion1.id', $id);
        return $query->first();
    }

    public static function getExportCotizacion($codigo)
    {
        $query = Cotizacion1::query();
        $query->select('koi_cotizacion1.*', 't.tercero_telefono1', 't.tercero_telefono2', 't.tercero_celular', DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"), 'u.username as username_elaboro', 'ua.username as username_anulo', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono', 't.tercero_nit', DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2) ELSE t.tercero_razonsocial END) as tercero_nombre"), 't.tercero_direccion', 't.tercero_dir_nomenclatura', 't.tercero_municipio', 'tcontacto_email', 'municipio_nombre', DB::raw("CONCAT(u.tercero_nombre1,' ',u.tercero_apellido1) AS usuario_nombre"));
        $query->join('koi_tercero as t', 'cotizacion1_cliente', '=', 't.id');
        $query->join('koi_tercero as u', 'cotizacion1_usuario_elaboro', '=', 'u.id');
        $query->leftJoin('koi_tercero as ua', 'cotizacion1_usuario_anulo', '=', 'ua.id');
        $query->leftJoin('koi_municipio', 't.tercero_municipio', '=', 'koi_municipio.id');
        $query->join('koi_tcontacto', 'cotizacion1_contacto', '=', 'koi_tcontacto.id');
        $query->whereRaw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) = '$codigo'");
        return $query->first();
    }

    public function scopeSchedule () {
        return self::selectRaw("SUM((cotizacion2_cantidad - cotizacion2_facturado) * cotizacion2_total_valor_unitario) as total")
                            ->join('koi_cotizacion2', 'koi_cotizacion1.id', '=', 'koi_cotizacion2.cotizacion2_cotizacion')
                            ->whereRaw('(cotizacion2_cantidad - cotizacion2_facturado) <> 0');
    }

    public function scopeAbiertas ($query) {
        return $query->where('cotizacion1_abierta', true);
    }

    public function productos () {
        return $this->hasMany('App\Models\Production\Cotizacion2', 'cotizacion2_cotizacion', 'id');
    }
}
