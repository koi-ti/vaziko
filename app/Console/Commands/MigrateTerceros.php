<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Base\Tercero, App\Models\Base\Actividad;
 
class MigrateTerceros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mterceros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate table tercero vaziko to laravel scheme';

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
        $this->line('Iniciando migracion de terceros');

        DB::beginTransaction();
        try {

            $partners = DB::table('tercero')
                ->select('tercero.*', DB::raw('COALESCE(koi_actividad.id, 327) as actividad'), 'usuario_cuenta', 'usuario_clave',
                    DB::raw('(SELECT koi_municipio.id FROM koi_municipio 
                        WHERE koi_municipio.departamento_codigo = departamento.departamento_codigo AND koi_municipio.municipio_codigo = right(municipio.municipio_codigo,3)
                        ) as municipio')
                )
                // Actividades
                ->leftJoin('retecree', 'tercero_rut1', '=', 'retecree_codigo')
                ->leftJoin('koi_actividad', 'retecree_codigo', '=', 'actividad_codigo')
                // Municipios
                ->leftJoin('municipio', 'tercero_municipio', '=', 'municipio_codigo')
                ->leftJoin('departamento', 'municipio_departamento', '=', 'departamento_codigo')
                // Terceros internos
                ->leftJoin('tercerointerno', 'tercero_nit', '=', 'tercerointerno_tercero')
                ->leftJoin('usuario', 'usuario_cuenta', '=', 'tercerointerno_usuario')
                // ->take(100)
                ->get();
            
            foreach ($partners as $partner) {
                
                $person = new Tercero;
                $person->tercero_nit = $partner->tercero_nit;
                $person->tercero_digito = $partner->tercero_digito;
                $person->tercero_tipo = $partner->tercero_tipodocumento;
                $person->tercero_regimen = $partner->tercero_regimen;
                $person->tercero_persona = $partner->tercero_persona;
                $person->tercero_razonsocial = $partner->tercero_razonsocial;
                $person->tercero_nombre1 = $partner->tercero_nombre1;
                $person->tercero_nombre2 = $partner->tercero_nombre2;
                $person->tercero_apellido1 = $partner->tercero_apellido1;
                $person->tercero_apellido2 = $partner->tercero_apellido2;
                $person->tercero_actividad = $partner->actividad;

                $person->tercero_municipio = $partner->municipio;
                $person->tercero_direccion = $partner->tercero_direccion;
                $person->tercero_postal = $partner->tercero_cpostal;
                $person->tercero_telefono1 = $partner->tercero_telefono;
                $person->tercero_celular = $partner->tercero_celular;

                $person->tercero_email = $partner->tercero_email;
                $person->tercero_activo = true;

                if($partner->usuario_cuenta) {
                    $person->tercero_interno = true;
                    $person->username = $partner->usuario_cuenta;
                    $person->password = $partner->usuario_clave;
                }
                $person->save();

                $this->info("Tercero -> {$partner->tercero_nit} OK (Id : {$person->id}) -> Rut : {$partner->actividad} -> Mun : {$partner->municipio}, User: {$partner->usuario_cuenta}");
            }

            // Commit Transaction
            // DB::commit();
            DB::rollback();

        }catch(\Exception $e){
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
