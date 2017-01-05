<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Production\Maquinap;

class MigrateMaquinas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mmaquinas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate table maquinaop vaziko to laravel scheme';

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
        $this->line('Iniciando migracion de maquinas');

        DB::beginTransaction();
        try
        {
            $maquinas = DB::table('maquinaop')
                ->whereNull('id_nuevo')
                ->orderBy('maquinaop_codigo', 'asc')
                ->get();

            foreach ($maquinas as $maquinap) {

                $maquina = new Maquinap;
                $maquina->maquinap_nombre = $maquinap->maquinaop_nombre;
                $maquina->save();

                DB::table('maquinaop')->where('maquinaop_codigo', $maquinap->maquinaop_codigo)->update(['id_nuevo' => $maquina->id]);

                $this->info("Maquina -> {$maquinap->maquinaop_codigo} OK (Id : {$maquina->id})");
            }

            // Commit Transaction
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
