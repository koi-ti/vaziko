<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\Cotizacion10, App\Models\Production\Ordenp10;
use DB, Log;

class TransporteProduccion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'produccion:transporte';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar transportes en produccion';

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
        $this->info('Rutina para actualizar transporte produccion');
        DB::beginTransaction();
        try {
            $transportes = Cotizacion10::all();
            foreach ($transportes as $transporte) {
                $tiempo = '';
                if (str_contains($transporte->cotizacion10_tiempo, '.')) {
                    $tiempo = $this->explodeTime($transporte->cotizacion10_tiempo);
                } else {
                    $tiempo = "$transporte->cotizacion10_tiempo:0";
                }
                $transporte->cotizacion10_tiempo = $tiempo;
                $transporte->save();
            }
            $this->info('Se actualizaron transportes en las cotizaciones');

            $transportes = Ordenp10::all();
            foreach ($transportes as $transporte) {
                $tiempo = '';
                if (str_contains($transporte->orden10_tiempo, '.')) {
                    $tiempo = $this->explodeTime($transporte->orden10_tiempo);
                } else {
                    $tiempo = "$transporte->orden10_tiempo:0";
                }
                $transporte->orden10_tiempo = $tiempo;
                $transporte->save();
            }
            $this->info('Se actualizaron transportes en las ordenes');

            DB::commit();
            $this->info("Se completo la rutina con exito.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }

    protected function explodeTime ($time) {
        $explodeTime = explode('.', $time);
        $tiempo = "0.{$explodeTime[1]}" * 60;
        $tiempo = "{$explodeTime[0]}:{$tiempo}";
        return $tiempo;
    }
}
