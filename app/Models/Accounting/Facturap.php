<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

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
}
