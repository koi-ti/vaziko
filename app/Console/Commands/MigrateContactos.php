<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Base\Contacto;

class MigrateContactos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mcontactos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate table tercerocontacto vaziko to laravel scheme';

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
        $this->line('Iniciando migracion de contactos');

        DB::beginTransaction();
        try
        {
            $contactos = DB::table('tercerocontacto')
                ->select('tercerocontacto.*', 'tercero_nit', 'koi_tercero.id as tercero_id',
                    DB::raw('(SELECT koi_municipio.id FROM koi_municipio
                        WHERE koi_municipio.departamento_codigo = departamento.departamento_codigo AND koi_municipio.municipio_codigo = right(municipio.municipio_codigo,3)
                        ) as municipio'))
                ->whereNull('id_nuevo')
                ->join('koi_tercero', 'tercerocontacto_tercero', '=', 'koi_tercero.tercero_nit')
                ->leftJoin('municipio', 'tercerocontacto_municipio', '=', 'municipio_codigo')
                ->leftJoin('departamento', 'municipio_departamento', '=', 'departamento_codigo')
                ->orderBy('koi_tercero.id', 'asc')
                ->get();

            $this->info("Contactos encontrados: ".count($contactos));

            foreach ($contactos as $tercerocontacto) {

                $contacto = new Contacto;
                $contacto->tcontacto_tercero = $tercerocontacto->tercero_id;
                $contacto->tcontacto_nombres = $tercerocontacto->tercerocontacto_nombres;
                $contacto->tcontacto_apellidos = $tercerocontacto->tercerocontacto_apellidos;
                $contacto->tcontacto_municipio = $tercerocontacto->municipio;
                $contacto->tcontacto_direccion = $tercerocontacto->tercerocontacto_direccion;
                $contacto->tcontacto_telefono = $tercerocontacto->tercerocontacto_telefono;
                $contacto->tcontacto_celular = $tercerocontacto->tercerocontacto_celular;
                $contacto->tcontacto_email = $tercerocontacto->tercerocontacto_email;
                $contacto->tcontacto_cargo = $tercerocontacto->tercerocontacto_cargo;
                $contacto->save();

                DB::table('tercerocontacto')->where('tercerocontacto_tercero', $tercerocontacto->tercerocontacto_tercero)->where('tercerocontacto_item', $tercerocontacto->tercerocontacto_item)->update(['id_nuevo' => $contacto->id]);

                $this->info("Tercero -> {$tercerocontacto->tercerocontacto_tercero} Nit -> {$tercerocontacto->tercero_nit} ID -> {$tercerocontacto->tercero_id} Contacto -> {$tercerocontacto->tercerocontacto_item} Municipio {$tercerocontacto->municipio} OK (Id : {$contacto->id})");
            }

            // Commit Transaction
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
