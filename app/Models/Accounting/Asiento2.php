<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use Validator;

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
}
