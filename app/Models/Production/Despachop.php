<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB, Validator;

class Despachop extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_despachop1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'despachop1_observacion', 'despachop1_transporte'
    ];

    public function isValid($data) {
        $rules = [
            'despachop1_contacto' => 'required|integer',
            'despachop1_orden' => 'required|integer',
            'despachop1_telefono' => 'required',
            'despachop1_nombre' => 'required',
            'despachop1_transporte' => 'max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getDespacho($id) {
        $query = Despachop::query();
        $query->select('koi_despachop1.*', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), 'orden_referencia', DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as tcontacto_municipio"), DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono', 'tcontacto_celular', 'tcontacto_direccion', 'tercero_nit',
            DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre")
        );
        $query->join('koi_ordenproduccion', 'despachop1_orden', '=', 'koi_ordenproduccion.id');
        $query->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');
        $query->join('koi_tcontacto', 'despachop1_contacto', '=', 'koi_tcontacto.id');
        $query->leftJoin('koi_municipio', 'tcontacto_municipio', '=', 'koi_municipio.id');
        $query->leftJoin('koi_departamento', 'koi_municipio.departamento_codigo', '=', 'koi_departamento.departamento_codigo');
        $query->where('koi_despachop1.id', $id);
        return $query->first();
    }
}
