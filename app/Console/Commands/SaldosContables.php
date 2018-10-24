<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accounting\Asiento, App\Models\Accounting\PlanCuenta, App\Models\Accounting\AsientoNif, App\Models\Accounting\PlanCuentaNif, App\Models\Accounting\SaldoContable, App\Models\Accounting\SaldoTercero, App\Models\Accounting\SaldoContableNif, App\Models\Accounting\SaldoTerceroNif, App\Models\Base\Tercero, App\Models\Base\Notificacion;
use DB, Auth, Log;
use Carbon\Carbon;

class SaldosContables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:saldos {mes} {ano} {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rutina para actualizar los saldos contables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            Log::info("Bienvenido a la rutina de actualizar saldos usuario id {$this->argument('user')}");

            // Mes filtro y mes default ( actual )
            $currentmonth = $this->argument('mes');
            $defaultmonth = date('m');
            $currentyear = $this->argument('ano');
            $defaultyear = date('Y');

            // Eliminar saldos contables existentes del rango de fecha seleccionado hasta fecha actual
            $dropsaldoscontables = SaldoContable::whereBetween('saldoscontables_ano', [$currentyear, $defaultyear])
                                                ->whereBetween('saldoscontables_mes', [$currentmonth, $defaultmonth])
                                                ->delete();

            $dropsaldosterceros = SaldoTercero::whereBetween('saldosterceros_ano', [$currentyear, $defaultyear])
                                                ->whereBetween('saldosterceros_mes', [$currentmonth, $defaultmonth])
                                                ->delete();

            // Eliminar saldos contables existentes del rango de fecha seleccionado hasta fecha actual
            $dropsaldoscontablesnif = SaldoContableNif::whereBetween('saldoscontablesn_ano', [$currentyear, $defaultyear])
                                                ->whereBetween('saldoscontablesn_mes', [$currentmonth, $defaultmonth])
                                                ->delete();

            $dropsaldostercerosnif = SaldoTerceroNif::whereBetween('saldostercerosn_ano', [$currentyear, $defaultyear])
                                                ->whereBetween('saldostercerosn_mes', [$currentmonth, $defaultmonth])
                                                ->delete();

            $asientos = Asiento::whereBetween('asiento1_ano', [$currentyear, $defaultyear])
                                ->whereBetween('asiento1_mes', [$currentmonth, $defaultmonth])
                                ->get();
            // Recorrer asientos
            foreach ($asientos as $asiento) {
                // Recorrer detalles del asiento
                $cuentas = [];
                foreach ($asiento->detalle as $asiento2) {
                    $arCuenta = [];
                    $arCuenta['Cuenta'] = $asiento2->asiento2_cuenta;
                    $arCuenta['Tercero'] = $asiento2->asiento2_beneficiario;
                    $arCuenta['Credito'] = $asiento2->asiento2_credito;
                    $arCuenta['Debito'] = $asiento2->asiento2_debito;
                    $cuentas[] = $arCuenta;
                }

                foreach ($cuentas as $cuenta) {
                    $objCuenta = PlanCuenta::find($cuenta['Cuenta']);
                    if(!$objCuenta instanceof PlanCuenta) {
                        DB::rollback();
                        throw new \Exception('No es posible recuperar el plan de cuentas.');
                    }

                    // Recuperar tercero
                    $objTercero = Tercero::find($cuenta['Tercero']);
                    if(!$objTercero instanceof Tercero) {
                        DB::rollback();
                        throw new \Exception('No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.');
                    }

                    // Mayorizacion de saldos x tercero
                    $saldosterceros = $this->saldosTerceros($objCuenta, $objTercero, $cuenta['Debito'], $cuenta['Credito'], $asiento->asiento1_mes, $asiento->asiento1_ano);
                    if($saldosterceros != 'OK') {
                        DB::rollback();
                        throw new \Exception($saldosterceros);
                    }

                    // Mayorizacion de saldos x mes
                    $saldoscontables = $this->saldosContables($objCuenta, $cuenta['Debito'], $cuenta['Credito'], $asiento->asiento1_mes, $asiento->asiento1_ano);
                    if($saldoscontables != 'OK') {
                        DB::rollback();
                        throw new \Exception($saldoscontables);
                    }
                }
            }

