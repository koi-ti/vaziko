<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion1, App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Cotizacion5, App\Models\Production\Cotizacion6, App\Models\Production\Productop, App\Models\Production\Productop4, App\Models\Production\Productop5, App\Models\Production\Productop6, App\Models\Production\Areap;
use Auth, DB, Log, Datatables;

class Cotizacion2Controller extends Controller
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
            if($request->has('cotizacion2_cotizacion')) {
                $detalle = Cotizacion2::getCotizaciones2($request->cotizacion2_cotizacion);
            }
            return response()->json($detalle);
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Recuperar cotizacion
        $cotizacion = $request->has('cotizacion') ? Cotizacion1::getCotizacion($request->cotizacion) : null;
        if(!$cotizacion instanceof Cotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = $request->has('productop') ? Productop::getProduct($request->productop) : null;
        if(!$producto instanceof Productop) {
            abort(404);
        }

        if($cotizacion->cotizacion1_abierta == false || $cotizacion->cotizacion1_anulada == true) {
            return redirect()->route('cotizaciones.show', ['cotizacion' => $cotizacion]);
        }

        return view('production.cotizaciones.productos.create', ['cotizacion' => $cotizacion, 'producto' => $producto]);
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
            $cotizacion2 = new Cotizacion2;
            if ($cotizacion2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $producto = Productop::find($request->cotizacion2_productop);
                    if(!$producto instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar cotizacion
                    $cotizacion = Cotizacion1::find($request->cotizacion2_cotizacion);
                    if(!$cotizacion instanceof Cotizacion1) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cotizacion, por favor verifique la información o consulte al administrador.']);
                    }

                    // Cotizacion2
                    $cotizacion2->fill($data);
                    $cotizacion2->fillBoolean($data);
                    $cotizacion2->cotizacion2_productop = $producto->id;
                    $cotizacion2->cotizacion2_cotizacion = $cotizacion->id;
                    $cotizacion2->cotizacion2_cantidad = $request->cotizacion2_cantidad;
                    $cotizacion2->cotizacion2_saldo = $cotizacion2->cotizacion2_cantidad;
                    $cotizacion2->cotizacion2_usuario_elaboro = Auth::user()->id;
                    $cotizacion2->cotizacion2_fecha_elaboro = date('Y-m-d H:m:s');
                    $cotizacion2->save();

                    // Maquinas
                    $maquinas = Cotizacion3::getCotizaciones3($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                    foreach ($maquinas as $maquina)
                    {
                        if($request->has("cotizacion3_maquinap_$maquina->id")) {
                            $cotizacion3 = new Cotizacion3;
                            $cotizacion3->cotizacion3_cotizacion2 = $cotizacion2->id;
                            $cotizacion3->cotizacion3_maquinap = $maquina->id;
                            $cotizacion3->save();
                        }
                    }

                    // Materiales
                    $materiales = Cotizacion4::getCotizaciones4($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                    foreach ($materiales as $material)
                    {
                        if($request->has("cotizacion4_materialp_$material->id")) {
                            $cotizacion4 = new Cotizacion4;
                            $cotizacion4->cotizacion4_cotizacion2 = $cotizacion2->id;
                            $cotizacion4->cotizacion4_materialp = $material->id;
                            $cotizacion4->save();
                        }
                    }

                    // Acabados
                    $acabados = Cotizacion5::getCotizaciones5($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                    foreach ($acabados as $acabado)
                    {
                        if($request->has("cotizacion5_acabadop_$acabado->id")) {
                            $cotizacion5 = new Cotizacion5;
                            $cotizacion5->cotizacion5_cotizacion2 = $cotizacion2->id;
                            $cotizacion5->cotizacion5_acabadop = $acabado->id;
                            $cotizacion5->save();
                        }
                    }

                    // Areap
                    $areasp = isset($data['cotizacion6']) ? $data['cotizacion6'] : null;
                    $sumaareasp = 0;
                    foreach ($areasp as $areap)
                    {
                        $cotizacion6 = new Cotizacion6;
                        $cotizacion6->fill($areap);
                        (!empty($areap['cotizacion6_areap'])) ? $cotizacion6->cotizacion6_areap = $areap['cotizacion6_areap'] : $cotizacion6->cotizacion6_nombre = $areap['cotizacion6_nombre'];
                        $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
                        $sumaareasp += $areap['total'];
                        $cotizacion6->save();
                    }

                    // Calcular valor unitario
                    $totalareasp = $sumaareasp / $request->cotizacion2_cantidad;
                    $transporte = $request->cotizacion2_transporte / $request->cotizacion2_cantidad;
                    $viaticos = $request->cotizacion2_viaticos / $request->cotizacion2_cantidad;
                    $valorunitario = $cotizacion2->cotizacion2_precio_venta + round($transporte) + round($viaticos) + round($totalareasp);

                    // Actualizar cotizacion2
                    $cotizacion2->cotizacion2_total_valor_unitario = $valorunitario;
                    $cotizacion2->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cotizacion2->errors]);
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
        // Recuperar cotizacion2
        $cotizacion2 = Cotizacion2::getCotizacion2($id);
        if(!$cotizacion2 instanceof Cotizacion2) {
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($cotizacion2);
        }

        // Recuperar cotizacion
        $cotizacion = Cotizacion1::getCotizacion($cotizacion2->cotizacion2_cotizacion);
        if(!$cotizacion instanceof Cotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct($cotizacion2->cotizacion2_productop);
        if(!$producto instanceof Productop) {
            abort(404);
        }

        // Validar cotizacion
        if( $cotizacion->cotizacion1_abierta == true && Auth::user()->ability('admin', 'editar', ['module' => 'cotizaciones']) ) {
            return redirect()->route('cotizaciones.productos.edit', ['productos' => $cotizacion2->id]);
        }
        return view('production.cotizaciones.productos.show', ['cotizacion' => $cotizacion, 'producto' => $producto, 'cotizacion2' => $cotizacion2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id3
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Recuperar cotizacion2
        $cotizacion2 = Cotizacion2::findOrFail($id);

        // Recuperar cotizacion
        $cotizacion = Cotizacion1::getCotizacion($cotizacion2->cotizacion2_cotizacion);
        if(!$cotizacion instanceof Cotizacion1) {
            abort(404);
        }

        // Recuperar producto
        $producto = Productop::getProduct($cotizacion2->cotizacion2_productop);
        if(!$producto instanceof Productop) {
            abort(404);
        }

        // Validar cotizacion
        if($cotizacion->cotizacion1_abierta == false) {
            return redirect()->route('cotizaciones.productos.show', ['productos' => $cotizacion2->id]);
        }
        return view('production.cotizaciones.productos.create', ['cotizacion' => $cotizacion, 'producto' => $producto, 'cotizacion2' => $cotizacion2]);
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

            // Recuperar cotizacion2
            $cotizacion2 = Cotizacion2::findOrFail($id);

            // Recuperar cotizacion
            $cotizacion = Cotizacion1::findOrFail($cotizacion2->cotizacion2_cotizacion);
            if($cotizacion->cotizacion1_abierta)
            {
                if ($cotizacion2->isValid($data)) {
                    DB::beginTransaction();
                    try {
                        // Cotizacion2
                        $cotizacion2->fill($data);
                        $cotizacion2->fillBoolean($data);
                        $cotizacion2->cotizacion2_cantidad = $request->cotizacion2_cantidad;
                        $cotizacion2->cotizacion2_saldo = $request->cotizacion2_cantidad;
                        $cotizacion2->save();

                        // Maquinas
                        $maquinas = Cotizacion3::getCotizaciones3($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                        foreach ($maquinas as $maquina)
                        {
                            $cotizacion3 = Cotizacion3::where('cotizacion3_cotizacion2', $cotizacion2->id)->where('cotizacion3_maquinap', $maquina->id)->first();
                            if($request->has("cotizacion3_maquinap_$maquina->id")) {
                                if(!$cotizacion3 instanceof Cotizacion3) {
                                    $cotizacion3 = new Cotizacion3;
                                    $cotizacion3->cotizacion3_cotizacion2 = $cotizacion2->id;
                                    $cotizacion3->cotizacion3_maquinap = $maquina->id;
                                    $cotizacion3->save();
                                }
                            }else{
                                if($cotizacion3 instanceof Cotizacion3) {
                                    $cotizacion3->delete();
                                }
                            }
                        }

                        // Materiales
                        $materiales = Cotizacion4::getCotizaciones4($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                        foreach ($materiales as $material)
                        {
                            $cotizacion4 = Cotizacion4::where('cotizacion4_cotizacion2', $cotizacion2->id)->where('cotizacion4_materialp', $material->id)->first();
                            if($request->has("cotizacion4_materialp_$material->id")) {
                                if(!$cotizacion4 instanceof Cotizacion4) {
                                    $cotizacion4 = new Cotizacion4;
                                    $cotizacion4->cotizacion4_cotizacion2 = $cotizacion2->id;
                                    $cotizacion4->cotizacion4_materialp = $material->id;
                                    $cotizacion4->save();
                                }
                            }else{
                                if($cotizacion4 instanceof Cotizacion4) {
                                    $cotizacion4->delete();
                                }
                            }
                        }

                        // Acabados
                        $acabados = Cotizacion5::getCotizaciones5($cotizacion2->cotizacion2_productop, $cotizacion2->id);
                        foreach ($acabados as $acabado)
                        {
                            $cotizacion5 = Cotizacion5::where('cotizacion5_cotizacion2', $cotizacion2->id)->where('cotizacion5_acabadop', $acabado->id)->first();
                            if($request->has("cotizacion5_acabadop_$acabado->id")) {
                                if(!$cotizacion5 instanceof Cotizacion5) {
                                    $cotizacion5 = new Cotizacion5;
                                    $cotizacion5->cotizacion5_cotizacion2 = $cotizacion2->id;
                                    $cotizacion5->cotizacion5_acabadop = $acabado->id;
                                    $cotizacion5->save();
                                }
                            }else{
                                if($cotizacion5 instanceof Cotizacion5) {
                                    $cotizacion5->delete();
                                }
                            }
                        }

                        // Areas
                        $areasp = isset($data['cotizacion6']) ? $data['cotizacion6'] : null;
                        foreach($areasp as $areap) {
                            if(!empty($areap['cotizacion6_areap'])){
                                $area = Areap::find($areap['cotizacion6_areap']);
                                if(!$area instanceof Areap){
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible actualizar las areas, por favor consulte al administrador.']);
                                }

                                $cotizacion6 = Cotizacion6::where('cotizacion6_cotizacion2', $cotizacion2->id)->where('cotizacion6_areap', $area->id)->first();
                                if(!$cotizacion6 instanceof Cotizacion6) {
                                    $cotizacion6 = new Cotizacion6;
                                    $cotizacion6->fill($areap);
                                    $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
                                    $cotizacion6->cotizacion6_areap = $area->id;
                                    $cotizacion6->save();
                                }
                            }else{
                                $cotizacion6 = Cotizacion6::where('cotizacion6_cotizacion2', $cotizacion2->id)->where('cotizacion6_nombre', $areap['cotizacion6_nombre'])->first();
                                if(!$cotizacion6 instanceof Cotizacion6) {
                                    $cotizacion6 = new Cotizacion6;
                                    $cotizacion6->fill($areap);
                                    $cotizacion6->cotizacion6_nombre = $areap['cotizacion6_nombre'];
                                    $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
                                    $cotizacion6->save();
                                }
                            }
                        }

                        // Recuperar sumatoria areas guardadas
                        $valorareasp = Cotizacion6::select( DB::raw("SUM( ((SUBSTRING_INDEX(cotizacion6_tiempo, ':', -1) / 60 ) + SUBSTRING_INDEX(cotizacion6_tiempo, ':', 1)) * cotizacion6_valor ) as valor_total"))->where('cotizacion6_cotizacion2', $cotizacion2->id)->first();

                        // Calcular valor unitario
                        $totalareasp = $valorareasp->valor_total / $request->cotizacion2_cantidad;
                        $transporte = $request->cotizacion2_transporte / $request->cotizacion2_cantidad;
                        $viaticos = $request->cotizacion2_viaticos / $request->cotizacion2_cantidad;
                        $valorunitario = $request->cotizacion2_precio_venta + round($transporte) + round($viaticos) + round($totalareasp);

                        // Actualizar cotizacion2
                        $cotizacion2->cotizacion2_total_valor_unitario = $valorunitario;
                        $cotizacion2->save();

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'id' => $cotizacion2->id]);
                    }catch(\Exception $e){
                        DB::rollback();
                        Log::error($e->getMessage());
                        return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                    }
                }
                return response()->json(['success' => false, 'errors' => $cotizacion2->errors]);
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
                $cotizacion2 = Cotizacion2::find($id);
                if(!$cotizacion2 instanceof Cotizacion2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar detalle la cotizacion, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Maquinas
                DB::table('koi_cotizacion3')->where('cotizacion3_cotizacion2', $cotizacion2->id)->delete();

                // Materiales
                DB::table('koi_cotizacion4')->where('cotizacion4_cotizacion2', $cotizacion2->id)->delete();

                // Acabados
                DB::table('koi_cotizacion5')->where('cotizacion5_cotizacion2', $cotizacion2->id)->delete();

                // Areasp
                DB::table('koi_cotizacion6')->where('cotizacion6_cotizacion2', $cotizacion2->id)->delete();

                // Eliminar item cotizacion2
                $cotizacion2->delete();

                DB::commit();
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Cotizacion2Controller', 'destroy', $e->getMessage()));
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
            $valor = Cotizacion2::calcString($equation);
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
            $cotizacion2 = Cotizacion2::findOrFail($id);
            DB::beginTransaction();
            try {
                $newcotizacion2 = $cotizacion2->replicate();
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

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $newcotizacion2->id, 'msg' => 'Producto de cotización clonado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
