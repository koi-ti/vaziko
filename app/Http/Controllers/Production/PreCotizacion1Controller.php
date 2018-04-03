<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion1, App\Models\Base\Tercero, App\Models\Base\Contacto;
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
        return view('production.precotizaciones.index');
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
     * Abrir the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function abrir(Request $request, $id)
    {
        if ($request->ajax()) {
            $precotizacion = PreCotizacion1::findOrFail($id);

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
