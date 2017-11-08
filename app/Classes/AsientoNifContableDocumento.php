<?php

namespace App\Classes;

use Auth, DB;

use App\Models\Accounting\PlanCuentaNif, App\Models\Accounting\Documento, App\Models\Base\Tercero, App\Models\Accounting\AsientoNif, App\Models\Accounting\AsientoNif2, App\Models\Accounting\CentroCosto, App\Models\Accounting\SaldoContableNif, App\Models\Accounting\SaldoTerceroNif, App\Models\Base\Empresa;

class AsientoNifContableDocumento {

	public $asientoNif;
	private $beneficiario;
	private $documento;
	private $asientoNif_cuentas = [];
	public $asientoNif_error = NULL;
	private $empresa;

	function __construct(Array $data, AsientoNif $asientoNif = null)
	{
		// Cuando se edita termina un asiento ya existe $asientoNif
		if(!$asientoNif instanceof AsientoNif) {
   	 		$asientoNif = new AsientoNif;
		}
		$this->asientoNif = $asientoNif;

        // if (!$this->asientoNif->isValid($data)) {
        // 	$this->asientoNif_error = $this->asientoNif->errors;
        // 	return;
        // }
        // $this->asientoNif->fill($data);

        // Recuperar tercero
        $this->beneficiario = Tercero::where('tercero_nit', $data['asienton1_beneficiario'])->first();
        if(!$this->beneficiario instanceof Tercero) {
        	$this->asientoNif_error = "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
        	return;
        }

        // Recuerar documento
        $this->documento = Documento::where('id', $this->asientoNif->asienton1_documento)->first();
        if(!$this->documento instanceof Documento) {
            $this->asientoNif_error = "No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.";
            return;
        }

        // Recuperar consecutivo
        if($this->documento->documento_tipo_consecutivo == 'A'){
        	$this->asientoNif->asienton1_numero = $this->documento->documento_consecutivo + 1;
        }

        // Validar consecutivo
        if (!intval($this->asientoNif->asienton1_numero) || $this->asientoNif->asienton1_numero <= 0){
			$this->asientoNif_error = "No es posible recuperar el consecutivo documento ({$this->asientoNif->asienton1_numero}), por favor verifique la información del asiento o consulte al administrador.";
			return;
		}

    	if($this->documento->documento_tipo_consecutivo == 'M') {
			$asientoNif = AsientoNif::where('asienton1_numero', $this->asientoNif->asienton1_numero)->where('asienton1_documento', $this->documento->id)->where('asienton1_preguardado', false)->first();
			if($asientoNif instanceof AsientoNif) {
	            $this->asientoNif_error = "Ya existe asiento con el numero {$this->asientoNif->asienton1_numero} para el documento {$this->documento->documento_nombre}, por favor verifique la información del asiento o consulte al administrador.";
	            return;
	        }
       	}

        // Recuperar empresa
		$this->empresa = Empresa::getEmpresa();
		if(!$this->empresa instanceof Empresa) {
        	$this->asientoNif_error = "No es posible recuperar información empresa, por favor consulte al administrador.";
			return;
		}

        // Validar cierre contable
		// if( $this->asientoNif1_fecha <= $empresa->empresa_fecha_contabilidad){
		// 	$this->asientoNif_error = 'La fecha que intenta realizar el asiento: '.$this->asientoNif1_fecha.' no esta PERMITIDA. Es menor a la del cierre contable :'.$empresa->empresa_fecha_contabilidad;
		// }
	}

