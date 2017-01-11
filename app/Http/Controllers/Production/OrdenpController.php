<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, DB, Log, Datatables;

use App\Models\Production\Ordenp, App\Models\Base\Tercero, App\Models\Base\Contacto;

class OrdenpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ordenp::query();
            $query->select('koi_ordenproduccion.id', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), 'orden_numero', 'orden_ano', 'orden_fecha_elaboro', 'orden_fecha_inicio', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_anulada', 'orden_abierta',
                DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END),
                    ' (', orden_referencia ,')'
                    ) AS tercero_nombre"
                )
            );
            $query->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchordenp_ordenp_numero' => $request->has('orden_numero') ? $request->orden_numero : '']);
                session(['searchordenp_tercero' => $request->has('orden_tercero_nit') ? $request->orden_tercero_nit : '']);
                session(['searchordenp_tercero_nombre' => $request->has('orden_tercero_nombre') ? $request->orden_tercero_nombre : '']);
                session(['searchordenp_ordenp_estado' => $request->has('orden_estado') ? $request->orden_estado : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Orden codigo
                    if($request->has('orden_numero')) {
                        $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) LIKE '%{$request->orden_numero}%'");
                    }
                    // Tercero nit
                    if($request->has('orden_tercero_nit')) {
                        $query->where('tercero_nit', $request->orden_tercero_nit);
                    }
                    // Tercero id
                    if($request->has('orden_cliente')) {
                        $query->whereRaw('orden_cliente', $request->orden_cliente);
                    }

                    // Estado
                    if($request->has('orden_estado')) {
                        if($request->orden_estado == 'A') {
                            $query->where('orden_abierta', true);
                        }
                        if($request->orden_estado == 'C') {
                            $query->where('orden_abierta', false);
                        }
                        if($request->orden_estado == 'N') {
                            $query->where('orden_anulada', true);
                        }
                    }
                })
                ->make(true);
        }
        return view('production.ordenes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.ordenes.create');
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

            $orden = new Ordenp;
            if ($orden->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->orden_cliente)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->orden_contacto);
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

                    // Recuperar numero orden
                    $numero = DB::table('koi_ordenproduccion')->where('orden_ano', date('Y'))->max('orden_numero');
                    $numero = !is_integer($numero) ? 1 : ($numero + 1);

                    // Orden de produccion
                    $orden->fill($data);
                    $orden->orden_cliente = $tercero->id;
                    $orden->orden_ano = date('Y');
                    $orden->orden_numero = $numero;
                    $orden->orden_contacto = $contacto->id;
                    $orden->orden_usuario_elaboro = Auth::user()->id;
                    $orden->orden_fecha_elaboro = date('Y-m-d H:m:s');
                    $orden->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $orden->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden->errors]);
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
        $orden = Ordenp::getOrden($id);
        if(!$orden instanceof Ordenp){
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($orden);
        }

        return view('production.ordenes.show', ['orden' => $orden]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orden = Ordenp::getOrden($id);
        if(!$orden instanceof Ordenp) {
            abort(404);
        }

        if($orden->orden_abierta == false || $orden->orden_anulada == true) {
            return redirect()->route('ordenes.show', ['orden' => $orden]);
        }

        return view('production.ordenes.edit', ['orden' => $orden]);
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

            $orden = Ordenp::findOrFail($id);
            if ($orden->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->orden_cliente)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->orden_contacto);
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

                    // Documento
                    $orden->fill($data);
                    $orden->orden_cliente = $tercero->id;
                    $orden->orden_contacto = $contacto->id;
                    $orden->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $orden->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden->errors]);
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
     * Search orden.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->has('ordenp_codigo')) {
            $ordenp = Ordenp::select(
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            )
            ->join('koi_tercero', 'orden_tercero', '=', 'koi_tercero.id')
            ->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->ordenp_codigo}'")->first();
            if($ordenp instanceof Ordenp) {
                return response()->json(['success' => true, 'tercero_nombre' => $ordenp->tercero_nombre]);
            }
        }
        return response()->json(['success' => false]);
    }
}
