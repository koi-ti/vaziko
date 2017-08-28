<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Cotizacion5, App\Models\Production\Cotizacion6, App\Models\Base\Tercero, App\Models\Base\Contacto, App\Models\Base\Empresa;
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
            $query->select('koi_cotizacion1.id', DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"), 'cotizacion1_numero', 'cotizacion1_ano', 'cotizacion1_fecha_elaboro as cotizacion1_fecha', 'cotizacion1_fecha_inicio', 'cotizacion1_fecha_entrega', 'cotizacion1_hora_entrega', 'cotizacion1_anulada', 'cotizacion1_abierta',
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
                    $numero = !is_integer($numero) ? 1 : ($numero + 1);

                    // cotizacion
                    $cotizacion->fill($data);
                    $cotizacion->cotizacion1_cliente = $tercero->id;
                    $cotizacion->cotizacion1_ano = date('Y');
                    $cotizacion->cotizacion1_numero = $numero;
                    $cotizacion->cotizacion1_contacto = $contacto->id;
                    $cotizacion->cotizacion1_iva = $empresa->empresa_iva;
                    $cotizacion->cotizacion1_usuario_elaboro = Auth::user()->id;
                    $cotizacion->cotizacion1_fecha_elaboro = date('Y-m-d H:m:s');
                    dd($cotizacion, $numero);
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

    // /**
    //  * Search cotizacion.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function search(Request $request)
    // {
    //     if($request->has('cotizacion_codigo')) {
    //         $cotizacion = Cotizacion1::select('koi_cotizacion1.id',
    //             DB::raw("(CASE WHEN tercero_persona = 'N'
    //                 THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
    //                         (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
    //                     )
    //                 ELSE tercero_razonsocial END)
    //             AS tercero_nombre")
    //         )
    //         ->join('koi_tercero', 'cotizacion1_cliente', '=', 'koi_tercero.id')
    //         ->whereRaw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) = '{$request->cotizacion_codigo}'")->first();
    //         if($cotizacion instanceof Cotizacion1) {
    //             return response()->json(['success' => true, 'tercero_nombre' => $cotizacion->tercero_nombre, 'id' => $cotizacion->id]);
    //         }
    //     }
    //     return response()->json(['success' => false]);
    // }

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
    public function exportar($id)
    {
        $cotizacion = Cotizacion1::getCotizacion($id);
        if(!$cotizacion instanceof Cotizacion1){
            abort(404);
        }
        $detalle = Cotizacion2::getCotizaciones2($cotizacion->id);
        $title = sprintf('Cotización %s', $cotizacion->cotizacion_codigo);

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('production.cotizaciones.export',  compact('cotizacion', 'detalle' ,'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'cotización', $cotizacion->id, date('Y_m_d'), date('H_m_s')));
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
                $numero = !is_integer($numero) ? 1 : ($numero + 1);

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
}
