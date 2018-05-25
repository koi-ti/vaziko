<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion1, App\Models\Production\PreCotizacion2, App\Models\Production\PreCotizacion3, App\Models\Production\PreCotizacion5, App\Models\Production\PreCotizacion6, App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Cotizacion6, App\Models\Base\Empresa, App\Models\Base\Tercero, App\Models\Base\Contacto;
use App, Auth, DB, Log, Datatables;

class PreCotizacion1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $query = PreCotizacion1::query();
            $query->select('koi_precotizacion1.id', DB::raw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"), 'precotizacion1_numero', 'precotizacion1_ano', 'precotizacion1_fecha', 'precotizacion1_abierta',
                DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END),
                    ' (', precotizacion1_referencia ,')'
                    ) AS tercero_nombre"
                )
            );
            $query->join('koi_tercero', 'precotizacion1_cliente', '=', 'koi_tercero.id');

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchprecotizacion_numero' => $request->has('precotizacion_numero') ? $request->precotizacion_numero : '']);
                session(['searchprecotizacion_tercero' => $request->has('precotizacion_tercero_nit') ? $request->precotizacion_tercero_nit : '']);
                session(['searchprecotizacion_tercero_nombre' => $request->has('precotizacion_tercero_nombre') ? $request->precotizacion_tercero_nombre : '']);
                session(['searchprecotizacion_estado' => $request->has('precotizacion_estado') ? $request->precotizacion_estado : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Cotizacion codigo
                    if($request->has('precotizacion_numero')) {
                        $query->whereRaw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) LIKE '%{$request->precotizacion_numero}%'");
                    }

                    // Tercero nit
                    if($request->has('precotizacion_tercero_nit')) {
                        $query->where('tercero_nit', $request->precotizacion_tercero_nit);
                    }

                    // Tercero id
                    if($request->has('precotizacion_cliente')) {
                        $query->where('precotizacion1_cliente', $request->precotizacion_cliente);
                    }

                    // Estado
                    if($request->has('precotizacion_estado')) {
                        if($request->precotizacion_estado == 'A') {
                            $query->where('precotizacion1_abierta', true);
                        }
                        if($request->precotizacion_estado == 'C') {
                            $query->where('precotizacion1_abierta', false);
                        }
                    }
                })->make(true);
        }
        return view('production.precotizaciones.index', ['empresa' => parent::getPaginacion()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.precotizaciones.create');
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

            $precotizacion = new PreCotizacion1;
            if ($precotizacion->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->precotizacion1_cliente)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->precotizacion1_contacto);
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
                    $numero = DB::table('koi_precotizacion1')->where('precotizacion1_ano', date('Y'))->max('precotizacion1_numero');
                    $numero = !is_integer(intval($numero)) ? 1 : ($numero + 1);

                    // cotizacion
                    $precotizacion->fill($data);
                    $precotizacion->precotizacion1_cliente = $tercero->id;
                    $precotizacion->precotizacion1_ano = date('Y');
                    $precotizacion->precotizacion1_numero = $numero;
                    $precotizacion->precotizacion1_contacto = $contacto->id;
                    $precotizacion->precotizacion1_abierta = true;
                    $precotizacion->precotizacion1_fh_elaboro = date('Y-m-d H:m:s');
                    $precotizacion->precotizacion1_usuario_elaboro = Auth::user()->id;
                    $precotizacion->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $precotizacion->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion->errors]);
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
        $precotizacion = PreCotizacion1::getPreCotizacion($id);
        if(!$precotizacion instanceof PreCotizacion1){
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($precotizacion);
        }

        if( $precotizacion->precotizacion1_abierta == true ) {
            return redirect()->route('precotizaciones.edit', ['precotizacion' => $precotizacion]);
        }

        return view('production.precotizaciones.show', ['precotizacion' => $precotizacion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $precotizacion = PreCotizacion1::getPreCotizacion($id);
        if(!$precotizacion instanceof PreCotizacion1) {
            abort(404);
        }

        if($precotizacion->precotizacion1_abierta == false ) {
            return redirect()->route('precotizaciones.show', ['precotizacion' => $precotizacion]);
        }

        return view('production.precotizaciones.create', ['precotizacion' => $precotizacion]);
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

            $precotizacion = PreCotizacion1::findOrFail($id);
            if ($precotizacion->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->precotizacion1_cliente)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->precotizacion1_contacto);
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
                    $precotizacion->fill($data);
                    $precotizacion->precotizacion1_cliente = $tercero->id;
                    $precotizacion->precotizacion1_contacto = $contacto->id;
                    $precotizacion->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $precotizacion->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $precotizacion->errors]);
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
            $precotizacion = PreCotizacion1::findOrFail($id);
            if(!$precotizacion instanceof PreCotizacion1){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la pre-cotización, por favor verifique la información o consulte al adminitrador.']);
            }

            DB::beginTransaction();
            try {
                // Orden
                $precotizacion->precotizacion1_abierta = false;
                $precotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Pre-cotización cerrada con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Cerrar the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generar(Request $request, $id)
    {
        if ($request->ajax()) {
            $precotizacion = PreCotizacion1::getPreCotizacion($id);
            if(!$precotizacion instanceof PreCotizacion1){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la pre-cotización, por favor verifique la información o consulte al adminitrador.']);
            }

            // Validar que no exista una cotizacion vinculada
            $cotizacion = Cotizacion1::where('cotizacion1_precotizacion', $precotizacion->id)->first();
            if($cotizacion instanceof Cotizacion1){
                return response()->json(['success' => false, 'errors' => 'La pre-cotización ya se ha registrado, por favor verifique la información o consulte al administrador.']);
            }

            $empresa = Empresa::getEmpresa();
            DB::beginTransaction();
            try{
                // Recuperar numero precotizacion
                $numero = Cotizacion1::where('cotizacion1_ano', date('Y'))->max('cotizacion1_numero');
                $numero = !is_integer(intval($numero)) ? 1 : ($numero + 1);

                // Cotizacion
                $cotizacion = new Cotizacion1;
                $cotizacion->cotizacion1_cliente = $precotizacion->precotizacion1_cliente;
                $cotizacion->cotizacion1_referencia = $precotizacion->precotizacion1_referencia;
                $cotizacion->cotizacion1_numero = $numero;
                $cotizacion->cotizacion1_ano = $precotizacion->precotizacion1_ano;
                $cotizacion->cotizacion1_fecha_inicio = $precotizacion->precotizacion1_fecha;
                $cotizacion->cotizacion1_contacto = $precotizacion->precotizacion1_contacto;
                $cotizacion->cotizacion1_iva = $empresa->empresa_iva;
                $cotizacion->cotizacion1_formapago = $precotizacion->tercero_formapago;
                $cotizacion->cotizacion1_precotizacion = $precotizacion->id;
                $cotizacion->cotizacion1_anulada = false;
                $cotizacion->cotizacion1_abierta = true;
                $cotizacion->cotizacion1_observaciones = $precotizacion->precotizacion1_observaciones;
                $cotizacion->cotizacion1_usuario_elaboro = Auth::user()->id;
                $cotizacion->cotizacion1_fecha_elaboro = date('Y-m-d H:m:s');
                $cotizacion->save();

                // Recuperar Productop de cotizacion para generar orden
                $productos = PreCotizacion2::where('precotizacion2_precotizacion1', $precotizacion->id)->orderBy('id', 'asc')->get();
                foreach ($productos as $precotizacion2) {
                    $cotizacion2 = new Cotizacion2;
                    $cotizacion2->cotizacion2_cotizacion = $cotizacion->id;
                    $cotizacion2->cotizacion2_productop = $precotizacion2->precotizacion2_productop;
                    $cotizacion2->cotizacion2_precotizacion2 = $precotizacion2->id;
                    $cotizacion2->cotizacion2_cantidad = $precotizacion2->precotizacion2_cantidad;
                    $cotizacion2->cotizacion2_tiro = $precotizacion2->precotizacion2_tiro;
                    $cotizacion2->cotizacion2_retiro = $precotizacion2->precotizacion2_retiro;
                    $cotizacion2->cotizacion2_yellow = $precotizacion2->precotizacion2_yellow;
                    $cotizacion2->cotizacion2_magenta = $precotizacion2->precotizacion2_magenta;
                    $cotizacion2->cotizacion2_cyan = $precotizacion2->precotizacion2_cyan;
                    $cotizacion2->cotizacion2_key = $precotizacion2->precotizacion2_key;
                    $cotizacion2->cotizacion2_color1 = $precotizacion2->precotizacion2_color1;
                    $cotizacion2->cotizacion2_color2 = $precotizacion2->precotizacion2_color2;
                    $cotizacion2->cotizacion2_nota_tiro = $precotizacion2->precotizacion2_nota_tiro;
                    $cotizacion2->cotizacion2_yellow2 = $precotizacion2->precotizacion2_yellow2;
                    $cotizacion2->cotizacion2_magenta2 = $precotizacion2->precotizacion2_magenta2;
                    $cotizacion2->cotizacion2_cyan2 = $precotizacion2->precotizacion2_cyan2;
                    $cotizacion2->cotizacion2_key2 = $precotizacion2->precotizacion2_key2;
                    $cotizacion2->cotizacion2_color12 = $precotizacion2->precotizacion2_color12;
                    $cotizacion2->cotizacion2_color22 = $precotizacion2->precotizacion2_color22;
                    $cotizacion2->cotizacion2_nota_retiro = $precotizacion2->precotizacion2_nota_retiro;
                    $cotizacion2->cotizacion2_ancho = $precotizacion2->precotizacion2_ancho;
                    $cotizacion2->cotizacion2_alto = $precotizacion2->precotizacion2_alto;
                    $cotizacion2->cotizacion2_c_ancho = $precotizacion2->precotizacion2_c_ancho;
                    $cotizacion2->cotizacion2_c_alto = $precotizacion2->precotizacion2_c_alto;
                    $cotizacion2->cotizacion2_3d_ancho = $precotizacion2->precotizacion2_3d_ancho;
                    $cotizacion2->cotizacion2_3d_alto = $precotizacion2->precotizacion2_3d_alto;
                    $cotizacion2->cotizacion2_3d_profundidad = $precotizacion2->precotizacion2_3d_profundidad;
                    $cotizacion2->cotizacion2_usuario_elaboro = $cotizacion->cotizacion1_usuario_elaboro;
                    $cotizacion2->cotizacion2_fecha_elaboro = $cotizacion->cotizacion1_fecha_elaboro;
                    $cotizacion2->save();

                    // Recuperar Materiales de pre-cotizacion para generar cotizacion
                    $materiales = PreCotizacion3::where('precotizacion3_precotizacion2', $precotizacion2->id)->get();
                    $totalmaterial = $totalareasp = 0;
                    foreach ($materiales as $precotizacion3) {
                         $cotizacion4 = new Cotizacion4;
                         $cotizacion4->cotizacion4_materialp = $precotizacion3->precotizacion3_materialp;
                         $cotizacion4->cotizacion4_cotizacion2 = $cotizacion2->id;
                         $cotizacion4->cotizacion4_cantidad = $precotizacion3->precotizacion3_cantidad;
                         $cotizacion4->cotizacion4_precio = $precotizacion3->precotizacion3_valor_total;
                         $cotizacion4->save();

                         $totalmaterial += $precotizacion3->precotizacion3_valor_total;
                    }

                    // Recuperar Areasp de cotizacion para generar orden
                    $areasp = PreCotizacion6::select('koi_precotizacion6.*', DB::raw("((SUBSTRING_INDEX(precotizacion6_tiempo, ':', -1) / 60) + SUBSTRING_INDEX(precotizacion6_tiempo, ':', 1)) * precotizacion6_valor as total_areap"))->where('precotizacion6_precotizacion2', $precotizacion2->id)->get();
                    foreach ($areasp as $precotizacion6) {
                         $cotizacion6 = new Cotizacion6;
                         $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
                         $cotizacion6->cotizacion6_areap = $precotizacion6->precotizacion6_areap;
                         $cotizacion6->cotizacion6_nombre = $precotizacion6->precotizacion6_nombre;
                         $cotizacion6->cotizacion6_tiempo = $precotizacion6->precotizacion6_tiempo;
                         $cotizacion6->cotizacion6_valor = $precotizacion6->precotizacion6_valor;
                         $cotizacion6->save();

                         // Convertir minutos a horas y sumar horas
                         $totalareasp += round($precotizacion6->total_areap) / $cotizacion2->cotizacion2_cantidad;
                    }

                    // Actualizar precio en cotizacion2;
                    $cotizacion2->cotizacion2_precio_formula = $totalmaterial;
                    $cotizacion2->cotizacion2_precio_venta = $totalmaterial;
                    $cotizacion2->cotizacion2_total_valor_unitario = $totalmaterial + $totalareasp;
                    $cotizacion2->save();
                }

                $precotizacion->precotizacion1_abierta = false;
                $precotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Se genero con exito la cotizacion', 'cotizacion_id' => $cotizacion->id]);
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
            $precotizacion = PreCotizacion1::findOrFail($id);
            if(!$precotizacion instanceof PreCotizacion1){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la pre-cotización, por favor verifique la información o consulte al administrador.']);
            }

            // Validar que no exista una cotizacion vinculada
            $cotizacion = Cotizacion1::where('cotizacion1_precotizacion', $precotizacion->id)->first();
            if($cotizacion instanceof Cotizacion1){
                return response()->json(['success' => false, 'errors' => 'La pre-cotización se encuentra en proceso de cotización, por favor verifique la información o consulte al administrador.']);
            }

            DB::beginTransaction();
            try {
                // Orden
                $precotizacion->precotizacion1_abierta = true;
                $precotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Pre-cotización reabierta con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
