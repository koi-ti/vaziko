<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth, DB, Log, App, View;
use App\Models\Production\DespachoCotizacion, App\Models\Production\DespachoCotizacion2, App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Base\Tercero, App\Models\Base\Contacto;

class DespachoCotizacionController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,consultar');
        $this->middleware('ability:admin,crear', ['only' => ['create', 'store']]);
        $this->middleware('ability:admin,editar', ['only' => ['edit', 'update']]);
        $this->middleware('ability:admin,opcional3', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $despachos = [];
            if($request->has('despachoc1_cotizacion'))
            {
                $query = DespachoCotizacion::query();
                $query->select('koi_despachocotizacion1.id as id', 'despachoc1_fecha', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"));
                $query->join('koi_tcontacto', 'despachoc1_contacto', '=', 'koi_tcontacto.id');
                $query->where('despachoc1_anulado', false);
                $query->where('despachoc1_cotizacion', $request->despachoc1_cotizacion);
                $query->orderBy('koi_despachocotizacion1.id', 'asc');
                $despachos = $query->get();
            }
            return response()->json( $despachos );
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            $despacho = new DespachoCotizacion;
            if ($despacho->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar cotizacion
                    $cotizacion = Cotizacion1::find($request->despachoc1_cotizacion);
                    if(!$cotizacion instanceof Cotizacion1) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cotización, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar tercero
                    $tercero = Tercero::find($cotizacion->cotizacion1_cliente);
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->despachoc1_contacto);
                    if(!$contacto instanceof Contacto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar contacto, por favor verifique la información o consulte al administrador.']);
                    }
                    // Validar tercero contacto
                    if($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor seleccione de nuevo el contacto o consulte al administrador.']);
                    }

                    // Contacto
                    $contacto->tcontacto_telefono = $request->despachoc1_telefono;
                    $contacto->tcontacto_direccion = $request->despachoc1_direccion;
                    $contacto->tcontacto_direccion_nomenclatura = $request->despachoc1_direccion_nomenclatura;
                    $contacto->tcontacto_municipio = $request->despachoc1_municipio;
                    $contacto->tcontacto_email = $request->despachoc1_email;
                    $contacto->save();

                    // Despacho
                    $despacho->fill($data);
                    $despacho->despachoc1_fecha = date('Y-m-d');
                    $despacho->despachoc1_cotizacion = $cotizacion->id;
                    $despacho->despachoc1_contacto = $contacto->id;
                    $despacho->despachoc1_usuario_elaboro = Auth::user()->id;
                    $despacho->despachoc1_fecha_elaboro = date('Y-m-d H:m:s');
                    $despacho->save();

                    // Recuperar items pendientes
                    $pendientes = $cotizacion->pendintesDespacho();
                    // Validar carrito
                    $items = 0;
                    foreach ($pendientes as $cotizacion2) {
                        if($request->has("despachoc2_cantidad_$cotizacion2->id") && $request->get("despachoc2_cantidad_$cotizacion2->id") > 0) {
                            $items ++;
                        }
                    }
                    if($items == 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "Por favor ingrese unidades a despachar."]);
                    }

                    // Items
                    foreach ($pendientes as $cotizacion2)
                    {
                        if($request->has("despachoc2_cantidad_$cotizacion2->id") && $request->get("despachoc2_cantidad_$cotizacion2->id") > 0) {
                            // Validar cotizacion2
                            if($cotizacion2->cotizacion2_saldo == 0) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "No existen unidades disponibles para $cotizacion2->productop_nombre, por favor verifique la información o consulte al administrador."]);
                            }
                            if($request->get("despachoc2_cantidad_$cotizacion2->id") > $cotizacion2->cotizacion2_saldo) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "No existen suficientes unidades disponibles para $cotizacion2->productop_nombre, por favor verifique la información o consulte al administrador."]);
                            }

                            // Despacho2
                            $despacho2 = new DespachoCotizacion2;
                            $despacho2->despachoc2_despacho = $despacho->id;
                            $despacho2->despachoc2_cotizacion2 = $cotizacion2->id;
                            $despacho2->despachoc2_cantidad = $request->get("despachoc2_cantidad_$cotizacion2->id");
                            $despacho2->save();

                            // Cotizacion2
                            $cotizacion2->cotizacion2_saldo = $cotizacion2->cotizacion2_saldo - $despacho2->despachoc2_cantidad;
                            $cotizacion2->cotizacion2_entregado = $cotizacion2->cotizacion2_entregado + $despacho2->despachoc2_cantidad;
                            $cotizacion2->save();
                        }
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $despacho->id, 'tcontacto_nombre' => "$contacto->tcontacto_nombres $contacto->tcontacto_apellidos", 'despachoc1_fecha' => $despacho->despachoc1_fecha]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error(sprintf('%s -> %s: %s', 'DespachoCotizacionController', 'store', $e->getMessage()));
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $despacho->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $despacho = DespachoCotizacion::find($id);
                if(!$despacho instanceof DespachoCotizacion){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar despacho, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Anular despachoc1
                $despacho->despachoc1_anulado = true;
                $despacho->despachoc1_usuario_anulo = Auth::user()->id;
                $despacho->despachoc1_fecha_anulo = date('Y-m-d H:m:s');
                $despacho->save();

                // Anular despachoc2
                $despachados = DespachoCotizacion2::where('despachoc2_despacho', $despacho->id)->get();
                foreach ($despachados as $despacho2) {
                    // Cotizacion2
                    $cotizacion2 = Cotizacion2::find($despacho2->despachoc2_cotizacion2);
                    if(!$cotizacion2 instanceof Cotizacion2){
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar item cotizacion, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    $cotizacion2->cotizacion2_saldo = $cotizacion2->cotizacion2_saldo + $despacho2->despachoc2_cantidad;
                    $cotizacion2->cotizacion2_entregado = $cotizacion2->cotizacion2_entregado - $despacho2->despachoc2_cantidad;
                    $cotizacion2->save();
                }

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'DespachoCotizacionController', 'destroy', $e->getMessage()));
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
    public function pendientes(Request $request)
    {
        if ($request->ajax())
        {
            $pendientes = [];
            if($request->has('cotizacion2_cotizacion')) {
                $cotizacion = Cotizacion1::findOrFail($request->cotizacion2_cotizacion);
                $pendientes = $cotizacion->pendintesDespacho();
            }
            return response()->json( $pendientes );
        }
        abort(404);
    }

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($id)
    {
        $despacho = DespachoCotizacion::getDespacho($id);
        if(!$despacho instanceof DespachoCotizacion){
            abort(404);
        }
        $detalle = DespachoCotizacion2::getDespacho2($despacho->id);
        $title = sprintf('Despacho de mercancía %s-%s', $despacho->id, substr($despacho->despachoc1_fecha, -8, 2));

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('production.cotizaciones.despachos.export', compact('title', 'despacho', 'detalle'))->render());
        return $pdf->stream(sprintf('%s_%s.pdf', 'despachoc', $despacho->id));
    }
}
