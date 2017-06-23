<?php

namespace App\Models\Receivable;

use Illuminate\Database\Eloquent\Model;
use App\Models\Production\Ordenp2, App\Models\Accounting\Asiento2, App\Models\Base\Empresa, App\Models\Accounting\Documento, App\Models\Base\Tercero, App\Models\Accounting\CentroCosto;

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
            'factura1_cuotas' => 'required|integer',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
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
        $query->select('koi_factura1.*','puntoventa_nombre','puntoventa_prefijo','documento_nombre', 'asiento1_numero','orden_referencia','t.tercero_telefono1', 't.tercero_nit', 't.tercero_direccion', 't.tercero_telefono1', 't.tercero_telefono2', 't.tercero_celular',
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
        $query->leftJoin('koi_asiento1', 'factura1_asiento', '=', 'koi_asiento1.id');
        $query->leftJoin('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
        $query->join('koi_tercero as to', 'orden_cliente', '=', 'to.id');
        $query->where('koi_factura1.id',$id);

        return $query->first();
    }

    public function prepararAsiento(){
        $object = new \stdClass();
        $object->data = [];
        $object->cuentas = [];

        // Recuperar documento
        $documento = Documento::where('documento_codigo', 'FS')->first();
        if(!$documento instanceof Documento){
            throw new \Exception('No es posible recuperar el documento.');
        }
        
        // Recuperar tercero
        $tercero = Tercero::find($this->factura1_tercero);
        if(!$tercero instanceof Tercero){
            throw new \Exception('No es posible recuperar el tercero.');
        }

        // Recuperar centroCosto
        $centrocosto = CentroCosto::where('centrocosto_codigo', 'OP')->first();
        if(!$centrocosto instanceof CentroCosto){
            throw new \Exception('No es posible recuperar el centro costo.');
        }

        $object->data = [
            'asiento1_mes' => (Int) date('m'),
            'asiento1_ano' => (Int) date('Y'),
            'asiento1_dia' => (Int) date('d'),
            'asiento1_numero' => $documento->documento_consecutivo + 1,
            'asiento1_folder' => $documento->documento_folder,
            'asiento1_documento' => $documento->id,
            'asiento1_documentos' => 'FACT',
            'asiento1_id_documentos' => $this->id,
            'asiento1_beneficiario' => $tercero->tercero_nit,
        ];

        // Subtotal
        $subtotalobase = [];
        $subtotalobase['Cuenta'] = '41209510';
        $subtotalobase['Tercero'] = $tercero->tercero_nit;
        $subtotalobase['CentroCosto'] = $centrocosto->id;
        $subtotalobase['Detalle'] = '';
        $subtotalobase['Naturaleza'] = 'C';
        $subtotalobase['Base'] = '';
        $subtotalobase['Credito'] = $this->factura1_subtotal;
        $subtotalobase['Debito'] = '';
        $subtotalobase['Orden'] = $this->factura1_orden;
        $object->cuentas[] = $subtotalobase;

        // Iva
        $iva = [];
        $iva['Cuenta'] = '24081010';
        $iva['Tercero'] = $tercero->tercero_nit;
        $iva['CentroCosto'] = $centrocosto->id;
        $iva['Detalle'] = '';
        $iva['Naturaleza'] = 'C';
        $iva['Base'] = $this->factura1_subtotal;
        $iva['Credito'] = $this->factura1_iva;
        $iva['Debito'] = '';
        $iva['Orden'] = $this->factura1_orden;
        $object->cuentas[] = $iva;

        // rtfuente
        if($this->factura1_retefuente > 0){
            $rtfuente = [];
            $rtfuente['Cuenta'] = '13551506';
            $rtfuente['Tercero'] = $tercero->tercero_nit;
            $rtfuente['CentroCosto'] = $centrocosto->id;
            $rtfuente['Detalle'] = '';
            $rtfuente['Naturaleza'] = 'D';
            $rtfuente['Base'] = $this->factura1_subtotal;
            $rtfuente['Credito'] = '';
            $rtfuente['Debito'] = $this->factura1_retefuente;
            $rtfuente['Orden'] = $this->factura1_orden;
            $object->cuentas[] = $rtfuente;
        }

        // rtiva
        if($this->factura1_reteiva > 0){
            $rtiva = [];
            $rtiva['Cuenta'] = '13551709';
            $rtiva['Tercero'] = $tercero->tercero_nit;
            $rtiva['CentroCosto'] = $centrocosto->id;
            $rtiva['Detalle'] = '';
            $rtiva['Naturaleza'] = 'D';
            $rtiva['Base'] = $this->factura1_subtotal;
            $rtiva['Credito'] = '';
            $rtiva['Debito'] = $this->factura1_reteiva;
            $rtiva['Orden'] = $this->factura1_orden;
            $object->cuentas[] = $rtiva;
        }

        // rtica
        if($this->factura1_reteica > 0){
            $rtica = [];
            $rtica['Cuenta'] = '13551801';
            $rtica['Tercero'] = $tercero->tercero_nit;
            $rtica['CentroCosto'] = $centrocosto->id;
            $rtica['Detalle'] = '';
            $rtica['Naturaleza'] = 'D';
            $rtica['Base'] = $this->factura1_subtotal;
            $rtica['Credito'] = '';
            $rtica['Debito'] = $this->factura1_reteica;
            $rtica['Orden'] = $this->factura1_orden;
            $object->cuentas[] = $rtica;
        }

        // clientenacionales
        $clientenacionales = [];
        $clientenacionales['Cuenta'] = '130505';
        $clientenacionales['Tercero'] = $tercero->tercero_nit;
        $clientenacionales['CentroCosto'] = $centrocosto->id;
        $clientenacionales['Detalle'] = '';
        $clientenacionales['Naturaleza'] = 'D';
        $clientenacionales['Base'] = '';
        $clientenacionales['Credito'] = '';
        $clientenacionales['Debito'] = $this->factura1_total;
        $clientenacionales['Orden'] = $this->factura1_orden;
        $object->cuentas[] = $clientenacionales;

        return $object;
    }
}
