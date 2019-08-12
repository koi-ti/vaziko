<?php

namespace App\Classes;

use App\Models\Accounting\PlanCuenta, App\Models\Base\Tercero, App\Models\Accounting\Asiento, App\Models\Accounting\Asiento2, App\Models\Accounting\AsientoMovimiento, App\Models\Accounting\SaldoContable, App\Models\Accounting\SaldoTercero, App\Models\Inventory\Producto, App\Models\Inventory\Prodbode, App\Models\Receivable\Factura1, App\Models\Receivable\Factura4, App\Models\Treasury\Facturap, App\Models\Treasury\Facturap2;
use DB, Log;

class AsientoContableDocumentoDevolver {

	public $asiento;
	private $cuentas = [];
	private $asiento_cuentas = [];
	public $asiento_error = NULL;

	function __construct (Asiento $asiento, Array $cuentas) {
		// Validar asiento
		if (!$asiento instanceof Asiento) {
			$this->asiento_error = "No es posible recuperar el asiento contable.";
			return;
		}

		$this->asiento = $asiento;

		// Validar que vengas cuentas
		if (!is_array($cuentas)) {
			$this->asiento_error = "Las cuentas no son validas.";
			return;
		}

		$this->cuentas = $cuentas;
	}

	public function revertirMovimientos () {
		foreach ($this->cuentas as $cuenta) {
			// Asiento2
			$asiento2 = Asiento2::find($cuenta['Id']);
			if (!$asiento2 instanceof Asiento2) {
				return "No es posible recuperar la cuenta {$cuenta['Id']}.";
			}

			// Recuperar cuenta
			$objCuenta = PlanCuenta::find($asiento2->asiento2_cuenta);
			if (!$objCuenta instanceof PlanCuenta) {
				return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
			}

			if (!in_array($objCuenta->plancuentas_tipo, ['N', 'I'])) {
				// Reveritr movmientos
				$devolucion = $asiento2->devolverMovimiento($objCuenta);
				if ($devolucion != 'OK') {
					return $devolucion;
				}
			}

			if ($objCuenta->plancuentas_tipo == 'N') {
				// asiento2_nuevo = true
				$asiento2->asiento2_nuevo = true;
				$asiento2->save();
			}

			// Recuperar tercero
			$objTercero = Tercero::find($asiento2->asiento2_beneficiario);
			if (!$objTercero instanceof Tercero) {
				return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
			}

			// Mayorizacion de saldos x tercero
			$result = $this->revertirSaldosTerceros($objCuenta, $objTercero->id, $cuenta['Debito'], $cuenta['Credito'], $this->asiento->asiento1_ano, $this->asiento->asiento1_mes);
			if ($result != 'OK') {
				return $result;
			}

			// Mayorizacion de saldos Contables
			$result = $this->revertirSaldosContables($objCuenta, $cuenta['Debito'], $cuenta['Credito'], $this->asiento->asiento1_ano, $this->asiento->asiento1_mes);
			if ($result != 'OK') {
				return $result;
			}
		}
		return 'OK';
	}

	public function revertirSaldosTerceros (PlanCuenta $cuenta, $tercero, $debito = 0, $credito = 0, $xano, $xmes) {
		// Recuperar registro saldos terceros
		$objSaldoTercero = SaldoTercero::where('saldosterceros_cuenta', $cuenta->id)->where('saldosterceros_tercero', $tercero)->where('saldosterceros_ano', $xano)->where('saldosterceros_mes', $xmes)->first();
		if ($objSaldoTercero instanceof SaldoTercero) {
			$objSaldoTercero->saldosterceros_debito_mes -= $debito;
			$objSaldoTercero->saldosterceros_credito_mes -= $credito;
			$objSaldoTercero->save();
		}
		return 'OK';
	}

	public function revertirSaldosContables (PlanCuenta $cuenta, $debito = 0, $credito = 0, $xano, $xmes) {
		// Recuperar cuentas a mayorizar
		$cuentas = $cuenta->getMayorizarCuentas();
		if (!is_array($cuentas) || count($cuentas) == 0) {
			return "Error al recuperar cuentas para mayorizar.";
		}

		foreach ($cuentas as $item) {
			// Recuperar cuenta
			$objCuenta = PlanCuenta::where('plancuentas_cuenta', $item)->first();
			if (!$objCuenta instanceof PlanCuenta) {
				return "No es posible recuperar cuenta saldos, por favor verifique la información del asiento o consulte al administrador.";
			}

			// Recuperar registro saldos contable
			$objSaldoContable = SaldoContable::where('saldoscontables_cuenta', $objCuenta->id)->where('saldoscontables_ano', $xano)->where('saldoscontables_mes', $xmes)->first();
			if ($objSaldoContable instanceof SaldoContable) {
				$objSaldoContable->saldoscontables_debito_mes -= $debito;
				$objSaldoContable->saldoscontables_credito_mes -= $credito;
				$objSaldoContable->save();
			}
		}
		return 'OK';
	}
}
