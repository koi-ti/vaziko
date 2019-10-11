<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Validator, Carbon\Carbon;

class Tiempop extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_tiempop';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tiempop_fecha', 'tiempop_hora_inicio', 'tiempop_hora_fin'
    ];

    /**
    * The attributes that are nullable..
    *
    * @var array
    */
    protected $nullable = [
        'tiempop_ordenp', 'tiempop_subactividadp'
    ];

    public function isValid($data) {
        $rules = [
            'tiempop_areap' => 'required|integer',
            'tiempop_actividadp' => 'required|integer',
            'tiempop_fecha' => 'required|date_format:Y-m-d'
        ];

        // Validar que hora final no sea menor o igual a la inicial
        $data['tiempop_hora_inicio'] = Carbon::parse("{$data['tiempop_hora_inicio']}:00")->toTimeString();
        $data['tiempop_hora_fin'] = Carbon::parse("{$data['tiempop_hora_fin']}:00")->toTimeString();

        if ($data['tiempop_hora_fin'] <= $data['tiempop_hora_inicio']) {
            $this->errors = 'La hora de inicio no puede ser mayor o igual a la final.';
            return false;
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    // Consulta modulo tiemposp
    public static function getTiemposp() {
        $query = Tiempop::query();
        $query->select('koi_tiempop.*', 'actividadp_nombre', 'subactividadp_nombre', 'areap_nombre', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), DB::raw("
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
        $query->leftJoin('koi_ordenproduccion', 'tiempop_ordenp', '=', 'koi_ordenproduccion.id');
        $query->leftJoin('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');
        $query->leftJoin('koi_subactividadp', 'tiempop_subactividadp', '=', 'koi_subactividadp.id');
        $query->join('koi_actividadp', 'tiempop_actividadp', '=', 'koi_actividadp.id');
        $query->join('koi_areap', 'tiempop_areap', '=', 'koi_areap.id');
        $query->where('tiempop_tercero', auth()->user()->id);
        $query->orderBy('koi_tiempop.id', 'desc');

        return $query->get();
    }

    // Consulta de detalle ordenp
    public static function getTiempospOrdenp($ordenp2) {
        $query = Tiempop::query();
        $query->select('koi_tiempop.*', 'actividadp_nombre', 'subactividadp_nombre', 'areap_nombre',  DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre")
        );
        $query->leftJoin('koi_subactividadp', 'tiempop_subactividadp', '=', 'koi_subactividadp.id');
        $query->join('koi_tercero', 'tiempop_tercero', '=', 'koi_tercero.id');
        $query->join('koi_actividadp', 'tiempop_actividadp', '=', 'koi_actividadp.id');
        $query->join('koi_areap', 'tiempop_areap', '=', 'koi_areap.id');
        $query->where('tiempop_ordenp', $ordenp2);
        $query->orderBy('koi_tiempop.id', 'desc');

        return $query->get();
    }
}
