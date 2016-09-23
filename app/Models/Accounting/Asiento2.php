<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Validator, Auth;

use App\Models\Base\Tercero;

class Asiento2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_asiento2';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'plancuentas_cuenta' => 'required|integer',
            'asiento2_naturaleza' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function store(Asiento $asiento, Array $data)
    {
        $response = new \stdClass();
        $response->success = false;

        // Recuperar cuenta
        $objCuenta = PlanCuenta::where('plancuentas_cuenta', $data['Cuenta'])->first();
        if(!$objCuenta instanceof PlanCuenta) {
            $response->error = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Verifico que no existan subniveles de la cuenta que estoy realizando el asiento
        $result = $objCuenta->validarSubnivelesCuenta();
        if($result != 'OK') {
            $response->error = $result;
            return $response;
        }

        // Recuperar niveles cuenta
        $niveles = PlanCuenta::getNivelesCuenta($objCuenta->plancuentas_cuenta);
        if(!is_array($niveles)) {
            $response->error = "Error al recuperar niveles para la cuenta {$objCuenta->plancuentas_cuenta}.";
            return $response;
        }

        // Validar base
        if( !empty($objCuenta->plancuentas_tasa) && $objCuenta->plancuentas_tasa > 0 && (!isset($data['Base']) || empty($data['Base']) || $data['Base'] == 0) ) {
            $response->error = "Para la cuenta {$objCuenta->plancuentas_cuenta} debe existir base.";
            return $response;
        }

        // Recuperar tercero
        $objTercero = null;
        if(isset($data['Tercero']) && !empty($data['Tercero'])) {
            $objTercero = Tercero::where('tercero_nit', $data['Tercero'])->first();
            if(!$objTercero instanceof Tercero) {
                $response->error = "No es posible recuperar beneficiario {$data['Tercero']}, por favor verifique la información del asiento o consulte al administrador.";
                return $response;
            }
        }

        // Si no require tercero se realiza el asiento a tercero empresa
        if(!$objTercero instanceof Tercero) {
            $objTercero = Tercero::find($asiento->asiento1_beneficiario);
        }

        if(!$objTercero instanceof Tercero) {
            $response->error = "No es posible definir beneficiario, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Recuperar centro costo
        $objCentroCosto = null;
        if(isset($data['CentroCosto']) && !empty($data['CentroCosto'])) {
            $objCentroCosto = CentroCosto::find($data['CentroCosto']);
            if(!$objCentroCosto instanceof CentroCosto) {
                $response->error = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
                return $response;
            }
        }

        // Validar valores
        if($data['Naturaleza'] == 'C') {
            if(!is_numeric($data['Credito']) || $data['Credito'] <= 0) {
                $response->error = "Valor no puede ser menor o igual a 0.";
                return $response;
            }
        }

        if($data['Naturaleza'] == 'D') {
            if(!is_numeric($data['Debito']) || $data['Debito'] <= 0) {
                $response->error = "Valor no puede ser menor o igual a 0 ({$data['Debito']}).";
                return $response;
            }
        }

        // Insert si no existe asiento2
        if(!isset($data['Id']) || empty($data['Id']))
        {
            $this->asiento2_asiento = $asiento->id;
            $this->asiento2_cuenta = $objCuenta->id;
            $this->asiento2_beneficiario = $objTercero->id;
            $this->asiento2_nivel1 = $niveles['nivel1'] ?: 0;
            $this->asiento2_nivel2 = $niveles['nivel2'] ?: 0;
            $this->asiento2_nivel3 = $niveles['nivel3'] ?: 0;
            $this->asiento2_nivel4 = $niveles['nivel4'] ?: 0;
            $this->asiento2_nivel5 = $niveles['nivel5'] ?: 0;
            $this->asiento2_nivel6 = $niveles['nivel6'] ?: 0;
            $this->asiento2_nivel7 = $niveles['nivel7'] ?: 0;
            $this->asiento2_nivel8 = $niveles['nivel8'] ?: 0;
            if($objCentroCosto instanceof CentroCosto) {
                $this->asiento2_centro = $objCentroCosto->id;
            }
            $this->asiento2_detalle = $data['Detalle'] ?: '';
            $this->asiento2_credito = $data['Credito'] ?: 0;
            $this->asiento2_debito = $data['Debito'] ?: 0;
            $this->asiento2_base = $data['Base'] ?: 0;
            $this->save();
        }

        $response->success = true;
        return $response;
    }

    public function movimiento(Request $request)
    {
        $response = new \stdClass();
        $response->success = false;

        // Recuperar cuenta
        $objCuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        if(!$objCuenta instanceof PlanCuenta) {
            $response->error = 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.';
            return $response;
        }

        if($objCuenta->plancuentas_tipo == 'P')
        {
            // Preparar movimiento
            $datamov = [];
            $datamov['Tipo'] = 'FP';
            $datamov['Naturaleza'] = $request->asiento2_naturaleza;
            $datamov['Factura'] = $request->facturap1_factura;

            // Recuperar factura
            $facturap = Facturap::where('facturap1_factura', $request->facturap1_factura)->where('facturap1_tercero', $this->asiento2_beneficiario)->first();
            // Validar naturaleza
            if($request->asiento2_naturaleza == 'D') {
                if(!$facturap instanceof Facturap) {
                    $response->error = 'Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.';
                    return $response;
                }
            }

            if($facturap instanceof Facturap) {
                // En caso de existir factura se afectan cuotas
                $cuotas = Facturap2::where('facturap2_factura', $facturap->id)->get();
                if($cuotas->count() <= 0) {
                    $response->error = "No es posible recuperar cuotas para la factura {$facturap->facturap1_factura}, por favor verifique la información del asiento o consulte al administrador.";
                    return $response;
                }

                // Validar valor distribucion cuotas
                $suma_valor = 0;
                foreach ($cuotas as $cuota) {
                    if($request->has("movimiento_valor_{$cuota->id}")) {
                        $suma_valor += $request->get("movimiento_valor_{$cuota->id}");
                    }
                }
                if($suma_valor != $request->asiento2_valor) {
                    $response->error = "Las suma de los valores debe ser igual al valor del item del asiento: valor {$request->asiento2_valor}, suma $suma_valor, diferencia ".abs($request->asiento2_valor - $suma_valor);
                    return $response;
                }

                // Insertar movimientos
                foreach ($cuotas as $cuota)
                {
                    if($request->has("movimiento_valor_{$cuota->id}"))
                    {
                        $datamov['Cuotas'] = $cuota->id;
                        $datamov['Valor'] = $request->get("movimiento_valor_{$cuota->id}");
                        $datamov['Nuevo'] = false;

                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }
                    }
                }

            }else{
                // En caso no existir factura se crea
                $datamov['Nuevo'] = true;
                $datamov['Valor'] = $request->asiento2_valor;
                $datamov['Sucursal'] = $request->facturap1_sucursal;
                $datamov['Fecha'] = $request->facturap1_vencimiento;
                $datamov['Cuotas'] = $request->facturap1_cuotas;
                $datamov['Periodicidad'] = $request->facturap1_periodicidad;
                $datamov['Detalle'] = $request->facturap1_observaciones;

                $movimiento = new AsientoMovimiento;
                $result = $movimiento->store($this, $datamov);
                if(!$result->success) {
                    $response->error = $result->error;
                    return $response;
                }
            }
        }

        $response->success = true;
        return $response;
    }

    public function movimientos()
    {
        // Recuperar movimientos
        $movements = AsientoMovimiento::where('movimiento_asiento2', $this->id)->get();

        // Actualizar facturap
        if($this->plancuentas_tipo == 'P')
        {
            $movementsfp = $movements->where('movimiento_tipo', 'FP');
            if ($movementsfp->count() <= 0) {
                return "No es posible recuperar movimientos factura proveedor para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
            }

            foreach ($movementsfp as $movefp)
            {
                $facturap = Facturap::where('facturap1_factura', $movefp->movimiento_facturap)->where('facturap1_tercero', $this->asiento2_beneficiario)->first();
                // Nuevo registro en facturap
                if($movefp->movimiento_nuevo == true) {
                    if($facturap instanceof Facturap){
                        return "Ya fue generada la factura proveedor número {$facturap->facturap1_factura} para el tercero {$this->tercero_nit}, por favor verifique la información del asiento o consulte al administrador.";
                    }

                    // Facturap
                    $facturap = new Facturap;
                    $facturap->facturap1_tercero = $this->asiento2_beneficiario;
                    $facturap->facturap1_factura = $movefp->movimiento_facturap;
                    $facturap->facturap1_sucursal = $movefp->movimiento_sucursal;
                    $facturap->facturap1_fecha = $movefp->movimiento_fecha;
                    $facturap->facturap1_cuotas = $movefp->movimiento_cuota;
                    $facturap->facturap1_periodicidad = $movefp->movimiento_periodicidad;
                    $facturap->facturap1_observaciones = $movefp->movimiento_observaciones;
                    $facturap->facturap1_usuario_elaboro = Auth::user()->id;
                    $facturap->facturap1_fecha_elaboro = date('Y-m-d H:m:s');
                    $facturap->save();

                    // Facturap2 (Cuotas)
                    $result = $facturap->storeCuotas($movefp->movimiento_valor);
                    if(!$result->success) {
                        return $result->error;
                    }

                }else{
                    // Actualizar cuota para facturap
                    if(!$facturap instanceof Facturap) {
                        return "No es posible recuperar información factura proveedor para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
                    }

                    $facturap2 = Facturap2::find($movefp->movimiento_cuota);
                    if(!$facturap2 instanceof Facturap2){
                        return "No es posible recuperar información cuota {$movefp->movimiento_cuota}, por favor verifique la información del asiento o consulte al administrador.";
                    }

                    if($this->asiento2_naturaleza == 'C') {
                        // Credito cuota
                        $facturap2->facturap2_saldo = ( $facturap2->facturap2_saldo + $movefp->movimiento_valor );

                    }else if($this->asiento2_naturaleza == 'D') {
                        // Debito cuota
                        $facturap2->facturap2_saldo = ( $facturap2->facturap2_saldo - $movefp->movimiento_valor );
                    }else{
                        return "No es posible recuperar naturaleza para la afectación de la cuota {$movefp->movimiento_cuota}, por favor verifique la información del asiento o consulte al administrador.";
                    }
                    $facturap2->save();
                }


            }
        }
        return 'OK';
    }
}
