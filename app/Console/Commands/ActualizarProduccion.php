<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\PreCotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Ordenp4;
use Log, DB;

class ActualizarProduccion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:produccion';

    /**
     * The console command description.
     *
     * @var string
     */
     protected $description = 'Rutina para actualizar produccion.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Rutina para actualizar produccion');
        DB::beginTransaction();
        try {
            $pre_materialesp = PreCotizacion3::get();
            foreach ($pre_materialesp as $precotizacion3) {
                $precotizacion3->precotizacion3_medidas = $precotizacion3->precotizacion3_cantidad;
                $precotizacion3->save();
            }
            $this->info('Se actualizaron las precotizaciones');

            $cot_materialesp = Cotizacion4::get();
            foreach ($cot_materialesp as $cotizacion4) {
                $cotizacion4->cotizacion4_medidas = $cotizacion4->cotizacion4_cantidad;
                $cotizacion4->save();
            }
            $this->info('Se actualizaron las cotizaciones');

            $ord_materialesp = Ordenp4::get();
            foreach ($ord_materialesp as $orden4) {
                $orden4->orden4_medidas = $orden4->orden4_cantidad;
                $orden4->save();
            }
            $this->info('Se actualizaron las ordenes');

            DB::commit();
            $this->info("Se completo la rutina con exito.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
