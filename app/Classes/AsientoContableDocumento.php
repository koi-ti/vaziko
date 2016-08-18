<?php

namespace App\Classes;

use Auth, DB;

use App\Models\Accounting\PlanCuenta, App\Models\Accounting\Documento, App\Models\Base\Tercero, App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\CentroCosto, App\Models\Accounting\SaldoContable, App\Models\Accounting\SaldoTercero, App\Models\Base\Empresa;

class AsientoContableDocumento {

	public $asiento;
	private $beneficiario;
	private $documento;
	private $asiento_cuentas = [];
	public $asiento_error = NULL;
	public $preguardado = false;
	private $empresa;

	function __construct(Array $data, Asiento $asiento = null)
	{
		// Cuando se edita termina un asiento PRE-GUARDADO ya existe $asiento
		if(!$asiento instanceof Asiento) {
   	 		$asiento = new Asiento;
		}
		$this->asiento = $asiento;

        if (!$this->asiento->isValid($data)) {
        	$this->asiento_error = $this->asiento->errors;
        }
        $this->asiento->fill($data);

        // Recuperar tercero
        $this->beneficiario = Tercero::where('tercero_nit', $data['asiento1_beneficiario'])->first();
        if(!$this->beneficiario instanceof Tercero) {
        	$this->asiento_error = "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
        	return;
        }

        // Recuerar documento
        $this->documento = Documento::where('id', $this->asiento->asiento1_documento)->first();
        if(!$this->documento instanceof Documento) {
            $this->asiento_error = "No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.";
            return;
        }

        // Generar consecutivo, en caso de confirmar PRE-GUARDADO no actualizar consecutivo en documento
		if($this->asiento->asiento1_preguardado == false) {
	        // Recuperar consecutivo
	        if($this->documento->documento_tipo_consecutivo == 'A'){
	        	$this->asiento->asiento1_numero = $this->documento->documento_consecutivo + 1;
	        }

	        // Validar consecutivo
	        if (!intval($this->asiento->asiento1_numero) || $this->asiento->asiento1_numero <= 0){
				$this->asiento_error = "No es posible recuperar el consecutivo documento ({$this->asiento->asiento1_numero}), por favor verifique la información del asiento o consulte al administrador.";
				return;
			}

			$asiento = Asiento::where('asiento1_numero', $this->asiento->asiento1_numero)->where('asiento1_documento', $this->documento->id)->first();
			if($asiento instanceof Asiento) {
	            $this->asiento_error = "Ya existe asiento con el numero {$this->asiento->asiento1_numero} para el documento {$this->documento->documento_nombre}, por favor verifique la información del asiento o consulte al administrador.";
	            return;
	        }
	  	}

        // Validar Pre-Guardado
        if(isset($data['preguardado']) && $data['preguardado'] == true) {
        	$this->preguardado = true;
        }

        // Recuperar empresa
		$this->empresa = Empresa::getEmpresa();
		if(!$this->empresa instanceof Empresa) {
        	$this->asiento_error = "No es posible recuperar información empresa, por favor consulte al administrador.";
			return;
		}

        // Validar cierre contable
		// if( $this->asiento1_fecha <= $empresa->empresa_fecha_contabilidad){
		// 	$this->asiento_error = 'La fecha que intenta realizar el asiento: '.$this->asiento1_fecha.' no esta PERMITIDA. Es menor a la del cierre contable :'.$empresa->empresa_fecha_contabilidad;
		// }
	}

