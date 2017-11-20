<?php

namespace App\Models\Receivable;

use Illuminate\Database\Eloquent\Model;
use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Accounting\Asiento2, App\Models\Base\Empresa, App\Models\Accounting\Documento, App\Models\Base\Tercero, App\Models\Accounting\CentroCosto, App\Models\Receivable\Factura2;

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

        // Recuperar Hijos
        $factura2 = factura2::where('factura2_factura1', $this->id)->get();
        foreach ($factura2 as $item) {
            // Recuperar ordenp2
            $ordenp2 = Ordenp2::find($item->factura2_orden2);
            if(!$ordenp2 instanceof Ordenp2){
                throw new \Exception('No es posible recuperar la ordenp2.');
            }

            // Recuperar ordenp
            $ordenp = Ordenp::find($ordenp2->orden2_orden);
            if(!$ordenp instanceof Ordenp){
                throw new \Exception('No es posible recuperar la ordenp.');
            }

            $totalF2 = $ordenp2->orden2_total_valor_unitario * $item->factura2_cantidad;

            // Subtotal
            $subtotalobase = [];
            $subtotalobase['Cuenta'] = '41209510';
            $subtotalobase['Tercero'] = $tercero->tercero_nit;
            $subtotalobase['CentroCosto'] = $centrocosto->id;
            $subtotalobase['Detalle'] = '';
            $subtotalobase['Naturaleza'] = 'C';
            $subtotalobase['Base'] = '';
            $subtotalobase['Credito'] = $totalF2;
            $subtotalobase['Debito'] = '';
            $subtotalobase['Orden'] = $ordenp->id;
            $object->cuentas[] = $subtotalobase;
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

        // Iva
        $iva = [];
        $iva['Cuenta'] = '24081010';
        $iva['Tercero'] = $tercero->tercero_nit;
        $iva['CentroCosto'] = '';
        $iva['Detalle'] = '';
        $iva['Naturaleza'] = 'C';
        $iva['Base'] = $this->factura1_subtotal;
        $iva['Credito'] = $this->factura1_iva;
        $iva['Debito'] = '';
        $iva['Orden'] = '';
        $object->cuentas[] = $iva;

        // rtfuente
        if($this->factura1_retefuente > 0){
            $rtfuente = [];
            $rtfuente['Cuenta'] = '13551506';
            $rtfuente['Tercero'] = $tercero->tercero_nit;
            $rtfuente['CentroCosto'] = '';
            $rtfuente['Detalle'] = '';
            $rtfuente['Naturaleza'] = 'D';
            $rtfuente['Base'] = $this->factura1_subtotal;
            $rtfuente['Credito'] = '';
            $rtfuente['Debito'] = $this->factura1_retefuente;
            $rtfuente['Orden'] = '';
            $object->cuentas[] = $rtfuente;
        }

        // rtiva
        if($this->factura1_reteiva > 0){
            $rtiva = [];
            $rtiva['Cuenta'] = '13551709';
            $rtiva['Tercero'] = $tercero->tercero_nit;
            $rtiva['CentroCosto'] = '';
            $rtiva['Detalle'] = '';
            $rtiva['Naturaleza'] = 'D';
            $rtiva['Base'] = $this->factura1_subtotal;
            $rtiva['Credito'] = '';
            $rtiva['Debito'] = $this->factura1_reteiva;
            $rtiva['Orden'] = '';
            $object->cuentas[] = $rtiva;
        }

        // rtica
        if($this->factura1_reteica > 0){
            $rtica = [];
            $rtica['Cuenta'] = '13551801';
            $rtica['Tercero'] = $tercero->tercero_nit;
            $rtica['CentroCosto'] = '';
            $rtica['Detalle'] = '';
            $rtica['Naturaleza'] = 'D';
            $rtica['Base'] = $this->factura1_subtotal;
            $rtica['Credito'] = '';
            $rtica['Debito'] = $this->factura1_reteica;
            $rtica['Orden'] = '';
            $object->cuentas[] = $rtica;
        }

        // clientenacionales
        $clientenacionales = [];
        $clientenacionales['Cuenta'] = '130505';
        $clientenacionales['Tercero'] = $tercero->tercero_nit;
        $clientenacionales['CentroCosto'] = '';
        $clientenacionales['Detalle'] = '';
        $clientenacionales['Naturaleza'] = 'D';
        $clientenacionales['Base'] = '';
        $clientenacionales['Credito'] = '';
        $clientenacionales['Debito'] = $this->factura1_total;
        $clientenacionales['Orden'] = '';
        $object->cuentas[] = $clientenacionales;

        return $object;
    }
}
