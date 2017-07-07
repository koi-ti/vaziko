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
    protected $fillable = ['cotizacion1_ano', 'cotizacion1_fecha', 'cotizacion1_entrega', 'cotizacion1_descripcion'];

    public function isValid($data)
    {
        $rules = [
            'cotizacion1_ano' => 'required|integer',
            'cotizacion1_fecha' => 'required',
            'cotizacion1_entrega' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getCotizacion($id){
        $query = Cotizacion1::query();
        $query->select('koi_cotizacion1.*', 'tercero_nit', 'tcontacto_telefono' ,DB::raw("CONCAT(cotizacion1_numero,' - ',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"), DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos ) as tcontacto_nombre"), DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre")
        );
        $query->join('koi_tercero','cotizacion1_cliente','=','koi_tercero.id');
        $query->join('koi_tcontacto','cotizacion1_contacto','=','koi_tcontacto.id');
        $query->where('koi_cotizacion1.id', $id);
        return $query->first();
    }
}
