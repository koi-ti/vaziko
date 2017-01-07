<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Production\Productop, App\Models\Production\Productop2, App\Models\Production\Productop3, App\Models\Production\Productop4, App\Models\Production\Productop5, App\Models\Production\Productop6;

class MigrateProductos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mproductosp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate table productosp vaziko to laravel scheme';

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
        $this->line('Iniciando migracion de productos');

        DB::beginTransaction();
        try
        {
            $productos = DB::table('productop1')
                ->select('productop1.*', 'koi_tercero.id as elaboro_id', 'm1.id_nuevo as m1_id', 'm2.id_nuevo as m2_id', 'm3.id_nuevo as m3_id', 'm4.id_nuevo as m4_id', 'm5.id_nuevo as m5_id', 'm6.id_nuevo as m6_id', 'm7.id_nuevo as m7_id')
                ->join('koi_tercero', 'productop1_usuario_elaboro', '=', 'koi_tercero.username')
                ->leftJoin('medida as m1', 'productop1_ancho_med', '=', 'm1.medida_codigo')
                ->leftJoin('medida as m2', 'productop1_alto_med', '=', 'm2.medida_codigo')
                ->leftJoin('medida as m3', 'productop1_c_med_ancho', '=', 'm3.medida_codigo')
                ->leftJoin('medida as m4', 'productop1_c_med_alto', '=', 'm4.medida_codigo')
                ->leftJoin('medida as m5', 'productop1_3d_ancho_med', '=', 'm5.medida_codigo')
                ->leftJoin('medida as m6', 'productop1_3d_alto_med', '=', 'm6.medida_codigo')
                ->leftJoin('medida as m7', 'productop1_3d_profundidad_med', '=', 'm7.medida_codigo')
                ->whereNull('productop1.id_nuevo')
                ->orderBy('productop1_codigo', 'asc')
                ->get();

            $this->info("Productos encontrados: ".count($productos));

            foreach ($productos as $productop)
            {
                // Productos
                $producto = new Productop;
                $producto->productop_nombre = $productop->productop1_nombre;
                $producto->productop_observaciones = $productop->productop1_observaciones;
                $producto->productop_fecha_elaboro = "$productop->productop1_fecha_elaboro $productop->productop1_hora_elaboro";
                $producto->productop_usuario_elaboro = $productop->elaboro_id;
                $producto->productop_tiro = $productop->productop1_tiro;
                $producto->productop_retiro = $productop->productop1_retiro;
                $producto->productop_abierto = $productop->productop1_abierto;
                $producto->productop_cerrado = $productop->productop1_cerrado;
                $producto->productop_3d = $productop->productop1_3d;
                $producto->productop_ancho_med = $productop->m1_id;
                $producto->productop_alto_med = $productop->m2_id;
                $producto->productop_c_med_ancho = $productop->m3_id;
                $producto->productop_c_med_alto = $productop->m4_id;
                $producto->productop_3d_ancho_med = $productop->m5_id;
                $producto->productop_3d_alto_med = $productop->m6_id;
                $producto->productop_3d_profundidad_med = $productop->m7_id;
                $producto->save();

                $this->info("Producto -> {$productop->productop1_codigo} Elaboro -> {$productop->elaboro_id} OK (Id : {$producto->id})");

                // Tips
                $tips = DB::table('productop6')
                    ->orderBy('productop6_item', 'asc')
                    ->where('productop6_productop1', $productop->productop1_codigo)
                    ->get();
                $this->line("Tips encontrados ".count($tips));
                foreach ($tips as $tipsp)
                {
                    $productop2 = new Productop2;
                    $productop2->productop2_productop = $producto->id;
                    $productop2->productop2_tip = $tipsp->productop6_tip;
                    $productop2->save();
                }

                // Areas
                $areas = DB::table('productop5')
                    ->join('areaop', 'productop5_area', '=', 'areaop_codigo')
                    ->where('productop5_productop', $productop->productop1_codigo)
                    ->get();
                $this->line("Areas encontrados ".count($areas));
                foreach ($areas as $areap)
                {
                    $productop3 = new Productop3;
                    $productop3->productop3_productop = $producto->id;
                    $productop3->productop3_areap = $areap->id_nuevo;
                    $productop3->save();
                }

                // Maquinas
                $maquinas = DB::table('productop2')
                    ->join('maquinaop', 'productop2_maquinaop', '=', 'maquinaop_codigo')
                    ->where('productop2_codigo', $productop->productop1_codigo)
                    ->get();
                $this->line("Maquinas encontrados ".count($maquinas));
                foreach ($maquinas as $maquinap)
                {
                    $productop4 = new Productop4;
                    $productop4->productop4_productop = $producto->id;
                    $productop4->productop4_maquinap = $maquinap->id_nuevo;
                    $productop4->save();
                }

                // Materiales
                $materiales = DB::table('productop3')
                    ->join('materialop', 'productop3_materialop', '=', 'materialop_codigo')
                    ->where('productop3_codigo', $productop->productop1_codigo)
                    ->get();
                $this->line("Materiales encontrados ".count($materiales));
                foreach ($materiales as $materialp)
                {
                    $productop5 = new Productop5;
                    $productop5->productop5_productop = $producto->id;
                    $productop5->productop5_materialp = $materialp->id_nuevo;
                    $productop5->save();
                }

                // Acabados
                $acabados = DB::table('productop4')
                    ->where('productop4_codigo', $productop->productop1_codigo)
                    ->join('acabado', 'productop4_acabado', '=', 'acabado_codigo')
                    ->get();
                $this->line("Acabados encontrados ".count($acabados));
                foreach ($acabados as $acabadop)
                {
                    $productop6 = new Productop6;
                    $productop6->productop6_productop = $producto->id;
                    $productop6->productop6_acabadop = $acabadop->id_nuevo;
                    $productop6->save();
                }

                // Actualizar id
                DB::table('productop1')->where('productop1_codigo', $productop->productop1_codigo)->update(['id_nuevo' => $producto->id]);
            }

            // Commit Transaction
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