	function asientoCuentas($cuentas = null)
	{
		if (!is_array( $cuentas )) {
			return 'El parámetro pasado como cuentas no es un array '.$cuentas;
		}
		$this->asientoNif_cuentas = $cuentas;

		// Valido que las sumas sean Iguales
		$result = $this->validarSumas();
		if ($result != 'OK'){
			return $result;
		}

		foreach ($this->asientoNif_cuentas as $cuenta)
		{
			// Recuperar cuenta
            $objCuenta = PlanCuentaNif::where('plancuentasn_cuenta', $cuenta['Cuenta'])->first();
            if(!$objCuenta instanceof PlanCuentaNif) {
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
		foreach ($this->asientoNif_cuentas as $cuenta)
		{
			// Valido que las variables hayan sido correctamente inicializadas
			if (!isset($cuenta['Cuenta'])){
				return "Error al recuperar cuenta contable.";
			}

	        $niveles = PlanCuentaNif::getNivelesCuenta($cuenta['Cuenta']);
	        if(!is_array($niveles)) {
				return "Error al recuperar niveles para la cuenta {$cuenta['Cuenta']}.";
	        }

			// Verifico que existan todos los niveles de la cuenta
			$srnivel = "<br/>N2: {$niveles['nivel2']}, N3: {$niveles['nivel3']}, N4: {$niveles['nivel4']}, N5: {$niveles['nivel5']}, N6: {$niveles['nivel6']}, N7: {$niveles['nivel7']}, N8: {$niveles['nivel8']}";

			if($niveles['nivel2'] == 0 && ($niveles['nivel3'] != 0 || $niveles['nivel4'] != 0 || $niveles['nivel5'] != 0 || $niveles['nivel6'] != 0 || $niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 2 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el AsientoNif. $srnivel";

			}else if($niveles['nivel3'] == 0 && ($niveles['nivel4'] != 0 || $niveles['nivel5'] != 0 || $niveles['nivel6'] != 0 || $niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 3 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el AsientoNif. $srnivel";

			}else if($niveles['nivel4'] == 0 && ($niveles['nivel5'] != 0 || $niveles['nivel6'] != 0 || $niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 4 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el AsientoNif. $srnivel";

			}else if($niveles['nivel5'] == 0 && ($niveles['nivel6'] != 0 || $niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 5 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el AsientoNif. $srnivel";

			}else if($niveles['nivel6'] == 0 && ($niveles['nivel7'] != 0 || $niveles['nivel8'] != 0)) {
				return "El nivel 6 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el AsientoNif. $srnivel";

			}else if($niveles['nivel7'] == 0 && $niveles['nivel8'] != 0) {
				return "El nivel 7 de la cuenta {$cuenta['Cuenta']} es cero y un nivel inferior es distinto de cero. No se puede realizar el AsientoNif. $srnivel";
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

	public function insertarAsientoNif()
	{
		$this->documento->documento_consecutivo = $this->asientoNif->asienton1_numero;
		$this->documento->save();

		// AsientoNif
		$this->asientoNif->asienton1_preguardado = false;
		$this->asientoNif->asienton1_beneficiario = $this->beneficiario->id;
		$this->asientoNif->asienton1_usuario_elaboro = Auth::user()->id;
		$this->asientoNif->asienton1_fecha_elaboro = date('Y-m-d H:m:s');
		$this->asientoNif->save();

		foreach ($this->asientoNif_cuentas as $cuenta)
		{
			// AsientoNif2
			$asientoNif2 = null;
			if(isset($cuenta['Id']) && !empty($cuenta['Id'])) {
				$asientoNif2 = AsientoNif2::find($cuenta['Id']);
			}

			if(!$asientoNif2 instanceof AsientoNif2) {
				$asientoNif2 = new AsientoNif2;
				$result = $asientoNif2->store($this->asientoNif, $cuenta);
	            if(!$result->success) {
	                return $result->error;
	            }
	      	}

	        // Recuperar cuenta
            $objCuenta = PlanCuentaNif::find($asientoNif2->asienton2_cuenta);
            if(!$objCuenta instanceof PlanCuentaNif) {
                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            }

            // Recuperar tercero
            $objTercero = Tercero::find($asientoNif2->asienton2_beneficiario);
		    if(!$objTercero instanceof Tercero) {
		        return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
		    }

		    // Mayorizacion de saldos Contables
            $result = $this->saldosContables($objCuenta, $cuenta['Naturaleza'], $cuenta['Debito'], $cuenta['Credito'], $this->asientoNif->asienton1_mes, $this->asientoNif->asienton1_ano);
			if($result != 'OK') {
				return $result;
			}

			// Mayorizacion de saldos x tercero
			$result = $this->saldosTerceros($objCuenta, $objTercero, $cuenta['Naturaleza'], $cuenta['Debito'], $cuenta['Credito'], $this->asientoNif->asienton1_mes, $this->asientoNif->asienton1_ano);
			if($result != 'OK') {
				return $result;
			}
		}
		return 'OK';
	}	

	public function saldosTerceros(PlanCuentaNif $cuenta, Tercero $tercero, $naturaleza, $debito = 0, $credito = 0, $xmes, $xano)
	{
        // Recuperar registro saldos terceros
		$objSaldoTerceroNif = SaldoTerceroNif::where('saldostercerosn_cuenta', $cuenta->id)->where('saldostercerosn_tercero', $tercero->id)->where('saldostercerosn_ano', $this->asientoNif->asienton1_ano)->where('saldostercerosn_mes', $this->asientoNif->asienton1_mes)->first();
    	if(!$objSaldoTerceroNif instanceof SaldoTerceroNif) {

			 // Recuperar niveles cuenta
			$niveles = PlanCuentaNif::getNivelesCuenta($cuenta->plancuentasn_cuenta);
	        if(!is_array($niveles)) {
				return "Error al recuperar niveles para la cuenta {$cuenta->plancuentasn_cuenta}.";
	        }

    		// Crear registro en saldos terceros
    		$objSaldoTerceroNif = new SaldoTerceroNif;
    		$objSaldoTerceroNif->saldostercerosn_cuenta = $cuenta->id;
    		$objSaldoTerceroNif->saldostercerosn_tercero = $tercero->id;
    		$objSaldoTerceroNif->saldostercerosn_ano = $this->asientoNif->asienton1_ano;
    		$objSaldoTerceroNif->saldostercerosn_mes = $this->asientoNif->asienton1_mes;
    		$objSaldoTerceroNif->saldostercerosn_nivel1 = $niveles['nivel1'] ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_nivel2 = $niveles['nivel2'] ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_nivel3 = $niveles['nivel3'] ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_nivel4 = $niveles['nivel4'] ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_nivel5 = $niveles['nivel5'] ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_nivel6 = $niveles['nivel6'] ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_nivel7 = $niveles['nivel7'] ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_nivel8 = $niveles['nivel8'] ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_debito_mes = $debito ?: 0;
    		$objSaldoTerceroNif->saldostercerosn_credito_mes = $credito ?: 0;
    		$objSaldoTerceroNif->save();

		}else{

			// Debito
    		if ($debito){
				$saldo = ($objSaldoTerceroNif->saldostercerosn_debito_mes ? $objSaldoTerceroNif->saldostercerosn_debito_mes : 0) + $debito;
				$objSaldoTerceroNif->saldostercerosn_debito_mes = $saldo;
				$objSaldoTerceroNif->save();
    		}

    		// Credito
    		if($credito){
				$saldo = ($objSaldoTerceroNif->saldostercerosn_credito_mes ? $objSaldoTerceroNif->saldostercerosn_credito_mes : 0) + $credito;
				$objSaldoTerceroNif->saldostercerosn_credito_mes = $saldo;
				$objSaldoTerceroNif->save();
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
				SELECT DISTINCT s1.saldostercerosn_cuenta, s1.saldostercerosn_tercero,
				(select (CASE when plancuentasn_naturaleza = 'D'
						THEN (s2.saldostercerosn_debito_inicial-s2.saldostercerosn_credito_inicial)
						ELSE (s2.saldostercerosn_credito_inicial-s2.saldostercerosn_debito_inicial)
						END)
					FROM koi_saldostercerosn as s2
					WHERE s2.saldostercerosn_mes = $xmes2
					and s2.saldostercerosn_ano = $xano2
					and s2.saldostercerosn_cuenta = s1.saldostercerosn_cuenta
					and s2.saldostercerosn_tercero = s1.saldostercerosn_tercero
				)as inicial,
				(select SUM(s2.saldostercerosn_debito_mes)
					FROM koi_saldostercerosn as s2
					WHERE s2.saldostercerosn_mes = $xmes
					and s2.saldostercerosn_ano = $xano
					and s2.saldostercerosn_cuenta = s1.saldostercerosn_cuenta
					and s2.saldostercerosn_tercero = s1.saldostercerosn_tercero
				)as debitomes,
				(select SUM(s2.saldostercerosn_credito_mes)
					FROM koi_saldostercerosn as s2
					WHERE s2.saldostercerosn_mes = $xmes
					and s2.saldostercerosn_ano = $xano
					and s2.saldostercerosn_cuenta = s1.saldostercerosn_cuenta
					and s2.saldostercerosn_tercero = s1.saldostercerosn_tercero
				)as creditomes,
				plancuentasn_cuenta, plancuentasn_naturaleza, plancuentasn_nombre

				FROM koi_saldostercerosn as s1, koi_plancuentasn
				WHERE (s1.saldostercerosn_mes = $xmes OR s1.saldostercerosn_mes = $xmes2)";
			if($xano == $xano2) {
				$sql.=" and( s1.saldostercerosn_ano = $xano)";
			}else{
				$sql.=" and( s1.saldostercerosn_ano = $xano OR s1.saldostercerosn_ano =".$xano2.")";
			}

			$sql .= "
				and s1.saldostercerosn_cuenta = koi_plancuentasn.id
				and s1.saldostercerosn_cuenta = {$cuenta->id}
				ORDER BY s1.saldostercerosn_cuenta ASC, s1.saldostercerosn_tercero ASC";
			$arSaldos = DB::select($sql);
	        if(!is_array($arSaldos)) {
				return "Se genero un error al consultar los saldos tercero, por favor verifique la información del asiento o consulte al administrador.";
			}

	        foreach ($arSaldos as $saldo)
	        {
				if($saldo->plancuentasn_naturaleza == 'D') {
					$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
					// return "Cuenta {$saldo->plancuentasn_cuenta} N {$saldo->plancuentasn_naturaleza} Tercero $tercero->tercero_nit Valor {$saldo->inicial} + ({$saldo->debitomes} - {$saldo->creditomes}) = $final";
				}else if($saldo->plancuentasn_naturaleza == 'C') {
					$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
					// return "Cuenta {$saldo->plancuentasn_cuenta} N {$saldo->plancuentasn_naturaleza} Tercero $tercero->tercero_nit Valor {$saldo->inicial} + ({$saldo->creditomes} - {$saldo->debitomes}) = $final";
				}

				// Recuperar registro saldos terceros
				$objSaldoTerceroNif = SaldoTerceroNif::where('saldostercerosn_cuenta', $cuenta->id)->where('saldostercerosn_tercero', $tercero->id)->where('saldostercerosn_tercero', $tercero->id)->where('saldostercerosn_ano', $xano)->where('saldostercerosn_mes', $xmes)->first();
				if(!$objSaldoTerceroNif instanceof SaldoTerceroNif) {

		            // Recuperar niveles cuenta
					$niveles = PlanCuentaNif::getNivelesCuenta($saldo->plancuentasn_cuenta);
			        if(!is_array($niveles)) {
						return "Error al recuperar niveles para la cuenta {$saldo->plancuentasn_cuenta}, saldos iniciales.";
			        }

		    		$objSaldoTerceroNif = new SaldoTerceroNif;
		    		$objSaldoTerceroNif->saldostercerosn_cuenta = $cuenta->id;
		    		$objSaldoTerceroNif->saldostercerosn_tercero = $tercero->id;
		    		$objSaldoTerceroNif->saldostercerosn_ano = $xano;
		    		$objSaldoTerceroNif->saldostercerosn_mes = $xmes;
		    		$objSaldoTerceroNif->saldostercerosn_nivel1 = $niveles['nivel1'] ?: 0;
		    		$objSaldoTerceroNif->saldostercerosn_nivel2 = $niveles['nivel2'] ?: 0;
		    		$objSaldoTerceroNif->saldostercerosn_nivel3 = $niveles['nivel3'] ?: 0;
		    		$objSaldoTerceroNif->saldostercerosn_nivel4 = $niveles['nivel4'] ?: 0;
		    		$objSaldoTerceroNif->saldostercerosn_nivel5 = $niveles['nivel5'] ?: 0;
		    		$objSaldoTerceroNif->saldostercerosn_nivel6 = $niveles['nivel6'] ?: 0;
		    		$objSaldoTerceroNif->saldostercerosn_nivel7 = $niveles['nivel7'] ?: 0;
		    		$objSaldoTerceroNif->saldostercerosn_nivel8 = $niveles['nivel8'] ?: 0;
				}

				// Actualizo saldo iniciales
				if($saldo->plancuentasn_naturaleza == 'D') {
					$objSaldoTerceroNif->saldostercerosn_debito_inicial = $final;
					$objSaldoTerceroNif->saldostercerosn_credito_inicial = 0;

				}else if($saldo->plancuentasn_naturaleza == 'C') {
					$objSaldoTerceroNif->saldostercerosn_debito_inicial = 0;
					$objSaldoTerceroNif->saldostercerosn_credito_inicial = $final;

				}else{
					return "No se puede definir la naturaleza {$saldo->plancuentasn_naturaleza} de la cuenta, por favor verifique la información del asiento o consulte al administrador.";
				}
				$objSaldoTerceroNif->save();
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

	public function saldosContables(PlanCuentaNif $cuenta, $naturaleza, $debito = 0, $credito = 0, $xmes, $xano)
	{
        // Recuperar cuentas a mayorizar
		$cuentas = $cuenta->getMayorizarCuentas();
        if(!is_array($cuentas) || count($cuentas) == 0) {
			return "Error al recuperar cuentas para mayorizar.";
        }

        foreach ($cuentas as $item) {

	        // Recuperar cuenta
            $objCuenta = PlanCuentaNif::where('plancuentasn_cuenta', $item)->first();
            if(!$objCuenta instanceof PlanCuentaNif) {
                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador (saldosContables).";
            }

            // Recuperar registro saldos contable
            $objSaldoContableNif = SaldoContableNif::where('saldoscontablesn_cuenta', $objCuenta->id)->where('saldoscontablesn_ano', $this->asientoNif->asienton1_ano)->where('saldoscontablesn_mes', $this->asientoNif->asienton1_mes)->first();
        	if(!$objSaldoContableNif instanceof SaldoContableNif) {

	            // Recuperar niveles cuenta
				$niveles = PlanCuentaNif::getNivelesCuenta($objCuenta->plancuentasn_cuenta);
		        if(!is_array($niveles)) {
					return "Error al recuperar niveles para la cuenta {$objCuenta->plancuentasn_cuenta}.";
		        }

        		// Crear registro en saldos contables
        		$objSaldoContableNif = new SaldoContableNif;
        		$objSaldoContableNif->saldoscontablesn_cuenta = $objCuenta->id;
        		$objSaldoContableNif->saldoscontablesn_ano = $this->asientoNif->asienton1_ano;
        		$objSaldoContableNif->saldoscontablesn_mes = $this->asientoNif->asienton1_mes;
        		$objSaldoContableNif->saldoscontablesn_nivel1 = $niveles['nivel1'] ?: 0;
        		$objSaldoContableNif->saldoscontablesn_nivel2 = $niveles['nivel2'] ?: 0;
        		$objSaldoContableNif->saldoscontablesn_nivel3 = $niveles['nivel3'] ?: 0;
        		$objSaldoContableNif->saldoscontablesn_nivel4 = $niveles['nivel4'] ?: 0;
        		$objSaldoContableNif->saldoscontablesn_nivel5 = $niveles['nivel5'] ?: 0;
        		$objSaldoContableNif->saldoscontablesn_nivel6 = $niveles['nivel6'] ?: 0;
        		$objSaldoContableNif->saldoscontablesn_nivel7 = $niveles['nivel7'] ?: 0;
        		$objSaldoContableNif->saldoscontablesn_nivel8 = $niveles['nivel8'] ?: 0;
        		$objSaldoContableNif->saldoscontablesn_debito_mes = $debito ?: 0;
        		$objSaldoContableNif->saldoscontablesn_credito_mes = $credito ?: 0;
        		$objSaldoContableNif->save();

        	}else{
        		// Debito
        		if ($debito){
					$saldo = ($objSaldoContableNif->saldoscontablesn_debito_mes ? $objSaldoContableNif->saldoscontablesn_debito_mes : 0) + $debito;
					$objSaldoContableNif->saldoscontablesn_debito_mes = $saldo;
					$objSaldoContableNif->save();
        		}

        		// Credito
        		if($credito){
					$saldo = ($objSaldoContableNif->saldoscontablesn_credito_mes ? $objSaldoContableNif->saldoscontablesn_credito_mes : 0) + $credito;
					$objSaldoContableNif->saldoscontablesn_credito_mes = $saldo;
					$objSaldoContableNif->save();
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
					SELECT koi_plancuentasn.id as plancuentasn_id, plancuentasn_nombre, plancuentasn_cuenta, plancuentasn_naturaleza,
					(select (CASE when plancuentasn_naturaleza = 'D'
							THEN (saldoscontablesn_debito_inicial-saldoscontablesn_credito_inicial)
							ELSE (saldoscontablesn_credito_inicial-saldoscontablesn_debito_inicial)
							END)
						FROM koi_saldoscontablesn
						WHERE saldoscontablesn_mes = $xmes2
						and saldoscontablesn_ano = $xano2
						and saldoscontablesn_cuenta = koi_plancuentasn.id
					) as inicial,
					(select (saldoscontablesn_debito_mes)
						FROM koi_saldoscontablesn
						WHERE saldoscontablesn_mes = $xmes
						and saldoscontablesn_ano = $xano
						and saldoscontablesn_cuenta = koi_plancuentasn.id
					) as debitomes,
					(select (saldoscontablesn_credito_mes)
						FROM koi_saldoscontablesn
						WHERE saldoscontablesn_mes = $xmes
						and saldoscontablesn_ano = $xano
						and saldoscontablesn_cuenta = koi_plancuentasn.id
					) as creditomes
					FROM koi_plancuentasn
					WHERE koi_plancuentasn.id IN (
						SELECT s.saldoscontablesn_cuenta
						FROM koi_saldoscontablesn as s
						WHERE s.saldoscontablesn_mes = $xmes and s.saldoscontablesn_ano = $xano
						UNION
						SELECT s.saldoscontablesn_cuenta
						FROM koi_saldoscontablesn as s
						WHERE s.saldoscontablesn_mes = $xmes2 and s.saldoscontablesn_ano = $xano2
					)
					and koi_plancuentasn.id = {$objCuenta->id} order by plancuentasn_cuenta ASC";
		        $arSaldos = DB::select($sql);
		        if(!is_array($arSaldos)) {
					return "Se genero un error al consultar los saldos, por favor verifique la información del asiento o consulte al administrador.";
				}

		        foreach ($arSaldos as $saldo)
		        {
					if($saldo->plancuentasn_naturaleza == 'D') {
						$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
						// return "Cuenta {$saldo->plancuentasn_cuenta} N {$saldo->plancuentasn_naturaleza} Valor {$saldo->inicial} + ({$saldo->debitomes} - {$saldo->creditomes}) = $final";

					}else if($saldo->plancuentasn_naturaleza == 'C') {
						$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
						// return "Cuenta {$saldo->plancuentasn_cuenta} N {$saldo->plancuentasn_naturaleza} Valor {$saldo->inicial} + ({$saldo->creditomes} - {$saldo->debitomes}) = $final";
					}

			        // Recuperar registro saldos contable
		            $objSaldoContableNif = SaldoContableNif::where('saldoscontablesn_cuenta', $saldo->plancuentasn_id)->where('saldoscontablesn_ano', $xano)->where('saldoscontablesn_mes', $xmes)->first();
		        	if(!$objSaldoContableNif instanceof SaldoContableNif) {

			            // Recuperar niveles cuenta
						$niveles = PlanCuentaNif::getNivelesCuenta($saldo->plancuentasn_cuenta);
				        if(!is_array($niveles)) {
							return "Error al recuperar niveles para la cuenta {$saldo->plancuentasn_cuenta}, saldos iniciales.";
				        }

		        		// Crear registro en saldos contables
		        		$objSaldoContableNif = new SaldoContableNif;
		        		$objSaldoContableNif->saldoscontablesn_cuenta = $saldo->plancuentasn_id;
		        		$objSaldoContableNif->saldoscontablesn_ano = $xano;
		        		$objSaldoContableNif->saldoscontablesn_mes = $xmes;
		        		$objSaldoContableNif->saldoscontablesn_nivel1 = $niveles['nivel1'] ?: 0;
		        		$objSaldoContableNif->saldoscontablesn_nivel2 = $niveles['nivel2'] ?: 0;
		        		$objSaldoContableNif->saldoscontablesn_nivel3 = $niveles['nivel3'] ?: 0;
		        		$objSaldoContableNif->saldoscontablesn_nivel4 = $niveles['nivel4'] ?: 0;
		        		$objSaldoContableNif->saldoscontablesn_nivel5 = $niveles['nivel5'] ?: 0;
		        		$objSaldoContableNif->saldoscontablesn_nivel6 = $niveles['nivel6'] ?: 0;
		        		$objSaldoContableNif->saldoscontablesn_nivel7 = $niveles['nivel7'] ?: 0;
		        		$objSaldoContableNif->saldoscontablesn_nivel8 = $niveles['nivel8'] ?: 0;
        			}

        			// Actualizo saldo iniciales
					if($saldo->plancuentasn_naturaleza == 'D') {
						$objSaldoContableNif->saldoscontablesn_debito_inicial = $final;
						$objSaldoContableNif->saldoscontablesn_credito_inicial = 0;

					}else if($saldo->plancuentasn_naturaleza == 'C') {
						$objSaldoContableNif->saldoscontablesn_debito_inicial = 0;
						$objSaldoContableNif->saldoscontablesn_credito_inicial = $final;

					}else{
						return "No se puede definir la naturaleza {$saldo->plancuentasn_naturaleza} de la cuenta, por favor verifique la información del asiento o consulte al administrador.";
					}
					$objSaldoContableNif->save();
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

