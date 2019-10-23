<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion10, App\Models\Production\Ordenp2, App\Models\Production\Ordenp10;
use DB;

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
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Rutina para actualizar produccion asdasd asd asdasdas');
        DB::beginTransaction();
        try {
            $cotizaciones2 = Cotizacion2::all();
            foreach ($cotizaciones2 as $cotizacion2) {
                if ($cotizacion2->cotizacion2_transporte <= 0) {
                    continue;
                }

                $valor = $cotizacion2->cotizacion2_transporte/1.3;

                // Nuevo transporte
                $cotizacion10 = new Cotizacion10;
                $cotizacion10->cotizacion10_cotizacion2 = $cotizacion2->id;
                $cotizacion10->cotizacion10_materialp = null;
                $cotizacion10->cotizacion10_producto = null;
                $cotizacion10->cotizacion10_medidas = 1;
                $cotizacion10->cotizacion10_cantidad = 1;
                $cotizacion10->cotizacion10_valor_unitario = $valor;
                $cotizacion10->cotizacion10_valor_total = $valor;
                $cotizacion10->cotizacion10_fh_elaboro = date('Y-m-d H:i:s');
                $cotizacion10->cotizacion10_usuario_elaboro = $cotizacion2->cotizacion2_usuario_elaboro;
                $cotizacion10->save();
            }
            $this->info('Se actualizaron transportes en las cotizaciones');

            $ordenesp2 = Ordenp2::all();
            foreach ($ordenesp2 as $ordenp2) {
                if ($ordenp2->orden2_transporte <= 0) {
                    continue;
                }

                $valor = $ordenp2->orden2_transporte/1.3;

                // Nuevo transporte
                $orden10 = new Ordenp10;
                $orden10->orden10_orden2 = $ordenp2->id;
                $orden10->orden10_materialp = null;
                $orden10->orden10_producto = null;
                $orden10->orden10_medidas = 1;
                $orden10->orden10_cantidad = 1;
                $orden10->orden10_valor_unitario = $valor;
                $orden10->orden10_valor_total = $valor;
                $orden10->orden10_fh_elaboro = date('Y-m-d H:i:s');
                $orden10->orden10_usuario_elaboro = $ordenp2->orden2_usuario_elaboro;
                $orden10->save();
            }
            $this->info('Se actualizaron transportes en las ordenes');

            DB::commit();
            $this->info("Se completo la rutina con exito.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
