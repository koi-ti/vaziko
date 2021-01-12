<?php

namespace App\Models\Receivable;

use Illuminate\Database\Eloquent\Model;
use App\Models\Receivable\Factura1, App\Models\Receivable\Factura4, App\Models\Accounting\Documento, App\Models\Base\Tercero, App\Models\Base\PuntoVenta, App\Models\Accounting\CentroCosto;
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
    protected $fillable = [
        'factura1_fecha', 'factura1_fecha_vencimiento', 'factura1_cuotas'
    ];

    public function isValid($data) {
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
            if (!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese al menos un producto a facturar.';
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function actualizarFactura4($movchildren, $naturaleza) {
        $response = new \stdClass();
        $response->success = false;

        foreach ($movchildren as $item) {
            $factura = Factura4::find($item->movimiento_factura4);
            if ($naturaleza == 'D') {
                $factura->factura4_saldo -= $item->movimiento_valor;
            } else {
                $factura->factura4_saldo += $item->movimiento_valor;
            }
            $factura->save();
        }

        $response->success = true;
        return $response;
    }

    public static function getFactura($id) {
        $query = Factura1::query();
        $query->select('koi_factura1.*', 'puntoventa_nombre', 'puntoventa_prefijo', 'documento_nombre', 'aprobado.asiento1_numero as asiento_numero', 'tercero_telefono1', 'tercero_nit', 'tercero_direccion', 'tercero_municipio', 'tercero_telefono1', 'tercero_telefono2', 'tercero_celular',
                DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as municipio_nombre"), DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
        $query->join('koi_tercero as t', 'factura1_tercero', '=', 't.id');
        $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');
        $query->leftJoin('koi_asiento1 as aprobado', 'factura1_asiento', '=', 'aprobado.id');
        $query->leftJoin('koi_documento', 'aprobado.asiento1_documento', '=', 'koi_documento.id');
        $query->leftJoin('koi_municipio','tercero_municipio','=', 'koi_municipio.id');
        $query->leftJoin('koi_departamento', 'koi_municipio.departamento_codigo', '=', 'koi_departamento.departamento_codigo');
        $query->where('koi_factura1.id',$id);
        return $query->first();
    }

    public function prepararAsiento() {
        $object = new \stdClass();
        $object->data = [];
        $object->dataNif = [];
        $object->cuentas = [];

        // Recuperar Punto de Venta
        $puntoventa = PuntoVenta::find($this->factura1_puntoventa);
        if (!$puntoventa instanceof PuntoVenta) {
            throw new \Exception('No es posible recuperar el punto de venta.');
        }

        // Recuperar documento
        if ($puntoventa->puntoventa_documento) {
            $documento = Documento::find($puntoventa->puntoventa_documento);
        } else {
            $documento = Documento::where('documento_codigo', 'FS')->first();
        }
        
        if (!$documento instanceof Documento) {
            throw new \Exception('No es posible recuperar el documento.');
        }

        // Recuperar tercero
        $tercero = Tercero::find($this->factura1_tercero);
        if (!$tercero instanceof Tercero) {
            throw new \Exception('No es posible recuperar el tercero.');
        }

        // Recuperar centroCosto
        $centrocosto = CentroCosto::where('centrocosto_codigo', 'OP')->first();
        if (!$centrocosto instanceof CentroCosto) {
            throw new \Exception('No es posible recuperar el centro costo.');
        }

        // Recuperar Hijos
        $facturas2 = factura2::select('koi_factura2.*', 'orden2_orden')->where('factura2_factura1', $this->id)->join('koi_ordenproduccion2', 'factura2_orden2', '=', 'koi_ordenproduccion2.id')->get();
        foreach ($facturas2 as $factura2) {
            // Subtotal
            $subtotalobase = [];
            $subtotalobase['Cuenta'] = '41209510';
            $subtotalobase['Tercero'] = $tercero->tercero_nit;
            $subtotalobase['CentroCosto'] = $centrocosto->id;
            $subtotalobase['Detalle'] = '';
            $subtotalobase['Naturaleza'] = 'C';
            $subtotalobase['Base'] = '';
            $subtotalobase['Credito'] = round($factura2->factura2_producto_valor_unitario * $factura2->factura2_cantidad);
            $subtotalobase['Debito'] = '';
            $subtotalobase['Orden'] = $factura2->orden2_orden;
            $object->cuentas[] = $subtotalobase;
        }

        $object->data = [
            'asiento1_mes' => (Int) date('m', strtotime($this->factura1_fecha)),
            'asiento1_ano' => (Int) date('Y', strtotime($this->factura1_fecha)),
            'asiento1_dia' => (Int) date('d', strtotime($this->factura1_fecha)),
            'asiento1_numero' => $documento->documento_consecutivo + 1,
            'asiento1_folder' => $documento->documento_folder,
            'asiento1_documento' => $documento->id,
            'asiento1_documentos' => 'FACT',
            'asiento1_id_documentos' => $this->id,
            'asiento1_beneficiario' => $tercero->tercero_nit,
        ];

        // Prepare Data nif
        if ($documento->documento_nif) {
            $object->dataNif = [
                'asienton1_mes' => (Int) date('m', strtotime($this->factura1_fecha)),
                'asienton1_ano' => (Int) date('Y', strtotime($this->factura1_fecha)),
                'asienton1_dia' => (Int) date('d', strtotime($this->factura1_fecha)),
                'asienton1_numero' => $documento->documento_consecutivo + 1,
                'asienton1_folder' => $documento->documento_folder,
                'asienton1_documento' => $documento->id,
                'asienton1_documentos' => 'FACT',
                'asienton1_id_documentos' => $this->id,
                'asienton1_beneficiario' => $tercero->tercero_nit,
            ];
        }

        // Iva
        $iva = [];
        $iva['Cuenta'] = '24081010';
        $iva['Tercero'] = $tercero->tercero_nit;
        $iva['CentroCosto'] = '';
        $iva['Detalle'] = '';
        $iva['Naturaleza'] = 'C';
        $iva['Base'] = $this->factura1_subtotal;
        $iva['Credito'] = round($this->factura1_iva);
        $iva['Debito'] = '';
        $iva['Orden'] = '';
        $object->cuentas[] = $iva;

        // rtfuente
        if ($this->factura1_retefuente > 0) {
            $rtfuente = [];
            $rtfuente['Cuenta'] = '13551506';
            $rtfuente['Tercero'] = $tercero->tercero_nit;
            $rtfuente['CentroCosto'] = '';
            $rtfuente['Detalle'] = '';
            $rtfuente['Naturaleza'] = 'D';
            $rtfuente['Base'] = $this->factura1_subtotal;
            $rtfuente['Credito'] = '';
            $rtfuente['Debito'] = round($this->factura1_retefuente);
            $rtfuente['Orden'] = '';
            $object->cuentas[] = $rtfuente;
        }

        // rtiva
        if ($this->factura1_reteiva > 0) {
            $rtiva = [];
            $rtiva['Cuenta'] = '13551709';
            $rtiva['Tercero'] = $tercero->tercero_nit;
            $rtiva['CentroCosto'] = '';
            $rtiva['Detalle'] = '';
            $rtiva['Naturaleza'] = 'D';
            $rtiva['Base'] = $this->factura1_subtotal;
            $rtiva['Credito'] = '';
            $rtiva['Debito'] = round($this->factura1_reteiva);
            $rtiva['Orden'] = '';
            $object->cuentas[] = $rtiva;
        }

        // rtica
        if ($this->factura1_reteica > 0) {
            $rtica = [];
            $rtica['Cuenta'] = '13551801';
            $rtica['Tercero'] = $tercero->tercero_nit;
            $rtica['CentroCosto'] = '';
            $rtica['Detalle'] = '';
            $rtica['Naturaleza'] = 'D';
            $rtica['Base'] = $this->factura1_subtotal;
            $rtica['Credito'] = '';
            $rtica['Debito'] = round($this->factura1_reteica);
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
        $clientenacionales['Debito'] = round($this->factura1_total);
        $clientenacionales['Orden'] = '';
        $object->cuentas[] = $clientenacionales;

        return $object;
    }

    public function puntoventa () {
        return $this->hasOne('App\Models\Base\PuntoVenta', 'id', 'factura1_puntoventa');
    }

    public function cuotas () {
        return $this->hasMany('App\Models\Receivable\Factura4', 'factura4_factura1', 'id');
    }
}
