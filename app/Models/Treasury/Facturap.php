<?php

namespace App\Models\Treasury;

use Illuminate\Database\Eloquent\Model;

use App\Models\Base\Tercero;
use DB, Carbon\Carbon;

class Facturap extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_facturap1';

    public $timestamps = false;

    public function storeCuotas($valor) {
        $response = new \stdClass();
        $response->success = false;

		// Generar cuotas
		$fecha_cuota = $this->facturap1_fecha;
        $valor_cuota = $valor / $this->facturap1_cuotas;

        for($i=1; $i <= $this->facturap1_cuotas; $i++) {
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
            $fecha_cuota = Carbon::parse($fecha_cuota)->addDays($this->facturap1_periodicidad)->format('Y-m-d H:i:s');
        }

        $response->success = true;
        return $response;
    }

    public static function getFacturap($id) {
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

    /**
    * Function for report history provider
    */
    public static function historyProviderReport(Tercero $tercero, Array $historyClient, $i ) {
        $response = new \stdClass();
        $response->success = false;
        $response->facturaProveedor = [];
        $response->position = 0;

        $query = Facturap::query();
        $query->select('koi_facturap1.*', 'sucursal_nombre', DB::raw('SUM(facturap2_valor) AS valor'), 'asiento1_numero', 'asienton1_numero');
        $query->leftJoin('koi_asiento1', 'facturap1_asiento', '=', 'koi_asiento1.id');
        $query->leftJoin('koi_asienton1', 'koi_asiento1.id', '=', 'koi_asienton1.asienton1_asiento');
        $query->join('koi_sucursal', 'facturap1_sucursal', '=', 'koi_sucursal.id');
        $query->join('koi_facturap2', 'koi_facturap1.id', '=', 'koi_facturap2.facturap2_factura');
        $query->where('facturap1_tercero', $tercero->id);
        $facturaProveedor = $query->get();

        foreach ($facturaProveedor as $value) {
            $historyClient[$i]['numero'] = $value->facturap1_factura;
            $historyClient[$i]['sucursal'] = $value->sucursal_nombre;
            $historyClient[$i]['asiento'] = $value->asiento1_numero;
            $historyClient[$i]['asientonif'] = $value->asienton1_numero;
            $historyClient[$i]['cuota'] = $value->facturap1_cuotas;
            $historyClient[$i]['naturaleza'] = $value->facturap1_cuotas > 1 ? 'C' : 'D';
            $historyClient[$i]['valor'] = $value->valor;
            $historyClient[$i]['elaboro_fh'] = $value->facturap1_fecha;
            $i++;
        }

        $response->facturaProveedor = $historyClient;
        $response->position = $i;
        return $response;
    }
}
