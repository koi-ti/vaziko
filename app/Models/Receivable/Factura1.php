<?php

namespace App\Models\Receivable;

use Illuminate\Database\Eloquent\Model;
use App\Models\Receivable\Factura1, App\Models\Receivable\Factura4;
use DB, Validator;

class Factura1 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_factura1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['factura1_fecha', 'factura1_fecha_vencimiento', 'factura1_cuotas'];

    public function isValid($data)
    {
        $rules = [
            'factura1_fecha' => 'required',
            'factura1_numero' => 'unique:koi_factura1',
            'factura1_prefijo' => 'unique:koi_factura1',
            'factura1_fecha_vencimiento' => 'required',
            'factura1_cuotas' => 'required|integer|min:1',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            // Validar Carritos
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese al menos un producto a facturar.';
                return false;
            }

            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function actualizarFactura4($movchildren, $naturaleza){
        $response = new \stdClass();
        $response->success = false;

        foreach ($movchildren as $item) {
            $factura = Factura4::find($item->movimiento_factura4);
            if($naturaleza == 'D'){
                $factura->factura4_saldo = $factura->factura4_saldo + $item->movimiento_valor;
            }else{
                $factura->factura4_saldo = $factura->factura4_saldo - $item->movimiento_valor;
            }
            $factura->save();
        }

        $response->success = true;
        return $response;
    }

    public static function getFactura($id){
        $query = Factura1::query();
        $query->select('koi_factura1.*','puntoventa_nombre','puntoventa_prefijo','documento_nombre', 'asiento1_numero','tercero_telefono1', 'tercero_nit', 'tercero_direccion', 'tercero_municipio', 'tercero_telefono1', 'tercero_telefono2', 'tercero_celular',
                DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as municipio_nombre"), DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
        $query->join('koi_tercero as t', 'factura1_tercero', '=', 't.id');
        $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');
        $query->leftJoin('koi_asiento1', 'factura1_asiento', '=', 'koi_asiento1.id');
        $query->leftJoin('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
        $query->leftJoin('koi_municipio','tercero_municipio','=', 'koi_municipio.id');
        $query->leftJoin('koi_departamento', 'koi_municipio.departamento_codigo', '=', 'koi_departamento.departamento_codigo');
        $query->where('koi_factura1.id',$id);

        return $query->first();
    }
}
