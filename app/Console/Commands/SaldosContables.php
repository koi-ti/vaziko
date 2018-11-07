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

            // Eliminar saldos contables existentes del rango de fecha seleccionado hasta fecha actual
            $dropsaldoscontables = SaldoContable::whereBetween('saldoscontables_ano', [$chosenyear, $this->currentyear])
                                                ->whereBetween('saldoscontables_mes', [$chosenmonth, $this->currentmonth])
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

                    $naturaleza = $asiento2->asiento2_debito != 0 ? 'D' : 'C';

                    // Mayorizacion de saldos x mes
                    $saldoscontables = $this->saldosContables($cuenta, $naturaleza, $asiento2->asiento2_debito, $asiento2->asiento2_credito, $asiento->asiento1_mes, $asiento->asiento1_ano);
                    if($saldoscontables != 'OK') {
                        DB::rollback();
                        throw new \Exception($saldoscontables);
                    }
                }
            }

            // Crear nueva notifiacion (tercero, title, description, fh)
            DB::commit();
            Log::info("Se actualizaron los saldos con exito.");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("{$e->getMessage()}");
        }
    }

    // Funcion para mayorizar saldos contables asientos {cuenta, naturaleza, debito, credito, mes, ano} asiento
    public function saldosContables(PlanCuenta $cuenta, $naturaleza, $debito, $credito, $mes, $ano) {
        $globalmes = $mes;
        $globalano = $ano;

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
            $saldoscontables = SaldoContable::where('saldoscontables_ano', $ano)->where('saldoscontables_mes', $mes)->where('saldoscontables_cuenta', $objCuenta->id)->first();
            if(!$saldoscontables instanceof SaldoContable){
                $saldoscontables = new SaldoContable;
                $saldoscontables->saldoscontables_cuenta = $objCuenta->id;
                $saldoscontables->saldoscontables_ano = $ano;
                $saldoscontables->saldoscontables_mes = $mes;
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
                if( $mes == 1 ){
                    $mes2 = 13;
                    $ano2 = $ano - 1;
                } else {
                    $mes2 = $mes - 1;
                    $ano2 = $ano;
                }

                // $sql = "
				// 	SELECT koi_plancuentas.id as plancuentas_id, plancuentas_nombre, plancuentas_cuenta, plancuentas_naturaleza,
                //     FROM koi_plancuentas
                //     WHERE koi_plancuentas.id IN (
                //         SELECT s.saldoscontables_cuenta
                //         FROM koi_saldoscontables as s
                //         WHERE s.saldoscontables_mes = $mes and s.saldoscontables_ano = $ano
                //         UNION
                //         SELECT s.saldoscontables_cuenta
                //         FROM koi_saldoscontables as s
                //         WHERE s.saldoscontables_mes = $mes2 and s.saldoscontables_ano = $ano2
                //     )
                //     and koi_plancuentas.id = {$objCuenta->id} order by plancuentas_cuenta ASC";

                // $x = SaldoContable::select('saldoscontables_debito_inicial', 'saldoscontables_credito_inicial')
                //                     ->where('saldoscontables_mes', $mes2)
                //                     ->where('saldoscontables_ano', $ano2)
                //                     ->where('saldoscontables_cuenta', $objCuenta->id)
                //                     ->first();
                // if( !$x instanceof SaldoContable ){
                //     $x = new \stdClass();
                //     $x->saldoscontables_debito_inicial = 0;
                //     $x->saldoscontables_credito_inicial = 0;
                // }
                //
                // $y = SaldoContable::select('saldoscontables_debito_mes', 'saldoscontables_credito_mes')
                //                     ->where('saldoscontables_mes', $mes2)
                //                     ->where('saldoscontables_ano', $ano2)
                //                     ->where('saldoscontables_cuenta', $objCuenta->id)
                //                     ->first();
                // if( !$y instanceof SaldoContable ){
                //     $y = new \stdClass();
                //     $y->saldoscontables_debito_mes = 0;
                //     $y->saldoscontables_credito_mes = 0;
                // }

                $x = SaldoContable::select('saldoscontables_debito_inicial', 'saldoscontables_credito_inicial')
                                    ->where('saldoscontables_mes', $mes2)
                                    ->where('saldoscontables_ano', $ano2)
                                    ->where('saldoscontables_cuenta', $objCuenta->id)
                                    ->first();
                if( !$x instanceof SaldoContable ){
                    $x = new \stdClass();
                    $x->saldoscontables_debito_inicial = 0;
                    $x->saldoscontables_credito_inicial = 0;
                }

                $y = SaldoContable::select('saldoscontables_debito_mes', 'saldoscontables_credito_mes')
                                    ->where('saldoscontables_mes', $mes)
                                    ->where('saldoscontables_ano', $ano)
                                    ->where('saldoscontables_cuenta', $objCuenta->id)
                                    ->first();
                if( !$y instanceof SaldoContable ){
                    $y = new \stdClass();
                    $y->saldoscontables_debito_mes = 0;
                    $y->saldoscontables_credito_mes = 0;
                }

    	        // Recuperar registro saldos contable
                $saldoscontable = SaldoContable::where('saldoscontables_cuenta', $objCuenta->id)->where('saldoscontables_ano', $ano)->where('saldoscontables_mes', $mes)->first();
            	if( !$saldoscontable instanceof SaldoContable ) {
            		// Crear registro en saldos contables
            		$saldoscontable = new SaldoContable;
            		$saldoscontable->saldoscontables_cuenta = $objCuenta->id;
            		$saldoscontable->saldoscontables_ano = $ano;
            		$saldoscontable->saldoscontables_mes = $mes;
            		$saldoscontable->saldoscontables_nivel1 = $objCuenta->plancuentas_nivel1;
            		$saldoscontable->saldoscontables_nivel2 = $objCuenta->plancuentas_nivel2;
            		$saldoscontable->saldoscontables_nivel3 = $objCuenta->plancuentas_nivel3;
            		$saldoscontable->saldoscontables_nivel4 = $objCuenta->plancuentas_nivel4;
            		$saldoscontable->saldoscontables_nivel5 = $objCuenta->plancuentas_nivel5;
            		$saldoscontable->saldoscontables_nivel6 = $objCuenta->plancuentas_nivel6;
            		$saldoscontable->saldoscontables_nivel7 = $objCuenta->plancuentas_nivel7;
            		$saldoscontable->saldoscontables_nivel8 = $objCuenta->plancuentas_nivel8;
    				$saldoscontable->saldoscontables_debito_inicial = $x->debito_inicial + ($y->saldoscontables_debito_mes - $y->saldoscontables_credito_mes);
    				$saldoscontable->saldoscontables_credito_inicial = $x->credito_inicial + ($y->saldoscontables_credito_mes - $y->saldoscontables_debito_mes);
        			$saldoscontable->save();

                    Log::info("$mes2/$ano2 -- $mes/$ano -- ($x->debito_inicial * $x->credito_inicial) -- $objCuenta->plancuentas_cuenta -- [$x->debito_inicial * $x->credito_inicial] -- ($y->saldoscontables_debito_mes * $y->saldoscontables_credito_mes)");
    			}

        		if($mes == $this->currentmonth && $ano == $this->currentyear ) {
        			break;
        		}

        		if( $mes == 13 ) {
        			$mes = 1;
        			$ano++;
        		} else {
        			$mes++;
        		}
            }

            $mes = $globalmes;
            $ano = $globalano;
        }

        return "OK";
    }
}
