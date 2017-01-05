<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Production\Materialp;

class MigrateMateriales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mmateriales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate table materialop vaziko to laravel scheme';

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
        $this->line('Iniciando migracion de materiales');

        DB::beginTransaction();
        try
        {
            $materiales = DB::table('materialop')
                ->whereNull('id_nuevo')
                ->orderBy('materialop_codigo', 'asc')
                ->get();

            foreach ($materiales as $materialp) {

                $material = new Materialp;
                $material->materialp_nombre = $materialp->materialop_nombre;
                $material->materialp_descripcion = $materialp->materialop_descripcion;
                $material->save();

                DB::table('materialop')->where('materialop_codigo', $materialp->materialop_codigo)->update(['id_nuevo' => $material->id]);

                $this->info("Material -> {$materialp->materialop_codigo} OK (Id : {$material->id})");
            }

            // Commit Transaction
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
