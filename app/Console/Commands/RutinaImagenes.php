<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\PreCotizacion4, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion8;
use Storage, Log, DB;

class RutinaImagenes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rutina para copiar las imagenes ya precotizadas';

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
        $this->info('Rutina para copiar imagenes ya precotizadas');

        DB::beginTransaction();
        try {
            // Recuperar imagenes
            $query = PreCotizacion4::query();
            $query->select('koi_precotizacion4.*', 'koi_precotizacion2.id as id_producto', 'koi_precotizacion1.id as id_precotizacion');
            $query->join('koi_precotizacion2', 'precotizacion4_precotizacion2', '=', 'koi_precotizacion2.id');
            $query->join('koi_precotizacion1', 'precotizacion2_precotizacion1', '=', 'koi_precotizacion1.id');
            $imagenes = $query->get();

            foreach ($imagenes as $imagen) {

                $query = Cotizacion2::query();
                $query->select('koi_cotizacion2.id', 'koi_cotizacion1.id as id_cotizacion');
                $query->where('cotizacion2_precotizacion2', $imagen->id_producto);
                $query->where('cotizacion1_precotizacion', $imagen->id_precotizacion);
                $query->join('koi_cotizacion1', 'cotizacion2_cotizacion', '=', 'koi_cotizacion1.id');
                $cotizacion2 = $query->first();

                if( $cotizacion2 instanceof Cotizacion2) {

                    // Copiar archivos y insertar en DB
                    if ( Storage::has("pre-cotizaciones/precotizacion_$imagen->id_precotizacion/producto_$imagen->id_producto/$imagen->precotizacion4_archivo") ){
                        $cotizacion8 = new Cotizacion8;
                        $cotizacion8->cotizacion8_cotizacion2 = $cotizacion2->id;
                        $cotizacion8->cotizacion8_archivo = $imagen->precotizacion4_archivo;
                        $cotizacion8->cotizacion8_fh_elaboro = $imagen->precotizacion4_fh_elaboro;
                        $cotizacion8->cotizacion8_usuario_elaboro = $imagen->precotizacion4_usuario_elaboro;
                        $cotizacion8->save();

                        $oldfile = "pre-cotizaciones/precotizacion_$imagen->id_precotizacion/producto_$imagen->id_producto/$imagen->precotizacion4_archivo";
                        $newfile = "cotizaciones/cotizacion_$cotizacion2->id_cotizacion/producto_$cotizacion2->id/$imagen->precotizacion4_archivo";

                        // Copy file storege laravel
                        Storage::copy($oldfile, $newfile);
                    }
                }
            }

            DB::commit();
            $this->info("Se completo la rutina con exito.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
