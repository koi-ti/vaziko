<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, DB, Log;

use App\Models\Production\Ordenp, App\Models\Production\Ordenp2, App\Models\Production\Productop;

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
                    $orden2->orden2_saldo = $orden2->orden2_cantidad;
                    $orden2->orden2_usuario_elaboro = Auth::user()->id;
                    $orden2->orden2_fecha_elaboro = date('Y-m-d H:m:s');
                    $orden2->save();

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
        if($orden->orden_abierta == true) {
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
                        // Orden2
                        $orden2->fill($data);
                        $orden2->fillBoolean($data);
                        $orden2->save();

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
                if(!$orden2 instanceof Ordenp2){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar detalle orden, por favor verifique la información del asiento o consulte al administrador.']);
                }

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
}
