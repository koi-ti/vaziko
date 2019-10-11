<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Validator, DB, Carbon\Carbon;

class Ordenp extends BaseModel
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
    protected $fillable = [
        'orden_referencia', 'orden_fecha_inicio', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_formapago', 'orden_iva', 'orden_suministran', 'orden_observaciones', 'orden_terminado', 'orden_observaciones_imagen', 'orden_fecha_recogida1', 'orden_fecha_recogida2', 'orden_hora_recogida1', 'orden_hora_recogida2'
    ];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = [
        'orden_estado_recogida1', 'orden_estado_recogida2'
    ];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = [
        'orden_cotizacion', 'orden_formapago', 'orden_fecha_recogida1', 'orden_fecha_recogida2', 'orden_hora_recogida1', 'orden_hora_recogida2'
    ];

    public function isValid ($data) {
        $rules = [
            'orden_referencia' => 'required|max:200',
            'orden_cliente' => 'required',
            'orden_contacto' => 'required',
            'tcontacto_telefono' => 'required',
            'orden_formapago' => "required|exists:koi_tercero,tercero_formapago,tercero_nit,{$data['orden_cliente']}",
            'orden_iva' => 'integer|min:0|max:19',
  	        'orden_fecha_inicio' => 'required|date_format:Y-m-d',
  	        'orden_suministran' => 'max:200',
            'orden_fecha_entrega' => 'required',
            'orden_hora_entrega' => 'required|date_format:H:m',
            'orden_fecha_recogida1' => 'date_format:Y-m-d',
            'orden_fecha_recogida2' => 'date_format:Y-m-d'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            if (isset($data['orden_estado_recogida1']) && $data['orden_estado_recogida1'] == true && ($data['orden_fecha_recogida1'] == '' || $data['orden_hora_recogida1'] == '')) {
                $this->errors = "La fecha y/o hora de recogida #1 esta incorrecta.";
                return false;
            }

            if (isset($data['orden_estado_recogida2']) && $data['orden_estado_recogida2'] == true && ($data['orden_fecha_recogida2'] == '' || $data['orden_hora_recogida2'] == '')) {
                $this->errors = "La fecha y/o hora de recogida #2 esta incorrecta.";
                return false;
            }

            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function pendintesDespacho () {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.id as id', 'orden2_cantidad', 'orden2_saldo', 'orden2_entregado',
            DB::raw("
                CASE
                WHEN productop_3d != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') 3D(',
                        COALESCE(orden2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                        COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                        COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                        COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') C(',
                        COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                ELSE
                        CONCAT(
                            COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                END AS productop_nombre
            ")
        );
        $query->join('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->where('orden2_orden', $this->id);
        $query->where('orden2_saldo', '>', 0);
        $query->orderBy('koi_ordenproduccion2.id', 'desc');
        return $query->get();
    }

    public function paraFacturar () {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.id as id', DB::raw('(orden2_cantidad - orden2_facturado) as orden2_cantidad'), 'orden2_facturado', 'orden2_precio_venta',
            DB::raw("
                CASE
                WHEN productop_3d != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') 3D(',
                        COALESCE(orden2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                        COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                        COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                        COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') C(',
                        COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                ELSE
                        CONCAT(
                            COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                END AS productop_nombre
            ")
        );
        $query->join('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->where('orden2_orden', $this->id);
        $query->whereRaw('(orden2_cantidad - orden2_facturado) > 0');
        $query->orderBy('koi_ordenproduccion2.id', 'asc');
        return $query->get();
    }

    public static function getOrden ($id) {
        $query = Ordenp::query();
        $query->select('koi_ordenproduccion.*', 'cotizacion1_precotizacion', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), DB::raw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"), DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"), 'u.username as username_elaboro', 'ua.username as username_anulo', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono', 't.tercero_nit', DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2) ELSE t.tercero_razonsocial END) as tercero_nombre"), 't.tercero_direccion', 't.tercero_dir_nomenclatura', 't.tercero_municipio');
        $query->join('koi_tercero as t', 'orden_cliente', '=', 't.id');
        $query->join('koi_tercero as u', 'orden_usuario_elaboro', '=', 'u.id');
        $query->leftJoin('koi_tercero as ua', 'orden_usuario_anulo', '=', 'ua.id');
        $query->leftJoin('koi_cotizacion1', 'orden_cotizacion', '=', 'koi_cotizacion1.id');
        $query->leftJoin('koi_precotizacion1', 'cotizacion1_precotizacion', '=', 'koi_precotizacion1.id');
        $query->join('koi_tcontacto', 'orden_contacto', '=', 'koi_tcontacto.id');
        $query->where('koi_ordenproduccion.id', $id);
        return $query->first();
    }

    public static function getOrdenp ($codigo) {
        $query = Ordenp::query();
        $query->select('koi_ordenproduccion.id as id', 'orden_culminada', 'orden_anulada', 'orden_abierta', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), DB::raw("
            CONCAT(
                (CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                    ELSE tercero_razonsocial
                END),
            ' (', orden_referencia ,')'
            ) AS tercero_nombre"
        ));
        $query->leftJoin('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');
        $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '$codigo'");
        return $query->first();
    }

    public function scopeSchedule () {
        return self::selectRaw("SUM((orden2_cantidad - orden2_facturado) * orden2_total_valor_unitario) as total")
                            ->join('koi_ordenproduccion2', 'koi_ordenproduccion.id', '=', 'koi_ordenproduccion2.orden2_orden')
                            ->whereRaw('(orden2_cantidad - orden2_facturado) <> 0');
    }

    public function scopeAbiertas ($query) {
        return $query->where('orden_abierta', true);
    }

    public function scopeCerradas ($query) {
        return $query->where('orden_abierta', false);
    }

    public function scopeCulminadas ($query) {
        return $query->where('orden_culminada', true);
    }

    public function scopeIncumplidas ($query) {
        return $query->whereRaw("CONCAT(orden_fecha_entrega, ' ',orden_hora_entrega) <= '".Carbon::now()."'");
    }

    public function scopeRecogidas ($query) {
        return $query->whereNotNull('orden_fecha_recogida1')
                    ->orWhereNotNull('orden_fecha_recogida2');
    }

    public function scopeRemisionadas ($query) {
        return $query->where('orden2_saldo', 0);
    }

    public function scopeOrden ($query, $remisionada = null) {
        $query->select('koi_ordenproduccion.id', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), 'orden_numero', 'orden_ano', 'orden_fecha_elaboro as orden_fecha', 'orden_fecha_inicio', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_anulada', 'orden_abierta', 'orden_culminada',
            DB::raw("
                CONCAT(
                    (CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                        ELSE tercero_razonsocial
                    END),
                ' (', orden_referencia ,')'
                ) AS tercero_nombre"
            )
        );
        $query->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');
        $query->with(['detalle' => function ($q) use ($remisionada){
            $q->detalle();
            if ($remisionada) {
                $q->where('orden2_saldo', 0);
            }
        }]);
        $query->orderBy('orden_ano', 'desc');
        return $query;
    }

    public function detalle () {
        return $this->hasMany(Ordenp2::class, 'orden2_orden', 'id');
    }
}
