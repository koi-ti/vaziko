<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Production\Acabadop;

class MigrateAcabados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:macabados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate table acabado vaziko to laravel scheme';

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
        $this->line('Iniciando migracion de acabados');

        DB::beginTransaction();
        try
        {
            $acabados = DB::table('acabado')
                ->whereNull('id_nuevo')
                ->orderBy('acabado_codigo', 'asc')
                ->get();

            foreach ($acabados as $acabadop) {

                $acabado = new Acabadop;
                $acabado->acabadop_nombre = $acabadop->acabado_nombre;
                $acabado->acabadop_descripcion = $acabadop->acabado_descripcion;
                $acabado->save();

                DB::table('acabado')->where('acabado_codigo', $acabadop->acabado_codigo)->update(['id_nuevo' => $acabado->id]);

                $this->info("Acabado -> {$acabadop->acabado_codigo} OK (Id : {$acabado->id})");
            }

            // Commit Transaction
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
