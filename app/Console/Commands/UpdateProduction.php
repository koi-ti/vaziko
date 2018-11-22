<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\Cotizacion1, App\Models\Production\Ordenp1;
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
            $cotizaciones  = Cotizacion1::whereNotNull('cotizacion1_precotizacion')->limit(10)->get();
            dd($cotizaciones);

            DB::commit();
            $this->info('Se actualizo con exito producción');
        } catch(\Exception $e){
            DB::rollback();
            Log::error("Ha ocurrido un error ".$e->getMessage());
            $this->error("Ha ocurrido un error ".$e->getMessage());
        }
    }
}
