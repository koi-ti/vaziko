<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion4, App\Models\Production\Ordenp1, App\Models\Production\Ordenp2, App\Models\Production\Ordenp4;
use DB, Log;

class UpdateProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:production';

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
        $this->info('Iniciando rutina de actualizacion');

        DB::beginTransaction();
        try {
            // $cotizaciones  = Cotizacion1::whereNotNull('cotizacion1_precotizacion')->get();
            // foreach ($cotizaciones as $cotizacion) {
            //     // $cot2 = Cotizacion2::where('cotizacion2_cotizacion1', $cotizacion->id)->
            //     $materialesp = Cotizacion4::join('koi_cotizacion2', 'cotizacion4_cotizacion2', '=', 'koi_cotizacion2.id')->where('cotizacion2_cotizacion1', $cotizacion->id)->get();
            //     dd($cotizacion, $materialesp);
            // }

            DB::commit();
            $this->info('Se actualizo con exito producción');
        } catch(\Exception $e){
            DB::rollback();
            Log::error("Ha ocurrido un error ".$e->getMessage());
            $this->error("Ha ocurrido un error ".$e->getMessage());
        }
    }
}
