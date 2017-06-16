<?php

namespace App\Models\Receivable;

use Illuminate\Database\Eloquent\Model;
use App\Models\Production\Ordenp2, App\Models\Accounting\Asiento2;

use DB;

class Factura1 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_factura1';

    public $timestamps = false;

    public function storeFactura2($children, $fatherOrdenp, Factura1 $factura)
    {
        $response = new \stdClass();
        $response->success = false;

        $subtotal = 0;
        foreach ($children as $item) {
            if ($item->movimiento_item < 0) {
                $response->error = "La cantidad del item no puede ser menor a 0, por favor verifique la información del asiento o consulte al administrador.";
                return $response;
            }

            // Insertar factura
            $factura2 = new Factura2;
            $factura2->factura2_factura1 = $factura->id;
            $factura2->factura2_orden2 = $item->movimiento_ordenp2;

            // Recuperar Asiento2
            $detalle = Asiento2::find($item->movimiento_asiento2)->select('koi_asiento2.*','plancuentas_cuenta', 'tercero_nit')->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id')->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id')->first();

            // Recuperar ordenp2
            $ordenp2 = Ordenp2::getOrdenpf2($item->movimiento_ordenp2);
            if ($item->movimiento_item > $ordenp2->orden2_cantidad){
                $response->error = "El saldo ingresado en la cuenta {$detalle->plancuentas_cuenta} del cliente {$detalle->tercero_nit} es de {$item->movimiento_item} y la cantidad disponible es {$ordenp2->orden2_cantidad}, por favor verifique la información o consulte al administrador.";
                return $response;   
            }

            $subtotal += $item->movimiento_item * $ordenp2->orden2_precio_venta;

            $factura2->factura2_cantidad = $item->movimiento_item;
            $factura2->save();

            $ordenp2->orden2_facturado = $ordenp2->orden2_facturado + $item->movimiento_item;
			$ordenp2->save();
        }

        $iva = $subtotal * 0.19;
        $total = $subtotal + $iva;

        $factura->factura1_subtotal = round($subtotal);
        $factura->factura1_iva = round($iva);
        $factura->factura1_total = round($total);
        $factura->save();

        $response->success = true;
        return $response;
    }

    public function storeFactura4(Factura1 $factura)
    {
        $response = new \stdClass();
        $response->success = false;

        if ($factura->factura1_cuotas > 0) {
            $valor = $factura->factura1_total / $factura->factura1_cuotas;
            $fecha = $factura->factura1_fecha_vencimiento; 

            for ($i=1; $i <= $factura->factura1_cuotas; $i++) {
                $factura4 = new Factura4;
                $factura4->factura4_factura1 = $factura->id;
                $factura4->factura4_cuota = $i;
                $factura4->factura4_valor = round($valor);
                $factura4->factura4_saldo = round($valor);
                $factura4->factura4_vencimiento = $fecha;
                $fechavencimiento = date('Y-m-d',strtotime('+1 months', strtotime($fecha)));
                $fecha = $fechavencimiento;
                $factura4->save();
            }
        }
        
        $response->success = true;
        return $response;
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
        $query->select('koi_factura1.*','puntoventa_nombre','puntoventa_prefijo', 'orden_referencia', 'municipio_nombre','t.tercero_telefono1', 't.tercero_nit', 't.tercero_direccion', 't.tercero_telefono1', 't.tercero_telefono2', 't.tercero_celular',
                DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), DB::raw("(CASE WHEN t.tercero_persona = 'N'
                    THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                            (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                        )
                    ELSE t.tercero_razonsocial END)
                AS tercero_nombre"), DB::raw("
                    CONCAT(
                        (CASE WHEN to.tercero_persona = 'N'
                            THEN CONCAT(to.tercero_nombre1,' ',to.tercero_nombre2,' ',to.tercero_apellido1,' ',to.tercero_apellido2,
                                (CASE WHEN (to.tercero_razonsocial IS NOT NULL AND to.tercero_razonsocial != '') THEN CONCAT(' - ', to.tercero_razonsocial) ELSE '' END)
                            )
                            ELSE to.tercero_razonsocial
                        END),
                    ' (', orden_referencia ,')'
                    ) AS orden_beneficiario"
                )
            );
        $query->join('koi_tercero as t', 'factura1_tercero', '=', 't.id');
        $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');
        $query->join('koi_ordenproduccion', 'factura1_orden', '=', 'koi_ordenproduccion.id');
        $query->join('koi_municipio', 'tercero_municipio', '=', 'koi_municipio.id');
        $query->join('koi_tercero as to', 'orden_cliente', '=', 'to.id');
        $query->where('koi_factura1.id',$id);
        return $query->first();
    }
}
