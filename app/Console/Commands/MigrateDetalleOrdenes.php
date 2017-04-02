<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Production\Ordenp3, App\Models\Production\Ordenp4, App\Models\Production\Ordenp5;

class MigrateDetalleOrdenes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mdetalleordenes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate details table ordenproduccion vaziko to laravel scheme';

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
        $this->line('Iniciando migracion de ordenes de produccion');
        DB::beginTransaction();
        try
        {
            // Orden ordenproduccion5
            $materiales = DB::table('ordenproduccion5')
                ->select('ordenproduccion1.id_nuevo as orden_id', 'materialop.id_nuevo as material_id')
                ->join('materialop', 'materialop_codigo', '=', 'ordenproduccion5.ordenproduccion5_materialop')
                ->join('ordenproduccion1', 'ordenproduccion1.ordenproduccion1_codigo', '=', 'ordenproduccion5.ordenproduccion5_codigo')
                ->join('koi_ordenproduccion2', 'koi_ordenproduccion2.id', '=', 'ordenproduccion1.id_nuevo')
                ->where('ordenproduccion5.ordenproduccion5_materialop', '!=', 0)
                ->get();
            $this->line("Materiales encontrados ".count($materiales));

            $materialesm = 0;
            foreach ($materiales as $material)
            {
                $ordenp4 = new Ordenp4;
                $ordenp4->orden4_orden2 = $material->orden_id;
                $ordenp4->orden4_materialp = $material->material_id;
                $ordenp4->save();

                $materialesm++;
            }
            $this->info("Materiales migrados: $materialesm");

            // Orden ordenproduccion2
            $maquinas = DB::table('ordenproduccion2')
                ->select('ordenproduccion1.id_nuevo as orden_id', 'maquinaop.id_nuevo as maquina_id')
                ->join('maquinaop', 'maquinaop_codigo', '=', 'ordenproduccion2.ordenproduccion2_maquinaop')
                ->join('ordenproduccion1', 'ordenproduccion1.ordenproduccion1_codigo', '=', 'ordenproduccion2.ordenproduccion2_codigo')
                ->join('koi_ordenproduccion2', 'koi_ordenproduccion2.id', '=', 'ordenproduccion1.id_nuevo')
                ->where('ordenproduccion2.ordenproduccion2_maquinaop', '!=', 0)
                ->get();
            $this->line("Maquinas encontrados ".count($maquinas));

            $maquinasm = 0;
            foreach ($maquinas as $maquina)
            {
                $ordenp3 = new Ordenp3;
                $ordenp3->orden3_orden2 = $maquina->orden_id;
                $ordenp3->orden3_maquinap = $maquina->maquina_id;
                $ordenp3->save();

                $maquinasm++;
            }
            $this->info("Maquinas migrados: $maquinasm");

            // Orden ordenproduccion2
            $acabados = DB::table('ordenproduccion6')
                ->select('ordenproduccion1.id_nuevo as orden_id', 'acabado.id_nuevo as acabado_id')
                ->join('acabado', 'acabado_codigo', '=', 'ordenproduccion6.ordenproduccion6_acabado')
                ->join('ordenproduccion1', 'ordenproduccion1.ordenproduccion1_codigo', '=', 'ordenproduccion6.ordenproduccion6_codigo')
                ->join('koi_ordenproduccion2', 'koi_ordenproduccion2.id', '=', 'ordenproduccion1.id_nuevo')
                ->where('ordenproduccion6.ordenproduccion6_acabado', '!=', 0)
                ->get();
            $this->line("Acabados encontrados ".count($acabados));

            $acabadosm = 0;
            foreach ($acabados as $acabado)
            {
                $ordenp5 = new Ordenp5;
                $ordenp5->orden5_orden2 = $acabado->orden_id;
                $ordenp5->orden5_acabadop = $acabado->acabado_id;
                $ordenp5->save();
                $acabadosm++;
            }
            $this->info("Acabados migrados: $acabadosm");

            // Commit Transaction
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
