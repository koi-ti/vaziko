<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta, App\Models\Accounting\SaldoContable, App\Models\Accounting\SaldoTercero;
use DB;

class SaldosContables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:saldos {mes} {ano}';

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
        $this->info('Bienvenido a la rutina de actualizar saldos');

        // Validar mes y año
        if($this->argument('mes') < 1 || $this->argument('mes') > 12 )
            return $this->error('El mes no es valido.');

        if(strlen($this->argument('ano')) != 4 )
            return $this->error('El año no es valido.');

        // Convertir a date y explode y traer mes anterior
        list($currentyear, $currentmonth) = explode('-', date('Y-m', strtotime("{$this->argument('ano')}-{$this->argument('mes')}")));
        list($prevyear, $prevmonth) = explode('-', date('Y-m', strtotime("{$this->argument('ano')}-{$this->argument('mes')} -1 month")));

        if($this->confirm("El mes ingresado es $currentmonth y el año es $currentyear?", true)){
            DB::beginTransaction();
            try {
                dd(SaldoContable::select(DB::raw("SUM(saldoscontables_debito_mes) as debito"))->where('saldoscontables_ano', $currentyear)->where('saldoscontables_mes', $currentmonth)->get());

                // // Eliminar registros del mes seleccionado
                // $allsaldoscontables = SaldoContable::where('saldoscontables_ano', $currentyear)->where('saldoscontables_mes', $currentmonth)->delete();
                // $allsaldosterceros = SaldoTercero::where('saldosterceros_ano', $currentyear)->where('saldosterceros_mes', $currentmonth)->delete();
                //
                // // Recuperar detalle de asientos para la rutina
                // $asientos = Asiento2::select('koi_asiento2.*')->where('asiento1_ano', $currentyear)->where('asiento1_mes', $currentmonth)->join('koi_asiento1', 'asiento2_asiento', '=', 'koi_asiento1.id')->get();
                // $bar = $this->output->createProgressBar(count($asientos));
                // foreach ($asientos as $asiento) {
                //     $plancuenta = PlanCuenta::find($asiento->asiento2_cuenta);
                //     if(!$plancuenta instanceof PlanCuenta){
                //         DB::rollback();
                //         return $this->error('No es posible recuperar el plan de cuentas.');
                //     }
                //
                //     // Mayorizar cuentas
                //     $mayorizaciones = $plancuenta->getMayorizarCuentas();
                //     foreach ($mayorizaciones as $mayorizacion) {
                //         // Recuperar cuenta
                //         $puc = PlanCuenta::where('plancuentas_cuenta', $mayorizacion)->first();
                //         if(!$puc instanceof PlanCuenta){
                //             DB::rollback();
                //             return $this->error('No es posible recuperar cuenta para mayorización.');
                //         }
                //
                //         // Guardar en saldoscontables
                //         $saldoscontables = SaldoContable::where('saldoscontables_ano', $currentyear)->where('saldoscontables_mes', $currentmonth)->where('saldoscontables_cuenta', $puc->id)->first();
                //         if(!$saldoscontables instanceof SaldoContable){
                //             $saldoscontables = new SaldoContable;
                //             $saldoscontables->saldoscontables_cuenta = $puc->id;
                //             $saldoscontables->saldoscontables_ano = $currentyear;
                //             $saldoscontables->saldoscontables_mes = $currentmonth;
                //             $saldoscontables->saldoscontables_nivel1 = $puc->plancuentas_nivel1;
                //             $saldoscontables->saldoscontables_nivel2 = $puc->plancuentas_nivel2;
                //             $saldoscontables->saldoscontables_nivel3 = $puc->plancuentas_nivel3;
                //             $saldoscontables->saldoscontables_nivel4 = $puc->plancuentas_nivel4;
                //             $saldoscontables->saldoscontables_nivel5 = $puc->plancuentas_nivel5;
                //             $saldoscontables->saldoscontables_nivel6 = $puc->plancuentas_nivel6;
                //             $saldoscontables->saldoscontables_nivel7 = $puc->plancuentas_nivel7;
                //             $saldoscontables->saldoscontables_nivel8 = $puc->plancuentas_nivel8;
                //             $saldoscontables->saldoscontables_debito_mes = $asiento->asiento2_debito;
                //             $saldoscontables->saldoscontables_credito_mes = $asiento->asiento2_credito;
                //             $saldoscontables->saldoscontables_debito_inicial = 0;
                //             $saldoscontables->saldoscontables_credito_inicial = 0;
                //             $saldoscontables->save();
                //
                //         } else {
                //             $saldoscontables->saldoscontables_debito_mes += $asiento->asiento2_debito;
                //             $saldoscontables->saldoscontables_credito_mes += $asiento->asiento2_credito;
                //             $saldoscontables->save();
                //         }
                //
                //         // Guardar en saldosterceros
                //         $saldosterceros = SaldoTercero::where('saldosterceros_ano', $currentyear)->where('saldosterceros_tercero', $asiento->asiento2_beneficiario)->where('saldosterceros_mes', $currentmonth)->where('saldosterceros_cuenta', $puc->id)->first();
                //         if(!$saldosterceros instanceof SaldoTercero){
                //             $saldosterceros = new SaldoTercero;
                //             $saldosterceros->saldosterceros_cuenta = $puc->id;
                //             $saldosterceros->saldosterceros_ano = $currentyear;
                //             $saldosterceros->saldosterceros_mes = $currentmonth;
                //             $saldosterceros->saldosterceros_tercero = $asiento->asiento2_beneficiario;
                //             $saldosterceros->saldosterceros_nivel1 = $puc->plancuentas_nivel1;
                //             $saldosterceros->saldosterceros_nivel2 = $puc->plancuentas_nivel2;
                //             $saldosterceros->saldosterceros_nivel3 = $puc->plancuentas_nivel3;
                //             $saldosterceros->saldosterceros_nivel4 = $puc->plancuentas_nivel4;
                //             $saldosterceros->saldosterceros_nivel5 = $puc->plancuentas_nivel5;
                //             $saldosterceros->saldosterceros_nivel6 = $puc->plancuentas_nivel6;
                //             $saldosterceros->saldosterceros_nivel7 = $puc->plancuentas_nivel7;
                //             $saldosterceros->saldosterceros_nivel8 = $puc->plancuentas_nivel8;
                //             $saldosterceros->saldosterceros_debito_mes = $asiento->asiento2_debito;
                //             $saldosterceros->saldosterceros_credito_mes = $asiento->asiento2_credito;
                //             $saldosterceros->saldosterceros_debito_inicial = 0;
                //             $saldosterceros->saldosterceros_credito_inicial = 0;
                //             $saldosterceros->save();
                //
                //         } else {
                //             $saldosterceros->saldosterceros_debito_mes += $asiento->asiento2_debito;
                //             $saldosterceros->saldosterceros_credito_mes += $asiento->asiento2_credito;
                //             $saldosterceros->save();
                //         }
                //     }
                //     $bar->advance();
                // }
                // $bar->finish();

                DB::commit();
                return $this->info("\nSe ha completado la rutina con exito.");
            }catch(\Exception $e){
                DB::rollback();
                return $this->error("Rutina saldos {$e->getMessage()}");
            }
        }
    }
}