            $asientosn = AsientoNif::whereBetween('asienton1_ano', [$currentyear, $defaultyear])
                                ->whereBetween('asienton1_mes', [$currentmonth, $defaultmonth])
                                ->get();
            // Recorrer asientosn
            foreach ($asientosn as $asienton) {
                // Recorrer detalles del $asienton
                $cuentas = [];
                foreach ($asienton->detalle as $asienton2) {
                    $arCuenta = [];
                    $arCuenta['Cuenta'] = $asienton2->asienton2_cuenta;
                    $arCuenta['Tercero'] = $asienton2->asienton2_beneficiario;
                    $arCuenta['Credito'] = $asienton2->asienton2_credito;
                    $arCuenta['Debito'] = $asienton2->asienton2_debito;
                    $cuentas[] = $arCuenta;
                }

                foreach ($cuentas as $cuenta) {
                    $objCuenta = PlanCuentaNif::find($cuenta['Cuenta']);
                    if(!$objCuenta instanceof PlanCuentaNif) {
                        DB::rollback();
                        throw new \Exception('No es posible recuperar el plan de cuentas.');
                    }

                    // Recuperar tercero
                    $objTercero = Tercero::find($cuenta['Tercero']);
                    if(!$objTercero instanceof Tercero) {
                        DB::rollback();
                        throw new \Exception('No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.');
                    }

                    // Mayorizacion de saldos x tercero
                    $saldostercerosnif = $this->saldosTercerosNif($objCuenta, $objTercero, $cuenta['Debito'], $cuenta['Credito'], $asienton->asienton1_mes, $asienton->asienton1_ano);
                    if($saldostercerosnif != 'OK') {
                        DB::rollback();
                        throw new \Exception($saldostercerosnif);
                    }

                    // Mayorizacion de saldos x mes
                    $saldoscontablesnif = $this->saldosContablesNif($objCuenta, $cuenta['Debito'], $cuenta['Credito'], $asienton->asienton1_mes, $asienton->asienton1_ano);
                    if($saldoscontablesnif != 'OK') {
                        DB::rollback();
                        throw new \Exception($saldoscontablesnif);
                    }
                }
            }

