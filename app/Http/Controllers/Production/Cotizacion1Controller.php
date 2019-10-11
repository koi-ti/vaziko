<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Cotizacion5, App\Models\Production\Cotizacion6, App\Models\Production\Cotizacion8, App\Models\Production\Cotizacion9, App\Models\Production\Cotizacion10, App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Production\Ordenp3, App\Models\Production\Ordenp4, App\Models\Production\Ordenp5, App\Models\Production\Ordenp6, App\Models\Production\Ordenp8, App\Models\Production\Ordenp9, App\Models\Production\Ordenp10;
use App\Models\Base\Tercero, App\Models\Base\Contacto, App\Models\Base\Empresa;
use App, View, DB, Log, Datatables, Storage;

class Cotizacion1Controller extends Controller
{
    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,consultar');
        $this->middleware('ability:admin,crear', ['only' => ['create', 'store', 'abrir', 'cerrar']]);
        $this->middleware('ability:admin,opcional2', ['only' => ['terminar', 'clonar']]);
        $this->middleware('ability:admin,editar', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Cotizacion1::query();
            $query->select('koi_cotizacion1.id', 'cotizacion1_precotizacion', DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo, CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"), 'cotizacion1_numero', 'cotizacion1_ano', 'cotizacion1_fecha_elaboro as cotizacion1_fecha', 'cotizacion1_fecha_inicio', 'cotizacion1_anulada', 'cotizacion1_abierta', 'cotizacion1_iva',
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
            $query->leftjoin('koi_precotizacion1', 'cotizacion1_precotizacion', '=', 'koi_precotizacion1.id');
            $query->with(['productos' => function ($producto) {
                $producto->select('cotizacion2_cotizacion', DB::raw('SUM(cotizacion2_total_valor_unitario*cotizacion2_cantidad) as total'))
                                ->groupBy('cotizacion2_cotizacion');
            }]);

            // Permisions mostrar botones crear [close, open]
            if (auth()->user()->ability('admin', 'crear', ['module' => 'cotizaciones'])) {
                $query->addSelect(DB::raw('TRUE as cotizacion_create'));
            } else {
                $query->addSelect(DB::raw('FALSE as cotizacion_create'));
            }

            if (auth()->user()->hasRole('admin')) {
                $query->addSelect(DB::raw('TRUE as admin'));
            } else {
                $query->addSelect(DB::raw('FALSE as admin'));
            }

            // Permisions mostrar botones opcional2 [complete, clone]
            if (auth()->user()->ability('admin', 'opcional2', ['module' => 'cotizaciones'])) {
                $query->addSelect(DB::raw('TRUE as cotizacion_opcional'));
            } else {
                $query->where('cotizacion1_abierta', true);
                $query->addSelect(DB::raw('FALSE as cotizacion_opcional'));
            }

            // Persistent data filter
            if ($request->has('persistent') && $request->persistent) {
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
                    if ($request->has('cotizacion_numero')) {
                        $query->whereRaw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) LIKE '%{$request->cotizacion_numero}%'");
                    }

                    // Tercero nit
                    if ($request->has('cotizacion_tercero_nit')) {
                        $query->where('tercero_nit', $request->cotizacion_tercero_nit);
                    }

                    // Tercero id
                    if ($request->has('cotizacion_cliente')) {
                        $query->where('cotizacion1_cliente', $request->cotizacion_cliente);
                    }

                    // Estado
                    if ($request->has('cotizacion_estado')) {
                        if ($request->cotizacion_estado == 'A') {
                            $query->where('cotizacion1_abierta', true);
                        }
                        if ($request->cotizacion_estado == 'C') {
                            $query->where('cotizacion1_abierta', false);
                            $query->where('cotizacion1_anulada', false);
                        }
                        if ($request->cotizacion_estado == 'N') {
                            $query->where('cotizacion1_anulada', true);
                        }
                    }

                    // Referencia
                    if ($request->has('cotizacion_referencia')) {
                        $query->whereRaw("cotizacion1_referencia LIKE '%{$request->cotizacion_referencia}%'");
                    }

                    // Producto
                    if ($request->has('cotizacion_productop')) {
                        $query->whereRaw("$request->cotizacion_productop IN ( SELECT cotizacion2_productop FROM koi_cotizacion2 WHERE cotizacion2_cotizacion = koi_cotizacion1.id) ");
                    }
                })
                ->make(true);
        }
        return view('production.cotizaciones.index', ['empresa' => parent::getPaginacion()]);
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
                    $cotizacion->cotizacion1_usuario_elaboro = auth()->user()->id;
                    $cotizacion->cotizacion1_fecha_elaboro = date('Y-m-d H:i:s');
                    $cotizacion->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cotizacion->id]);
                } catch(\Exception $e) {
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
        if( !auth()->user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) && $cotizacion->cotizacion1_abierta == false) {
            abort(403);
        }

        if( $cotizacion->cotizacion1_abierta == true && $cotizacion->cotizacion1_anulada == false && auth()->user()->ability('admin', 'editar', ['module' => 'cotizaciones']) ) {
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
                } catch(\Exception $e) {
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
            if( !in_array($request->state, array_keys(config('koi.close.state'))) ){
                return response()->json(['success' => false, 'errors' => 'El estado de cerrar no es valido.']);
            }

            $cotizacion = Cotizacion1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Cotización

                $cotizacion->cotizacion1_abierta = false;
                $cotizacion->cotizacion1_estado = $request->state;
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Cotización cerrada con exito.']);
            } catch(\Exception $e) {
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
            if(!$cotizacion instanceof Cotizacion1){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cotización, por favor verifique la información o consulte al adminitrador.']);
            }

            // Comprobar que no exita orden de produccion
            $orden = Ordenp::where('orden_cotizacion', $cotizacion->id)->first();
            if($orden instanceof Ordenp){
                return response()->json(['success' => false, 'errors' => 'No se puede reabrir la cotización, porque tiene una orden de produccion en proceso.']);
            }

            DB::beginTransaction();
            try {
                // Cotizacion
                $cotizacion->cotizacion1_abierta = true;
                $cotizacion->cotizacion1_estado = '';
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Cotización reabierta con exito.']);
            } catch(\Exception $e) {
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

            $imagenes = [];
            $query = Cotizacion8::query();
            $query->select('cotizacion8_archivo');
            $query->where('cotizacion8_cotizacion2', $cotizacion2->id);
            $query->where('cotizacion8_imprimir', true);
            $cotizacion8 = $query->get();
            foreach ($cotizacion8 as $imagen) {
                $imagenes[] = "storage/cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$imagen->cotizacion8_archivo";
            }

            $query = Cotizacion9::query();
            $query->select(DB::raw("GROUP_CONCAT(materialp_nombre SEPARATOR ', ') AS empaque_nombre"));
            $query->leftJoin('koi_materialp', 'cotizacion9_materialp', '=', 'koi_materialp.id');
            $query->where('cotizacion9_cotizacion2', $cotizacion2->id);
            $empaques = $query->first();

            $cotizacion2->materialp_nombre = $materialesp->materialp_nombre;
            $cotizacion2->acabadop_nombre = $acabadosp->acabadop_nombre;
            $cotizacion2->empaque_nombre = $empaques->empaque_nombre;
            $cotizacion2->imagenes = $imagenes;

            $data[] = $cotizacion2;
        }

        $export = str_slug("$cotizacion->cotizacion_codigo $cotizacion->tercero_nombre $cotizacion->cotizacion1_referencia", '_');

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('production.cotizaciones.report.export',  compact('cotizacion', 'data' ,'title'))->render());
        return $pdf->stream("cotización_$export.pdf");
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
            if(!$cotizacion instanceof Cotizacion1){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cotización, por favor verifique la información o consulte al adminitrador.']);
            }

            DB::beginTransaction();
            try {
                // Recuperar numero cotizacion
                $numero = DB::table('koi_cotizacion1')->where('cotizacion1_ano', date('Y'))->max('cotizacion1_numero');
                $numero = !is_integer(intval($numero)) ? 1 : ($numero + 1);

                // Cotizacion
                $newcotizacion = $cotizacion->replicate();
                $newcotizacion->cotizacion1_fecha_inicio = date('Y-m-d');
                $newcotizacion->cotizacion1_abierta = true;
                $newcotizacion->cotizacion1_anulada = false;
                $newcotizacion->cotizacion1_estado = '';
                $newcotizacion->cotizacion1_ano = date('Y');
                $newcotizacion->cotizacion1_numero = $numero;
                $newcotizacion->cotizacion1_usuario_elaboro = auth()->user()->id;
                $newcotizacion->cotizacion1_fecha_elaboro = date('Y-m-d H:i:s');
                $newcotizacion->save();

                // Cotizacion2
                $productos = Cotizacion2::where('cotizacion2_cotizacion', $cotizacion->id)->orderBy('id', 'asc')->get();
                foreach ($productos as $cotizacion2) {
                    $newcotizacion2 = $cotizacion2->replicate();
                    $newcotizacion2->cotizacion2_cotizacion = $newcotizacion->id;
                    $newcotizacion2->cotizacion2_saldo = $newcotizacion2->cotizacion2_cantidad;
                    $newcotizacion2->cotizacion2_entregado = 0;
                    $newcotizacion2->cotizacion2_usuario_elaboro = auth()->user()->id;
                    $newcotizacion2->cotizacion2_fecha_elaboro = date('Y-m-d H:i:s');
                    $newcotizacion2->save();

                    // Maquinas
                    $maquinas = Cotizacion3::where('cotizacion3_cotizacion2', $cotizacion2->id)->get();
                    foreach ($maquinas as $cotizacion3) {
                         $newcotizacion3 = $cotizacion3->replicate();
                         $newcotizacion3->cotizacion3_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion3->save();
                    }

                    // Acabados
                    $acabados = Cotizacion5::where('cotizacion5_cotizacion2', $cotizacion2->id)->get();
                    foreach ($acabados as $cotizacion5) {
                        $newcotizacion5 = $cotizacion5->replicate();
                        $newcotizacion5->cotizacion5_cotizacion2 = $newcotizacion2->id;
                        $newcotizacion5->save();
                    }

                    // Imagenes
                    $imagenes = Cotizacion8::where('cotizacion8_cotizacion2', $cotizacion2->id)->get();
                    foreach ($imagenes as $cotizacion8) {
                        $newcotizacion8 = $cotizacion8->replicate();
                        $newcotizacion8->cotizacion8_cotizacion2 = $newcotizacion2->id;
                        $newcotizacion8->cotizacion8_usuario_elaboro = auth()->user()->id;
                        $newcotizacion8->cotizacion8_fh_elaboro = date('Y-m-d H:i:s');
                        $newcotizacion8->save();

                        // Recuperar imagen y copiar
                        if( Storage::has("cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$cotizacion8->cotizacion8_archivo") ) {

                            $oldfile = "cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$cotizacion8->cotizacion8_archivo";
                            $newfile = "cotizaciones/cotizacion_$newcotizacion2->cotizacion2_cotizacion/producto_$newcotizacion2->id/$newcotizacion8->cotizacion8_archivo";

                            // Copy file storege laravel
                            Storage::copy($oldfile, $newfile);
                        }
                    }

                    // Materiales
                    $materiales = Cotizacion4::where('cotizacion4_cotizacion2', $cotizacion2->id)->get();
                    foreach ($materiales as $cotizacion4) {
                         $newcotizacion4 = $cotizacion4->replicate();
                         $newcotizacion4->cotizacion4_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion4->cotizacion4_usuario_elaboro = auth()->user()->id;
                         $newcotizacion4->cotizacion4_fh_elaboro = date('Y-m-d H:i:s');
                         $newcotizacion4->save();
                    }

                    // Areasp
                    $areasp = Cotizacion6::where('cotizacion6_cotizacion2', $cotizacion2->id)->get();
                    foreach ($areasp as $cotizacion6) {
                         $newcotizacion6 = $cotizacion6->replicate();
                         $newcotizacion6->cotizacion6_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion6->save();
                    }

                    // Empaques
                    $empaques = Cotizacion9::where('cotizacion9_cotizacion2', $cotizacion2->id)->get();
                    foreach ($empaques as $cotizacion9) {
                         $newcotizacion9 = $cotizacion9->replicate();
                         $newcotizacion9->cotizacion9_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion9->cotizacion9_usuario_elaboro = auth()->user()->id;
                         $newcotizacion9->cotizacion9_fh_elaboro = date('Y-m-d H:i:s');
                         $newcotizacion9->save();
                    }

                    // Transportes
                    $transportes = Cotizacion10::where('cotizacion10_cotizacion2', $cotizacion2->id)->get();
                    foreach ($transportes as $cotizacion10) {
                         $newcotizacion10 = $cotizacion10->replicate();
                         $newcotizacion10->cotizacion10_cotizacion2 = $newcotizacion2->id;
                         $newcotizacion10->cotizacion10_usuario_elaboro = auth()->user()->id;
                         $newcotizacion10->cotizacion10_fh_elaboro = date('Y-m-d H:i:s');
                         $newcotizacion10->save();
                    }
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $newcotizacion->id, 'msg' => 'Cotización clonada con exito.']);
            } catch(\Exception $e) {
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
            if(!$cotizacion instanceof Cotizacion1){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cotización, por favor verifique la información o consulte al adminitrador.']);
            }

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
                $orden->orden_ano = date('Y');
                $orden->orden_fecha_inicio = date('Y-m-d');
                $orden->orden_contacto = $cotizacion->cotizacion1_contacto;
                $orden->orden_formapago = $cotizacion->cotizacion1_formapago;
                $orden->orden_fecha_entrega = date('Y-m-d');
                $orden->orden_hora_entrega = date('H:i:s');
                $orden->orden_cotizacion = $cotizacion->id;
                $orden->orden_iva = $cotizacion->cotizacion1_iva;
                $orden->orden_suministran = $cotizacion->cotizacion1_suministran;
                $orden->orden_abierta = true;
                $orden->orden_observaciones = $cotizacion->cotizacion1_observaciones;
                $orden->orden_terminado = $cotizacion->cotizacion1_terminado;
                $orden->orden_usuario_elaboro = auth()->user()->id;
                $orden->orden_fecha_elaboro = date('Y-m-d H:i:s');
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
                    $orden2->orden2_viaticos = $cotizacion2->cotizacion2_viaticos;
                    $orden2->orden2_transporte = $cotizacion2->cotizacion2_transporte;
                    $orden2->orden2_precio_venta = $cotizacion2->cotizacion2_precio_venta;
                    $orden2->orden2_total_valor_unitario = $cotizacion2->cotizacion2_total_valor_unitario;
                    $orden2->orden2_volumen = $cotizacion2->cotizacion2_volumen;
                    $orden2->orden2_round = $cotizacion2->cotizacion2_round;
                    $orden2->orden2_margen_materialp = $cotizacion2->cotizacion2_margen_materialp;
                    $orden2->orden2_vtotal = $cotizacion2->cotizacion2_vtotal;
                    $orden2->orden2_margen_materialp = $cotizacion2->cotizacion2_margen_materialp;
                    $orden2->orden2_margen_empaque = $cotizacion2->cotizacion2_margen_empaque;
                    $orden2->orden2_margen_transporte = $cotizacion2->cotizacion2_margen_transporte;
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

                    // Recuperar Acabados de cotizacion para generar orden
                    $acabados = Cotizacion5::where('cotizacion5_cotizacion2', $cotizacion2->id)->get();
                    foreach ($acabados as $cotizacion5) {
                        $orden5 = new Ordenp5;
                        $orden5->orden5_acabadop = $cotizacion5->cotizacion5_acabadop;
                        $orden5->orden5_orden2 = $orden2->id;
                        $orden5->save();
                    }

                    // Recuperar impresiones de cotizacion para generar orden
                    $imagenes = Cotizacion8::where('cotizacion8_cotizacion2', $cotizacion2->id)->get();
                    foreach ($imagenes as $cotizacion8) {
                        $orden8 = new Ordenp8;
                        $orden8->orden8_orden2 = $orden2->id;
                        $orden8->orden8_archivo = $cotizacion8->cotizacion8_archivo;
                        $orden8->orden8_fh_elaboro = date('Y-m-d H:i:s');
                        $orden8->orden8_usuario_elaboro = auth()->user()->id;
                        $orden8->save();

                        // Recuperar imagen y copiar
                        if( Storage::has("cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$cotizacion8->cotizacion8_archivo") ) {

                            $oldfile = "cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$cotizacion8->cotizacion8_archivo";
                            $newfile = "ordenes/orden_$orden2->orden2_orden/producto_$orden2->id/$orden8->orden8_archivo";

                            // Copy file storege laravel
                            Storage::copy($oldfile, $newfile);
                        }
                    }

                    // Recuperar Materiales de cotizacion para generar orden
                    $materiales = Cotizacion4::where('cotizacion4_cotizacion2', $cotizacion2->id)->get();
                    foreach ($materiales as $cotizacion4) {
                         $orden4 = new Ordenp4;
                         $orden4->orden4_materialp = $cotizacion4->cotizacion4_materialp;
                         $orden4->orden4_orden2 = $orden2->id;
                         $orden4->orden4_producto = $cotizacion4->cotizacion4_producto;
                         $orden4->orden4_medidas = $cotizacion4->cotizacion4_medidas;
                         $orden4->orden4_cantidad = $cotizacion4->cotizacion4_cantidad;
                         $orden4->orden4_valor_unitario = $cotizacion4->cotizacion4_valor_unitario;
                         $orden4->orden4_valor_total = $cotizacion4->cotizacion4_valor_total;
                         $orden4->orden4_usuario_elaboro = auth()->user()->id;
                         $orden4->orden4_fh_elaboro = date('Y-m-d H:i:s');
                         $orden4->save();
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

                    // Recuperar Empaques de cotizacion para generar orden
                    $empaques = Cotizacion9::where('cotizacion9_cotizacion2', $cotizacion2->id)->get();
                    foreach ($empaques as $cotizacion9) {
                         $orden9 = new Ordenp9;
                         $orden9->orden9_orden2 = $orden2->id;
                         $orden9->orden9_producto = $cotizacion9->cotizacion9_producto;
                         $orden9->orden9_materialp = $cotizacion9->cotizacion9_materialp;
                         $orden9->orden9_medidas = $cotizacion9->cotizacion9_medidas;
                         $orden9->orden9_cantidad = $cotizacion9->cotizacion9_cantidad;
                         $orden9->orden9_valor_unitario = $cotizacion9->cotizacion9_valor_unitario;
                         $orden9->orden9_valor_total = $cotizacion9->cotizacion9_valor_total;
                         $orden9->orden9_usuario_elaboro = auth()->user()->id;
                         $orden9->orden9_fh_elaboro = date('Y-m-d H:i:s');
                         $orden9->save();
                    }

                    // Recuperar Transportes de cotizacion para generar orden
                    $transportes = Cotizacion10::where('cotizacion10_cotizacion2', $cotizacion2->id)->get();
                    foreach ($transportes as $cotizacion10) {
                         $orden10 = new Ordenp10;
                         $orden10->orden10_orden2 = $orden2->id;
                         $orden10->orden10_producto = $cotizacion10->cotizacion10_producto;
                         $orden10->orden10_materialp = $cotizacion10->cotizacion10_materialp;
                         $orden10->orden10_medidas = $cotizacion10->cotizacion10_medidas;
                         $orden10->orden10_cantidad = $cotizacion10->cotizacion10_cantidad;
                         $orden10->orden10_valor_unitario = $cotizacion10->cotizacion10_valor_unitario;
                         $orden10->orden10_valor_total = $cotizacion10->cotizacion10_valor_total;
                         $orden10->orden10_usuario_elaboro = auth()->user()->id;
                         $orden10->orden10_fh_elaboro = date('Y-m-d H:i:s');
                         $orden10->save();
                    }
                }

                $cotizacion->cotizacion1_abierta = false;
                $cotizacion->cotizacion1_anulada = false;
                $cotizacion->cotizacion1_estado = 'O';
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Se genero con exito la orden de producción', 'orden_id' => $orden->id]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * function charts ordenesp
     */
    public function charts(Request $request, $id)
    {
        if ($request->ajax()) {
            $cotizacion = Cotizacion1::find($id);
            if (!$cotizacion instanceof Cotizacion1) {
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cotización']);
            }

            // Construir object con graficas
            $object = new \stdClass();

            // Chart productos
            $tprecio = $ttransporte = $tviaticos = $tmateriales = $tareas = $tempaques = $tvolumen = 0;
            $cotizaciones2 = Cotizacion2::where('cotizacion2_cotizacion', $cotizacion->id)->get();
            foreach ($cotizaciones2 as $cotizacion2) {
                $tprecio += $precio = $cotizacion2->cotizacion2_precio_venta;
                $ttransporte += $transporte = round($cotizacion2->cotizacion2_transporte/$cotizacion2->cotizacion2_cantidad);
                $tviaticos += $viaticos = round($cotizacion2->cotizacion2_viaticos/$cotizacion2->cotizacion2_cantidad);

                $materiales = Cotizacion4::where('cotizacion4_cotizacion2', $cotizacion2->id)->sum('cotizacion4_valor_total');
                $tmateriales += $materiales = ($materiales/$cotizacion2->cotizacion2_cantidad)/((100-$cotizacion2->cotizacion2_margen_materialp)/100);

                $tareas += $areas = Cotizacion6::select(DB::raw("SUM(((SUBSTRING_INDEX(cotizacion6_tiempo, ':', 1) + (SUBSTRING_INDEX(cotizacion6_tiempo, ':', -1)/60)) * cotizacion6_valor)/$cotizacion2->cotizacion2_cantidad) as total"))->where('cotizacion6_cotizacion2', $cotizacion2->id)->value('total');

                $empaques = Cotizacion9::where('cotizacion9_cotizacion2', $cotizacion2->id)->sum('cotizacion9_valor_total');
                $tempaques += $empaques = ($empaques/$cotizacion2->cotizacion2_cantidad)/((100-$cotizacion2->cotizacion2_margen_materialp)/100);

                $subtotal = $precio + $transporte + $viaticos + $materiales + round($areas) + $empaques;
                $tvolumen += $comision = ($subtotal/((100-$cotizacion2->cotizacion2_volumen)/100)) * (1-(((100-$cotizacion2->cotizacion2_volumen)/100)));
            }

            // Make object
            $chartproducto = new \stdClass();
            $chartproducto->labels = [
                'Precio', 'Transporte', 'Viáticos', 'Materiales de producción', 'Áreas de producción', 'Empaques de producción', 'Volumen'
            ];
            $chartproducto->data = [
                $tprecio, $ttransporte, $tviaticos, $tmateriales, $tareas, $tempaques, $tvolumen
            ];
            $object->chartproductos = $chartproducto;

            $object->success = true;
            return response()->json($object);
        }
        return response()->json(['success' => false]);
    }
}
