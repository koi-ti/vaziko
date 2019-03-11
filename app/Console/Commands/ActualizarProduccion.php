<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        // $this->info('Rutina para actualizar produccion');
        // DB::beginTransaction();
        // try {
        //     $pre_materialesp = PreCotizacion3::get();
        //     foreach ($pre_materialesp as $precotizacion3) {
        //         $precotizacion3->precotizacion3_cantidad = round(eval("return ($precotizacion3->precotizacion3_medidas);"), 2);
        //         $precotizacion3->save();
        //     }
        //     $this->info('Se actualizaron materiales las precotizaciones');
        //
        //     $cot_materialesp = Cotizacion4::get();
        //     foreach ($cot_materialesp as $cotizacion4) {
        //         $cotizacion4->cotizacion4_cantidad = round(eval("return ($cotizacion4->cotizacion4_medidas);"), 2);
        //         $cotizacion4->save();
        //     }
        //     $this->info('Se actualizaron materiales las cotizaciones');
        //
        //     $ord_materialesp = Ordenp4::get();
        //     foreach ($ord_materialesp as $orden4) {
        //         $orden4->orden4_cantidad = round(eval("return ($orden4->orden4_medidas);"), 2);
        //         $orden4->save();
        //     }
        //     $this->info('Se actualizaron materiales las ordenes');
        //
        //     $pre_empaques = PreCotizacion9::get();
        //     foreach ($pre_empaques as $precotizacion9) {
        //         $precotizacion9->precotizacion9_cantidad = round(eval("return ($precotizacion9->precotizacion9_medidas);"), 2);
        //         $precotizacion9->save();
        //     }
        //     $this->info('Se actualizaron empaques las precotizaciones');
        //
        //     $cot_empaques = Cotizacion9::get();
        //     foreach ($cot_empaques as $cotizacion9) {
        //         $cotizacion9->cotizacion9_cantidad = round(eval("return ($cotizacion9->cotizacion9_medidas);"), 2);
        //         $cotizacion9->save();
        //     }
        //     $this->info('Se actualizaron empaques las cotizaciones');
        //
        //     $ord_empaques = Ordenp9::get();
        //     foreach ($ord_empaques as $orden9) {
        //         $orden9->orden9_cantidad = round(eval("return ($orden9->orden9_medidas);"), 2);
        //         $orden9->save();
        //     }
        //     $this->info('Se actualizaron empaques las ordenes');
        //
        //     DB::commit();
        //     $this->info("Se completo la rutina con exito.");
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $this->error($e->getMessage());
        // }
    }
}
