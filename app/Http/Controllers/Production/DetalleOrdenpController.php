<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, DB, Log;

use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Production\Ordenp3, App\Models\Production\Ordenp4, App\Models\Production\Ordenp5, App\Models\Production\Productop, App\Models\Production\Productop4, App\Models\Production\Productop5, App\Models\Production\Productop6, App\Models\Production\Despachop2;

class DetalleOrdenpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $detalle = [];
            if($request->has('orden2_orden')) {
                $detalle = Ordenp2::getOrdenesp2($request->orden2_orden);
            }
            return response()->json($detalle);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Recuperar orden
        $orden = $request->has('ordenp') ? Ordenp::getOrden($request->ordenp) : null;
        if(!$orden instanceof Ordenp) {
            abort(404);
        }

        // Recuperar producto
        $producto = $request->has('productop') ? Productop::getProduct($request->productop) : null;
        if(!$producto instanceof Productop) {
            abort(404);
        }

        if($orden->orden_abierta == false || $orden->orden_anulada == true) {
            return redirect()->route('ordenes.show', ['orden' => $orden]);
        }

        return view('production.ordenes.productos.create', ['orden' => $orden, 'producto' => $producto]);
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

            $orden2 = new Ordenp2;
            if ($orden2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $producto = Productop::find($request->orden2_productop);
                    if(!$producto instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar orden
                    $orden = Ordenp::find($request->orden2_orden);
                    if(!$orden instanceof Ordenp) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden, por favor verifique la información o consulte al administrador.']);
                    }

                    // Orden2
                    $orden2->fill($data);
                    $orden2->fillBoolean($data);
                    $orden2->orden2_productop = $producto->id;
                    $orden2->orden2_orden = $orden->id;
                    $orden2->orden2_cantidad = $request->orden2_cantidad;
                    $orden2->orden2_saldo = $orden2->orden2_cantidad;
                    $orden2->orden2_usuario_elaboro = Auth::user()->id;
                    $orden2->orden2_fecha_elaboro = date('Y-m-d H:m:s');
                    $orden2->save();

                    // Maquinas
                    $maquinas = Ordenp3::getOrdenesp3($orden2->orden2_productop, $orden2->id);
                    foreach ($maquinas as $maquina)
                    {
                        if($request->has("orden3_maquinap_$maquina->id")) {
                            $orden3 = new Ordenp3;
                            $orden3->orden3_orden2 = $orden2->id;
                            $orden3->orden3_maquinap = $maquina->id;
                            $orden3->save();
                        }
                    }

                    // Materiales
                    $materiales = Ordenp4::getOrdenesp4($orden2->orden2_productop, $orden2->id);
                    foreach ($materiales as $material)
                    {
                        if($request->has("orden4_materialp_$material->id")) {
                            $orden4 = new Ordenp4;
                            $orden4->orden4_orden2 = $orden2->id;
                            $orden4->orden4_materialp = $material->id;
                            $orden4->save();
                        }
                    }

                    // Acabados
                    $acabados = Ordenp5::getOrdenesp5($orden2->orden2_productop, $orden2->id);
                    foreach ($acabados as $acabado)
                    {
                        if($request->has("orden5_acabadop_$acabado->id")) {
                            $orden5 = new Ordenp5;
                            $orden5->orden5_orden2 = $orden2->id;
                            $orden5->orden5_acabadop = $acabado->id;
                            $orden5->save();
                        }
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden2->errors]);
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
        // Recuperar orden2
        $ordenp2 = Ordenp2::getOrdenp2($id);
        if(!$ordenp2 instanceof Ordenp2) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($ordenp2);
        }

        // Recuperar orden
        $orden = Ordenp::getOrden($ordenp2->orden2_orden);
        if(!$orden instanceof Ordenp) {
            abort(404);
        }


        // Recuperar producto
        $producto = Productop::getProduct($ordenp2->orden2_productop);
        if(!$producto instanceof Productop) {
            abort(404);
        }

        // Validar orden
        if($orden->orden_abierta == true && Auth::user()->can('editar', 'ordenes')) {
            return redirect()->route('ordenes.productos.edit', ['productos' => $ordenp2->id]);
        }
        return view('production.ordenes.productos.show', ['orden' => $orden, 'producto' => $producto, 'ordenp2' => $ordenp2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Recuperar orden2
        $ordenp2 = Ordenp2::findOrFail($id);

        // Recuperar orden
        $orden = Ordenp::getOrden($ordenp2->orden2_orden);
        if(!$orden instanceof Ordenp) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct($ordenp2->orden2_productop);
        if(!$producto instanceof Productop) {
            abort(404);
        }

        // Validar orden
        if($orden->orden_abierta == false) {
            return redirect()->route('ordenes.productos.show', ['productos' => $ordenp2->id]);
        }
        return view('production.ordenes.productos.edit', ['orden' => $orden, 'producto' => $producto, 'ordenp2' => $ordenp2]);
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

            // Recuperar orden2
            $orden2 = Ordenp2::findOrFail($id);

            // Recuperar orden
            $orden = Ordenp::findOrFail($orden2->orden2_orden);
            if($orden->orden_abierta)
            {
                if ($orden2->isValid($data)) {
                    DB::beginTransaction();
                    try {
                        // Validar despachos
                        $query = Despachop2::query();
                        $query->select(DB::raw('COALESCE(sum(despachop2_cantidad),0) as despachadas'));
                        $query->join('koi_despachop1', 'despachop2_despacho', '=', 'koi_despachop1.id');
                        $query->where('despachop2_orden2', $orden2->id);
                        $query->where('despachop1_anulado', false);
                        $despacho = $query->first();

                        if($request->orden2_cantidad < $despacho->despachadas) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => "No es posible actualizar unidades, cantidad mínima despachos ($despacho->despachadas), por favor verifique la información del asiento o consulte al administrador."]);
                        }

                        // Orden2
                        $orden2->fill($data);
                        $orden2->fillBoolean($data);
                        $orden2->orden2_cantidad = $request->orden2_cantidad;
                        $orden2->orden2_saldo = $orden2->orden2_cantidad - $despacho->despachadas;
                        $orden2->save();

                        // Maquinas
                        $maquinas = Ordenp3::getOrdenesp3($orden2->orden2_productop, $orden2->id);
                        foreach ($maquinas as $maquina)
                        {
                            $orden3 = Ordenp3::where('orden3_orden2', $orden2->id)->where('orden3_maquinap', $maquina->id)->first();
                            if($request->has("orden3_maquinap_$maquina->id")) {
                                if(!$orden3 instanceof Ordenp3) {
                                    $orden3 = new Ordenp3;
                                    $orden3->orden3_orden2 = $orden2->id;
                                    $orden3->orden3_maquinap = $maquina->id;
                                    $orden3->save();
                                }
                            }else{
                                if($orden3 instanceof Ordenp3) {
                                    $orden3->delete();
                                }
                            }
                        }

                        // Materiales
                        $materiales = Ordenp4::getOrdenesp4($orden2->orden2_productop, $orden2->id);
                        foreach ($materiales as $material)
                        {
                            $orden4 = Ordenp4::where('orden4_orden2', $orden2->id)->where('orden4_materialp', $material->id)->first();
                            if($request->has("orden4_materialp_$material->id")) {
                                if(!$orden4 instanceof Ordenp4) {
                                    $orden4 = new Ordenp4;
                                    $orden4->orden4_orden2 = $orden2->id;
                                    $orden4->orden4_materialp = $material->id;
                                    $orden4->save();
                                }
                            }else{
                                if($orden4 instanceof Ordenp4) {
                                    $orden4->delete();
                                }
                            }
                        }

                        // Acabados
                        $acabados = Ordenp5::getOrdenesp5($orden2->orden2_productop, $orden2->id);
                        foreach ($acabados as $acabado)
                        {
                            $orden5 = Ordenp5::where('orden5_orden2', $orden2->id)->where('orden5_acabadop', $acabado->id)->first();
                            if($request->has("orden5_acabadop_$acabado->id")) {
                                if(!$orden5 instanceof Ordenp5) {
                                    $orden5 = new Ordenp5;
                                    $orden5->orden5_orden2 = $orden2->id;
                                    $orden5->orden5_acabadop = $acabado->id;
                                    $orden5->save();
                                }
                            }else{
                                if($orden5 instanceof Ordenp5) {
                                    $orden5->delete();
                                }
                            }
                        }

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => $orden2->id]);
                    }catch(\Exception $e){
                        DB::rollback();
                        Log::error($e->getMessage());
                        return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                    }
                }
                return response()->json(['success' => false, 'errors' => $orden2->errors]);
            }
            abort(403);
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
                $orden2 = Ordenp2::find($id);
                if(!$orden2 instanceof Ordenp2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar detalle orden, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Validar despachos
                $despacho = Despachop2::where('despachop2_orden2', $orden2->id)->first();
                if($despacho instanceof Despachop2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible eliminar producto, contiene despachos asociados, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Maquinas
                DB::table('koi_ordenproduccion3')->where('orden3_orden2', $orden2->id)->delete();

                // Materiales
                DB::table('koi_ordenproduccion4')->where('orden4_orden2', $orden2->id)->delete();

                // Acabados
                DB::table('koi_ordenproduccion5')->where('orden5_orden2', $orden2->id)->delete();

                // Eliminar item orden2
                $orden2->delete();

                DB::commit();
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'DetalleOrdenpController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Eval formula.
     */
    public function formula(Request $request)
    {
        // sanitize input and replace
        $equation = str_replace("t", "+", $request->equation);
        $equation = str_replace("n", "(", $equation);
        $equation = str_replace("m", ")", $equation);
        $equation = preg_replace("/[^0-9+\-.*\/()%]/", '', $equation);

        if( trim($equation) != '' && $request->has('equation') )
        {
            $valor = Ordenp2::calcString($equation);
            if(!is_numeric($valor)){
                return response()->json(['precio_venta' => 0]);
            }
            if($request->has('round') && trim($request->round)!='' && is_numeric($request->round)) {
                $valor = round($valor, $request->round);
            }
            return response()->json(['precio_venta' => $valor]);
        }
        return response()->json(['precio_venta' => 0]);
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
            $orden2 = Ordenp2::findOrFail($id);
            DB::beginTransaction();
            try {
                $neworden2 = $orden2->replicate();
                $neworden2->orden2_saldo = $neworden2->orden2_cantidad;
                $neworden2->orden2_entregado = 0;
                $neworden2->orden2_usuario_elaboro = Auth::user()->id;
                $neworden2->orden2_fecha_elaboro = date('Y-m-d H:m:s');
                $neworden2->save();

                // Maquinas
                $maquinas = Ordenp3::where('orden3_orden2', $orden2->id)->get();
                foreach ($maquinas as $orden3) {
                     $neworden3 = $orden3->replicate();
                     $neworden3->orden3_orden2 = $neworden2->id;
                     $neworden3->save();
                }

                // Materiales
                $materiales = Ordenp4::where('orden4_orden2', $orden2->id)->get();
                foreach ($materiales as $orden4) {
                     $neworden4 = $orden4->replicate();
                     $neworden4->orden4_orden2 = $neworden2->id;
                     $neworden4->save();
                }

                // Acabados
                $acabados = Ordenp5::where('orden5_orden2', $orden2->id)->get();
                foreach ($acabados as $orden5) {
                     $neworden5 = $orden5->replicate();
                     $neworden5->orden5_orden2 = $neworden2->id;
                     $neworden5->save();
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $neworden2->id, 'msg' => 'Producto orden clonado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