            // Crear nueva notifiacion (tercero, title, description, fh)
            Notificacion::nuevaNotificacion($this->argument('user'), 'Rutina de saldos', "Se actualizaron con exito los saldos del mes {$currentmonth} a {$defaultmonth} y año {$currentyear}.", Carbon::now());
            DB::commit();
            Log::info("Se actualizaron los saldos con exito.");
        } catch (\Exception $e) {
            DB::rollback();
            Notificacion::nuevaNotificacion($this->argument('user'), 'Error en la rutina', "Por favor comuníquese con el administrador, mes del {$currentmonth} a {$defaultmonth} y año {$currentyear}.", Carbon::now());
            Log::error("{$e->getMessage()}");
        }
    }

    // Funcion para mayorizar saldos terceros asientos
    public function saldosTerceros(PlanCuenta $cuenta, Tercero $tercero, $debito, $credito, $asiento_mes, $asiento_ano) {
        $globalmes = $asiento_mes;
        $globalano = $asiento_ano;

        // Recuperar registro saldos terceros
        $objSaldoTercero = SaldoTercero::where('saldosterceros_cuenta', $cuenta->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_ano', $asiento_ano)->where('saldosterceros_mes', $asiento_mes)->first();
        if(!$objSaldoTercero instanceof SaldoTercero) {
    		// Crear registro en saldos terceros
    		$objSaldoTercero = new SaldoTercero;
    		$objSaldoTercero->saldosterceros_cuenta = $cuenta->id;
    		$objSaldoTercero->saldosterceros_tercero = $tercero->id;
    		$objSaldoTercero->saldosterceros_ano = $asiento_ano;
    		$objSaldoTercero->saldosterceros_mes = $asiento_mes;
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
    	while (true) {
            if($asiento_mes == 1) {
                $asiento_mes2 = 13;
                $asiento_ano2 = $asiento_ano - 1;
            }else{
                $asiento_mes2 = $asiento_mes - 1;
                $asiento_ano2 = $asiento_ano;
            }

			$sql = "
				SELECT DISTINCT s1.saldosterceros_cuenta, s1.saldosterceros_tercero,
				(select (CASE when plancuentas_naturaleza = 'D'
						THEN (s2.saldosterceros_debito_inicial-s2.saldosterceros_credito_inicial)
						ELSE (s2.saldosterceros_credito_inicial-s2.saldosterceros_debito_inicial)
						END)
					FROM koi_saldosterceros as s2
					WHERE s2.saldosterceros_mes = $asiento_mes2
					and s2.saldosterceros_ano = $asiento_ano2
					and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
					and s2.saldosterceros_tercero = s1.saldosterceros_tercero
				)as inicial,
				(select SUM(s2.saldosterceros_debito_mes)
					FROM koi_saldosterceros as s2
					WHERE s2.saldosterceros_mes = $asiento_mes
					and s2.saldosterceros_ano = $asiento_ano
					and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
					and s2.saldosterceros_tercero = s1.saldosterceros_tercero
				)as debitomes,
				(select SUM(s2.saldosterceros_credito_mes)
					FROM koi_saldosterceros as s2
					WHERE s2.saldosterceros_mes = $asiento_mes
					and s2.saldosterceros_ano = $asiento_ano
					and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
					and s2.saldosterceros_tercero = s1.saldosterceros_tercero
				)as creditomes,
				plancuentas_cuenta, plancuentas_naturaleza, plancuentas_nombre

				FROM koi_saldosterceros as s1, koi_plancuentas
				WHERE (s1.saldosterceros_mes = $asiento_mes OR s1.saldosterceros_mes = $asiento_mes2)";
			if($asiento_ano == $asiento_ano2) {
				$sql.=" and( s1.saldosterceros_ano = $asiento_ano)";
			}else{
				$sql.=" and( s1.saldosterceros_ano = $asiento_ano OR s1.saldosterceros_ano =".$asiento_ano2.")";
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
				if($saldo->plancuentas_naturaleza == 'D') {
					$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
				}else if($saldo->plancuentas_naturaleza == 'C') {
					$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
				}

				// Recuperar registro saldos terceros
				$objSaldoTercero = SaldoTercero::where('saldosterceros_cuenta', $cuenta->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_ano', $asiento_ano)->where('saldosterceros_mes', $asiento_mes)->first();
				if(!$objSaldoTercero instanceof SaldoTercero) {
		            // Recuperar niveles cuenta
					$niveles = PlanCuenta::getNivelesCuenta($saldo->plancuentas_cuenta);
			        if(!is_array($niveles)) {
						return "Error al recuperar niveles para la cuenta {$saldo->plancuentas_cuenta}, saldos iniciales.";
			        }

		    		$objSaldoTercero = new SaldoTercero;
		    		$objSaldoTercero->saldosterceros_cuenta = $cuenta->id;
		    		$objSaldoTercero->saldosterceros_tercero = $tercero->id;
		    		$objSaldoTercero->saldosterceros_ano = $asiento_ano;
		    		$objSaldoTercero->saldosterceros_mes = $asiento_mes;
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

            if($asiento_mes == date('m') && $asiento_ano == date('Y')) {
                break;
            }

            if($asiento_mes == 13) {
                $asiento_mes = 1;
                $asiento_ano++;
            } else {
                $asiento_mes++;
            }
        }

        $asiento_mes = $globalmes;
        $asiento_ano = $globalano;

        // Saldos iniciales
        return 'OK';
    }

    // Funcion para mayorizar saldos contables asientos
    public function saldosContables(PlanCuenta $cuenta, $debito, $credito, $asiento_mes, $asiento_ano) {
        // Initialize global filters
        $globalmes = $asiento_mes;
        $globalano = $asiento_ano;

        // Recuperar cuentas a mayorizar
        $cuentas = $cuenta->getMayorizarCuentas();
        if(!is_array($cuentas) || count($cuentas) == 0) {
            return "Error al recuperar cuentas para mayorizar.";
        }

        // Recorrer cuentas de hijo a padre
        foreach ($cuentas as $item) {
            // Recuperar cuenta
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $item)->first();
            if(!$objCuenta instanceof PlanCuenta){
                DB::rollback();
                return Log::error('No es posible recuperar cuenta para mayorización.');
            }

            // Guardar en saldoscontables
            $saldoscontables = SaldoContable::where('saldoscontables_ano', $asiento_ano)->where('saldoscontables_mes', $asiento_mes)->where('saldoscontables_cuenta', $objCuenta->id)->first();
            if(!$saldoscontables instanceof SaldoContable){
                $saldoscontables = new SaldoContable;
                $saldoscontables->saldoscontables_cuenta = $objCuenta->id;
                $saldoscontables->saldoscontables_ano = $asiento_ano;
                $saldoscontables->saldoscontables_mes = $asiento_mes;
                $saldoscontables->saldoscontables_nivel1 = $objCuenta->plancuentas_nivel1;
                $saldoscontables->saldoscontables_nivel2 = $objCuenta->plancuentas_nivel2;
                $saldoscontables->saldoscontables_nivel3 = $objCuenta->plancuentas_nivel3;
                $saldoscontables->saldoscontables_nivel4 = $objCuenta->plancuentas_nivel4;
                $saldoscontables->saldoscontables_nivel5 = $objCuenta->plancuentas_nivel5;
                $saldoscontables->saldoscontables_nivel6 = $objCuenta->plancuentas_nivel6;
                $saldoscontables->saldoscontables_nivel7 = $objCuenta->plancuentas_nivel7;
                $saldoscontables->saldoscontables_nivel8 = $objCuenta->plancuentas_nivel8;
                $saldoscontables->saldoscontables_debito_mes = $debito;
                $saldoscontables->saldoscontables_credito_mes = $credito;
                $saldoscontables->save();

            } else {
        		// Debito
        		if ($debito){
        			$saldo = ($saldoscontables->saldoscontables_debito_mes ? $saldoscontables->saldoscontables_debito_mes : 0) + $debito;
        			$saldoscontables->saldoscontables_debito_mes = $saldo;
        			$saldoscontables->save();
        		}

        		// Credito
        		if($credito){
        			$saldo = ($saldoscontables->saldoscontables_credito_mes ? $saldoscontables->saldoscontables_credito_mes : 0) + $credito;
        			$saldoscontables->saldoscontables_credito_mes = $saldo;
        			$saldoscontables->save();
        		}
            }

            // Saldos iniciales
            while (true) {

        		if($asiento_mes == 1) {
					$asiento_mes2 = 13;
					$asiento_ano2 = $asiento_ano - 1;
				}else{
					$asiento_mes2 = $asiento_mes - 1;
					$asiento_ano2 = $asiento_ano;
				}

        		$sql = "
        			SELECT koi_plancuentas.id as plancuentas_id, plancuentas_nombre, plancuentas_cuenta, plancuentas_naturaleza,
        			(select (CASE when plancuentas_naturaleza = 'D'
        					THEN (saldoscontables_debito_inicial-saldoscontables_credito_inicial)
        					ELSE (saldoscontables_credito_inicial-saldoscontables_debito_inicial)
        					END)
        				FROM koi_saldoscontables
        				WHERE saldoscontables_mes = $asiento_mes2
        				and saldoscontables_ano = $asiento_ano2
        				and saldoscontables_cuenta = koi_plancuentas.id
        			) as inicial,
        			(select (saldoscontables_debito_mes)
        				FROM koi_saldoscontables
        				WHERE saldoscontables_mes = $asiento_mes
        				and saldoscontables_ano = $asiento_ano
        				and saldoscontables_cuenta = koi_plancuentas.id
        			) as debitomes,
        			(select (saldoscontables_credito_mes)
        				FROM koi_saldoscontables
        				WHERE saldoscontables_mes = $asiento_mes
        				and saldoscontables_ano = $asiento_ano
        				and saldoscontables_cuenta = koi_plancuentas.id
        			) as creditomes
        			FROM koi_plancuentas
        			WHERE koi_plancuentas.id IN (
        				SELECT s.saldoscontables_cuenta
        				FROM koi_saldoscontables as s
        				WHERE s.saldoscontables_mes = $asiento_mes and s.saldoscontables_ano = $asiento_ano
        				UNION
        				SELECT s.saldoscontables_cuenta
        				FROM koi_saldoscontables as s
        				WHERE s.saldoscontables_mes = $asiento_mes2 and s.saldoscontables_ano = $asiento_ano2
        			)
        			and koi_plancuentas.id = {$objCuenta->id} order by plancuentas_cuenta ASC";
                $arSaldos = DB::select($sql);
                if(!is_array($arSaldos)) {
        			return "Se genero un error al consultar los saldos, por favor verifique la información del asiento o consulte al administrador.";
                }

                foreach ($arSaldos as $saldo) {
					if($saldo->plancuentas_naturaleza == 'D') {
						$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);

					}else if($saldo->plancuentas_naturaleza == 'C') {
						$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
					}

			        // Recuperar registro saldos contable
		            $objSaldoContable = SaldoContable::where('saldoscontables_cuenta', $saldo->plancuentas_id)->where('saldoscontables_ano', $asiento_ano)->where('saldoscontables_mes', $asiento_mes)->first();
		        	if(!$objSaldoContable instanceof SaldoContable) {

			            // Recuperar niveles cuenta
						$niveles = PlanCuenta::getNivelesCuenta($saldo->plancuentas_cuenta);
				        if(!is_array($niveles)) {
							return "Error al recuperar niveles para la cuenta {$saldo->plancuentas_cuenta}, saldos iniciales.";
				        }

		        		// Crear registro en saldos contables
		        		$objSaldoContable = new SaldoContable;
		        		$objSaldoContable->saldoscontables_cuenta = $saldo->plancuentas_id;
		        		$objSaldoContable->saldoscontables_ano = $asiento_ano;
		        		$objSaldoContable->saldoscontables_mes = $asiento_mes;
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

				if($asiento_mes == date('m') && $asiento_ano == date('Y')) {
					break;
				}

				if($asiento_mes == 13) {
					$asiento_mes = 1;
					$asiento_ano++;
				}else{
					$asiento_mes++;
				}
            }

            $asiento_mes = $globalmes;
            $asiento_ano = $globalano;
        }

        return 'OK';
    }

    // Funcion para mayorizar saldos terceros asientosnif
    public function saldosTercerosNif(PlanCuentaNif $cuenta, Tercero $tercero, $debito, $credito, $asiento_mes, $asiento_ano) {
        $globalmes = $asiento_mes;
        $globalano = $asiento_ano;

        // Recuperar registro saldos terceros
        $objSaldoTerceroNif = SaldoTerceroNif::where('saldostercerosn_cuenta', $cuenta->id)->where('saldostercerosn_tercero', $tercero->id)->where('saldostercerosn_ano', $asiento_ano)->where('saldostercerosn_mes', $asiento_mes)->first();
        if(!$objSaldoTerceroNif instanceof SaldoTerceroNif) {
    		// Crear registro en saldos terceros
    		$objSaldoTerceroNif = new SaldoTerceroNif;
    		$objSaldoTerceroNif->saldostercerosn_cuenta = $cuenta->id;
    		$objSaldoTerceroNif->saldostercerosn_tercero = $tercero->id;
    		$objSaldoTerceroNif->saldostercerosn_ano = $asiento_ano;
    		$objSaldoTerceroNif->saldostercerosn_mes = $asiento_mes;
    		$objSaldoTerceroNif->saldostercerosn_nivel1 = $cuenta->plancuentasn_nivel1;
    		$objSaldoTerceroNif->saldostercerosn_nivel2 = $cuenta->plancuentasn_nivel2;
    		$objSaldoTerceroNif->saldostercerosn_nivel3 = $cuenta->plancuentasn_nivel3;
    		$objSaldoTerceroNif->saldostercerosn_nivel4 = $cuenta->plancuentasn_nivel4;
    		$objSaldoTerceroNif->saldostercerosn_nivel5 = $cuenta->plancuentasn_nivel5;
    		$objSaldoTerceroNif->saldostercerosn_nivel6 = $cuenta->plancuentasn_nivel6;
    		$objSaldoTerceroNif->saldostercerosn_nivel7 = $cuenta->plancuentasn_nivel7;
    		$objSaldoTerceroNif->saldostercerosn_nivel8 = $cuenta->plancuentasn_nivel8;
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
    	while (true) {
            if($asiento_mes == 1) {
                $asiento_mes2 = 13;
                $asiento_ano2 = $asiento_ano - 1;
            }else{
                $asiento_mes2 = $asiento_mes - 1;
                $asiento_ano2 = $asiento_ano;
            }

			$sql = "
				SELECT DISTINCT s1.saldostercerosn_cuenta, s1.saldostercerosn_tercero,
				(select (CASE when plancuentasn_naturaleza = 'D'
						THEN (s2.saldostercerosn_debito_inicial-s2.saldostercerosn_credito_inicial)
						ELSE (s2.saldostercerosn_credito_inicial-s2.saldostercerosn_debito_inicial)
						END)
					FROM koi_saldostercerosn as s2
					WHERE s2.saldostercerosn_mes = $asiento_mes2
					and s2.saldostercerosn_ano = $asiento_ano2
					and s2.saldostercerosn_cuenta = s1.saldostercerosn_cuenta
					and s2.saldostercerosn_tercero = s1.saldostercerosn_tercero
				)as inicial,
				(select SUM(s2.saldostercerosn_debito_mes)
					FROM koi_saldostercerosn as s2
					WHERE s2.saldostercerosn_mes = $asiento_mes
					and s2.saldostercerosn_ano = $asiento_ano
					and s2.saldostercerosn_cuenta = s1.saldostercerosn_cuenta
					and s2.saldostercerosn_tercero = s1.saldostercerosn_tercero
				)as debitomes,
				(select SUM(s2.saldostercerosn_credito_mes)
					FROM koi_saldostercerosn as s2
					WHERE s2.saldostercerosn_mes = $asiento_mes
					and s2.saldostercerosn_ano = $asiento_ano
					and s2.saldostercerosn_cuenta = s1.saldostercerosn_cuenta
					and s2.saldostercerosn_tercero = s1.saldostercerosn_tercero
				)as creditomes,
				plancuentasn_cuenta, plancuentasn_naturaleza, plancuentasn_nombre

				FROM koi_saldostercerosn as s1, koi_plancuentasn
				WHERE (s1.saldostercerosn_mes = $asiento_mes OR s1.saldostercerosn_mes = $asiento_mes2)";
			if($asiento_ano == $asiento_ano2) {
				$sql.=" and( s1.saldostercerosn_ano = $asiento_ano)";
			}else{
				$sql.=" and( s1.saldostercerosn_ano = $asiento_ano OR s1.saldostercerosn_ano =".$asiento_ano2.")";
			}

			$sql .= "
				and s1.saldostercerosn_cuenta = koi_plancuentasn.id
				and s1.saldostercerosn_cuenta = {$cuenta->id}
				ORDER BY s1.saldostercerosn_cuenta ASC, s1.saldostercerosn_tercero ASC";
			$arSaldos = DB::select($sql);
	        if(!is_array($arSaldos)) {
				return "Se genero un error al consultar los saldos tercero, por favor verifique la información del asiento o consulte al administrador.";
			}

	        foreach ($arSaldos as $saldo) {
				if($saldo->plancuentasn_naturaleza == 'D') {
					$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
				}else if($saldo->plancuentasn_naturaleza == 'C') {
					$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
				}

				// Recuperar registro saldos terceros
				$objSaldoTerceroNif = SaldoTerceroNif::where('saldostercerosn_cuenta', $cuenta->id)->where('saldostercerosn_tercero', $tercero->id)->where('saldostercerosn_tercero', $tercero->id)->where('saldostercerosn_ano', $asiento_ano)->where('saldostercerosn_mes', $asiento_mes)->first();
				if(!$objSaldoTerceroNif instanceof SaldoTerceroNif) {
		            // Recuperar niveles cuenta
					$niveles = PlanCuentaNif::getNivelesCuenta($saldo->plancuentasn_cuenta);
			        if(!is_array($niveles)) {
						return "Error al recuperar niveles para la cuenta {$saldo->plancuentasn_cuenta}, saldos iniciales.";
			        }

		    		$objSaldoTerceroNif = new SaldoTercero;
		    		$objSaldoTerceroNif->saldostercerosn_cuenta = $cuenta->id;
		    		$objSaldoTerceroNif->saldostercerosn_tercero = $tercero->id;
		    		$objSaldoTerceroNif->saldostercerosn_ano = $asiento_ano;
		    		$objSaldoTerceroNif->saldostercerosn_mes = $asiento_mes;
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

            if($asiento_mes == date('m') && $asiento_ano == date('Y')) {
                break;
            }

            if($asiento_mes == 13) {
                $asiento_mes = 1;
                $asiento_ano++;
            } else {
                $asiento_mes++;
            }
        }

        $asiento_mes = $globalmes;
        $asiento_ano = $globalano;

        // Saldos nif iniciales
        return 'OK';
    }

    // Funcion para mayorizar saldos contables asientosnif
    public function saldosContablesNif(PlanCuentaNif $cuenta, $debito, $credito, $asiento_mes, $asiento_ano) {
        // Initialize global filters
        $globalmes = $asiento_mes;
        $globalano = $asiento_ano;

        // Recuperar cuentas a mayorizar
        $cuentas = $cuenta->getMayorizarCuentas();
        if(!is_array($cuentas) || count($cuentas) == 0) {
            return "Error al recuperar cuentas para mayorizar.";
        }

        // Recorrer cuentas de hijo a padre
        foreach ($cuentas as $item) {
            // Recuperar cuenta
            $objCuenta = PlanCuentaNif::where('plancuentasn_cuenta', $item)->first();
            if(!$objCuenta instanceof PlanCuentaNif){
                DB::rollback();
                return Log::error('No es posible recuperar cuenta para mayorización.');
            }

            // Guardar en saldoscontables
            $saldoscontablesn = SaldoContableNif::where('saldoscontablesn_ano', $asiento_ano)->where('saldoscontablesn_mes', $asiento_mes)->where('saldoscontablesn_cuenta', $objCuenta->id)->first();
            if(!$saldoscontablesn instanceof SaldoContableNif){
                $saldoscontablesn = new SaldoContableNif;
                $saldoscontablesn->saldoscontablesn_cuenta = $objCuenta->id;
                $saldoscontablesn->saldoscontablesn_ano = $asiento_ano;
                $saldoscontablesn->saldoscontablesn_mes = $asiento_mes;
                $saldoscontablesn->saldoscontablesn_nivel1 = $objCuenta->plancuentasn_nivel1;
                $saldoscontablesn->saldoscontablesn_nivel2 = $objCuenta->plancuentasn_nivel2;
                $saldoscontablesn->saldoscontablesn_nivel3 = $objCuenta->plancuentasn_nivel3;
                $saldoscontablesn->saldoscontablesn_nivel4 = $objCuenta->plancuentasn_nivel4;
                $saldoscontablesn->saldoscontablesn_nivel5 = $objCuenta->plancuentasn_nivel5;
                $saldoscontablesn->saldoscontablesn_nivel6 = $objCuenta->plancuentasn_nivel6;
                $saldoscontablesn->saldoscontablesn_nivel7 = $objCuenta->plancuentasn_nivel7;
                $saldoscontablesn->saldoscontablesn_nivel8 = $objCuenta->plancuentasn_nivel8;
                $saldoscontablesn->saldoscontablesn_debito_mes = $debito;
                $saldoscontablesn->saldoscontablesn_credito_mes = $credito;
                $saldoscontablesn->save();

            } else {
        		// Debito
        		if ($debito){
        			$saldo = ($saldoscontablesn->saldoscontablesn_debito_mes ? $saldoscontablesn->saldoscontablesn_debito_mes : 0) + $debito;
        			$saldoscontablesn->saldoscontablesn_debito_mes = $saldo;
        			$saldoscontablesn->save();
        		}

        		// Credito
        		if($credito){
        			$saldo = ($saldoscontablesn->saldoscontablesn_credito_mes ? $saldoscontablesn->saldoscontablesn_credito_mes : 0) + $credito;
        			$saldoscontablesn->saldoscontablesn_credito_mes = $saldo;
        			$saldoscontablesn->save();
        		}
            }

            // Saldos iniciales
            while (true) {
        		if($asiento_mes == 1) {
					$asiento_mes2 = 13;
					$asiento_ano2 = $asiento_ano - 1;
				}else{
					$asiento_mes2 = $asiento_mes - 1;
					$asiento_ano2 = $asiento_ano;
				}

        		$sql = "
        			SELECT koi_plancuentasn.id as plancuentasn_id, plancuentasn_nombre, plancuentasn_cuenta, plancuentasn_naturaleza,
        			(select (CASE when plancuentasn_naturaleza = 'D'
        					THEN (saldoscontablesn_debito_inicial-saldoscontablesn_credito_inicial)
        					ELSE (saldoscontablesn_credito_inicial-saldoscontablesn_debito_inicial)
        					END)
        				FROM koi_saldoscontablesn
        				WHERE saldoscontablesn_mes = $asiento_mes2
        				and saldoscontablesn_ano = $asiento_ano2
        				and saldoscontablesn_cuenta = koi_plancuentasn.id
        			) as inicial,
        			(select (saldoscontablesn_debito_mes)
        				FROM koi_saldoscontablesn
        				WHERE saldoscontablesn_mes = $asiento_mes
        				and saldoscontablesn_ano = $asiento_ano
        				and saldoscontablesn_cuenta = koi_plancuentasn.id
        			) as debitomes,
        			(select (saldoscontablesn_credito_mes)
        				FROM koi_saldoscontablesn
        				WHERE saldoscontablesn_mes = $asiento_mes
        				and saldoscontablesn_ano = $asiento_ano
        				and saldoscontablesn_cuenta = koi_plancuentasn.id
        			) as creditomes
        			FROM koi_plancuentasn
        			WHERE koi_plancuentasn.id IN (
        				SELECT s.saldoscontablesn_cuenta
        				FROM koi_saldoscontablesn as s
        				WHERE s.saldoscontablesn_mes = $asiento_mes and s.saldoscontablesn_ano = $asiento_ano
        				UNION
        				SELECT s.saldoscontablesn_cuenta
        				FROM koi_saldoscontablesn as s
        				WHERE s.saldoscontablesn_mes = $asiento_mes2 and s.saldoscontablesn_ano = $asiento_ano2
        			)
        			and koi_plancuentasn.id = {$objCuenta->id} order by plancuentasn_cuenta ASC";
                $arSaldos = DB::select($sql);
                if(!is_array($arSaldos)) {
        			return "Se genero un error al consultar los saldos, por favor verifique la información o consulte al administrador.";
                }

                foreach ($arSaldos as $saldo) {
					if($saldo->plancuentasn_naturaleza == 'D') {
						$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);

					}else if($saldo->plancuentasn_naturaleza == 'C') {
						$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
					}

			        // Recuperar registro saldos contable
		            $objSaldoContableNif = SaldoContableNif::where('saldoscontablesn_cuenta', $saldo->plancuentasn_id)->where('saldoscontablesn_ano', $asiento_ano)->where('saldoscontablesn_mes', $asiento_mes)->first();
		        	if(!$objSaldoContableNif instanceof SaldoContableNif) {

			            // Recuperar niveles cuenta
						$niveles = PlanCuentaNif::getNivelesCuenta($saldo->plancuentasn_cuenta);
				        if(!is_array($niveles)) {
							return "Error al recuperar niveles para la cuenta {$saldo->plancuentasn_cuenta}, saldos iniciales (NIFF).";
				        }

		        		// Crear registro en saldos contables
		        		$objSaldoContableNif = new SaldoContableNif;
		        		$objSaldoContableNif->saldoscontablesn_cuenta = $saldo->plancuentasn_id;
		        		$objSaldoContableNif->saldoscontablesn_ano = $asiento_ano;
		        		$objSaldoContableNif->saldoscontablesn_mes = $asiento_mes;
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
						return "No se puede definir la naturaleza {$saldo->plancuentasn_naturaleza} de la cuenta, por favor verifique la información o consulte al administrador.";
					}
					$objSaldoContableNif->save();
		        }

				if($asiento_mes == date('m') && $asiento_ano == date('Y')) {
					break;
				}

				if($asiento_mes == 13) {
					$asiento_mes = 1;
					$asiento_ano++;
				}else{
					$asiento_mes++;
				}
            }

            $asiento_mes = $globalmes;
            $asiento_ano = $globalano;
        }

        return 'OK';
    }
}
