<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Empresa, App\Models\Base\Tercero, App\Models\Base\Contacto, App\Models\Base\Bitacora;
use App\Models\Production\Despachop, App\Models\Production\Despachop2, App\Models\Production\Ordenp, App\Models\Production\Ordenp2;
use DB, Log, App, View;

class DespachopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('despachop1_orden')) {
                $query = Despachop::query();
                $query->select('koi_despachop1.id as id', 'despachop1_fecha', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'despachop1_anulado');
                $query->join('koi_tcontacto', 'despachop1_contacto', '=', 'koi_tcontacto.id');
                $query->where('despachop1_orden', $request->despachop1_orden);
                $query->orderBy('koi_despachop1.id', 'asc');
                $data = $query->get();
            }
            return response()->json($data);
        }
        abort(404);
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
            $despacho = new Despachop;
            if ($despacho->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar orden
                    $orden = Ordenp::find($request->despachop1_orden);
                    if (!$orden instanceof Ordenp) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar tercero
                    $tercero = Tercero::find($orden->orden_cliente);
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar contacto
                    $contacto = Contacto::find($request->despachop1_contacto);
                    if (!$contacto instanceof Contacto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar contacto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar tercero contacto
                    if ($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor seleccione de nuevo el contacto o consulte al administrador.']);
                    }

                    // Contacto
                    $contacto->tcontacto_telefono = $request->despachop1_telefono;
                    $contacto->tcontacto_direccion = $request->despachop1_direccion;
                    $contacto->tcontacto_direccion_nomenclatura = $request->despachop1_direccion_nomenclatura;
                    $contacto->tcontacto_municipio = $request->despachop1_municipio;
                    $contacto->tcontacto_email = $request->despachop1_email;
                    $contacto->save();

                    // Despacho
                    $despacho->fill($data);
                    $despacho->despachop1_fecha = date('Y-m-d');
                    $despacho->despachop1_orden = $orden->id;
                    $despacho->despachop1_contacto = $contacto->id;
                    $despacho->despachop1_usuario_elaboro = auth()->user()->id;
                    $despacho->despachop1_fecha_elaboro = date('Y-m-d H:i:s');
                    $despacho->save();

                    // Recuperar items pendientes
                    $pendientes = $orden->pendintesDespacho();

                    // Validar carrito
                    $items = 0;
                    foreach ($pendientes as $orden2) {
                        if ($request->has("despachop2_cantidad_$orden2->id") && $request->get("despachop2_cantidad_$orden2->id") > 0) {
                            $items++;
                        }
                    }

                    if ($items == 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "Por favor ingrese unidades a despachar."]);
                    }

                    // Items
                    foreach ($pendientes as $orden2) {
                        if ($request->has("despachop2_cantidad_$orden2->id") && $request->get("despachop2_cantidad_$orden2->id") > 0) {
                            // Validar orden2
                            if ($orden2->orden2_saldo == 0) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "No existen unidades disponibles para $orden2->productop_nombre, por favor verifique la información o consulte al administrador."]);
                            }

                            if ($request->get("despachop2_cantidad_$orden2->id") > $orden2->orden2_saldo) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => "No existen suficientes unidades disponibles para $orden2->productop_nombre, por favor verifique la información o consulte al administrador."]);
                            }

                            // Despacho2
                            $despacho2 = new Despachop2;
                            $despacho2->despachop2_despacho = $despacho->id;
                            $despacho2->despachop2_orden2 = $orden2->id;
                            $despacho2->despachop2_cantidad = $request->get("despachop2_cantidad_$orden2->id");
                            $despacho2->save();

                            // Orden2
                            $orden2->orden2_saldo = $orden2->orden2_saldo -  $despacho2->despachop2_cantidad;
                            $orden2->orden2_entregado = $orden2->orden2_entregado + $despacho2->despachop2_cantidad;
                            $orden2->save();
                        }
                    }

                    // Crear bitacora
                    Bitacora::createBitacora($orden, [], "Se creo el despacho {$despacho->id}", 'Distribución por clientes', 'C', $request->ip());

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $despacho->id, 'tcontacto_nombre' => "$contacto->tcontacto_nombres $contacto->tcontacto_apellidos", 'despachop1_fecha' => $despacho->despachop1_fecha]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error(sprintf('%s -> %s: %s', 'DespachopController', 'store', $e->getMessage()));
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $despacho->errors]);
        }
        abort(403);
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
                $despacho = Despachop::find($id);
                if (!$despacho instanceof Despachop) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar despacho, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Recuperar orden
                $orden = Ordenp::find($despacho->despachop1_orden);
                if (!$orden instanceof Ordenp) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la orden de producción.']);
                }

                if ($despacho->despachop1_anulado) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'El despacho que intenta eliminar ya esta anulado.']);
                }

                // Anular despachop1
                $despacho->despachop1_anulado = true;
                $despacho->despachop1_usuario_anulo = auth()->user()->id;
                $despacho->despachop1_fecha_anulo = date('Y-m-d H:i:s');
                $despacho->save();

                // Anular despachop2
                $despachados = Despachop2::where('despachop2_despacho', $despacho->id)->get();
                foreach ($despachados as $despacho2) {
                    // Orden2
                    $orden2 = Ordenp2::find($despacho2->despachop2_orden2);
                    if (!$orden2 instanceof Ordenp2) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar item orden, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    $orden2->orden2_saldo = $orden2->orden2_saldo + $despacho2->despachop2_cantidad;
                    $orden2->orden2_entregado = $orden2->orden2_entregado - $despacho2->despachop2_cantidad;
                    $orden2->save();
                }

                // Crear bitacora
                Bitacora::createBitacora($orden, [], "Se anulo el despacho {$despacho->id}", 'Distribución por clientes', 'D', $request->ip());

                DB::commit();
                return response()->json(['success' => true, 'id' => $despacho->id]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'DespachopController', 'destroy', $e->getMessage()));
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
        if ($request->ajax()) {
            $data = [];
            if ($request->has('orden2_orden')) {
                $orden = Ordenp::findOrFail($request->orden2_orden);
                $data = $orden->pendintesDespacho();
            }
            return response()->json($data);
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
        $despacho = Despachop::getDespacho($id);
        if (!$despacho instanceof Despachop) {
            abort(404);
        }

        $detalle = Despachop2::getDespacho2($despacho->id);
        $title = sprintf('Despacho de mercancía %s-%s', $despacho->id, substr($despacho->despachop1_fecha, -8, 2));

        $empresa = Empresa::getEmpresa();

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('production.despachos.export', compact('title', 'despacho', 'detalle', 'empresa'))->render());
        return $pdf->stream(sprintf('%s_%s.pdf', 'despachop', $despacho->id));
    }
}
