<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Auth, DB, Validator;

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
    protected $fillable = ['tiempop_fecha', 'tiempop_hora_inicio', 'tiempop_hora_fin'];

    /**
    * The attributes that are nullable..
    *
    * @var array
    */
    protected $nullable = ['tiempop_ordenp', 'tiempop_subactividadp'];

    public function isValid($data)
    {
        $rules = [
            'tiempop_areap' => 'required|integer',
            'tiempop_actividadp' => 'required|integer',
            'tiempop_fecha' => 'required|date_format:Y-m-d',
            'tiempop_hora_inicio' => 'required|date_format:H:m',
            'tiempop_hora_fin' => 'required|date_format:H:m',
        ];

        // Validar que hora final no sea menor o igual a la inicial
        if( $data['tiempop_hora_fin'] <= $data['tiempop_hora_inicio'] ){
            $this->errors = 'La hora final no puede ser menor o igual a la incial, por favor consulte al administrador.';
            return false;
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiemposp(){
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
        $query->where('tiempop_tercero', Auth::user()->id);
        $query->orderBy('tiempop_fh_elaboro', 'asc');

        return $query->get();
    }

    public static function getTiempospOrdenp( $ordenp2 ){
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
        $query->orderBy('tiempop_fh_elaboro', 'asc');

        return $query->get();
    }
}
