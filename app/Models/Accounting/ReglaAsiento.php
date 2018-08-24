<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use App\Models\Receivable\Factura1;
use App\Models\Base\Tercero;
use Validator, DB;
class ReglaAsiento extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'koi_regla_asiento';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'factura_numero' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    public static function createAsiento($document, $codigo, $beneficiario, $anular=false)
    {
        $object = new \stdClass();
        $object->data = [];
        $object->dataNif = [];
        $object->cuentas = [];
        $object->success = false;

        /* Variables que seran igualadas en el switch */
        $asiento1_id_documentos = '';
        $asiento1_beneficiario = '';

        // Recuperar documento
        $documento = Documento::where('documento_codigo', $codigo)->first();
        if(!$documento instanceof Documento){
            $object->error = "No es posible recuperar el prefijo $codigo en los documentos contables.";
            return $object;
        }

        // Recuperar tercero
        $tercero = Tercero::find($beneficiario);
        if(!$tercero instanceof Tercero){
            $object->error = "No es posible recuperar el tercero.";
            return $object;
        }

        // Nit
        $asiento1_beneficiario = $tercero->tercero_nit;

        //  Evalua el tipo de documento
        switch ($documento->documento_codigo) {
            // Factura de venta
            case 'FS':
                $factura = Factura1::find($document);
                if(!$factura instanceof Factura1){
                    $object->error = "No es posible recuperar $documento->documento_nombre.";
                    return $object;
                }
                // Id Documento
                $asiento1_id_documentos = $factura->id;
                $numeroDocumento = $factura->factura1_numero;

                // Prepare Data asiento
                $object->data = [
                    'asiento1_mes' => (int) date('m', strtotime($factura->factura1_fecha)),
                    'asiento1_ano' => (int) date('Y', strtotime($factura->factura1_fecha)),
                    'asiento1_dia' => (int) date('d', strtotime($factura->factura1_fecha)),
                    'asiento1_numero' => $documento->documento_consecutivo + 1,
                    'asiento1_folder' => $documento->documento_folder,
                    'asiento1_documento' => $documento->id,
                    'asiento1_documentos' => $documento->documento_codigo,
                    'asiento1_id_documentos' => $asiento1_id_documentos,
                    'asiento1_beneficiario' => $asiento1_beneficiario,
                ];

                // Prepare Data Asiento nif
                if ($documento->documento_nif) {
                    $object->dataNif = [
                        'asienton1_mes' => (int) date('m', strtotime($factura->factura1_fecha)),
                        'asienton1_ano' => (int) date('Y', strtotime($factura->factura1_fecha)),
                        'asienton1_dia' => (int) date('d', strtotime($factura->factura1_fecha)),
                        'asienton1_numero' => $documento->documento_consecutivo + 1,
                        'asienton1_folder' => $documento->documento_folder,
                        'asienton1_documento' => $documento->id,
                        'asienton1_documentos' => $documento->documento_codigo,
                        'asienton1_id_documentos' => $asiento1_id_documentos,
                        'asienton1_beneficiario' => $asiento1_beneficiario,
                    ];
                }
            break;
        }

        // Consulto reglas
        $rules_sql ="
            SELECT * FROM koi_regla_asiento WHERE regla_documento = '$documento->documento_codigo'
        ";
        $query = ReglaAsiento::where('regla_documento', $documento->documento_codigo)->get();
        // Itero registro de la tabla reglas
        foreach ($query as $item) {
            // Armo sql que satisface cada regla
            $sql = "
                $item->regla_select, plancuentas_nombre $item->regla_tabla $item->regla_union INNER JOIN koi_plancuentas ON (plancuentas_cuenta = $item->regla_cuenta)  $item->regla_condicion factura1_numero = $numeroDocumento  $item->regla_grupo";

            $query_rule = DB::select($sql);
            foreach ($query_rule as $value) {
                // Preparo data
                if ($value->valor != 0) {
                    //  Prepara para devolucion si es necesario
                    if ( $anular ){
                        $naturaleza = ($item->regla_naturaleza == 'C') ? 'D' : 'C';
                        $credito = ($item->regla_naturaleza == 'C') ? 0 : $value->valor;
                        $debito = ($item->regla_naturaleza == 'D') ? 0 : $value->valor;
                    } else {
                        $naturaleza = $item->regla_naturaleza;
                        $credito = ($item->regla_naturaleza == 'C') ? $value->valor: 0;
                        $debito = ($item->regla_naturaleza == 'D') ? $value->valor: 0;
                    }

                    // Prepare detalle asiento
                    $detalle = [];
                    $detalle['Cuenta'] = $item->regla_cuenta;
                    $detalle['Cuenta_Nombre'] = $value->plancuentas_nombre;
                    $detalle['Tercero'] = $value->nit;
                    $detalle['CentroCosto'] = $value->centrocosto;
                    $detalle['CentroCosto_Nombre'] = $value->centrocosto_nombre;
                    $detalle['Detalle'] = '';
                    $detalle['Naturaleza'] = $naturaleza;
                    $detalle['Base'] = $value->base;
                    $detalle['Credito'] = $credito;
                    $detalle['Debito'] = $debito;
                    $detalle['Orden'] = $value->orden;
                    $object->cuentas[] = $detalle;
                }
            }
        }
        $object->success = true;
        return $object;
    }
}
