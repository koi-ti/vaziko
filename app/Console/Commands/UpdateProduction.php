<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion4, App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Production\Ordenp4, App\Models\Production\PreCotizacion3;
use DB, Log, Carbon\Carbon;

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
            $cotizaciones  = Cotizacion1::whereNotNull('cotizacion1_precotizacion')->get();
            foreach ($cotizaciones as $cotizacion) {

                if( Carbon::createFromFormat('Y-m-d H:i:s', $cotizacion->cotizacion1_fecha_elaboro)->toDateString() == Carbon::now()->toDateString() ){
                    continue;
                }

                // Recorrer productos
                $productos = Cotizacion2::where('cotizacion2_cotizacion', $cotizacion->id)->get();
                foreach ($productos as $producto) {

                    // Recuperar materialp cot4
                    $materialesp = Cotizacion4::where('cotizacion4_cotizacion2', $producto->id)->get();
                    foreach ($materialesp as $materialp) {

                        $precotizacion3 = PreCotizacion3::select('koi_precotizacion3.*', 'precotizacion2_precotizacion1')
                                                            ->join('koi_precotizacion2', 'precotizacion3_precotizacion2', '=', 'koi_precotizacion2.id')
                                                            ->where('precotizacion2_precotizacion1', $cotizacion->cotizacion1_precotizacion)
                                                            ->where('precotizacion3_materialp', $materialp->cotizacion4_materialp)
                                                            ->where('precotizacion3_valor_total', $materialp->cotizacion4_valor_total)
                                                            ->first();

                        // Si es instancia guarde el materialp
                        if($precotizacion3 instanceof PreCotizacion3){
                            $materialp->cotizacion4_cantidad = $precotizacion3->precotizacion3_cantidad;
                            $materialp->cotizacion4_medidas = $precotizacion3->precotizacion3_medidas;
                            $materialp->cotizacion4_producto = $precotizacion3->precotizacion3_producto;
                            $materialp->cotizacion4_proveedor = $precotizacion3->precotizacion3_proveedor;
                            $materialp->cotizacion4_valor_unitario = $precotizacion3->precotizacion3_valor_unitario;
                            $materialp->cotizacion4_valor_total = $precotizacion3->precotizacion3_valor_total;
                            $materialp->cotizacion4_fh_elaboro = $precotizacion3->precotizacion3_fh_elaboro;
                            $materialp->cotizacion4_usuario_elaboro = $precotizacion3->precotizacion3_usuario_elaboro;
                            $materialp->save();
                        }
                    }
                }
            }

            $ordenesp = Ordenp::select('koi_ordenproduccion.*')->join('koi_cotizacion1', 'orden_cotizacion', '=', 'koi_cotizacion1.id')->whereNotNull('cotizacion1_precotizacion')->get();
            foreach ($ordenesp as $ordenp) {
                if( Carbon::createFromFormat('Y-m-d H:i:s', $ordenp->orden_fecha_elaboro)->toDateString() == Carbon::now()->toDateString() ){
                    continue;
                }

                Log::info("ORD:[$ordenp->id|$ordenp->orden_cotizacion]");
                // Recorrer productos
                $productos = Ordenp2::where('orden2_orden', $ordenp->id)->get();
                foreach ($productos as $producto) {

                    // Recuperar materiales de cot4
                    $materialesp = Ordenp4::where('orden4_orden2', $producto->id)->get();
                    foreach ($materialesp as $materialp) {

                        $query = Cotizacion4::select('koi_cotizacion4.*', 'cotizacion2_cotizacion');
                        $query->join('koi_cotizacion2', 'cotizacion4_cotizacion2', '=', 'koi_cotizacion2.id');
                        $query->where('cotizacion2_cotizacion', $ordenp->orden_cotizacion);
                        $query->where('cotizacion4_materialp', $materialp->orden4_materialp);
                        if( $materialp->orden4_cantidad != 0 && empty($materialp->orden4_medidas) ){
                            $query->where('cotizacion4_cantidad', $materialp->orden4_cantidad);
                        }else if ( $materialp->orden4_cantidad == 0 && $materialp->orden4_medidas ){
                            $query->where('cotizacion4_medidas', $materialp->orden4_medidas);
                        }
                        $cotizacion4 = $query->first();

                        if( $cotizacion4 instanceof Cotizacion4 ){
                            $materialp->orden4_cantidad = $cotizacion4->cotizacion4_cantidad;
                            $materialp->orden4_medidas = $cotizacion4->cotizacion4_medidas;
                            $materialp->orden4_producto = $cotizacion4->cotizacion4_producto;
                            $materialp->orden4_proveedor = $cotizacion4->cotizacion4_proveedor;
                            $materialp->orden4_valor_unitario = $cotizacion4->cotizacion4_valor_unitario;
                            $materialp->orden4_valor_total = $cotizacion4->cotizacion4_valor_total;
                            $materialp->orden4_fh_elaboro = $cotizacion4->cotizacion4_fh_elaboro;
                            $materialp->orden4_usuario_elaboro = $cotizacion4->cotizacion4_usuario_elaboro;
                            $materialp->save();
                        }
                    }
                }
            }

            DB::commit();
            Log::info('Se actualizo con exito producción');
            $this->info('Se actualizo con exito producción');
        } catch(\Exception $e){
            DB::rollback();
            Log::error("Ha ocurrido un error ".$e->getMessage());
            $this->error("Ha ocurrido un error ".$e->getMessage());
        }
    }
}
