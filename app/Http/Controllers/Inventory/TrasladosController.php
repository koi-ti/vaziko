<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Auth;

use App\Models\Base\Sucursal, App\Models\Inventory\Traslado1, App\Models\Inventory\Traslado2, App\Models\Inventory\Producto;

class TrasladosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Traslado1::query();
            $query->select('koi_traslado1.id', 'traslado1_numero', 'traslado1_fecha', 'o.sucursal_nombre as sucursa_origen', 'd.sucursal_nombre as sucursa_destino');
            $query->join('koi_sucursal as o', 'traslado1_sucursal', '=', 'o.id');
            $query->join('koi_sucursal as d', 'traslado1_destino', '=', 'd.id');
            return Datatables::of($query->get())->make(true);
        }
        return view('inventory.traslados.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.traslados.create');
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

            $traslado = new Traslado1;
            if ($traslado->isValid($data)) {

                DB::beginTransaction();
                try {
                    // Recuperar origen
                    $origen = Sucursal::find($request->traslado1_sucursal);
                    if(!$origen instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal origen, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar destino
                    $destino = Sucursal::find($request->traslado1_destino);
                    if(!$destino instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal destino, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar consecutivo
                    $consecutivo = $origen->sucursal_traslado + 1;

                    // Traslado1
                    $traslado->fill($data);
                    $traslado->traslado1_numero = $consecutivo;
                    $traslado->traslado1_usuario_elaboro = Auth::user()->id;
                    $traslado->traslado1_fecha_elaboro = date('Y-m-d H:m:s');
                    $traslado->save();

                    // Traslado2
                    $detalle = isset($data['detalle']) ? $data['detalle'] : null;
                    foreach ($detalle as $item)
                    {
                        // Recuperar producto
                        $producto = Producto::where('producto_codigo', $item['producto_codigo'])->first();
                        if(!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                        }

                        $traslado2 = new Traslado2;
                        $traslado2->traslado2_traslado = $traslado->id;
                        $traslado2->traslado2_producto = $producto->id;
                        $traslado2->traslado2_costo = $producto->producto_costo;
                        $traslado2->traslado2_cantidad = $item['traslado2_cantidad'];
                        $traslado2->save();
                    }

                    // Actualizar consecutivo
                    $origen->sucursal_traslado = $consecutivo;
                    $origen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $traslado->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $traslado->errors]);
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
        $traslado = Traslado1::getTraslado($id);
        if(!$traslado instanceof Traslado1){
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($traslado);
        }

        return view('inventory.traslados.show', ['traslado' => $traslado]);
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
    public function destroy($id)
    {
        //
    }
}
