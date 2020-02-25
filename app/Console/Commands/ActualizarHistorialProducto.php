<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory\ProductoHistorial;
use App\Models\Production\Cotizacion4, App\Models\Production\Ordenp4, App\Models\Production\Cotizacion9, App\Models\Production\Ordenp9, App\Models\Production\Cotizacion10, App\Models\Production\Ordenp10;
use DB;

class ActualizarHistorialProducto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:historial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar historial de los productos';

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
        $this->info('Rutina para actualizar historial productos');
        DB::beginTransaction();
        try {
            // Mateirales
            $cotizaciones4 = Cotizacion4::take(10)->orderBy('id', 'desc')->get();
            foreach ($cotizaciones4 as $producto) {
                $historial = new ProductoHistorial;
                $historial->productohistorial_tipo = 'M';
                $historial->productohistorial_modulo = 'C';
                $historial->productohistorial_producto = $producto->cotizacion4_producto;
                $historial->productohistorial_valor = $producto->cotizacion4_valor_unitario;
                $historial->productohistorial_fh_elaboro = $producto->cotizacion4_fh_elaboro;
                $historial->save();
            }

            $ordenes4 = Ordenp4::take(10)->orderBy('id', 'desc')->get();
            foreach ($ordenes4 as $producto) {
                $historial = new ProductoHistorial;
                $historial->productohistorial_tipo = 'M';
                $historial->productohistorial_modulo = 'O';
                $historial->productohistorial_producto = $producto->orden4_producto;
                $historial->productohistorial_valor = $producto->orden4_valor_unitario;
                $historial->productohistorial_fh_elaboro = $producto->orden4_fh_elaboro;
                $historial->save();
            }

            // Empaques
            $cotizaciones9 = Cotizacion9::take(10)->orderBy('id', 'desc')->get();
            foreach ($cotizaciones9 as $producto) {
                $historial = new ProductoHistorial;
                $historial->productohistorial_tipo = 'E';
                $historial->productohistorial_modulo = 'C';
                $historial->productohistorial_producto = $producto->cotizacion9_producto;
                $historial->productohistorial_valor = $producto->cotizacion9_valor_unitario;
                $historial->productohistorial_fh_elaboro = $producto->cotizacion9_fh_elaboro;
                $historial->save();
            }

            $ordenes9 = Ordenp9::take(10)->orderBy('id', 'desc')->get();
            foreach ($ordenes9 as $producto) {
                $historial = new ProductoHistorial;
                $historial->productohistorial_tipo = 'E';
                $historial->productohistorial_modulo = 'O';
                $historial->productohistorial_producto = $producto->orden9_producto;
                $historial->productohistorial_valor = $producto->orden9_valor_unitario;
                $historial->productohistorial_fh_elaboro = $producto->orden9_fh_elaboro;
                $historial->save();
            }

            // Transportes
            $cotizaciones10 = Cotizacion10::take(10)->orderBy('id', 'desc')->get();
            foreach ($cotizaciones10 as $producto) {
                $historial = new ProductoHistorial;
                $historial->productohistorial_tipo = 'T';
                $historial->productohistorial_modulo = 'C';
                $historial->productohistorial_producto = $producto->cotizacion10_producto;
                $historial->productohistorial_valor = $producto->cotizacion10_valor_unitario;
                $historial->productohistorial_fh_elaboro = $producto->cotizacion10_fh_elaboro;
                $historial->save();
            }

            $ordenes10 = Ordenp10::take(10)->orderBy('id', 'desc')->get();
            foreach ($ordenes10 as $producto) {
                $historial = new ProductoHistorial;
                $historial->productohistorial_tipo = 'T';
                $historial->productohistorial_modulo = 'O';
                $historial->productohistorial_producto = $producto->orden10_producto;
                $historial->productohistorial_valor = $producto->orden10_valor_unitario;
                $historial->productohistorial_fh_elaboro = $producto->orden10_fh_elaboro;
                $historial->save();
            }

            DB::commit();
            $this->info("Se completo la rutina con exito.");
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
