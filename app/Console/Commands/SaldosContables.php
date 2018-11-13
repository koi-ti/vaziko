<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accounting\Asiento, App\Models\Accounting\PlanCuenta, App\Models\Accounting\AsientoNif, App\Models\Accounting\PlanCuentaNif, App\Models\Accounting\SaldoContable, App\Models\Accounting\SaldoTercero, App\Models\Accounting\SaldoContableNif, App\Models\Accounting\SaldoTerceroNif, App\Models\Base\Tercero, App\Models\Base\Notificacion;
use DB, Auth, Log, Carbon\Carbon;

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

        $this->currentmonth = Carbon::now()->month;
        $this->currentyear = Carbon::now()->year;
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
            $chosenmonth = $this->argument('mes');
            $chosenyear = $this->argument('ano');

            // Eliminar saldos contables existentes del rango de fecha seleccionado hasta fecha actual nif y normales
            $dropsaldoscontables = SaldoContable::whereBetween('saldoscontables_ano', [$chosenyear, $this->currentyear])
                                                ->whereBetween('saldoscontables_mes', [$chosenmonth, $this->currentmonth])
                                                ->delete();

            $dropsaldosterceros = SaldoTercero::whereBetween('saldosterceros_ano', [$chosenyear, $this->currentyear])
                                                ->whereBetween('saldosterceros_mes', [$chosenmonth, $this->currentmonth])
                                                ->delete();

            $dropsaldoscontablesnif = SaldoContableNif::whereBetween('saldoscontablesn_ano', [$chosenyear, $this->currentyear])
                                                ->whereBetween('saldoscontablesn_mes', [$chosenmonth, $this->currentmonth])
                                                ->delete();

            $dropsaldostercerosnif = SaldoTerceroNif::whereBetween('saldostercerosn_ano', [$chosenyear, $this->currentyear])
                                                ->whereBetween('saldostercerosn_mes', [$chosenmonth, $this->currentmonth])
                                                ->delete();

            $asientos = Asiento::whereBetween('asiento1_ano', [$chosenyear, $this->currentyear])
                                ->whereBetween('asiento1_mes', [$chosenmonth, $this->currentmonth])
                                ->get();

            // Recorrer asientos
            foreach ($asientos as $asiento) {
                // Recorrer detalles del asiento
                foreach ($asiento->detalle as $asiento2) {
                    $cuenta = PlanCuenta::find( $asiento2->asiento2_cuenta );
                    if( !$cuenta instanceof PlanCuenta ) {
                        throw new \Exception('No es posible recuperar el plan de cuentas.');
                    }

                    // Recuperar tercero
                    $tercero = Tercero::find( $asiento2->asiento2_beneficiario );
                    if(!$tercero instanceof Tercero) {
                        throw new \Exception('No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.');
                    }

                    // Mayorizacion de saldos x tercero
                    $saldosterceros = $this->saldosTerceros($cuenta, $tercero, $asiento2->asiento2_debito, $asiento2->asiento2_credito, $asiento->asiento1_mes, $asiento->asiento1_ano);
                    if($saldosterceros != 'OK') {
                        throw new \Exception($saldosterceros);
                    }

                    // Mayorizacion de saldos x mes
                    $saldoscontables = $this->saldosContables($cuenta, $asiento2->asiento2_debito, $asiento2->asiento2_credito, $asiento->asiento1_mes, $asiento->asiento1_ano);
                    if($saldoscontables != 'OK') {
                        throw new \Exception($saldoscontables);
                    }
                }
            }

            $asientosn = AsientoNif::whereBetween('asienton1_ano', [$chosenyear, $this->currentyear])
                                    ->whereBetween('asienton1_mes', [$chosenmonth, $this->currentmonth])
                                    ->get();

            // Recorrer asientosn
            foreach ($asientosn as $asienton) {
                // Recorrer detalles del $asienton
                foreach ($asienton->detalle as $asienton2) {
                    $cuenta = PlanCuentaNif::find( $asienton2->asienton2_cuenta );
                    if(!$cuenta instanceof PlanCuentaNif) {
                        throw new \Exception('No es posible recuperar el plan de cuentas.');
                    }

                    // Recuperar tercero
                    $tercero = Tercero::find( $asienton2->asienton2_beneficiario );
                    if(!$tercero instanceof Tercero) {
                        throw new \Exception('No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.');
                    }

                    // Mayorizacion de saldos x tercero
                    $saldostercerosnif = $this->saldosTercerosNif($cuenta, $tercero, $asienton2->asienton2_debito, $asienton2->asienton2_credito, $asienton->asienton1_mes, $asienton->asienton1_ano);
                    if($saldostercerosnif != 'OK') {
                        throw new \Exception($saldostercerosnif);
                    }

                    // Mayorizacion de saldos x mes
                    $saldoscontablesnif = $this->saldosContablesNif($cuenta, $asienton2->asienton2_debito, $asienton2->asienton2_credito, $asienton->asienton1_mes, $asienton->asienton1_ano);
                    if($saldoscontablesnif != 'OK') {
                        throw new \Exception($saldoscontablesnif);
                    }
                }
            }

            // Crear nueva notifiacion (tercero, title, description, fh)
            DB::commit();
            Log::info("Se actualizaron los saldos con exito.");
            return Notificacion::nuevaNotificacion($this->argument('user'), 'Rutina de saldos', "Se actualizaron con exito los saldos del mes {$chosenmonth} a {$this->currentmonth} y año {$chosenyear}.", Carbon::now());
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{$e->getMessage()}");
            return Notificacion::nuevaNotificacion($this->argument('user'), 'Error en la rutina', "Por favor comuníquese con el administrador, mes del {$chosenmonth} a {$this->currentmonth} y año {$chosenyear}.", Carbon::now());
        }
    }

    // Funcion para mayorizar saldos terceros asientos {cuenta, tercero, debito, credito, mes, ano}
    public function saldosTerceros(PlanCuenta $cuenta, Tercero $tercero, $debito = 0, $credito = 0, $xmes, $xano)
	{
        $asiento_mes = $xmes;
        $asiento_ano = $xano;

        // Recuperar registro saldos terceros
		$objSaldoTercero = SaldoTercero::where('saldosterceros_cuenta', $cuenta->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_ano', $xano)->where('saldosterceros_mes', $xmes)->first();
    	if(!$objSaldoTercero instanceof SaldoTercero) {
    		// Crear registro en saldos terceros
    		$objSaldoTercero = new SaldoTercero;
    		$objSaldoTercero->saldosterceros_cuenta = $cuenta->id;
    		$objSaldoTercero->saldosterceros_tercero = $tercero->id;
    		$objSaldoTercero->saldosterceros_ano = $xano;
    		$objSaldoTercero->saldosterceros_mes = $xmes;
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
		$xano = $asiento_ano;
		$xmes = $asiento_mes;

		// Saldos iniciales
		return 'OK';
	}

    // Funcion para mayorizar saldos contables asientos {cuenta, debito, credito, mes, ano}
    public function saldosContables(PlanCuenta $cuenta, $debito = 0, $credito = 0, $xmes, $xano)
    {
        $asiento_mes = $xmes;
        $asiento_ano = $xano;

        // Recuperar cuentas a mayorizar
        $mayorizaciones = $cuenta->getMayorizarCuentas();
        if(!is_array($mayorizaciones) || count($mayorizaciones) == 0) {
            return "Error al recuperar cuentas para mayorizar.";
        }

        // Recorrer mayorizaciones de hijo a padre
        foreach ($mayorizaciones as $mayorizar) {
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $mayorizar)->first();
            if(!$objCuenta instanceof PlanCuenta){
                return "No es posible recuperar cuenta para mayorización.";
            }

            // Guardar en saldoscontables
            $saldoscontables = SaldoContable::where('saldoscontables_ano', $xano)->where('saldoscontables_mes', $xmes)->where('saldoscontables_cuenta', $objCuenta->id)->first();
            if(!$saldoscontables instanceof SaldoContable){
                $saldoscontables = new SaldoContable;
                $saldoscontables->saldoscontables_cuenta = $objCuenta->id;
                $saldoscontables->saldoscontables_ano = $xano;
                $saldoscontables->saldoscontables_mes = $xmes;
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
                // Actualizar saldos existentes
                $saldoscontables->saldoscontables_debito_mes += $debito;
                $saldoscontables->saldoscontables_credito_mes += $credito;
                $saldoscontables->save();

            }

            while (true) {
                // Si asiento mes igual a 1, cierre del año
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

			$xano = $asiento_ano;
			$xmes = $asiento_mes;
        }
        return "OK";
    }

    // Funcion para mayorizar saldos terceros asientos nif {cuenta, tercero, debito, credito, mes, ano}
    public function saldosTercerosNif(PlanCuentaNif $cuenta, Tercero $tercero, $debito = 0, $credito = 0, $xmes, $xano)
    {
        $asiento_mes = $xmes;
        $asiento_ano = $xano;

        // Recuperar registro saldos terceros
        $objSaldoTerceroNif = SaldoTerceroNif::where('saldostercerosn_cuenta', $cuenta->id)->where('saldostercerosn_tercero', $tercero->id)->where('saldostercerosn_ano', $xano)->where('saldostercerosn_mes', $xmes)->first();
        if(!$objSaldoTerceroNif instanceof SaldoTerceroNif) {
            // Crear registro en saldos terceros
            $objSaldoTerceroNif = new SaldoTerceroNif;
            $objSaldoTerceroNif->saldostercerosn_cuenta = $cuenta->id;
            $objSaldoTerceroNif->saldostercerosn_tercero = $tercero->id;
            $objSaldoTerceroNif->saldostercerosn_ano = $xano;
            $objSaldoTerceroNif->saldostercerosn_mes = $xmes;
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
            // Actualizar debito o credito mes si existe
            $objSaldoTerceroNif->saldostercerosn_debito_mes += $debito;
            $objSaldoTerceroNif->saldostercerosn_credito_mes += $credito;
            $objSaldoTerceroNif->save();

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
                SELECT DISTINCT s1.saldostercerosn_cuenta, s1.saldostercerosn_tercero,
                (select (s2.saldostercerosn_debito_inicial)
                    FROM koi_saldostercerosn as s2
                    WHERE s2.saldostercerosn_mes = $xmes2
                    and s2.saldostercerosn_ano = $xano2
                    and s2.saldostercerosn_cuenta = s1.saldostercerosn_cuenta
                    and s2.saldostercerosn_tercero = s1.saldostercerosn_tercero
                )as debito_inicial,
                (select (s2.saldostercerosn_credito_inicial)
                    FROM koi_saldostercerosn as s2
                    WHERE s2.saldostercerosn_mes = $xmes2
                    and s2.saldostercerosn_ano = $xano2
                    and s2.saldostercerosn_cuenta = s1.saldostercerosn_cuenta
                    and s2.saldostercerosn_tercero = s1.saldostercerosn_tercero
                )as credito_inicial,
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

            foreach ($arSaldos as $saldo) {
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
                if($debito) {
                    $objSaldoTerceroNif->saldostercerosn_debito_inicial = $saldo->debito_inicial + ($saldo->debitomes - $saldo->creditomes);

                }else if($credito) {
                    $objSaldoTerceroNif->saldostercerosn_credito_inicial = $saldo->credito_inicial + ($saldo->creditomes - $saldo->debitomes);

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

        $xano = $asiento_ano;
        $xmes = $asiento_mes;

        // Saldos iniciales
        return 'OK';
    }

    // Funcion para mayorizar saldos contables asientos nif {cuenta, debito, credito, mes, ano}
    public function saldosContablesNif(PlanCuentaNif $cuenta, $debito = 0, $credito = 0, $xmes, $xano)
    {
        $asiento_mes = $xmes;
        $asiento_ano = $xano;

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
            $objSaldoContableNif = SaldoContableNif::where('saldoscontablesn_cuenta', $objCuenta->id)->where('saldoscontablesn_ano', $xano)->where('saldoscontablesn_mes', $xmes)->first();
            if(!$objSaldoContableNif instanceof SaldoContableNif) {
                // Crear registro en saldos contables
                $objSaldoContableNif = new SaldoContableNif;
                $objSaldoContableNif->saldoscontablesn_cuenta = $objCuenta->id;
                $objSaldoContableNif->saldoscontablesn_ano = $xano;
                $objSaldoContableNif->saldoscontablesn_mes = $xmes;
                $objSaldoContableNif->saldoscontablesn_nivel1 = $objCuenta->plancuentas_nivel1;
                $objSaldoContableNif->saldoscontablesn_nivel2 = $objCuenta->plancuentas_nivel2;
                $objSaldoContableNif->saldoscontablesn_nivel3 = $objCuenta->plancuentas_nivel3;
                $objSaldoContableNif->saldoscontablesn_nivel4 = $objCuenta->plancuentas_nivel4;
                $objSaldoContableNif->saldoscontablesn_nivel5 = $objCuenta->plancuentas_nivel5;
                $objSaldoContableNif->saldoscontablesn_nivel6 = $objCuenta->plancuentas_nivel6;
                $objSaldoContableNif->saldoscontablesn_nivel7 = $objCuenta->plancuentas_nivel7;
                $objSaldoContableNif->saldoscontablesn_nivel8 = $objCuenta->plancuentas_nivel8;
                $objSaldoContableNif->saldoscontablesn_debito_mes = $debito ?: 0;
                $objSaldoContableNif->saldoscontablesn_credito_mes = $credito ?: 0;
                $objSaldoContableNif->save();

            }else{
                // Actualizar debito o credito si existe
                $objSaldoContableNif->saldoscontablesn_debito_mes += $debito;
                $objSaldoContableNif->saldoscontablesn_credito_mes += $credito;
                $objSaldoContableNif->save();
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
                    SELECT koi_plancuentasn.id as plancuentasn_id, plancuentasn_nombre, plancuentasn_cuenta, plancuentasn_naturaleza,
                    (select (saldoscontablesn_debito_inicial)
                        FROM koi_saldoscontablesn
                        WHERE saldoscontablesn_mes = $xmes2
                        and saldoscontablesn_ano = $xano2
                        and saldoscontablesn_cuenta = koi_plancuentasn.id
                    ) as debito_inicial,
                    (select (saldoscontablesn_credito_inicial)
                        FROM koi_saldoscontablesn
                        WHERE saldoscontablesn_mes = $xmes2
                        and saldoscontablesn_ano = $xano2
                        and saldoscontablesn_cuenta = koi_plancuentasn.id
                    ) as credito_inicial,
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

                foreach ($arSaldos as $saldo) {
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
                    if($debito) {
                        $objSaldoContableNif->saldoscontablesn_debito_inicial = $saldo->debito_inicial + ($saldo->debitomes - $saldo->creditomes);

                    }else if($credito) {
                        $objSaldoContableNif->saldoscontablesn_credito_inicial = $saldo->credito_inicial + ($saldo->creditomes - $saldo->debitomes);

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

            $xano = $asiento_ano;
            $xmes = $asiento_mes;
        }
        return 'OK';
    }
}
