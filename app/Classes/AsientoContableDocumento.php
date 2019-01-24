<?php

namespace App\Classes;

use Auth, DB, Log;
use App\Models\Accounting\PlanCuenta, App\Models\Accounting\Documento, App\Models\Base\Tercero, App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\CentroCosto, App\Models\Accounting\SaldoContable, App\Models\Accounting\SaldoTercero, App\Models\Base\Empresa;

class AsientoContableDocumento {

	public $asiento;
	private $beneficiario;
	private $documento;
	private $import;
	private $asiento_cuentas = [];
	public $asiento_error = NULL;
	private $empresa;

	function __construct(Array $data, Asiento $asiento = null, $import = false)
	{
		// Cuando se edita termina un asiento ya existe $asiento
		if(!$asiento instanceof Asiento) {
   	 		$asiento = new Asiento;
		}
		$this->asiento = $asiento;

        if (!$this->asiento->isValid($data)) {
        	$this->asiento_error = $this->asiento->errors;
        	return;
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

        // Recuperar consecutivo
        if($this->documento->documento_tipo_consecutivo == 'A'){
        	$this->asiento->asiento1_numero = $this->documento->documento_consecutivo + 1;
        }

        // Validar consecutivo
        if (!intval($this->asiento->asiento1_numero) || $this->asiento->asiento1_numero <= 0){
			$this->asiento_error = "No es posible recuperar el consecutivo documento ({$this->asiento->asiento1_numero}), por favor verifique la información del asiento o consulte al administrador.";
			return;
		}

    	if($this->documento->documento_tipo_consecutivo == 'M') {
			$asiento = Asiento::where('asiento1_numero', $this->asiento->asiento1_numero)->where('asiento1_documento', $this->documento->id)->where('asiento1_preguardado', false)->first();
			if($asiento instanceof Asiento) {
	            $this->asiento_error = "Ya existe asiento con el numero {$this->asiento->asiento1_numero} para el documento {$this->documento->documento_nombre}, por favor verifique la información del asiento o consulte al administrador.";
	            return;
	        }
       	}

        // Recuperar empresa
		$this->empresa = Empresa::getEmpresa();
		if(!$this->empresa instanceof Empresa) {
        	$this->asiento_error = "No es posible recuperar información empresa, por favor consulte al administrador.";
			return;
		}

		$this->import = $import;

        // Validar cierre contable
		$date_asiento = "{$this->asiento->asiento1_ano}-{$this->asiento->asiento1_mes}-{$this->asiento->asiento1_dia}";
		if( $date_asiento <= $this->empresa->empresa_fecha_cierre_contabilidad){
			$this->asiento_error = 'La fecha que intenta realizar el asiento: '.$date_asiento.' no esta PERMITIDA. Es menor a la del cierre contable :'.$this->empresa->empresa_fecha_cierre_contabilidad;
		}
	}

	function asientoCuentas($cuentas = null)
	{
		if (!is_array( $cuentas )) {
			return 'El parámetro pasado como cuentas no es un array '.$cuentas;
		}
		$this->asiento_cuentas = $cuentas;

		// Valido que las sumas sean Iguales
		$result = $this->validarSumas();
		if ($result != 'OK'){
			return $result;
		}

		foreach ($this->asiento_cuentas as $cuenta)
		{
			// Recuperar cuenta
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $cuenta['Cuenta'])->first();
            if(!$objCuenta instanceof PlanCuenta) {
                return "No es posible recuperar cuenta {$cuenta['Cuenta']}, por favor verifique la información del asiento o consulte al administrador (asientoCuentas). ";
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

			if (floatval(abs($cuenta['Debito'])) > 0 && $cuenta['Credito'] == 0) {
				$debito += round($cuenta['Debito'],2);

			}else if (floatval(abs($cuenta['Credito'])) > 0 && $cuenta['Debito'] == 0) {
				$credito += round($cuenta['Credito'],2);

			}else{
				return "Los registros de crédito y débito de la cuenta {$cuenta['Cuenta']} no son correctos. Valor crédito {$cuenta['Credito']}, Valor débito {$cuenta['Debito']}.";
			}
		}

		$resta = round(abs($credito) - abs($debito),2);
		if (abs($resta)>0.01 || ($credito === 0 && $debito === 0)) {
			return 'Las sumas de créditos como de débitos no son iguales: créditos '.$credito.', débitos '.$debito.', diferencia '.abs($resta);
		}
		return 'OK';
	}

	public function insertarAsiento()
	{
		$this->documento->documento_consecutivo = $this->asiento->asiento1_numero;
		$this->documento->save();

		// Asiento
		$this->asiento->asiento1_preguardado = false;
		$this->asiento->asiento1_beneficiario = $this->beneficiario->id;
		$this->asiento->asiento1_usuario_elaboro = Auth::user()->id;
		$this->asiento->asiento1_fecha_elaboro = date('Y-m-d H:i:s');
		$this->asiento->save();

		foreach ($this->asiento_cuentas as $cuenta)
		{
			// Asiento2
			$asiento2 = null;
			if(isset($cuenta['Id']) && !empty($cuenta['Id'])) {
				$asiento2 = Asiento2::find($cuenta['Id']);
			}

			if(!$asiento2 instanceof Asiento2) {
				$asiento2 = new Asiento2;
				$result = $asiento2->store($this->asiento, $cuenta, $this->import);
	            if(!$result->success) {
	                return $result->error;
	            }
	      	}

	        // Recuperar cuenta
            $objCuenta = PlanCuenta::find($asiento2->asiento2_cuenta);
            if(!$objCuenta instanceof PlanCuenta) {
                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            }

            // Recuperar tercero
            $objTercero = Tercero::find($asiento2->asiento2_beneficiario);
		    if(!$objTercero instanceof Tercero) {
		        return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
		    }

			// Mayorizacion de saldos x tercero
			$result = $this->saldosTerceros($objCuenta, $objTercero, $cuenta['Debito'], $cuenta['Credito'], $this->asiento->asiento1_mes, $this->asiento->asiento1_ano);
			if($result != 'OK') {
				return $result;
			}

			// Mayorizacion de saldos Contables
			$result = $this->saldosContables($objCuenta, $cuenta['Debito'], $cuenta['Credito'], $this->asiento->asiento1_mes, $this->asiento->asiento1_ano);
			if($result != 'OK') {
				return $result;
			}
		}
		return 'OK';
	}

	public function saldosTerceros(PlanCuenta $cuenta, Tercero $tercero, $debito = 0, $credito = 0, $xmes, $xano)
	{
        // Recuperar registro saldos terceros
		$objSaldoTercero = SaldoTercero::where('saldosterceros_cuenta', $cuenta->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_ano', $this->asiento->asiento1_ano)->where('saldosterceros_mes', $this->asiento->asiento1_mes)->first();
    	if(!$objSaldoTercero instanceof SaldoTercero) {
    		// Crear registro en saldos terceros
    		$objSaldoTercero = new SaldoTercero;
    		$objSaldoTercero->saldosterceros_cuenta = $cuenta->id;
    		$objSaldoTercero->saldosterceros_tercero = $tercero->id;
    		$objSaldoTercero->saldosterceros_ano = $this->asiento->asiento1_ano;
    		$objSaldoTercero->saldosterceros_mes = $this->asiento->asiento1_mes;
    		$objSaldoTercero->saldosterceros_nivel1 = $cuenta->plancuentas_nivel1;
    		$objSaldoTercero->saldosterceros_nivel2 = $cuenta->plancuentas_nivel2;
    		$objSaldoTercero->saldosterceros_nivel3 = $cuenta->plancuentas_nivel3;
    		$objSaldoTercero->saldosterceros_nivel4 = $cuenta->plancuentas_nivel4;
    		$objSaldoTercero->saldosterceros_nivel5 = $cuenta->plancuentas_nivel5;
    		$objSaldoTercero->saldosterceros_nivel6 = $cuenta->plancuentas_nivel6;
    		$objSaldoTercero->saldosterceros_nivel7 = $cuenta->plancuentas_nivel7;
    		$objSaldoTercero->saldosterceros_nivel8 = $cuenta->plancuentas_nivel8;
    		$objSaldoTercero->saldosterceros_debito_mes = $debito ?: 0;
    		$objSaldoTercero->saldosterceros_credito_mes = $credito ?: 0;
    		$objSaldoTercero->save();

		}else{
			// Actualizar debito o credito mes si existe
			$objSaldoTercero->saldosterceros_debito_mes += $debito;
			$objSaldoTercero->saldosterceros_credito_mes += $credito;
			$objSaldoTercero->save();

		}

    	// Saldos iniciales
    	while (true) {
			if($xmes == 1) {
				$xmes2 = 13;
				$xano2 = $xano - 1;
			}else{
				$xmes2 = $xmes - 1;
				$xano2 = $xano;
			}

			$sql = "
				SELECT DISTINCT s1.saldosterceros_cuenta, s1.saldosterceros_tercero,
				(select (s2.saldosterceros_debito_inicial)
					FROM koi_saldosterceros as s2
					WHERE s2.saldosterceros_mes = $xmes2
					and s2.saldosterceros_ano = $xano2
					and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
					and s2.saldosterceros_tercero = s1.saldosterceros_tercero
				)as debito_inicial,
				(select (s2.saldosterceros_credito_inicial)
					FROM koi_saldosterceros as s2
					WHERE s2.saldosterceros_mes = $xmes2
					and s2.saldosterceros_ano = $xano2
					and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
					and s2.saldosterceros_tercero = s1.saldosterceros_tercero
				)as credito_inicial,
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

	        foreach ($arSaldos as $saldo) {
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
				if($debito) {
					$objSaldoTercero->saldosterceros_debito_inicial = $saldo->debito_inicial + ($saldo->debitomes - $saldo->creditomes);

				}else if($credito) {
					$objSaldoTercero->saldosterceros_credito_inicial = $saldo->credito_inicial + ($saldo->creditomes - $saldo->debitomes);

				}else{
					return "No se puede definir la naturaleza {$saldo->plancuentas_naturaleza} de la cuenta, por favor verifique la información del asiento o consulte al administrador.";

				}
				$objSaldoTercero->save();
			}

			if($xmes == date('m') && $xano == date('Y')) {
				break;
			}

			if($xmes == 13) {
				$xmes = 1;
				$xano++;
			}else{
				$xmes++;
			}
		}
		$xano = $this->asiento->asiento1_ano;
		$xmes = $this->asiento->asiento1_mes;

		// Saldos iniciales
		return 'OK';
	}

	public function saldosContables(PlanCuenta $cuenta, $debito = 0, $credito = 0, $xmes, $xano)
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
        		// Crear registro en saldos contables
        		$objSaldoContable = new SaldoContable;
        		$objSaldoContable->saldoscontables_cuenta = $objCuenta->id;
        		$objSaldoContable->saldoscontables_ano = $this->asiento->asiento1_ano;
        		$objSaldoContable->saldoscontables_mes = $this->asiento->asiento1_mes;
        		$objSaldoContable->saldoscontables_nivel1 = $objCuenta->plancuentas_nivel1;
        		$objSaldoContable->saldoscontables_nivel2 = $objCuenta->plancuentas_nivel2;
        		$objSaldoContable->saldoscontables_nivel3 = $objCuenta->plancuentas_nivel3;
        		$objSaldoContable->saldoscontables_nivel4 = $objCuenta->plancuentas_nivel4;
        		$objSaldoContable->saldoscontables_nivel5 = $objCuenta->plancuentas_nivel5;
        		$objSaldoContable->saldoscontables_nivel6 = $objCuenta->plancuentas_nivel6;
        		$objSaldoContable->saldoscontables_nivel7 = $objCuenta->plancuentas_nivel7;
        		$objSaldoContable->saldoscontables_nivel8 = $objCuenta->plancuentas_nivel8;
        		$objSaldoContable->saldoscontables_debito_mes = $debito ?: 0;
        		$objSaldoContable->saldoscontables_credito_mes = $credito ?: 0;
        		$objSaldoContable->save();

        	}else{
        		// Actualizar credito o debito mes si existe
				$objSaldoContable->saldoscontables_debito_mes += $debito;
				$objSaldoContable->saldoscontables_credito_mes += $credito;
				$objSaldoContable->save();

        	}

        	// Saldos iniciales
        	while (true) {
				if($xmes == 1) {
					$xmes2 = 13;
					$xano2 = $xano - 1;
				}else{
					$xmes2 = $xmes - 1;
					$xano2 = $xano;
				}

				$sql = "
				    SELECT koi_plancuentas.id as plancuentas_id, plancuentas_cuenta,
				    (select (saldoscontables_debito_inicial)
				        FROM koi_saldoscontables
				        WHERE saldoscontables_mes = $xmes2
				        and saldoscontables_ano = $xano2
				        and saldoscontables_cuenta = koi_plancuentas.id
				    ) as debito_inicial,
				    (select (saldoscontables_credito_inicial)
				        FROM koi_saldoscontables
				        WHERE saldoscontables_mes = $xmes2
				        and saldoscontables_ano = $xano2
				        and saldoscontables_cuenta = koi_plancuentas.id
				    ) as credito_inicial,
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

		        foreach ($arSaldos as $saldo) {
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
					if( $debito ) {
						$objSaldoContable->saldoscontables_debito_inicial = $saldo->debito_inicial + ($saldo->debitomes - $saldo->creditomes);
					}else if( $credito ) {
						$objSaldoContable->saldoscontables_credito_inicial = $saldo->credito_inicial + ($saldo->creditomes - $saldo->debitomes);
					}else{
						return "No se puede definir la naturaleza de la cuenta, por favor verifique la información del asiento o consulte al administrador.";
					}
					$objSaldoContable->save();
					// Log::info("CUENTA[$saldo->plancuentas_cuenta] | MES[$objSaldoContable->saldoscontables_mes] | AÑO[$objSaldoContable->saldoscontables_ano] | [C_INICIAL($objSaldoContable->saldoscontables_credito_inicial) | D_INICIAL($objSaldoContable->saldoscontables_debito_inicial)] | [M_C($objSaldoContable->saldoscontables_credito_mes) | M_D($objSaldoContable->saldoscontables_debito_mes)]");
		        }

				if($xmes == date('m') && $xano == date('Y')) {
					break;
				}

				if($xmes == 13) {
					$xmes = 1;
					$xano++;
				}else{
					$xmes++;
				}
			}

			$xano = $this->asiento->asiento1_ano;
			$xmes = $this->asiento->asiento1_mes;
        }
        return 'OK';
	}
}
