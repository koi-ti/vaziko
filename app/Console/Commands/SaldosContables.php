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

            $xmes = $chosenmonth;
            $xmes2 = $this->currentmonth;
            if ($xmes > $xmes2) {
                $chosenmonth = $xmes2;
                $this->currentmonth = $xmes;
            }

            $asientos = Asiento::whereBetween('asiento1_ano', [$chosenyear, $this->currentyear])
                                ->whereBetween('asiento1_mes', [$chosenmonth, $this->currentmonth])
                                ->get();

            // Recorrer asientos
            foreach ($asientos as $asiento) {
                // Recorrer detalles del asiento
                foreach ($asiento->detalle as $asiento2) {
                    $cuenta = PlanCuenta::find( $asiento2->asiento2_cuenta );
                    if (!$cuenta instanceof PlanCuenta) {
                        throw new \Exception('No es posible recuperar el plan de cuentas.');
                    }

                    // Recuperar tercero
                    $tercero = Tercero::find( $asiento2->asiento2_beneficiario );
                    if (!$tercero instanceof Tercero) {
                        throw new \Exception('No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.');
                    }

                    // Mayorizacion de saldos x tercero
                    $saldosterceros = $this->saldosTerceros($cuenta, $tercero, $asiento2->asiento2_debito, $asiento2->asiento2_credito, $asiento->asiento1_mes, $asiento->asiento1_ano);
                    if ($saldosterceros != 'OK') {
                        throw new \Exception($saldosterceros);
                    }

                    // Mayorizacion de saldos x mes
                    $saldoscontables = $this->saldosContables($cuenta, $asiento2->asiento2_debito, $asiento2->asiento2_credito, $asiento->asiento1_mes, $asiento->asiento1_ano);
                    if ($saldoscontables != 'OK') {
                        throw new \Exception($saldoscontables);
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
    	if (!$objSaldoTercero instanceof SaldoTercero) {
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

		} else {
			// Actualizar debito o credito mes si existe
			$objSaldoTercero->saldosterceros_debito_mes += $debito;
			$objSaldoTercero->saldosterceros_credito_mes += $credito;
			$objSaldoTercero->save();

		}

    	// Saldos iniciales
    	while (true) {
			if ($xmes == 1) {
				$xmes2 = 13;
				$xano2 = $xano - 1;
			} else {
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
			if ($xano == $xano2) {
				$sql.=" and( s1.saldosterceros_ano = $xano)";
			} else {
				$sql.=" and( s1.saldosterceros_ano = $xano OR s1.saldosterceros_ano =".$xano2.")";
			}

			$sql .= "
				and s1.saldosterceros_cuenta = koi_plancuentas.id
				and s1.saldosterceros_cuenta = {$cuenta->id}
				ORDER BY s1.saldosterceros_cuenta ASC, s1.saldosterceros_tercero ASC";
			$arSaldos = DB::select($sql);
	        if (!is_array($arSaldos)) {
				return "Se genero un error al consultar los saldos tercero, por favor verifique la información del asiento o consulte al administrador.";
			}

	        foreach ($arSaldos as $saldo) {
				// Recuperar registro saldos terceros
				$objSaldoTercero = SaldoTercero::where('saldosterceros_cuenta', $cuenta->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_tercero', $tercero->id)->where('saldosterceros_ano', $xano)->where('saldosterceros_mes', $xmes)->first();
				if (!$objSaldoTercero instanceof SaldoTercero) {
		            // Recuperar niveles cuenta
					$niveles = PlanCuenta::getNivelesCuenta($saldo->plancuentas_cuenta);
			        if (!is_array($niveles)) {
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
				if ($debito) {
					$objSaldoTercero->saldosterceros_debito_inicial = $saldo->debito_inicial + ($saldo->debitomes - $saldo->creditomes);

				} else if ($credito) {
					$objSaldoTercero->saldosterceros_credito_inicial = $saldo->credito_inicial + ($saldo->creditomes - $saldo->debitomes);

				} else {
					return "No se puede definir la naturaleza {$saldo->plancuentas_naturaleza} de la cuenta, por favor verifique la información del asiento o consulte al administrador.";

				}
				$objSaldoTercero->save();
			}

			if ($xmes == date('m') && $xano == date('Y')) {
				break;
			}

			if ($xmes == 13) {
				$xmes = 1;
				$xano++;
			} else {
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
        if (!is_array($mayorizaciones) || count($mayorizaciones) == 0) {
            return "Error al recuperar cuentas para mayorizar.";
        }

        // Recorrer mayorizaciones de hijo a padre
        foreach ($mayorizaciones as $mayorizar) {
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $mayorizar)->first();
            if (!$objCuenta instanceof PlanCuenta){
                return "No es posible recuperar cuenta para mayorización.";
            }

            // Guardar en saldoscontables
            $saldoscontables = SaldoContable::where('saldoscontables_ano', $xano)->where('saldoscontables_mes', $xmes)->where('saldoscontables_cuenta', $objCuenta->id)->first();
            if (!$saldoscontables instanceof SaldoContable){
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
                if ($xmes == 1) {
					$xmes2 = 13;
					$xano2 = $xano - 1;
				} else {
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
				if (!is_array($arSaldos)) {
				    return "Se genero un error al consultar los saldos, por favor verifique la información del asiento o consulte al administrador.";
				}

		        foreach ($arSaldos as $saldo) {
			        // Recuperar registro saldos contable
		            $objSaldoContable = SaldoContable::where('saldoscontables_cuenta', $saldo->plancuentas_id)->where('saldoscontables_ano', $xano)->where('saldoscontables_mes', $xmes)->first();
		        	if (!$objSaldoContable instanceof SaldoContable) {
			            // Recuperar niveles cuenta
						$niveles = PlanCuenta::getNivelesCuenta($saldo->plancuentas_cuenta);
				        if (!is_array($niveles)) {
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
					if ($debito) {
						$objSaldoContable->saldoscontables_debito_inicial = $saldo->debito_inicial + ($saldo->debitomes - $saldo->creditomes);
					} else if ($credito) {
						$objSaldoContable->saldoscontables_credito_inicial = $saldo->credito_inicial + ($saldo->creditomes - $saldo->debitomes);
					} else {
						return "No se puede definir la naturaleza de la cuenta, por favor verifique la información del asiento o consulte al administrador.";
					}
					$objSaldoContable->save();
				}

				if ($xmes == date('m') && $xano == date('Y')) {
					break;
				}

				if ($xmes == 13) {
					$xmes = 1;
					$xano++;
				} else {
					$xmes++;
				}
			}

			$xano = $asiento_ano;
			$xmes = $asiento_mes;
        }
        return "OK";
    }
}
