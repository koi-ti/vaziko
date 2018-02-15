<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Cotizacion5, App\Models\Production\Cotizacion6, App\Models\Base\Tercero, App\Models\Base\Contacto, App\Models\Base\Empresa, App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Production\Ordenp3, App\Models\Production\Ordenp4, App\Models\Production\Ordenp5, App\Models\Production\Ordenp6;
use App, View, Auth, DB, Log, Datatables;

class Cotizacion1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Cotizacion1::query();
            $query->select('koi_cotizacion1.id', DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"), 'cotizacion1_numero', 'cotizacion1_ano', 'cotizacion1_fecha_elaboro as cotizacion1_fecha', 'cotizacion1_fecha_inicio', 'cotizacion1_anulada', 'cotizacion1_abierta',
                DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END),
                    ' (', cotizacion1_referencia ,')'
                    ) AS tercero_nombre"
                )
            );
            $query->join('koi_tercero', 'cotizacion1_cliente', '=', 'koi_tercero.id');

            // Permisions
            if( !Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) ) {
                $query->where('cotizacion1_abierta', true);
            }

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchcotizacion_numero' => $request->has('cotizacion_numero') ? $request->cotizacion_numero : '']);
                session(['searchcotizacion_tercero' => $request->has('cotizacion_tercero_nit') ? $request->cotizacion_tercero_nit : '']);
                session(['searchcotizacion_tercero_nombre' => $request->has('cotizacion_tercero_nombre') ? $request->cotizacion_tercero_nombre : '']);
                session(['searchcotizacion_estado' => $request->has('cotizacion_estado') ? $request->cotizacion_estado : '']);
                session(['searchcotizacion_referencia' => $request->has('cotizacion_referencia') ? $request->cotizacion_referencia : '']);
                session(['searchcotizacion_productop' => $request->has('cotizacion_productop') ? $request->cotizacion_productop : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {

                    // Cotizacion codigo
                    if($request->has('cotizacion_numero')) {
                        $query->whereRaw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) LIKE '%{$request->cotizacion_numero}%'");
                    }

                    // Tercero nit
                    if($request->has('cotizacion_tercero_nit')) {
                        $query->where('tercero_nit', $request->cotizacion_tercero_nit);
                    }

                    // Tercero id
                    if($request->has('cotizacion_cliente')) {
                        $query->where('cotizacion1_cliente', $request->cotizacion_cliente);
                    }

                    // Estado
                    if($request->has('cotizacion_estado')) {
                        if($request->cotizacion_estado == 'A') {
                            $query->where('cotizacion1_abierta', true);
                        }
                        if($request->cotizacion_estado == 'C') {
                            $query->where('cotizacion1_abierta', false);
                            $query->where('cotizacion1_anulada', false);
                        }
                        if($request->cotizacion_estado == 'N') {
                            $query->where('cotizacion1_anulada', true);
                        }
                    }

                    // Referencia
                    if($request->has('cotizacion_referencia')) {
                        $query->whereRaw("cotizacion1_referencia LIKE '%{$request->cotizacion_referencia}%'");
                    }

                    // Producto
                    if($request->has('cotizacion_productop')) {
                        $query->whereRaw("$request->cotizacion_productop IN ( SELECT cotizacion2_productop FROM koi_cotizacion2 WHERE cotizacion2_cotizacion = koi_cotizacion1.id) ");
                    }
                })
                ->make(true);
        }
        return view('production.cotizaciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.cotizaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $cotizacion = new Cotizacion1;
            if ($cotizacion->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar empresa
                    $empresa = Empresa::getEmpresa();
                    if(!$empresa instanceof Empresa) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar empresa, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->cotizacion1_cliente)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->cotizacion1_contacto);
                    if(!$contacto instanceof Contacto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar contacto, por favor verifique la información o consulte al administrador.']);
                    }
                    // Validar tercero contacto
                    if($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor seleccione de nuevo el contacto o consulte al administrador.']);
                    }

                    // Actualizar telefono del contacto
                    if($contacto->tcontacto_telefono != $request->tcontacto_telefono) {
                        $contacto->tcontacto_telefono = $request->tcontacto_telefono;
                        $contacto->save();
                    }

                    // Recuperar numero cotizacion
                    $numero = DB::table('koi_cotizacion1')->where('cotizacion1_ano', date('Y'))->max('cotizacion1_numero');
                    $numero = !is_integer(intval($numero)) ? 1 : ($numero + 1);

                    // cotizacion
                    $cotizacion->fill($data);
                    $cotizacion->cotizacion1_cliente = $tercero->id;
                    $cotizacion->cotizacion1_ano = date('Y');
                    $cotizacion->cotizacion1_numero = $numero;
                    $cotizacion->cotizacion1_contacto = $contacto->id;
                    $cotizacion->cotizacion1_iva = $empresa->empresa_iva;
                    $cotizacion->cotizacion1_usuario_elaboro = Auth::user()->id;
                    $cotizacion->cotizacion1_fecha_elaboro = date('Y-m-d H:m:s');
                    $cotizacion->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cotizacion->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $cotizacion = Cotizacion1::getCotizacion($id);
        if(!$cotizacion instanceof Cotizacion1){
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($cotizacion);
        }

        // Permisions
        if( !Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) && $cotizacion->cotizacion1_abierta == false) {
            abort(403);
        }

        if( $cotizacion->cotizacion1_abierta == true && $cotizacion->cotizacion1_anulada == false && Auth::user()->ability('admin', 'editar', ['module' => 'cotizaciones']) ) {
            return redirect()->route('cotizaciones.edit', ['cotizacion' => $cotizacion]);
        }

        return view('production.cotizaciones.show', ['cotizacion' => $cotizacion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cotizacion = Cotizacion1::getCotizacion($id);
        if(!$cotizacion instanceof Cotizacion1) {
            abort(404);
        }

        if($cotizacion->cotizacion1_abierta == false || $cotizacion->cotizacion1_anulada == true) {
            return redirect()->route('cotizaciones.show', ['cotizacion' => $cotizacion]);
        }

        return view('production.cotizaciones.create', ['cotizacion' => $cotizacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $cotizacion = Cotizacion1::findOrFail($id);
            if ($cotizacion->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->cotizacion1_cliente)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->cotizacion1_contacto);
                    if(!$contacto instanceof Contacto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar contacto, por favor verifique la información o consulte al administrador.']);
                    }
                    // Validar tercero contacto
                    if($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor seleccione de nuevo el contacto o consulte al administrador.']);
                    }

                    // Actualizar telefono del contacto
                    if($contacto->tcontacto_telefono != $request->tcontacto_telefono) {
                        $contacto->tcontacto_telefono = $request->tcontacto_telefono;
                        $contacto->save();
                    }

                    // Cotizacion
                    $cotizacion->fill($data);
                    $cotizacion->cotizacion1_cliente = $tercero->id;
                    $cotizacion->cotizacion1_contacto = $contacto->id;
                    $cotizacion->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cotizacion->id, 'cotizacion1_iva' => $cotizacion->cotizacion1_iva]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion->errors]);
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Cerrar the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cerrar(Request $request, $id)
    {
        if ($request->ajax()) {
            $cotizacion = Cotizacion1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Cotización
                $cotizacion->cotizacion1_abierta = false;
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Cotización cerrada con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Abrir the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function abrir(Request $request, $id)
    {
        if ($request->ajax()) {
            $cotizacion = Cotizacion1::findOrFail($id);

            // Comprobar que no exita orden de produccion
            $orden = Ordenp::where('orden_cotizacion', $cotizacion->id)->first();
            if($orden instanceof Ordenp){
                return response()->json(['success' => false, 'errors' => 'No se puede reabrir la cotización, porque tiene una orden de produccion en proceso.']);
            }

            DB::beginTransaction();
            try {
                // Cotizacion
                $cotizacion->cotizacion1_abierta = true;
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Cotización reabierta con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($codigo)
    {
        $cotizacion = Cotizacion1::getExportCotizacion($codigo);
        if(!$cotizacion instanceof Cotizacion1){
            abort(404);
        }

        $cotizaciones2 = Cotizacion2::getCotizaciones2($cotizacion->id);
        $title = "Cotización {$cotizacion->cotizacion_codigo}";

        $data = [];
        foreach ( $cotizaciones2 as $cotizacion2 ) {
            $query = Cotizacion4::query();
            $query->select(DB::raw("GROUP_CONCAT(materialp_nombre SEPARATOR ', ') AS materialp_nombre"));
            $query->join('koi_materialp', 'cotizacion4_materialp', '=', 'koi_materialp.id');
            $query->where('cotizacion4_cotizacion2', $cotizacion2->id);
            $materialesp = $query->first();

            $query = Cotizacion5::query();
            $query->select(DB::raw("GROUP_CONCAT(acabadop_nombre SEPARATOR ', ') AS acabadop_nombre"));
            $query->join('koi_acabadop', 'cotizacion5_acabadop', '=', 'koi_acabadop.id');
            $query->where('cotizacion5_cotizacion2', $cotizacion2->id);
            $acabadosp = $query->first();

            $cotizacion2->materialp_nombre = $materialesp->materialp_nombre;
            $cotizacion2->acabadop_nombre = $acabadosp->acabadop_nombre;

            $data[] = $cotizacion2;
        }

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('production.cotizaciones.report.export',  compact('cotizacion', 'data' ,'title'))->render());
        return $pdf->stream("cotización_{$cotizacion->cotizacion_codigo}.pdf");
    }

    /**
     * Clonar the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clonar(Request $request, $id)
    {
        if ($request->ajax()) {
            $cotizacion = Cotizacion1::findOrFail($id);

            DB::beginTransaction();
            try {
                // Recuperar numero cotizacion
                $numero = DB::table('koi_cotizacion1')->where('cotizacion1_ano', date('Y'))->max('cotizacion1_numero');
                $numero = !is_integer(intval($numero)) ? 1 : ($numero + 1);

                // Cotizacion
                $newcotizacion = $cotizacion->replicate();
                $newcotizacion->cotizacion1_abierta = true;
                $newcotizacion->cotizacion1_anulada = false;
                $newcotizacion->cotizacion1_ano = date('Y');
                $newcotizacion->cotizacion1_numero = $numero;
                $newcotizacion->cotizacion1_usuario_elaboro = Auth::user()->id;
                $newcotizacion->cotizacion1_fecha_elaboro = date('Y-m-d H:m:s');
                $newcotizacion->save();

                // Cotizacion2
                $productos = Cotizacion2::where('cotizacion2_cotizacion', $cotizacion->id)->orderBy('id', 'asc')->get();
                foreach ($productos as $cotizacion2) {
                    $newcotizacion2 = $cotizacion2->replicate();
                    $newcotizacion2->cotizacion2_cotizacion = $newcotizacion->id;
                    $newcotizacion2->cotizacion2_saldo = $newcotizacion2->cotizacion2_cantidad;
                    $newcotizacion2->cotizacion2_entregado = 0;
                    $newcotizacion2->cotizacion2_usuario_elaboro = Auth::user()->id;
                    $newcotizacion2->cotizacion2_fecha_elaboro = date('Y-m-d H:m:s');
                    $newcotizacion2->save();

                    // Maquinas
                    $maquinas = Cotizacion3::where('cotizacion3_cotizacion2', $cotizacion2->id)->get();
                    foreach ($maquinas as $cotizacion3) {
                         $newcotizacion3 = $cotizacion3->replicate();
                         $newcotizacion3->cotizacion3_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion3->save();
                    }

                    // Materiales
                    $materiales = Cotizacion4::where('cotizacion4_cotizacion2', $cotizacion2->id)->get();
                    foreach ($materiales as $cotizacion4) {
                         $newcotizacion4 = $cotizacion4->replicate();
                         $newcotizacion4->cotizacion4_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion4->save();
                    }

                    // Acabados
                    $acabados = Cotizacion5::where('cotizacion5_cotizacion2', $cotizacion2->id)->get();
                    foreach ($acabados as $cotizacion5) {
                         $newcotizacion5 = $cotizacion5->replicate();
                         $newcotizacion5->cotizacion5_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion5->save();
                    }

                    // Areasp
                    $areasp = Cotizacion6::where('cotizacion6_cotizacion2', $cotizacion2->id)->get();
                    foreach ($areasp as $cotizacion6) {
                         $newcotizacion6 = $cotizacion6->replicate();
                         $newcotizacion6->cotizacion6_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion6->save();
                    }
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $newcotizacion->id, 'msg' => 'Cotización clonada con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Generate orden the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generar(Request $request, $id)
    {
        if ($request->ajax()) {
            $cotizacion = Cotizacion1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Recuperar numero cotizacion
                $numero = Ordenp::where('orden_ano', date('Y'))->max('orden_numero');
                $numero = !is_integer(intval($numero)) ? 1 : ($numero + 1);

                // Ordenp
                $orden = new Ordenp;
                $orden->orden_cliente = $cotizacion->cotizacion1_cliente;
                $orden->orden_referencia = $cotizacion->cotizacion1_referencia;
                $orden->orden_numero = $numero;
                $orden->orden_ano = $cotizacion->cotizacion1_ano;
                $orden->orden_fecha_inicio = $cotizacion->cotizacion1_fecha_inicio;
                $orden->orden_contacto = $cotizacion->cotizacion1_contacto;
                $orden->orden_formapago = $cotizacion->cotizacion1_formapago;
                $orden->orden_fecha_entrega = date('Y-m-d');
                $orden->orden_hora_entrega = date('H:m:s');
                $orden->orden_cotizacion = $cotizacion->id;
                $orden->orden_iva = $cotizacion->cotizacion1_iva;
                $orden->orden_suministran = $cotizacion->cotizacion1_suministran;
                $orden->orden_abierta = true;
                $orden->orden_observaciones = $cotizacion->cotizacion1_observaciones;
                $orden->orden_terminado = $cotizacion->cotizacion1_terminado;
                $orden->orden_usuario_elaboro = Auth::user()->id;
                $orden->orden_fecha_elaboro = date('Y-m-d H:m:s');
                $orden->save();

                // Recuperar Productop de cotizacion para generar orden
                $productos = Cotizacion2::where('cotizacion2_cotizacion', $cotizacion->id)->orderBy('id', 'asc')->get();
                foreach ($productos as $cotizacion2) {
                    $orden2 = new Ordenp2;
                    $orden2->orden2_orden = $orden->id;
                    $orden2->orden2_productop = $cotizacion2->cotizacion2_productop;
                    $orden2->orden2_referencia = $cotizacion2->cotizacion2_referencia;
                    $orden2->orden2_cantidad = $cotizacion2->cotizacion2_cantidad;
                    $orden2->orden2_saldo = $cotizacion2->cotizacion2_saldo;
                    $orden2->orden2_facturado = $cotizacion2->cotizacion2_facturado;
                    $orden2->orden2_precio_formula = $cotizacion2->cotizacion2_precio_formula;
                    $orden2->orden2_transporte_formula = $cotizacion2->cotizacion2_transporte_formula;
                    $orden2->orden2_viaticos_formula = $cotizacion2->cotizacion2_viaticos_formula;
                    $orden2->orden2_precio_round = $cotizacion2->cotizacion2_precio_round;
                    $orden2->orden2_transporte_round = $cotizacion2->cotizacion2_transporte_round;
                    $orden2->orden2_viaticos_round = $cotizacion2->cotizacion2_viaticos_round;
                    $orden2->orden2_viaticos = $cotizacion2->cotizacion2_viaticos;
                    $orden2->orden2_transporte = $cotizacion2->cotizacion2_transporte;
                    $orden2->orden2_precio_venta = $cotizacion2->cotizacion2_precio_venta;
                    $orden2->orden2_total_valor_unitario = $cotizacion2->cotizacion2_total_valor_unitario;
                    $orden2->orden2_volumen = $cotizacion2->cotizacion2_volumen;
                    $orden2->orden2_redondear = $cotizacion2->cotizacion2_redondear;
                    $orden2->orden2_vtotal = $cotizacion2->cotizacion2_vtotal;
                    $orden2->orden2_entregado = $cotizacion2->cotizacion2_entregado;
                    $orden2->orden2_observaciones = $cotizacion2->cotizacion2_observaciones;
                    $orden2->orden2_tiro = $cotizacion2->cotizacion2_tiro;
                    $orden2->orden2_retiro = $cotizacion2->cotizacion2_retiro;
                    $orden2->orden2_yellow = $cotizacion2->cotizacion2_yellow;
                    $orden2->orden2_magenta = $cotizacion2->cotizacion2_magenta;
                    $orden2->orden2_cyan = $cotizacion2->cotizacion2_cyan;
                    $orden2->orden2_key = $cotizacion2->cotizacion2_key;
                    $orden2->orden2_color1 = $cotizacion2->cotizacion2_color1;
                    $orden2->orden2_color2 = $cotizacion2->cotizacion2_color2;
                    $orden2->orden2_nota_tiro = $cotizacion2->cotizacion2_nota_tiro;
                    $orden2->orden2_yellow2 = $cotizacion2->cotizacion2_yellow2;
                    $orden2->orden2_magenta2 = $cotizacion2->cotizacion2_magenta2;
                    $orden2->orden2_cyan2 = $cotizacion2->cotizacion2_cyan2;
                    $orden2->orden2_key2 = $cotizacion2->cotizacion2_key2;
                    $orden2->orden2_color12 = $cotizacion2->cotizacion2_color12;
                    $orden2->orden2_color22 = $cotizacion2->cotizacion2_color22;
                    $orden2->orden2_nota_retiro = $cotizacion2->cotizacion2_nota_retiro;
                    $orden2->orden2_ancho = $cotizacion2->cotizacion2_ancho;
                    $orden2->orden2_alto = $cotizacion2->cotizacion2_alto;
                    $orden2->orden2_c_ancho = $cotizacion2->cotizacion2_c_ancho;
                    $orden2->orden2_c_alto = $cotizacion2->cotizacion2_c_alto;
                    $orden2->orden2_3d_ancho = $cotizacion2->cotizacion2_3d_ancho;
                    $orden2->orden2_3d_alto = $cotizacion2->cotizacion2_3d_alto;
                    $orden2->orden2_3d_profundidad = $cotizacion2->cotizacion2_3d_profundidad;
                    $orden2->orden2_usuario_elaboro = $cotizacion2->cotizacion2_usuario_elaboro;
                    $orden2->orden2_fecha_elaboro = $cotizacion2->cotizacion2_usuario_elaboro;
                    $orden2->save();

                    // Recuperar Maquinas de cotizacion para generar orden
                    $maquinas = Cotizacion3::where('cotizacion3_cotizacion2', $cotizacion2->id)->get();
                    foreach ($maquinas as $cotizacion3) {
                         $orden3 = new Ordenp3;
                         $orden3->orden3_maquinap = $cotizacion3->cotizacion3_maquinap;
                         $orden3->orden3_orden2 = $orden2->id;
                         $orden3->save();
                    }

                    // Recuperar Materiales de cotizacion para generar orden
                    $materiales = Cotizacion4::where('cotizacion4_cotizacion2', $cotizacion2->id)->get();
                    foreach ($materiales as $cotizacion4) {
                         $orden4 = new Ordenp4;
                         $orden4->orden4_materialp = $cotizacion4->cotizacion4_materialp;
                         $orden4->orden4_orden2 = $orden2->id;
                         $orden4->save();
                    }

                    // Recuperar Acabados de cotizacion para generar orden
                    $acabados = Cotizacion5::where('cotizacion5_cotizacion2', $cotizacion2->id)->get();
                    foreach ($acabados as $cotizacion5) {
                         $orden5 = new Ordenp5;
                         $orden5->orden5_acabadop = $cotizacion5->cotizacion5_acabadop;
                         $orden5->orden5_orden2 = $orden2->id;
                         $orden5->save();
                    }

                    // Recuperar Areasp de cotizacion para generar orden
                    $areasp = Cotizacion6::where('cotizacion6_cotizacion2', $cotizacion2->id)->get();
                    foreach ($areasp as $cotizacion6) {
                         $orden6 = new Ordenp6;
                         $orden6->orden6_orden2 = $orden2->id;
                         $orden6->orden6_areap = $cotizacion6->cotizacion6_areap;
                         $orden6->orden6_nombre = $cotizacion6->cotizacion6_nombre;
                         $orden6->orden6_tiempo = $cotizacion6->cotizacion6_tiempo;
                         $orden6->orden6_valor = $cotizacion6->cotizacion6_valor;
                         $orden6->save();
                    }
                }

                $cotizacion->cotizacion1_abierta = false;
                $cotizacion->cotizacion1_anulada = false;
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Se genero con exito la orden de producción', 'orden_id' => $orden->id]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
