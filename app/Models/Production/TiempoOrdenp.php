<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Auth, DB, Validator;

class TiempoOrdenp extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_tiempoordenp';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tiempoordenp_fecha', 'tiempoordenp_hora_inicio', 'tiempoordenp_hora_fin'];

    public function isValid($data)
    {
        $rules = [
            'tiempoordenp_areap' => 'required|integer',
            'tiempoordenp_actividadop' => 'required|integer',
            'tiempoordenp_subactividadop' => 'required|integer',
            'tiempoordenp_fecha' => 'required|date_format:Y-m-d',
            'tiempoordenp_hora_inicio' => 'required|date_format:H:m',
            'tiempoordenp_hora_fin' => 'required|date_format:H:m',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiempos(){
        $query = TiempoOrdenp::query();
        $query->select('koi_tiempoordenp.*', 'actividadop_nombre', 'subactividadop_nombre', 'areap_nombre', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), DB::raw("
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
        $query->join('koi_ordenproduccion', 'tiempoordenp_ordenp', '=', 'koi_ordenproduccion.id');
        $query->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');
        $query->join('koi_actividadop', 'tiempoordenp_actividadop', '=', 'koi_actividadop.id');
        $query->join('koi_subactividadop', 'tiempoordenp_subactividadop', '=', 'koi_subactividadop.id');
        $query->join('koi_areap', 'tiempoordenp_areap', '=', 'koi_areap.id');
        $query->where('tiempoordenp_tercero', Auth::user()->id);

        return $query->get();
    }
}
