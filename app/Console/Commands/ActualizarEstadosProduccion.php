<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\Cotizacion1;
use DB;

class ActualizarEstadosProduccion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:estados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar estados de la cotización';

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
        $this->info('Rutina para actualizar estados de cotización');
        DB::beginTransaction();
        try {
            $cotizaciones = Cotizacion1::whereNotNull('cotizacion1_estado')->get();
            foreach ($cotizaciones as $cotizacion) {
                if ($cotizacion->cotizacion1_estado == 'N') {
                    $cotizacion->cotizacion1_estados = 'CN';
                } else if ($cotizacion->cotizacion1_estado == 'R') {
                    $cotizacion->cotizacion1_estados = 'CR';
                } else if ($cotizacion->cotizacion1_estado == 'O') {
                    $cotizacion->cotizacion1_estados = 'CO';
                }
                $cotizacion->save();
            }

            DB::commit();
            $this->info("Se completo la rutina con exito.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
