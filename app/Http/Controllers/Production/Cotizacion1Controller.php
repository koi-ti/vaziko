<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Production\Cotizacion1, App\Models\Base\Tercero, App\Models\Base\Contacto, App\Models\Base\Empresa;
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
        if($request->ajax()){
            $query = Cotizacion1::query();
            $query->select('koi_cotizacion1.*', 'tercero_nit', DB::raw("CONCAT(cotizacion1_numero,' - ',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo") ,DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('koi_tercero', 'cotizacion1_cliente', '=','koi_tercero.id');

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchcotizacion_numero' => $request->has('cotizacion_numero') ? $request->cotizacion_numero : '']);
                session(['searchcotizacion_estado' => $request->has('estado') ? $request->estado : '']);
                session(['searchcotizacion_tercero' => $request->has('tercero_nit') ? $request->tercero_nit : '']);
                session(['searchcotizacion_tercero_nombre' => $request->has('tercero_nombre') ? $request->tercero_nombre : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Cotizacion id
                    if($request->has('cotizacion_numero')) {
                        $query->whereRaw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) LIKE '%{$request->cotizacion_numero}%'");
                    }

                    // Tercero nit
                    if($request->has('tercero_nit')) {
                        $query->where('tercero_nit', $request->tercero_nit);
                    }

                    // Estado
                    if($request->has('estado')) {
                        if($request->estado == 'A') {
                            $query->where('cotizacion1_aprobada', true);
                        }
                        if($request->estado == 'N') {
                            $query->where('cotizacion1_anulada', true);
                        }
                    }

            })->make(true);
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
                    // Recuperar Tercero
                    $tercero = Tercero::where('tercero_nit', $request->cotizacion1_cliente)->first();
                    if(!$tercero instanceof Tercero){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el cliente, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Recuperar Contacto
                    $contacto = Contacto::find($request->cotizacion1_contacto);
                    if(!$contacto instanceof Contacto){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el contacto, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Validar tercero contacto
                    if($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Recuperar numero cotizacion
                    $numero = DB::table('koi_cotizacion1')->where('cotizacion1_ano', $request->cotizacion1_ano)->max('cotizacion1_numero');
                    $numero = !is_integer($numero) ? 1 : ($numero + 1);

                    // Cotizacion
                    $cotizacion->fill($data);
                    $cotizacion->cotizacion1_numero = $numero;
                    $cotizacion->cotizacion1_cliente = $tercero->id;
                    $cotizacion->cotizacion1_contacto = $contacto->id;
                    $cotizacion->cotizacion1_usuario_elaboro = Auth::user()->id;
                    $cotizacion->cotizacion1_fh_elaboro = date('Y-m-d H:m:s');
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
        if ($request->ajax()) {
            return response()->json($cotizacion);
        }

        // Permisions
        if( !Auth::user()->ability('admin', ['module' => 'cotizaciones']) && $cotizacion->cotizacion1_aprobada == false) {
            abort(403);
        }

        if($cotizacion->cotizacion1_aprobada == false && $cotizacion->cotizacion1_anulada == false) {
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
        $cotizacion = Cotizacion1::findOrFail($id);

        // Permisions
        if( !Auth::user()->ability('admin', ['module' => 'cotizaciones']) && $cotizacion->cotizacion1_aprobada == false) {
            abort(403);
        }

        if( $cotizacion->cotizacion1_aprobada == true || $cotizacion->cotizacion1_anulada == true ) {
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
                    // Recuperar Tercero
                    $tercero = Tercero::where('tercero_nit', $request->cotizacion1_cliente)->first();
                    if(!$tercero instanceof Tercero){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el cliente, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Recuperar Contacto
                    $contacto = Contacto::find($request->cotizacion1_contacto);
                    if(!$contacto instanceof Contacto){
                        DB::rollback();
                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el contacto, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Validar tercero contacto
                    if($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Actualizar telefono del contacto
                    if($contacto->tcontacto_telefono != $request->tcontacto_telefono) {
                        $contacto->tcontacto_telefono = $request->tcontacto_telefono;
                        $contacto->save();
                    }

                    // Validar numero
                    if( $cotizacion->cotizacion1_ano != $request->cotizacion1_ano ){
                        // Recuperar numero cotizacion
                        $numero = DB::table('koi_cotizacion1')->where('cotizacion1_ano', $request->cotizacion1_ano)->max('cotizacion1_numero');
                        $numero = !is_integer($numero) ? 1 : ($numero + 1);
                        $cotizacion->cotizacion1_numero = $numero;
                    }

                    // Cotizacion
                    $cotizacion->fill($data);
                    $cotizacion->cotizacion1_cliente = $tercero->id;
                    $cotizacion->cotizacion1_contacto = $contacto->id;
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
     * Anular the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, $id)
    {
        // Permisions
        if( !Auth::user()->ability('admin', ['module' => 'cotizaciones'])) {
            abort(403);
        }

        if ($request->ajax()) {
            $cotizacion = Cotizacion1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Cotizacion
                $cotizacion->cotizacion1_anulada = true;
                $cotizacion->cotizacion1_aprobada = false;
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'La cotizacion se anulo con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Approve the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        // Permisions
        if( !Auth::user()->ability('admin', ['module' => 'cotizaciones'])) {
            abort(403);
        }

        if ($request->ajax()) {
            $cotizacion = Cotizacion1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Cotizacion
                $cotizacion->cotizacion1_anulada = false;
                $cotizacion->cotizacion1_aprobada = true;
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'La cotizacion se aprobo con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Open the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function open(Request $request, $id)
    {
        // Permisions
        if( !Auth::user()->ability('admin', ['module' => 'cotizaciones'])) {
            abort(403);
        }
        
        if ($request->ajax()) {
            $cotizacion = Cotizacion1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Cotizacion
                $cotizacion->cotizacion1_anulada = false;
                $cotizacion->cotizacion1_aprobada = false;
                $cotizacion->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'La cotizacion se reabrio con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
