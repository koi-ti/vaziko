<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\Ordenp, App\Models\Production\Ordenp2;
use DB, Log;

class actualizarordenes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ordenes:actualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        try{
            $this->info('Se esta generando.');

            //recuperar ordenes
            $query = Ordenp2::query();
            $query->select('koi_ordenproduccion2.id as id', 'orden2_precio_venta', 'orden2_orden', 'orden2_total_valor_unitario', 'orden_cotizacion');
            $query->join('koi_ordenproduccion', 'orden2_orden', '=', 'koi_ordenproduccion.id');
            $query->whereNull('orden_cotizacion');
            $ordenesp2 = $query->get();

            $i = 1;
            foreach($ordenesp2 as $orden2){
                // Actualizar ordenp2 valor_precio_venta ----> valor_total_unitario
                $orden2->orden2_total_valor_unitario = $orden2->orden2_precio_venta;
                $orden2->save();
            }

            DB::commit();
            Log::info('Se ha producido con exito.');
            $this->info('Se ha producido con exito.');
        }catch(\Exception $e){
            DB::rollback();
            $this->info('Se ha producido algun error en la rutina.');
            return;
        }
    }
}
