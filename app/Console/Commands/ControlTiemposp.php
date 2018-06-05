<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Base\Rol, App\Models\Base\UsuarioRol, App\Models\Production\Tiempop, App\Models\Base\Empresa;
use Log, DB, Mail;

class ControlTiemposp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'control:tiemposp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rutina para informar si algun operario no a generado tiempos.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Fecha actual y fecha anteriros
        $this->previusdate = date('Y-m-d',strtotime("-1 days"));
        $this->currentdate = date('Y-m-d');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            Log::info("Generando control tiempos de producción - ($this->currentdate)");

            // Recuperar roles (operario)
            $rol = Rol::where('name', 'operario')->first();
            if(!$rol instanceof Rol){
                throw new \Exception('No es posible recuperar el rol de operario.');
            }

            // Recuperar usuarios con rol de (operario)
            $data = [];
            $usuariosrol = UsuarioRol::select('koi_usuario_rol.*', 'tercero_nit', 'tercero_activo', DB::raw("CONCAT(tercero_nombre1,' ',tercero_apellido1) AS tercero_nombre"))->where('role_id', $rol->id)->where('tercero_activo', true)->join('koi_tercero', 'user_id', '=', 'koi_tercero.id')->get();
            foreach ($usuariosrol as $usuario) {
                // Tiempos de produccion del usuario
                $operario = new \stdClass();
                $tiemposp = Tiempop::where('tiempop_tercero', $usuario->user_id)->whereRaw("SUBSTRING_INDEX(tiempop_fh_elaboro, ' ', 1) = '$this->previusdate'")->count();
                if($tiemposp == 0){
                    $operario->tercero_nit = $usuario->tercero_nit;
                    $operario->tercero_nombre = $usuario->tercero_nombre;

                    $data[] = $operario;
                }
            }

            // Recuperar empresa
            $empresa = Empresa::getEmpresa();
            if( !empty($empresa->tercero_email) ){

                if( count($data) > 0 ){
                    $datos = ['operarios' => $data, 'fecha' => $this->previusdate];
                    Mail::send('emails.tiemposp.control', $datos, function($msj) use ($empresa){
                        $msj->from('soportekoiti@gmail.com', $empresa->tercero_razonsocial);
                        $msj->to($empresa->tercero_email);
                        $msj->subject('Control de operarios.');
                    });
                }

            }else{
                throw new \Exception('La empresa no tiene un correo asociado.');
            }

            DB::commit();
            Log::info("Se completo la rutina con exito.");
        }catch(\Exception $e){
            DB::rollback();
            Log::error("{$e->getMessage()} - ($this->currentdate)");
        }
    }
}
