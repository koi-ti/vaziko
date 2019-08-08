<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Producto, App\Models\Inventory\Traslado2, App\Models\Inventory\ProdbodeRollo, App\Models\Inventory\Prodbode, App\Models\Inventory\Inventario;
use App\Models\Base\Sucursal;
use Log, DB;

class DetalleTrasladoController extends Controller
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
            if ($request->has('traslado')) {
                $query = Traslado2::query();
                $query->select('koi_producto.id', 'traslado2_cantidad', 'traslado2_costo', 'producto_codigo', 'producto_nombre');
                $query->join('koi_producto', 'traslado2_producto', '=', 'koi_producto.id');
                $query->where('traslado2_traslado', $request->traslado);
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
            $traslado2 = new Traslado2;
            if ($traslado2->isValid($data)) {
                try {
                    // Validar sucursal origen
                    $origen = Sucursal::find($request->sucursal);
                    if (!$origen instanceof Sucursal) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar SUCURSAL DE ORIGEN, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar sucursal destino
                    $destino = Sucursal::find($request->destino);
                    if (!$destino instanceof Sucursal) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar SUCURSAL DESTINO, por favor verifique la información o consulte al administrador.']);
                    }

                    // Origen y destion deben ser diferentes
                    if ($origen->id == $destino->id ) {
                        return response()->json(['success' => false, 'errors' => "No es posible realizar TRASLADO de $origen->sucursal_nombre a $destino->sucursal_nombre, por favor verifique la información o consulte al administrador."]);
                    }

                    // Recuperar producto
                    $producto = Producto::where('producto_codigo', $request->producto_codigo)->first();
                    if (!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar maneja unidades
                    if (!$producto->producto_unidades) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar movimientos para productos que no manejan unidades en inventario"]);
                    }

                    // Validar unidades
                    if ($request->get('traslado2_cantidad') <= 0) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar movimientos cantidad no valida, por favor verifique la información ó consulte al administrador"]);
                    }

                    // Validar action
                    $costo = 0;
                    if ($request->action === 'metrado') {
                        $items = ProdbodeRollo::where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $origen->id)->get();

                        $chosen = 0;
                        foreach ($items as $item) {
                            // Validar items ingresados
                            if (array_has($request->items, "itemrollo_metros_{$item->id}") && array_get($request->items, "itemrollo_metros_{$item->id}") > 0 && array_get($request->items, "itemrollo_metros_{$item->id}") != '') {
                                // Validar cantidad
                                if (array_get($request->items, "itemrollo_metros_{$item->id}") > $item->prodboderollo_saldo) {
                                    return response()->json(['success' => false, 'errors' => "Metros debe ser menor o igual a {$item->prodboderollo_saldo}, para el item rollo {$item->prodboderollo_item}."]);
                                }
                                $chosen++;
                            }

                            // Maximo numero items
                            if ($chosen > $request->traslado2_cantidad) {
                                return response()->json(['success' => false, 'errors' => "Por favor ingrese metros unicamente para {$request->traslado2_cantidad} items."]);
                            }

                            $costo += $request->get("itemrollo_metros_{$item->id}") * $item->prodboderollo_costo;
                        }

                        // Minimo numero items
                        if ($chosen < $request->traslado2_cantidad) {
                            return response()->json(['success' => false, 'errors' => "Por favor ingrese metros para {$request->traslado2_cantidad} items."]);
                        }
                    } else {
                        // Cuando es serie
                        if ($request->action === 'series') {
                            if (!$request->has('traslado2_cantidad') || $request->traslado2_cantidad > 1 ||$request->traslado2_cantidad < 1) {
                                return response()->json(['success'=> false, 'errors' => "La cantidad de salida de {$producto->producto_nombre} debe ser de una unidad"]);
                            }
                            if ($producto->id == $producto->producto_referencia) {
                                return response()->json(['success'=> false, 'errors' => "NO se pueden realizar movimientos del producto  {$producto->producto_nombre} debido a que es un producto padre"]);
                            }
                        }
                        // Recuperar prodbode
                        $prodbode = Prodbode::prodbode($producto, $origen->id);
                        if (!$prodbode instanceof Prodbode || $request->traslado2_cantidad > $prodbode->disponibles) {
                            return response()->json(['success' => false, 'errors' => "No existen suficientes unidades para salida, unidades disponibles ".($prodbode instanceof Prodbode ? $prodbode->prodbode_cantidad  : 0).", por favor verifique la información o consulte al administrador."]);
                        }

                        // Costo salida
                        $costo = Inventario::primerasEnSalir($producto, $origen->id, $request->traslado2_cantidad);
                        if (!is_numeric($costo)) {
                            return response()->json(['success' => false, 'errors' => $costo]);
                        }
                    }
                    return response()->json(['success' => true, 'id' => uniqid(), 'traslado2_costo' => $costo ]);
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }

            return response()->json(['success' => false, 'errors' => $traslado2->errors]);
        }
        abort(403);
    }
}
