<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Production\Despachop, App\Models\Production\Despachop2;

class MigrateOrdenes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mordenes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate table ordenproduccion vaziko to laravel scheme';

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
            $ordenes = DB::table('ordenproduccion0')
                ->select('ordenproduccion0.*', 'koi_tercero.tercero_nit as tercero_nit', 'tercerocontacto.id_nuevo as contacto_id', 'ue.id as elaboro_id', 'ua.id as anulo_id')
                ->join('koi_tercero', 'ordenproduccion0_tercero', '=', 'koi_tercero.id')
                ->join('koi_tercero as ue', 'ordenproduccion0_usuario_elaboro', '=', 'ue.username')
                ->leftJoin('koi_tercero as ua', 'ordenproduccion0_usuario_anulo', '=', 'ua.username')
                ->leftJoin('tercerocontacto', function($join) {
                    $join->on('tercerocontacto.tercerocontacto_tercero', '=', 'koi_tercero.tercero_nit')
                        ->on('tercerocontacto.tercerocontacto_item', '=', 'ordenproduccion0.ordenproduccion0_itemc');
                })
                ->whereNull('ordenproduccion0.id_nuevo')
                ->orderBy('ordenproduccion0_ano', 'asc')
                ->orderBy('ordenproduccion0_numero', 'asc')
                ->get();

            $this->info("Ordenes encontrados: ".count($ordenes));

            $ordenesm = 0;
            foreach ($ordenes as $ordenp)
            {
                $orden = new Ordenp;
                $orden->orden_cliente = $ordenp->ordenproduccion0_tercero;
                $orden->orden_referencia = $ordenp->ordenproduccion0_referencia;
                $orden->orden_ano = $ordenp->ordenproduccion0_ano;
                $orden->orden_numero = $ordenp->ordenproduccion0_numero;
                $orden->orden_fecha_inicio = $ordenp->ordenproduccion0_fecha_inicio;
                $orden->orden_fecha_entrega = $ordenp->ordenproduccion0_fecha_entrega;
                $orden->orden_hora_entrega = str_replace('T', '', $ordenp->ordenproduccion0_hora_entrega);
                $orden->orden_contacto = $ordenp->contacto_id;
                $orden->orden_formapago = $ordenp->ordenproduccion0_pago == 'C' ? 'CT' : 'CO';
                $orden->orden_suministran = $ordenp->ordenproduccion0_suministran;
                $orden->orden_anulada = $ordenp->ordenproduccion0_anulada;
                $orden->orden_abierta = $ordenp->ordenproduccion0_abierta;
                $orden->orden_observaciones = $ordenp->ordenproduccion0_observaciones;
                $orden->orden_terminado = $ordenp->ordenproduccion0_terminado;
                $orden->orden_fecha_elaboro = $ordenp->ordenproduccion0_fecha_elaboro;
                $orden->orden_usuario_elaboro = $ordenp->elaboro_id;
                $orden->orden_fecha_anulo = "$ordenp->ordenproduccion0_fecha_anulo $ordenp->ordenproduccion0_hora_anulo";
                $orden->orden_usuario_anulo = $ordenp->anulo_id;
                $orden->save();

                // Actualizar id
                DB::table('ordenproduccion0')->where('ordenproduccion0_ano', $orden->orden_ano)->where('ordenproduccion0_numero', $orden->orden_numero)->update(['id_nuevo' => $orden->id]);

                $ordenesm++;
            }
            $this->info("Ordenes migradas: $ordenesm");

            // Despachos
            $despachos = DB::table('despachop1')
                ->select('despachop1.*', 'ordenproduccion0.id_nuevo as orden_id', 'ue.id as elaboro_id', 'ua.id as anulo_id')
                ->join('ordenproduccion0', function($join) {
                    $join->on('ordenproduccion0.ordenproduccion0_numero', '=', 'despachop1.despachop_orden')
                        ->on('ordenproduccion0.ordenproduccion0_ano', '=', 'despachop1.despachop_ano');
                })
                ->whereNull('despachop1.id_nuevo')
                ->join('koi_tercero as ue', 'despachop_usuario_elaboro', '=', 'ue.username')
                ->leftJoin('koi_tercero as ua', 'despachop_usuario_anulo', '=', 'ua.username')
                ->get();
            $this->line("Despachos encontrados ".count($despachos));

            $despachosm = 0;
            foreach ($despachos as $despachop)
            {
                // Recuperar contacto
                $contacto = DB::table('tercerocontacto')
                    ->where('tercerocontacto_tercero', $despachop->despachop_tercero)
                    ->where('tercerocontacto_email', $despachop->despachop_email)
                    ->first();
                $primero = DB::table('tercerocontacto')
                    ->where('tercerocontacto_tercero', $despachop->despachop_tercero)
                    ->first();
                $contacto_id = isset($contacto) && is_object($contacto) ? $contacto->id_nuevo : $primero->id_nuevo;

                $despacho = new Despachop;
                $despacho->despachop1_orden = $despachop->orden_id;
                $despacho->despachop1_contacto = $contacto_id;
                $despacho->despachop1_fecha = $despachop->despachop_fecha;
                $despacho->despachop1_anulado = $despachop->despachop_anulado;
                $despacho->despachop1_observacion = $despachop->despachop_observacion;
                $despacho->despachop1_transporte = $despachop->despachop_transporte;
                $despacho->despachop1_usuario_elaboro = $despachop->elaboro_id;
                $despacho->despachop1_fecha_elaboro = "$despachop->despachop_fecha_elaboro $despachop->despachop_hora_elaboro";
                $despacho->despachop1_usuario_anulo = $despachop->anulo_id;
                $despacho->despachop1_fecha_anulo = "$despachop->despachop_fecha_anulo $despachop->despachop_hora_anulo";
                $despacho->save();

                // Actualizar id
                DB::table('despachop1')->where('despachop_numero', $despachop->despachop_numero)->update(['id_nuevo' => $despacho->id]);

                $despachosm++;
            }
            $this->info("Despachos migrados: $despachosm");

            // Orden produccion2
            $productos = DB::table('ordenproduccion1')
                ->select('ordenproduccion1.*', 'productop1.id_nuevo as producto_id', 'ue.id as elaboro_id', 'ordenproduccion0.id_nuevo as orden_id')
                ->join('ordenproduccion0', function($join) {
                    $join->on('ordenproduccion0.ordenproduccion0_numero', '=', 'ordenproduccion1.ordenproduccion1_id')
                        ->on('ordenproduccion0.ordenproduccion0_ano', '=', 'ordenproduccion1.ordenproduccion1_ano');
                })
                ->join('productop1', 'ordenproduccion1_productop', '=', 'productop1.productop1_codigo')
                ->join('koi_tercero as ue', 'ordenproduccion1_usuario_elaboro', '=', 'ue.username')
                ->whereNull('ordenproduccion1.id_nuevo')
                ->get();
            $this->line("Ordenes2 encontrados ".count($productos));

            $ordenes2m = 0;
            foreach ($productos as $ordenp2)
            {
                $orden2 = new Ordenp2;
                $orden2->orden2_orden = $ordenp2->orden_id;
                $orden2->orden2_productop = $ordenp2->producto_id;
                $orden2->orden2_referencia = $ordenp2->ordenproduccion1_referencia;
                $orden2->orden2_cantidad = $ordenp2->ordenproduccion1_cantidad;
                $orden2->orden2_saldo = $ordenp2->ordenproduccion1_saldo;
                $orden2->orden2_precio_formula = $ordenp2->ordenproduccion1_precio_formula;
                $orden2->orden2_round_formula = $ordenp2->ordenproduccion1_round_formula;
                $orden2->orden2_precio_venta = $ordenp2->ordenproduccion1_precio_venta;
                $orden2->orden2_entregado = $ordenp2->ordenproduccion1_entregado;
                $orden2->orden2_observaciones = $ordenp2->ordenproduccion1_observaciones;

                $orden2->orden2_tiro = $ordenp2->ordenproduccion1_tiro;
                $orden2->orden2_yellow = $ordenp2->ordenproduccion1_yellow;
                $orden2->orden2_magenta = $ordenp2->ordenproduccion1_magenta;
                $orden2->orden2_cyan = $ordenp2->ordenproduccion1_cyan;
                $orden2->orden2_key = $ordenp2->ordenproduccion1_key;
                $orden2->orden2_color1 = $ordenp2->ordenproduccion1_color1;
                $orden2->orden2_color2 = $ordenp2->ordenproduccion1_color2;
                $orden2->orden2_nota_tiro = $ordenp2->ordenproduccion1_nota_tiro;

                $orden2->orden2_retiro = $ordenp2->ordenproduccion1_retiro;
                $orden2->orden2_yellow2 = $ordenp2->ordenproduccion1_yellow2;
                $orden2->orden2_magenta2 = $ordenp2->ordenproduccion1_magenta2;
                $orden2->orden2_cyan2 = $ordenp2->ordenproduccion1_cyan2;
                $orden2->orden2_key2 = $ordenp2->ordenproduccion1_key2;
                $orden2->orden2_color12 = $ordenp2->ordenproduccion1_color12;
                $orden2->orden2_color22 = $ordenp2->ordenproduccion1_color22;
                $orden2->orden2_nota_retiro = $ordenp2->ordenproduccion1_nota_retiro;

                $orden2->orden2_ancho = $ordenp2->ordenproduccion1_ancho;
                $orden2->orden2_alto = $ordenp2->ordenproduccion1_alto;
                $orden2->orden2_c_ancho = $ordenp2->ordenproduccion1_c_ancho;
                $orden2->orden2_c_alto = $ordenp2->ordenproduccion1_c_alto;
                $orden2->orden2_3d_ancho = $ordenp2->ordenproduccion1_3d_ancho_med;
                $orden2->orden2_3d_alto = $ordenp2->ordenproduccion1_3d_alto_med;
                $orden2->orden2_3d_profundidad = $ordenp2->ordenproduccion1_3d_profundidad_med;

                $orden2->orden2_fecha_elaboro = "$ordenp2->ordenproduccion1_fecha_elaboro $ordenp2->ordenproduccion1_hora_elaboro";
                $orden2->orden2_usuario_elaboro = $ordenp2->elaboro_id;
                $orden2->save();

                // Actualizar id
                DB::table('ordenproduccion1')->where('ordenproduccion1_codigo', $ordenp2->ordenproduccion1_codigo)->update(['id_nuevo' => $orden2->id]);

                $ordenes2m++;
            }
            $this->info("Ordenes2 migrados: $ordenes2m");

            // Despacho2
            $despachos2 = DB::table('despachop2')
                ->select('despachop2.*', 'despachop1.id_nuevo as despacho_id', 'ordenproduccion1.id_nuevo as orden2_id')
                ->join('despachop1', 'despachop_numero', '=', 'despachop2_numero')
                ->join('ordenproduccion1', 'despachop2_productop', '=', 'ordenproduccion1_codigo')
                ->get();
            $this->line("Despachos2 encontrados ".count($despachos2));

            $despachos2m = 0;
            foreach ($despachos2 as $despachop2)
            {
                $despacho2 = new Despachop2;
                $despacho2->despachop2_despacho = $despachop2->despacho_id;
                $despacho2->despachop2_orden2 = $despachop2->orden2_id;
                $despacho2->despachop2_cantidad = $despachop2->despachop2_cantidad;
                $despacho2->save();

                $despachos2m ++;
            }
            $this->info("Despachos2 migrados: $despachos2m");

            // Commit Transaction
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $this->error($e->getMessage());
        }
    }
}
