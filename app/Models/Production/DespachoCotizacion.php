<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB, Validator;

class DespachoCotizacion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_despachocotizacion1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['despachoc1_observacion', 'despachoc1_transporte'];

    public function isValid($data)
    {
        $rules = [
            'despachoc1_contacto' => 'required|integer',
            'despachoc1_cotizacion' => 'required|integer',
            'despachoc1_telefono' => 'required',
            'despachoc1_nombre' => 'required',
            'despachoc1_transporte' => 'max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getDespacho($id)
    {
        $query = DespachoCotizacion::query();
        $query->select('koi_despachocotizacion1.*', DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"), 'cotizacion1_referencia', DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as tcontacto_municipio"), DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono', 'tcontacto_celular', 'tcontacto_direccion', 'tercero_nit',
            DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre")
        );
        $query->join('koi_cotizacion1', 'despachoc1_cotizacion', '=', 'koi_cotizacion1.id');
        $query->join('koi_tercero', 'cotizacion1_cliente', '=', 'koi_tercero.id');
        $query->join('koi_tcontacto', 'despachoc1_contacto', '=', 'koi_tcontacto.id');
        $query->leftJoin('koi_municipio', 'tcontacto_municipio', '=', 'koi_municipio.id');
        $query->leftJoin('koi_departamento', 'koi_municipio.departamento_codigo', '=', 'koi_departamento.departamento_codigo');
        $query->where('koi_despachocotizacion1.id', $id);
        return $query->first();
    }
}