	function asientoCuentas($cuentas = null, $num = null, $item = 1)
	{
		if (!is_array( $cuentas )) {
			return 'El parámetro pasado como cuentas no es un array '.$cuentas;
		}
		$this->asiento_cuentas = $cuentas;

		// Preguardado asiento contable FALSE no valida sumas
		if($this->preguardado == false) {
			// Valido que las sumas sean Iguales
			$result = $this->validarSumas();
			if ($result != 'OK'){
				return $result;
			}
		}

		foreach ($this->asiento_cuentas as $cuenta)
		{
			// Recuperar cuenta
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $cuenta['Cuenta'])->first();
            if(!$objCuenta instanceof PlanCuenta) {
                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador (asientoCuentas). ";
            }

			// Verifico que no existan subniveles de la cuenta que estoy realizando el asiento
        	$result = $objCuenta->validarSubnivelesCuenta();
	        if($result != 'OK') {
				return $result;
			}
		}
		return 'OK';
	}

	function validarSumas()
	{
		$debito = $credito = 0;
		foreach ($this->asiento_cuentas as $cuenta)
		{
			// Valido que las variables hayan sido correctamente inicializadas
			if (!isset($cuenta['Cuenta'])){
				return "Error al recuperar cuenta contable.";
			}

	        $niveles = PlanCuenta::getNivelesCuenta($cuenta['Cuenta']);
	        if(!is_array($niveles)) {
				return "Error al recuperar niveles para la cuenta {$cuenta['Cuenta']}.";
	        }

			// Verifico que existan todos los niveles de la cuenta
			$srnivel = "<br/>N2: {$niveles['nivel2']}, N3: {$niveles['nivel3']}, N4: {$niveles['nivel4']}, N5: {$niveles['nivel5']}, N6: {$niveles['nivel6']}, N7: {$niveles['nivel7']}, N8: {$niveles['nivel8']}";

			if($niveles['nivel2'] == 0 && ($niveles['nivel3'] != 0 || $niveles['nivel4'] != 0 || $niveles['nivel5'] != 0 || $niveles['nivel6'] != 0 || $niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 2 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el Asiento. $srnivel";

			}else if($niveles['nivel3'] == 0 && ($niveles['nivel4'] != 0 || $niveles['nivel5'] != 0 || $niveles['nivel6'] != 0 || $niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 3 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el Asiento. $srnivel";

			}else if($niveles['nivel4'] == 0 && ($niveles['nivel5'] != 0 || $niveles['nivel6'] != 0 || $niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 4 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el Asiento. $srnivel";

			}else if($niveles['nivel5'] == 0 && ($niveles['nivel6'] != 0 || $niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 5 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el Asiento. $srnivel";

			}else if($niveles['nivel6'] == 0 && ($niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 6 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el Asiento. $srnivel";

			}else if($niveles['nivel7'] == 0 && $niveles['nivel8'] != 0) {
				return "El nivel 7 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el Asiento. $srnivel";
			}

			if (floatval($cuenta['Debito']) > 0 && $cuenta['Credito'] == 0) {
				$debito += round($cuenta['Debito'],2);

			}else if (floatval($cuenta['Credito']) > 0 && $cuenta['Debito'] == 0) {
				$credito += round($cuenta['Credito'],2);

			}else{
				return "Los registros de crédito y débito de la cuenta {$cuenta['Cuenta']} no son correctos. Valor crédito {$cuenta['Credito']}, Valor débito {$cuenta['Debito']}.";
			}
		}

		$resta = round(abs($credito-$debito),2);
		if ($resta>0.01 || ($credito === 0 && $debito === 0)) {
			return 'Las sumas de créditos como de débitos no son iguales: créditos '.$credito.', débitos '.$debito.', diferencia '.abs($debito-$credito);
		}
		return 'OK';
	}

	public function insertarAsiento()
	{
		// Valido registros de asiento2, en caso de confirmar PRE-GUARDADO eliminar registros existentes
		$asientos = Asiento2::where('asiento2_asiento', $this->asiento->id)->get();
		if($asientos->count() > 0 || $this->asiento->asiento1_preguardado) {
			Asiento2::where('asiento2_asiento', $this->asiento->id)->delete();
		}

		// Actualizar consecutivo, en caso de confirmar PRE-GUARDADO no actualizar consecutivo en documento
		if($this->asiento->asiento1_preguardado == false){
			$this->documento->documento_consecutivo = $this->asiento->asiento1_numero;
			$this->documento->save();

		}

		// Asiento
		$this->asiento->asiento1_preguardado = $this->preguardado;
		$this->asiento->asiento1_beneficiario = $this->beneficiario->id;
		$this->asiento->asiento1_usuario_elaboro = Auth::user()->id;
		$this->asiento->asiento1_fecha_elaboro = date('Y-m-d H:m:s');
		$this->asiento->save();

		foreach ($this->asiento_cuentas as $cuenta)
		{
	        // Recuperar cuenta
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $cuenta['Cuenta'])->first();
            if(!$objCuenta instanceof PlanCuenta) {
                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador (1. insertarAsiento).";
            }

            // Recuperar niveles cuenta
			$niveles = PlanCuenta::getNivelesCuenta($cuenta['Cuenta']);
	        if(!is_array($niveles)) {
				return "Error al recuperar niveles para la cuenta {$cuenta['Cuenta']}.";
	        }

	        // Validar base
			if( !empty($objCuenta->plancuentas_tasa) && $objCuenta->plancuentas_tasa > 0 && (!isset($cuenta['Base']) || empty($cuenta['Base']) || $cuenta['Base'] == 0) ) {
				return "Para la cuenta {$objCuenta->plancuentas_cuenta} debe existir base.";
			}

		    // Recuperar tercero
		    $objTercero = null;
	        if(isset($cuenta['Tercero']) && !empty($cuenta['Tercero'])) {
			    $objTercero = Tercero::find($cuenta['Tercero']);
			    if(!$objTercero instanceof Tercero) {
			        return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
			    }
		   	}

		   	// Validacion plancuentas_tercero requiere tercero inactiva
		   	// if($objCuenta->plancuentas_tercero) {
                // if(!$objTercero instanceof Tercero) {
                    // return response()->json(['success' => false, 'errors' => 'La cuenta requiere información de tercero beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                // }
            // }

            // Si no require tercero se realiza el asiento a tercero empresa
            if(!$objTercero instanceof Tercero) {
            	$objTercero = $this->beneficiario;
			}

			if(!$objTercero instanceof Tercero) {
                return response()->json(['success' => false, 'errors' => 'No es posible definir beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
            }

            // Recuperar centro costo
	        $objCentroCosto = null;
	        if(isset($cuenta['CentroCosto']) && !empty($cuenta['CentroCosto'])) {
	            $objCentroCosto = CentroCosto::find($cuenta['CentroCosto']);
	            if(!$objCentroCosto instanceof CentroCosto) {
	                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador (2. insertarAsiento).";
	            }
	        }

			$asiento2 = new Asiento2;
			$asiento2->asiento2_asiento = $this->asiento->id;
	        $asiento2->asiento2_beneficiario = $objTercero->id;
		    $asiento2->asiento2_cuenta = $objCuenta->id;
			$asiento2->asiento2_nivel1 = $niveles['nivel1'] ?: 0;
			$asiento2->asiento2_nivel2 = $niveles['nivel2'] ?: 0;
			$asiento2->asiento2_nivel3 = $niveles['nivel3'] ?: 0;
			$asiento2->asiento2_nivel4 = $niveles['nivel4'] ?: 0;
			$asiento2->asiento2_nivel5 = $niveles['nivel5'] ?: 0;
			$asiento2->asiento2_nivel6 = $niveles['nivel6'] ?: 0;
			$asiento2->asiento2_nivel7 = $niveles['nivel7'] ?: 0;
			$asiento2->asiento2_nivel8 = $niveles['nivel8'] ?: 0;

		    if($objCentroCosto instanceof CentroCosto) {
		        $asiento2->asiento2_centro = $objCentroCosto->id;
		    }
		    $asiento2->asiento2_credito = $cuenta['Credito'] ?: 0;
		    $asiento2->asiento2_debito = $cuenta['Debito'] ?: 0;
		    $asiento2->asiento2_base = $cuenta['Base'] ?: 0;
		    $asiento2->asiento2_detalle = $cuenta['Detalle'] ?: '';
		    $asiento2->save();

    		// Preguardado asiento contable FALSE realiza movimientos contables
		    if($this->preguardado == false) {
			    // Mayorizacion de saldos Contables
	            $result = $this->saldosContables($objCuenta, $cuenta['Naturaleza'], $cuenta['Debito'], $cuenta['Credito'], $this->asiento->asiento1_mes, $this->asiento->asiento1_ano);
				if($result != 'OK') {
					return $result;
				}

				// Mayorizacion de saldos x tercero
				$result = $this->saldosTerceros($objCuenta, $objTercero, $cuenta['Naturaleza'], $cuenta['Debito'], $cuenta['Credito'], $this->asiento->asiento1_mes, $this->asiento->asiento1_ano);
				if($result != 'OK') {
					return $result;
				}
			}
		}
		return 'OK';
	}

	public function saldosTerceros(PlanCuenta $cuenta, Tercero $tercero, $naturaleza, $debito = 0, $credito = 0, $xmes, $xano)
	{
        // Recuperar registro saldos terceros
		$objSaldoTercero = SaldoTercero::where('saldosterceros_cuenta', $cuenta->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_ano', $this->asiento->asiento1_ano)->where('saldosterceros_mes', $this->asiento->asiento1_mes)->first();
    	if(!$objSaldoTercero instanceof SaldoTercero) {

			 // Recuperar niveles cuenta
			$niveles = PlanCuenta::getNivelesCuenta($cuenta->plancuentas_cuenta);
	        if(!is_array($niveles)) {
				return "Error al recuperar niveles para la cuenta {$cuenta->plancuentas_cuenta}.";
	        }

    		// Crear registro en saldos terceros
    		$objSaldoTercero = new SaldoTercero;
    		$objSaldoTercero->saldosterceros_cuenta = $cuenta->id;
    		$objSaldoTercero->saldosterceros_tercero = $tercero->id;
    		$objSaldoTercero->saldosterceros_ano = $this->asiento->asiento1_ano;
    		$objSaldoTercero->saldosterceros_mes = $this->asiento->asiento1_mes;
    		$objSaldoTercero->saldosterceros_nivel1 = $niveles['nivel1'] ?: 0;
    		$objSaldoTercero->saldosterceros_nivel2 = $niveles['nivel2'] ?: 0;
    		$objSaldoTercero->saldosterceros_nivel3 = $niveles['nivel3'] ?: 0;
    		$objSaldoTercero->saldosterceros_nivel4 = $niveles['nivel4'] ?: 0;
    		$objSaldoTercero->saldosterceros_nivel5 = $niveles['nivel5'] ?: 0;
    		$objSaldoTercero->saldosterceros_nivel6 = $niveles['nivel6'] ?: 0;
    		$objSaldoTercero->saldosterceros_nivel7 = $niveles['nivel7'] ?: 0;
    		$objSaldoTercero->saldosterceros_nivel8 = $niveles['nivel8'] ?: 0;
    		$objSaldoTercero->saldosterceros_debito_mes = $debito ?: 0;
    		$objSaldoTercero->saldosterceros_credito_mes = $credito ?: 0;
    		$objSaldoTercero->save();

		}else{

			// Debito
    		if ($debito){
				$saldo = ($objSaldoTercero->saldosterceros_debito_mes ? $objSaldoTercero->saldosterceros_debito_mes : 0) + $debito;
				$objSaldoTercero->saldosterceros_debito_mes = $saldo;
				$objSaldoTercero->save();
    		}

    		// Credito
    		if($credito){
				$saldo = ($objSaldoTercero->saldosterceros_credito_mes ? $objSaldoTercero->saldosterceros_credito_mes : 0) + $credito;
				$objSaldoTercero->saldosterceros_credito_mes = $saldo;
				$objSaldoTercero->save();
    		}
		}

    	// Saldos iniciales
    	while (true)
		{
			if($xmes == 1) {
				$xmes2 = 13;
				$xano2 = $xano - 1;
			}else{
				$xmes2 = $xmes - 1;
				$xano2 = $xano;
			}

			$sql = "
				SELECT DISTINCT s1.saldosterceros_cuenta, s1.saldosterceros_tercero,
				(select (CASE when plancuentas_naturaleza = 'D'
						THEN (s2.saldosterceros_debito_inicial-s2.saldosterceros_credito_inicial)
						ELSE (s2.saldosterceros_credito_inicial-s2.saldosterceros_debito_inicial)
						END)
					FROM koi_saldosterceros as s2
					WHERE s2.saldosterceros_mes = $xmes2
					and s2.saldosterceros_ano = $xano2
					and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
					and s2.saldosterceros_tercero = s1.saldosterceros_tercero
				)as inicial,
				(select SUM(s2.saldosterceros_debito_mes)
					FROM koi_saldosterceros as s2
					WHERE s2.saldosterceros_mes = $xmes
					and s2.saldosterceros_ano = $xano
					and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
					and s2.saldosterceros_tercero = s1.saldosterceros_tercero
				)as debitomes,
				(select SUM(s2.saldosterceros_credito_mes)
					FROM koi_saldosterceros as s2
					WHERE s2.saldosterceros_mes = $xmes
					and s2.saldosterceros_ano = $xano
					and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
					and s2.saldosterceros_tercero = s1.saldosterceros_tercero
				)as creditomes,
				plancuentas_cuenta, plancuentas_naturaleza, plancuentas_nombre

				FROM koi_saldosterceros as s1, koi_plancuentas
				WHERE (s1.saldosterceros_mes = $xmes OR s1.saldosterceros_mes = $xmes2)";
			if($xano == $xano2) {
				$sql.=" and( s1.saldosterceros_ano = $xano)";
			}else{
				$sql.=" and( s1.saldosterceros_ano = $xano OR s1.saldosterceros_ano =".$xano2.")";
			}

			$sql .= "
				and s1.saldosterceros_cuenta = koi_plancuentas.id
				and s1.saldosterceros_cuenta = {$cuenta->id}
				ORDER BY s1.saldosterceros_cuenta ASC, s1.saldosterceros_tercero ASC";
			$arSaldos = DB::select($sql);
	        if(!is_array($arSaldos)) {
				return "Se genero un error al consultar los saldos tercero, por favor verifique la información del asiento o consulte al administrador.";
			}

	        foreach ($arSaldos as $saldo)
	        {
				if($saldo->plancuentas_naturaleza == 'D') {
					$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
					// return "Cuenta {$saldo->plancuentas_cuenta} N {$saldo->plancuentas_naturaleza} Tercero $tercero->tercero_nit Valor {$saldo->inicial} + ({$saldo->debitomes} - {$saldo->creditomes}) = $final";
				}else if($saldo->plancuentas_naturaleza == 'C') {
					$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
					// return "Cuenta {$saldo->plancuentas_cuenta} N {$saldo->plancuentas_naturaleza} Tercero $tercero->tercero_nit Valor {$saldo->inicial} + ({$saldo->creditomes} - {$saldo->debitomes}) = $final";
				}

				// Recuperar registro saldos terceros
				$objSaldoTercero = SaldoTercero::where('saldosterceros_cuenta', $cuenta->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_ano', $xano)->where('saldosterceros_mes', $xmes)->first();
				if(!$objSaldoTercero instanceof SaldoTercero) {

		            // Recuperar niveles cuenta
					$niveles = PlanCuenta::getNivelesCuenta($saldo->plancuentas_cuenta);
			        if(!is_array($niveles)) {
						return "Error al recuperar niveles para la cuenta {$saldo->plancuentas_cuenta}, saldos iniciales.";
			        }

		    		$objSaldoTercero = new SaldoTercero;
		    		$objSaldoTercero->saldosterceros_cuenta = $cuenta->id;
		    		$objSaldoTercero->saldosterceros_tercero = $tercero->id;
		    		$objSaldoTercero->saldosterceros_ano = $xano;
		    		$objSaldoTercero->saldosterceros_mes = $xmes;
		    		$objSaldoTercero->saldosterceros_nivel1 = $niveles['nivel1'] ?: 0;
		    		$objSaldoTercero->saldosterceros_nivel2 = $niveles['nivel2'] ?: 0;
		    		$objSaldoTercero->saldosterceros_nivel3 = $niveles['nivel3'] ?: 0;
		    		$objSaldoTercero->saldosterceros_nivel4 = $niveles['nivel4'] ?: 0;
		    		$objSaldoTercero->saldosterceros_nivel5 = $niveles['nivel5'] ?: 0;
		    		$objSaldoTercero->saldosterceros_nivel6 = $niveles['nivel6'] ?: 0;
		    		$objSaldoTercero->saldosterceros_nivel7 = $niveles['nivel7'] ?: 0;
		    		$objSaldoTercero->saldosterceros_nivel8 = $niveles['nivel8'] ?: 0;
				}

				// Actualizo saldo iniciales
				if($saldo->plancuentas_naturaleza == 'D') {
					$objSaldoTercero->saldosterceros_debito_inicial = $final;
					$objSaldoTercero->saldosterceros_credito_inicial = 0;

				}else if($saldo->plancuentas_naturaleza == 'C') {
					$objSaldoTercero->saldosterceros_debito_inicial = 0;
					$objSaldoTercero->saldosterceros_credito_inicial = $final;

				}else{
					return "No se puede definir la naturaleza {$saldo->plancuentas_naturaleza} de la cuenta, por favor verifique la información del asiento o consulte al administrador.";
				}
				$objSaldoTercero->save();
			}

			if($xmes == date('n') && $xano == date('Y')) {
				break;
			}

			if($xmes == 13) {
				$xmes = 1;
				$xano++;
			}else{
				$xmes++;
			}
       }

    	// Saldos iniciales
		return 'OK';
	}

	public function saldosContables(PlanCuenta $cuenta, $naturaleza, $debito = 0, $credito = 0, $xmes, $xano)
	{
        // Recuperar cuentas a mayorizar
		$cuentas = $cuenta->getMayorizarCuentas();
        if(!is_array($cuentas) || count($cuentas) == 0) {
			return "Error al recuperar cuentas para mayorizar.";
        }

        foreach ($cuentas as $item) {

	        // Recuperar cuenta
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $item)->first();
            if(!$objCuenta instanceof PlanCuenta) {
                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador (saldosContables).";
            }

            // Recuperar registro saldos contable
            $objSaldoContable = SaldoContable::where('saldoscontables_cuenta', $objCuenta->id)->where('saldoscontables_ano', $this->asiento->asiento1_ano)->where('saldoscontables_mes', $this->asiento->asiento1_mes)->first();
        	if(!$objSaldoContable instanceof SaldoContable) {

	            // Recuperar niveles cuenta
				$niveles = PlanCuenta::getNivelesCuenta($objCuenta->plancuentas_cuenta);
		        if(!is_array($niveles)) {
					return "Error al recuperar niveles para la cuenta {$objCuenta->plancuentas_cuenta}.";
		        }

        		// Crear registro en saldos contables
        		$objSaldoContable = new SaldoContable;
        		$objSaldoContable->saldoscontables_cuenta = $objCuenta->id;
        		$objSaldoContable->saldoscontables_ano = $this->asiento->asiento1_ano;
        		$objSaldoContable->saldoscontables_mes = $this->asiento->asiento1_mes;
        		$objSaldoContable->saldoscontables_nivel1 = $niveles['nivel1'] ?: 0;
        		$objSaldoContable->saldoscontables_nivel2 = $niveles['nivel2'] ?: 0;
        		$objSaldoContable->saldoscontables_nivel3 = $niveles['nivel3'] ?: 0;
        		$objSaldoContable->saldoscontables_nivel4 = $niveles['nivel4'] ?: 0;
        		$objSaldoContable->saldoscontables_nivel5 = $niveles['nivel5'] ?: 0;
        		$objSaldoContable->saldoscontables_nivel6 = $niveles['nivel6'] ?: 0;
        		$objSaldoContable->saldoscontables_nivel7 = $niveles['nivel7'] ?: 0;
        		$objSaldoContable->saldoscontables_nivel8 = $niveles['nivel8'] ?: 0;
        		$objSaldoContable->saldoscontables_debito_mes = $debito ?: 0;
        		$objSaldoContable->saldoscontables_credito_mes = $credito ?: 0;
        		$objSaldoContable->save();

        	}else{
        		// Debito
        		if ($debito){
					$saldo = ($objSaldoContable->saldoscontables_debito_mes ? $objSaldoContable->saldoscontables_debito_mes : 0) + $debito;
					$objSaldoContable->saldoscontables_debito_mes = $saldo;
					$objSaldoContable->save();
        		}

        		// Credito
        		if($credito){
					$saldo = ($objSaldoContable->saldoscontables_credito_mes ? $objSaldoContable->saldoscontables_credito_mes : 0) + $credito;
					$objSaldoContable->saldoscontables_credito_mes = $saldo;
					$objSaldoContable->save();
        		}
        	}

        	// Saldos iniciales
        	while (true)
			{
				if($xmes == 1) {
					$xmes2 = 13;
					$xano2 = $xano - 1;
				}else{
					$xmes2 = $xmes - 1;
					$xano2 = $xano;
				}

	    		$sql = "
					SELECT koi_plancuentas.id as plancuentas_id, plancuentas_nombre, plancuentas_cuenta, plancuentas_naturaleza,
					(select (CASE when plancuentas_naturaleza = 'D'
							THEN (saldoscontables_debito_inicial-saldoscontables_credito_inicial)
							ELSE (saldoscontables_credito_inicial-saldoscontables_debito_inicial)
							END)
						FROM koi_saldoscontables
						WHERE saldoscontables_mes = $xmes2
						and saldoscontables_ano = $xano2
						and saldoscontables_cuenta = koi_plancuentas.id
					) as inicial,
					(select (saldoscontables_debito_mes)
						FROM koi_saldoscontables
						WHERE saldoscontables_mes = $xmes
						and saldoscontables_ano = $xano
						and saldoscontables_cuenta = koi_plancuentas.id
					) as debitomes,
					(select (saldoscontables_credito_mes)
						FROM koi_saldoscontables
						WHERE saldoscontables_mes = $xmes
						and saldoscontables_ano = $xano
						and saldoscontables_cuenta = koi_plancuentas.id
					) as creditomes
					FROM koi_plancuentas
					WHERE koi_plancuentas.id IN (
						SELECT s.saldoscontables_cuenta
						FROM koi_saldoscontables as s
						WHERE s.saldoscontables_mes = $xmes and s.saldoscontables_ano = $xano
						UNION
						SELECT s.saldoscontables_cuenta
						FROM koi_saldoscontables as s
						WHERE s.saldoscontables_mes = $xmes2 and s.saldoscontables_ano = $xano2
					)
					and koi_plancuentas.id = {$objCuenta->id} order by plancuentas_cuenta ASC";
		        $arSaldos = DB::select($sql);
		        if(!is_array($arSaldos)) {
					return "Se genero un error al consultar los saldos, por favor verifique la información del asiento o consulte al administrador.";
				}

		        foreach ($arSaldos as $saldo)
		        {
					if($saldo->plancuentas_naturaleza == 'D') {
						$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
						// return "Cuenta {$saldo->plancuentas_cuenta} N {$saldo->plancuentas_naturaleza} Valor {$saldo->inicial} + ({$saldo->debitomes} - {$saldo->creditomes}) = $final";

					}else if($saldo->plancuentas_naturaleza == 'C') {
						$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
						// return "Cuenta {$saldo->plancuentas_cuenta} N {$saldo->plancuentas_naturaleza} Valor {$saldo->inicial} + ({$saldo->creditomes} - {$saldo->debitomes}) = $final";
					}

			        // Recuperar registro saldos contable
		            $objSaldoContable = SaldoContable::where('saldoscontables_cuenta', $saldo->plancuentas_id)->where('saldoscontables_ano', $xano)->where('saldoscontables_mes', $xmes)->first();
		        	if(!$objSaldoContable instanceof SaldoContable) {

			            // Recuperar niveles cuenta
						$niveles = PlanCuenta::getNivelesCuenta($saldo->plancuentas_cuenta);
				        if(!is_array($niveles)) {
							return "Error al recuperar niveles para la cuenta {$saldo->plancuentas_cuenta}, saldos iniciales.";
				        }

		        		// Crear registro en saldos contables
		        		$objSaldoContable = new SaldoContable;
		        		$objSaldoContable->saldoscontables_cuenta = $saldo->plancuentas_id;
		        		$objSaldoContable->saldoscontables_ano = $xano;
		        		$objSaldoContable->saldoscontables_mes = $xmes;
		        		$objSaldoContable->saldoscontables_nivel1 = $niveles['nivel1'] ?: 0;
		        		$objSaldoContable->saldoscontables_nivel2 = $niveles['nivel2'] ?: 0;
		        		$objSaldoContable->saldoscontables_nivel3 = $niveles['nivel3'] ?: 0;
		        		$objSaldoContable->saldoscontables_nivel4 = $niveles['nivel4'] ?: 0;
		        		$objSaldoContable->saldoscontables_nivel5 = $niveles['nivel5'] ?: 0;
		        		$objSaldoContable->saldoscontables_nivel6 = $niveles['nivel6'] ?: 0;
		        		$objSaldoContable->saldoscontables_nivel7 = $niveles['nivel7'] ?: 0;
		        		$objSaldoContable->saldoscontables_nivel8 = $niveles['nivel8'] ?: 0;
        			}

        			// Actualizo saldo iniciales
					if($saldo->plancuentas_naturaleza == 'D') {
						$objSaldoContable->saldoscontables_debito_inicial = $final;
						$objSaldoContable->saldoscontables_credito_inicial = 0;

					}else if($saldo->plancuentas_naturaleza == 'C') {
						$objSaldoContable->saldoscontables_debito_inicial = 0;
						$objSaldoContable->saldoscontables_credito_inicial = $final;

					}else{
						return "No se puede definir la naturaleza {$saldo->plancuentas_naturaleza} de la cuenta, por favor verifique la información del asiento o consulte al administrador.";
					}
					$objSaldoContable->save();
		        }

				if($xmes == date('n') && $xano == date('Y')) {
					break;
				}

				if($xmes == 13) {
					$xmes = 1;
					$xano++;
				}else{
					$xmes++;
				}
			}
        }
        return 'OK';
	}
}

