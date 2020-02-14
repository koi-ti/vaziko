<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounting\PlanCuenta, App\Models\Accounting\PlanCuentaNif;
use App\Models\Base\Tercero, App\Models\Base\Contacto;
use App\Models\Receivable\Factura1;
use App\Models\Inventory\Producto;
use App\Models\Production\Cotizacion1, App\Models\Production\Ordenp, App\Models\Production\Cotizacion2, App\Models\Production\Ordenp2, App\Models\Production\Productop, App\Models\Production\SubActividadp, App\Models\Production\SubtipoProductop;
use Datatables, DB;

class BuscadorController extends Controller
{
    /**
     * Instantiate a new instance.
     */
    public function __construct() {}

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function terceros(Request $request)
    {
        if ($request->ajax()) {
            $query = Tercero::query();
            $query->buscador();

            if ($request->has('search_vendedor') && $request->search_vendedor) {
                $query->with(['vendedor' => function ($q) {
                    $q->select('id', 'tercero_nit')->nombre();
                }]);
            }

            if ($request->has('search')) {
                return Datatables::of($query)
                    ->filter(function ($query) use ($request) {
                        // Documento
                        if ($request->has('tercero_nit')) {
                            $query->whereRaw("tercero_nit LIKE '%{$request->tercero_nit}%'");
                        }

                        // Nombre
                        if ($request->has('tercero_nombre')) {
                            $query->where(function ($query) use ($request) {
                                $query->whereRaw("tercero_nombre1 LIKE '%{$request->tercero_nombre}%'");
                                $query->orWhereRaw("tercero_nombre2 LIKE '%{$request->tercero_nombre}%'");
                                $query->orWhereRaw("tercero_apellido1 LIKE '%{$request->tercero_nombre}%'");
                                $query->orWhereRaw("tercero_apellido2 LIKE '%{$request->tercero_nombre}%'");
                                $query->orWhereRaw("tercero_razonsocial LIKE '%{$request->tercero_nombre}%'");
                                $query->orWhereRaw("tercero_sigla LIKE '%{$request->tercero_nombre}%'");
                                $query->orWhereRaw("CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) LIKE '%{$request->tercero_nombre}%'");
                            });
                        }

                        // funcionario = tiemposp
                        if ($request->has('tercero_tiempop')) {
                            $query->where('tercero_activo', true);
                            $query->whereIn('koi_tercero.id', DB::table('koi_tiempop')->select('tiempop_tercero'));
                        }

                        if ($request->has('tercero_proveedor')) {
                            $query->where('tercero_activo', true);
                            $query->where('tercero_proveedor', true);
                        }

                        if ($request->has('tercero_vendedor_estado')) {
                            $query->where('tercero_vendedor_estado', true);
                            $query->where('tercero_activo', true);
                        }
                    })
                    ->make(true);
            } else {
                // Search
                $query->where('tercero_nit', $request->tercero_nit);
                $tercero = $query->first();

                if ($tercero instanceof Tercero) {
                    $tercero->success = true;
                    return response()->json($tercero);
                }
                return response()->json(['success' => false]);
            }

        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function contactos(Request $request)
    {
        if ($request->ajax()) {
            $query = Contacto::query();
            $query->select('koi_tcontacto.id', 'tcontacto_nombres', 'tcontacto_apellidos', 'tcontacto_telefono', DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as municipio_nombre"), 'tcontacto_direccion', 'tcontacto_direccion_nomenclatura', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_municipio', 'tcontacto_email');
            $query->leftJoin('koi_municipio', 'tcontacto_municipio', '=', 'koi_municipio.id');
            $query->leftJoin('koi_departamento', 'koi_municipio.departamento_codigo', '=', 'koi_departamento.departamento_codigo');

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Tercero
                    if ($request->has('tcontacto_tercero')) {
                        $query->where('tcontacto_tercero', $request->tcontacto_tercero);
                    }

                    // Nombres
                    if ($request->has('tcontacto_nombres')) {
                        $query->whereRaw("tcontacto_nombres LIKE '%{$request->tcontacto_nombres}%'");
                    }

                    // Apellidos
                    if ($request->has('tcontacto_apellidos')) {
                        $query->whereRaw("tcontacto_apellidos LIKE '%{$request->tcontacto_apellidos}%'");
                    }
                })
                ->make(true);
        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function cuentas(Request $request)
    {
        if ($request->ajax()) {
            $query = PlanCuenta::query();
            $query->select('koi_plancuentas.id as id', 'plancuentas_cuenta', 'plancuentas_nivel', 'plancuentas_nombre', 'plancuentas_naturaleza', 'plancuentas_tercero', 'plancuentas_tasa', 'plancuentas_centro', 'plancuentas_tipo', 'plancuentas_equivalente', 'plancuentasn_cuenta');
            $query->leftJoin('koi_plancuentasn', 'plancuentas_equivalente', '=', 'koi_plancuentasn.id');

            if ($request->has('search')) {
                return Datatables::of($query)
                    ->filter(function($query) use($request) {
                        // Cuenta
                        if($request->has('plancuentas_cuenta')) {
                            $query->whereRaw("plancuentas_cuenta LIKE '%{$request->plancuentas_cuenta}%'");
                        }
                        // Nombre
                        if($request->has('plancuentas_nombre')) {
                            $query->whereRaw("plancuentas_nombre LIKE '%{$request->plancuentas_nombre}%'");
                        }
                    })
                    ->make(true);
            } else {
                if ($request->has('plancuentas_cuenta')) {
                    $query->where('plancuentas_cuenta', $request->plancuentas_cuenta);
                    $plancuenta = $query->first();

                    if ($plancuenta instanceof PlanCuenta) {
                        $ica = ($plancuenta->plancuentas_nivel == 4 && strstr($plancuenta->plancuentas_cuenta, '2368') && $plancuenta->plancuentas_tasa != 0) ? true : false;
                        return response()->json(['success' => true, 'plancuentas_nombre' => $plancuenta->plancuentas_nombre, 'plancuentas_tasa' => $plancuenta->plancuentas_tasa, 'plancuentas_centro' => $plancuenta->plancuentas_centro, 'plancuentas_naturaleza' => $plancuenta->plancuentas_naturaleza, 'plancuentas_tipo' => $plancuenta->plancuentas_tipo, 'ica' => $ica]);
                    }
                }
                return response()->json(['success' => false]);
            }
        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function cuentasnif(Request $request)
    {
        if ($request->ajax()) {
            $query = PlanCuentaNif::query();
            $query->select('id', 'plancuentasn_cuenta', 'plancuentasn_nivel', 'plancuentasn_nombre', 'plancuentasn_naturaleza', 'plancuentasn_tercero', 'plancuentasn_tasa', 'plancuentasn_centro', 'plancuentasn_tipo');

            if ($request->has('search')) {
                return Datatables::of($query)
                    ->filter(function($query) use($request) {
                        // Cuenta
                        if($request->has('plancuentasn_cuenta')) {
                            $query->whereRaw("plancuentasn_cuenta LIKE '%{$request->plancuentasn_cuenta}%'");
                        }
                        // Nombre
                        if($request->has('plancuentasn_nombre')) {
                            $query->whereRaw("plancuentasn_nombre LIKE '%{$request->plancuentasn_nombre}%'");
                        }
                    })
                    ->make(true);
            } else {
                if ($request->has('plancuentas_cuenta')) {
                    $query->where('plancuentasn_cuenta', $request->plancuentasn_cuenta);
                    $plancuentanif = $query->first();

                    if ($plancuentanif instanceof PlanCuenta) {
                        return response()->json(['success' => true, 'plancuentasn_nombre' => $plancuentanif->plancuentasn_nombre, 'plancuentasn_tasa' => $plancuentanif->plancuentasn_tasa, 'plancuentasn_centro' => $plancuentanif->plancuentasn_centro, 'plancuentasn_naturaleza' => $plancuentanif->plancuentasn_naturaleza, 'plancuentasn_tipo' => $plancuentanif->plancuentasn_tipo]);
                    }
                }
                return response()->json(['success' => false]);
            }
        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function facturas(Request $request)
    {
        if ($request->ajax()) {
            $query = Factura1::query();
            $query->select('koi_factura1.*', 'tercero_nit', 'puntoventa_prefijo', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id');
            $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Estado
                    if ($request->has('factura1_estado')) {
                        $query->where('factura1_anulado', false);
                    }

                    // Numero
                    if ($request->has('factura1_numero')) {
                        $query->whereRaw("factura1_numero LIKE '%{$request->factura1_numero}%'");
                    }

                    // Documento
                    if ($request->has('tercero_nit')) {
                        $query->whereRaw("tercero_nit LIKE '%{$request->tercero_nit}%'");
                    }

                    // If sum saldo
                    if ($request->has('activo') && $request->activo == 'saldo') {
                        $query->whereHas('cuotas', function ($query) {
                            $query->where('factura4_saldo', '<>', 0);
                        });
                    }
                })
                ->make(true);
        }
        abort(404);
    }

    /**
    *
    * @param  \Illuminate\Http\Request  $request
    */
    public function cotizaciones(Request $request)
    {
        if ($request->ajax()) {
            $query = Cotizacion1::query();
            $query->select('koi_cotizacion1.id', 'cotizacion1_precotizacion', 'cotizacion1_estados', DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo, CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"), 'cotizacion1_numero', 'cotizacion1_ano', 'cotizacion1_fecha_elaboro as cotizacion1_fecha', 'cotizacion1_fecha_inicio', 'cotizacion1_anulada', 'cotizacion1_abierta', 'cotizacion1_iva',
                DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END),
                    ' (', cotizacion1_referencia ,')'
                    ) AS tercero_nombre"
                )
            );
            $query->join('koi_tercero', 'cotizacion1_cliente', '=', 'koi_tercero.id');
            $query->leftjoin('koi_precotizacion1', 'cotizacion1_precotizacion', '=', 'koi_precotizacion1.id');
            // $query->with(['productos' => function ($producto) {
            //     $producto->select('cotizacion2_cotizacion', DB::raw('SUM(cotizacion2_total_valor_unitario*cotizacion2_cantidad) as total'))
            //                     ->groupBy('cotizacion2_cotizacion');
            // }]);

            return Datatables::of($query)
                ->filter(function ($query) use ($request) {

                    // Cotizacion codigo
                    if ($request->has('cotizacion_numero')) {
                        $query->whereRaw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) LIKE '%{$request->cotizacion_numero}%'");
                    }

                    // Tercero nit
                    if ($request->has('cotizacion_tercero_nit')) {
                        $query->where('tercero_nit', $request->cotizacion_tercero_nit);
                    }

                    // Tercero id
                    if ($request->has('cotizacion_cliente')) {
                        $query->where('cotizacion1_cliente', $request->cotizacion_cliente);
                    }

                    // Referencia
                    if ($request->has('cotizacion_referencia')) {
                        $query->whereRaw("cotizacion1_referencia LIKE '%{$request->cotizacion_referencia}%'");
                    }

                    // Producto
                    if ($request->has('cotizacion_productop')) {
                        $query->whereRaw("$request->cotizacion_productop IN ( SELECT cotizacion2_productop FROM koi_cotizacion2 WHERE cotizacion2_cotizacion = koi_cotizacion1.id) ");
                    }

                    // Estados
                    if ($request->has('cotizacion_estado')) {
                        if ($request->cotizacion_estado == 'P') {
                            $query->whereIn('cotizacion1_estados', ['PC', 'PF']);
                        }
                    }
                })
                ->make(true);
        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function ordenes(Request $request)
    {
        if ($request->ajax()) {
            $query = Ordenp::query();
            $query->select('koi_ordenproduccion.id', 'orden_cotizacion', 'cotizacion1_precotizacion', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo, CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo, CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"), 'orden_numero', 'orden_ano', 'orden_fecha_elaboro as orden_fecha', 'orden_fecha_inicio', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_anulada', 'orden_abierta', 'orden_culminada',
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
            $query->leftjoin('koi_cotizacion1', 'orden_cotizacion', '=', 'koi_cotizacion1.id');
            $query->leftjoin('koi_precotizacion1', 'cotizacion1_precotizacion', '=', 'koi_precotizacion1.id');

            $query->with(['detalle' => function ($producto) {
                $producto->select('orden2_orden', DB::raw('SUM(orden2_total_valor_unitario * orden2_cantidad) as total'))
                                ->groupBy('orden2_orden');
            }]);

            if ($request->has('search')) {
                return Datatables::of($query)
                    ->filter(function($query) use($request) {
                        // Orden codigo
                        if ($request->has('orden_numero')) {
                            $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) LIKE '%{$request->orden_numero}%'");
                        }

                        // Ordenes a facturar
                        if ($request->has('factura') && $request->factura == 'true') {
                            $query->whereIn('koi_ordenproduccion.id', DB::table('koi_ordenproduccion2')->select('orden2_orden')->whereRaw('(orden2_cantidad - orden2_facturado) > 0'));
                        }

                        // Tercero nit
                        if ($request->has('orden_tercero_nit')) {
                            $query->where('tercero_nit', $request->orden_tercero_nit);
                        }

                        // Tercero id
                        if ($request->has('orden_cliente')) {
                            $query->where('orden_cliente', $request->orden_cliente);
                        }

                        // Estado
                        if ($request->has('orden_estado')) {
                            if ($request->orden_estado == 'A') {
                                $query->where('orden_abierta', true);
                            }

                            if ($request->orden_estado == 'C') {
                                $query->where('orden_abierta', false);
                                $query->where('orden_culminada', false);
                            }

                            if ($request->orden_estado == 'N') {
                                $query->where('orden_anulada', true);
                            }

                            if ($request->orden_estado == 'T') {
                                $query->where('orden_culminada', true);
                            }

                            if ($request->orden_estado == 'AT') {
                                $query->where('orden_abierta', true);
                                $query->orWhere('orden_culminada', true);
                                $query->where('orden_anulada', false);
                            }
                        }

                        // Referencia
                        if ($request->has('orden_referencia')) {
                            $query->whereRaw("orden_referencia LIKE '%{$request->orden_referencia}%'");
                        }

                        // Producto
                        if ($request->has('orden_productop')) {
                            $query->whereRaw("$request->orden_productop IN ( SELECT orden2_productop
                                FROM koi_ordenproduccion2 WHERE orden2_orden = koi_ordenproduccion.id) ");
                        }
                    })
                    ->make(true);
            } else {
                // If exists codigo
                if ($request->has('orden_codigo')) {
                    $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '$request->orden_codigo'");
                }

                // If exists estados
                if ($request->has('orden_estado')) {
                    if ($request->orden_estado == 'A') {
                        $query->where('orden_abierta', true);
                    }

                    if ($request->orden_estado == 'C') {
                        $query->where('orden_abierta', false);
                        $query->where('orden_culminada', false);
                    }

                    if ($request->orden_estado == 'N') {
                        $query->where('orden_anulada', true);
                    }

                    if ($request->orden_estado == 'T') {
                        $query->where('orden_culminada', true);
                    }

                    if ($request->orden_estado == 'AT') {
                        $query->where('orden_abierta', true);
                        $query->where('orden_anulada', false);
                    }
                }
                $ordenp = $query->first();
                if ($ordenp instanceof Ordenp) {
                    return response()->json(['success' => true, 'tercero_nombre' => $ordenp->tercero_nombre, 'id' => $ordenp->id]);
                }
                return response()->json(['success' => false]);
            }
        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function productos(Request $request)
    {
        if ($request->ajax()) {
            $query = Producto::query();
            $query->select('koi_producto.id as id', 'producto_codigo', 'producto_nombre', 'producto_unidades', 'producto_serie', 'producto_metrado');
            $query->leftJoin('koi_materialp', 'producto_materialp', '=', 'koi_materialp.id');
            $query->addSelect('materialp_nombre');

            if ($request->has('search')) {
                return Datatables::of($query)
                    ->filter(function ($query) use ($request) {
                        // Codigo
                        if ($request->has('producto_codigo')) {
                            $query->whereRaw("producto_codigo LIKE '%{$request->producto_codigo}%'");
                        }

                        // Nombre
                        if ($request->has('producto_nombre')) {
                            $query->whereRaw("producto_nombre LIKE '%{$request->producto_nombre}%'");
                        }

                        // Nombre
                        if ($request->has('asiento') && $request->asiento) {
                            if ($request->has('naturaleza')) {
                                if ($request->naturaleza == 'D') {
                                    $query->where(function ($query) {
                                        $query->whereRaw("IF(producto_unidades = true, IF(producto_serie = true,(producto_codigo = producto_referencia), producto_metrado = true) OR (producto_metrado = false AND producto_serie = false), 0)");
                                    });
                                } else {
                                    $query->where(function ($query) {
                                        $query->whereRaw("IF(producto_unidades = true, IF(producto_serie = true,(producto_codigo <> producto_referencia), producto_metrado = true) OR (producto_metrado = false AND producto_serie = false), 0)");
                                    });
                                }
                            }
                        }
                    })->make(true);
            } else if ($request->has('materialp') && $request->has('reference')) {
                $query->where('producto_materialp', $request->materialp);

                if ($request->reference == 'empaque') {
                    $query->where('producto_empaque', true);
                }

                if ($request->reference == 'transporte') {
                    $query->where('producto_transporte', true);
                }
                return response()->json($query->get());
            } else {
                if ($request->has('producto_codigo')) {
                    $query = Producto::query();
                    $query->select('id', 'producto_nombre', 'producto_metrado', 'producto_serie', 'producto_unidades');
                    $query->where('producto_codigo', $request->producto_codigo);
                    if ($request->has('asiento') && $request->asiento) {
                        if ($request->has('naturaleza')) {
                            if ($request->naturaleza == 'D') {
                                $query->where(function ($query) {
                                    $query->whereRaw("IF(producto_unidades = true, IF(producto_serie = true,(producto_codigo = producto_referencia), producto_metrado = true) OR (producto_metrado = false AND producto_serie = false), 0)");
                                });
                            } else {
                                $query->where(function ($query) {
                                    $query->whereRaw("IF(producto_unidades = true, IF(producto_serie = true,(producto_codigo <> producto_referencia), producto_metrado = true) OR (producto_metrado = false AND producto_serie = false), 0)");
                                });
                            }
                        }
                    }
                    $producto = $query->first();
                    if ($producto instanceof Producto) {
                        return response()->json(['success' => true, 'id' => $producto->id, 'producto_nombre' => $producto->producto_nombre, 'producto_metrado' => $producto->producto_metrado, 'producto_serie' => $producto->producto_serie, 'producto_unidades' => $producto->producto_unidades]);
                    }
                }
                return response()->json(['success' => false]);
            }
        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function productosp(Request $request)
    {
        if ($request->ajax()) {
            $query = Productop::query();
            $query->select('koi_productop.id as id', 'koi_productop.id as productop_codigo', 'productop_nombre');

            if ($request->has('search')) {
                return Datatables::of($query)
                    ->filter(function ($query) use ($request) {
                        // Codigo
                        if ($request->has('id')) {
                            $query->where('koi_productop.id', $request->id);
                        }

                        // Nombre
                        if ($request->has('productop_nombre')) {
                            $query->whereRaw("productop_nombre LIKE '%{$request->productop_nombre}%'");
                        }
                    })
                    ->make(true);
            } else {
                if ($request->has('typeproduct') && $request->has('subtypeproduct'))  {
                    $query->where('productop_subtipoproductop', $request->subtypeproduct);
                    $query->where('productop_tipoproductop', $request->typeproduct);
                }
                return response()->json($query->get());
            }
        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function productosCotizacion(Request $request)
    {
        if ($request->ajax()) {
            $query = Cotizacion2::getCotizaciones2();

            return Datatables::of($query)
                ->filter(function ($query) use ($request) {
                    // Cotizacion
                    if ($request->has('search_cotizacion')) {
                        $query->whereRaw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) LIKE '%{$request->search_cotizacion}%'");
                    }

                    if ($request->has('search_cotizacion_estado')) {
                        if ($request->search_cotizacion_estado == 'P') {
                            $query->whereIn('cotizacion1_estados', ['PC', 'PF']);
                        }
                    }
                })
                ->make(true);
        }
        abort(404);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function productosOrden(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('search')) {
                $query = Ordenp2::getDetails();
                return Datatables::of($query)
                    ->filter(function($query) use($request) {
                        // Orden
                        if ($request->has('search_ordenp')) {
                            $query->whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) LIKE '%{$request->search_ordenp}%'");
                        }

                        if ($request->has('search_ordenp_estado')) {
                            if ($request->search_ordenp_estado == 'A') {
                                $query->where('orden_abierta', true);
                            }
                            if ($request->search_ordenp_estado == 'C') {
                                $query->where('orden_abierta', false);
                                $query->where('orden_culminada', false);
                            }
                            if ($request->search_ordenp_estado == 'N') {
                                $query->where('orden_anulada', true);
                            }
                            if ($request->search_ordenp_estado == 'T') {
                                $query->where('orden_culminada', true);
                            }
                        }
                    })
                    ->make(true);
            } else {
                $ordenp2 = Ordenp2::getDetail($request->producto);
                if ($ordenp2 instanceof Ordenp2) {
                    return response()->json(['success' => true, 'productop_nombre' => $ordenp2->productop_nombre, 'id' => $ordenp2->id]);
                }
                return response()->json(['success' => false]);
            }
        }
        abort(404);
    }

    /**
    *
    * @param  \Illuminate\Http\Request  $request
    */
    public function subactividadesp(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('actividadesp')) {
                $query = SubActividadp::query();
                $query->select('koi_subactividadp.*', 'actividadp_nombre');
                $query->join('koi_actividadp', 'subactividadp_actividadp', '=', 'koi_actividadp.id');
                $query->where('subactividadp_actividadp', $request->actividadesp);
                $query->where('subactividadp_activo', true);
                $data = $query->get();
            }
            return response()->json($data);
        }
        abort(404);
    }

    /**
    *
    * @param  \Illuminate\Http\Request  $request
    */
    public function subtipoproductosp(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('typeproduct')) {
                $query = SubtipoProductop::query();
                $query->select('koi_subtipoproductop.*');
                $query->join('koi_tipoproductop', 'subtipoproductop_tipoproductop', '=', 'koi_tipoproductop.id');
                $query->where('subtipoproductop_tipoproductop', $request->typeproduct);
                $query->where('subtipoproductop_activo', true);
                $data = $query->get();
            }
            return response()->json($data);
        }
        abort(404);
    }
}
