<?php

namespace App\Models\Treasury;

use Illuminate\Database\Eloquent\Model;

use DB;

class Facturap extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_facturap1';

    public $timestamps = false;

    public function storeCuotas($valor)
    {
        $response = new \stdClass();
        $response->success = false;

		// Generar cuotas
		$fecha_cuota = $this->facturap1_fecha;
        $valor_cuota = $valor / $this->facturap1_cuotas;

        for($i=1; $i <= $this->facturap1_cuotas; $i++)
        {
            if (!$fecha_cuota) {
            	$response->error = "No es posible recuperar información de fecha para cuota $i de la factura {$this->facturap1_factura}, por favor verifique la información del asiento o consulte al administrador.";
            	return $response;
            }

            $facturap2 = new Facturap2;
            $facturap2->facturap2_factura = $this->id;
            $facturap2->facturap2_cuota = $i;
            $facturap2->facturap2_vencimiento = $fecha_cuota;
            $facturap2->facturap2_valor = number_format(round($valor_cuota), 2, '.', '');
            $facturap2->facturap2_saldo = number_format(round($valor_cuota), 2, '.', '');
            $facturap2->save();

            // Sumar fechas
            $fecha_cuota = $this->sumaFechas($fecha_cuota, $this->facturap1_periodicidad);
        }

        $response->success = true;
        return $response;
    }

    public function sumaFechas($fecha, $ndias)
    {
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha)) {
            list($ao,$mes,$dia) = explode("/", $fecha);
        }else if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha)) {
            list($ao,$mes,$dia) = explode("-", $fecha);
        }else{
            return NULL;
        }
        $nueva = mktime(0,0,0, $mes,$dia,$ao) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("Y-m-d",$nueva);
        return ($nuevafecha);
    }

    public static function getFacturap($id){
        $query = Facturap::query();
        $query->select('koi_facturap1.*', 'tercero_nit','documento_nombre', 'asiento1_numero','sucursal_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre")
        );
        $query->join('koi_sucursal', 'facturap1_sucursal', '=', 'koi_sucursal.id');
        $query->leftjoin('koi_asiento1', 'facturap1_asiento', '=', 'koi_asiento1.id');
        $query->leftJoin('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
        $query->join('koi_tercero', 'facturap1_tercero', '=', 'koi_tercero.id');
        $query->where('koi_facturap1.id', $id);

        return $query->first();
    }
}
