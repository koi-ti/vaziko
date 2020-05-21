<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Validator, DB, Storage;

class Ordenp2 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion2';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'orden2_referencia', 'orden2_observaciones', 'orden2_transporte_formula', 'orden2_viaticos_formula', 'orden2_precio_formula', 'orden2_precio_venta', 'orden2_ancho', 'orden2_alto', 'orden2_c_ancho', 'orden2_c_alto', 'orden2_3d_ancho', 'orden2_3d_alto', 'orden2_3d_profundidad', 'orden2_nota_tiro', 'orden2_nota_retiro', 'orden2_transporte', 'orden2_viaticos', 'orden2_volumen', 'orden2_vtotal', 'orden2_total_valor_unitario', 'orden2_round', 'orden2_margen_materialp', 'orden2_margen_areap', 'orden2_margen_empaque', 'orden2_margen_transporte', 'orden2_descuento', 'orden2_comision'
    ];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = [
        'orden2_tiro', 'orden2_retiro', 'orden2_yellow', 'orden2_magenta', 'orden2_cyan', 'orden2_key', 'orden2_color1', 'orden2_color2', 'orden2_yellow2', 'orden2_magenta2', 'orden2_cyan2', 'orden2_key2', 'orden2_color12', 'orden2_color22'
    ];

    public function isValid($data) {
        $rules = [
            'orden2_referencia' => 'required|max:200',
            'orden2_cantidad' => 'required|min:1|integer',
            'orden2_precio_venta' => 'required',
            'orden2_ancho' => 'numeric|min:0',
            'orden2_volumen' => 'min:0|max:100|numeric',
            'orden2_margen_materialp' => 'min:0|max:100|numeric',
            'orden2_margen_areap' => 'min:0|max:100|numeric',
            'orden2_margen_empaque' => 'min:0|max:100|numeric',
            'orden2_margen_transporte' => 'min:0|max:100|numeric',
            'orden2_descuento' => 'min:0|max:100|numeric',
            'orden2_round' => 'required|min:-3|max:3|numeric',
            'orden2_comision' => 'min:0|max:100|numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getOrdenesp2($orden) {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.id as id', 'orden2_orden','orden2_cantidad', 'orden2_saldo', 'orden2_facturado');
        $query->precio();
        $query->producto();
        $query->where('orden2_orden', $orden);
        return $query->get();
    }

    public static function getOrdenespSpecial2($orden) {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.id as id', 'orden2_referencia', 'productop_nombre', 'orden2_orden', 'orden2_cantidad', 'orden2_saldo', 'orden2_facturado', 'orden2_total_valor_unitario',
            DB::raw("CASE WHEN orden2_tiro IS TRUE THEN (orden2_yellow + orden2_magenta + orden2_cyan + orden2_key + orden2_color1 + orden2_color2) ELSE '0' END AS tiro"),
            DB::raw("CASE WHEN orden2_retiro IS TRUE THEN (orden2_yellow2 + orden2_magenta2 + orden2_cyan2 + orden2_key2 + orden2_color12 + orden2_color22) ELSE '0' END AS retiro"),
            DB::raw('(orden2_total_valor_unitario * orden2_cantidad) as orden2_precio_total'),
            DB::raw("
                CASE
                WHEN productop_3d != 0 THEN
                        CONCAT('3D(',
                        COALESCE(orden2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN
                        CONCAT('A(',
                        COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                        COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN
                        CONCAT('A(',
                        COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN
                        CONCAT('C(',
                        COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                        COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                END AS medidas
            "));
        $query->join('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->where('orden2_orden', $orden);
        return $query->get();
    }

    public static function getOrdenp2($ordenp2) {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.*');
        $query->producto();
        $query->where('koi_ordenproduccion2.id', $ordenp2);
        return $query->first();
    }

    // Index detail
    public static function getDetails() {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.id as id', 'orden2_productop', 'orden2_orden', 'orden_abierta', 'orden_anulada', 'orden_culminada', 'orden_cliente', DB::raw('(orden2_cantidad - orden2_facturado) as orden2_cantidad'), 'orden2_saldo', 'orden2_facturado', 'orden2_total_valor_unitario', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), 'orden_numero', 'orden_ano',
            'orden2_total_valor_unitario', DB::raw('(orden2_total_valor_unitario * orden2_cantidad) as orden2_precio_total'));
        $query->producto();
        $query->join('koi_ordenproduccion', 'orden2_orden', '=', 'koi_ordenproduccion.id');
        $query->whereRaw('(orden2_cantidad - orden2_facturado) <> 0');
        $query->whereRaw('orden2_total_valor_unitario <> 0');
        return $query;
    }

    // Search detail
    public static function getDetail($id) {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.id as id', 'orden2_orden', DB::raw('(orden2_cantidad - orden2_facturado) as orden2_cantidad'), 'orden2_saldo', 'orden2_facturado', 'orden2_total_valor_unitario', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), 'orden_numero', 'orden_ano', 'orden2_total_valor_unitario', DB::raw('(orden2_total_valor_unitario * orden2_cantidad) as orden2_precio_total'));
        $query->producto();
        $query->join('koi_ordenproduccion', 'orden2_orden', '=', 'koi_ordenproduccion.id');
        $query->whereRaw('(orden2_cantidad - orden2_facturado) > 0');
        $query->whereRaw('orden2_total_valor_unitario <> 0');
        $query->where('koi_ordenproduccion2.id', $id);
        return $query->first();
    }

    public function scopePrecio ($query) {
        return auth()->user()->ability('admin', 'precios', ['module' => 'ordenes']) ?
                $query->addSelect('orden2_total_valor_unitario', DB::raw('(orden2_total_valor_unitario * orden2_cantidad) as orden2_precio_total')) :
                $query->addSelect(DB::raw('0 AS orden2_total_valor_unitario, 0 as orden2_precio_total'));
    }

    public function scopeDetalle ($query) {
        $query->select('koi_ordenproduccion2.id as id', 'orden2_orden', 'orden2_cantidad', 'orden2_saldo', 'orden2_facturado', 'orden2_total_valor_unitario', DB::raw("(orden2_cantidad-orden2_facturado)*orden2_total_valor_unitario as total"));
        $query->whereRaw('orden2_total_valor_unitario <> 0');
        return $query;
    }

    public function scopeProducto ($query) {
        return $query->addSelect(DB::raw("
                        CASE
                        WHEN productop_3d != 0 THEN
                                CONCAT(
                                COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') 3D(',
                                COALESCE(orden2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                        WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN
                                CONCAT(
                                COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                                COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                                COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                        WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN
                                CONCAT(
                                COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                                COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                        WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN
                                CONCAT(
                                COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') C(',
                                COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                        ELSE
                                CONCAT(COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                        END AS productop_nombre
                    "))
                    ->join('koi_productop', 'orden2_productop', '=', 'koi_productop.id')
                    ->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id')
                    ->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id')
                    ->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id')
                    ->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id')
                    ->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id')
                    ->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id')
                    ->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
    }

    public function crearProductoCotizacion ($cotizacion) {
        $cotizacion2 = new Cotizacion2;
        $cotizacion2->cotizacion2_cotizacion = $cotizacion;
        $cotizacion2->cotizacion2_productop = $this->orden2_productop;
        $cotizacion2->cotizacion2_referencia = $this->orden2_referencia;
        $cotizacion2->cotizacion2_cantidad = $this->orden2_cantidad;
        $cotizacion2->cotizacion2_saldo = $this->orden2_cantidad;
        $cotizacion2->cotizacion2_precio_formula = $this->orden2_precio_formula;
        $cotizacion2->cotizacion2_transporte_formula = $this->orden2_transporte_formula;
        $cotizacion2->cotizacion2_viaticos_formula = $this->orden2_viaticos_formula;
        $cotizacion2->cotizacion2_viaticos = $this->orden2_viaticos;
        $cotizacion2->cotizacion2_transporte = $this->orden2_transporte;
        $cotizacion2->cotizacion2_precio_venta = $this->orden2_precio_venta;
        $cotizacion2->cotizacion2_total_valor_unitario = $this->orden2_total_valor_unitario;
        $cotizacion2->cotizacion2_entregado = 0;
        $cotizacion2->cotizacion2_observaciones = $this->orden2_observaciones;
        $cotizacion2->cotizacion2_tiro = $this->orden2_tiro;
        $cotizacion2->cotizacion2_retiro = $this->orden2_retiro;
        $cotizacion2->cotizacion2_volumen = $this->orden2_volumen;
        $cotizacion2->cotizacion2_round = $this->orden2_round;
        $cotizacion2->cotizacion2_margen_materialp = $this->orden2_margen_materialp;
        $cotizacion2->cotizacion2_margen_areap = $this->orden2_margen_areap;
        $cotizacion2->cotizacion2_margen_empaque = $this->orden2_margen_empaque;
        $cotizacion2->cotizacion2_margen_transporte = $this->orden2_margen_transporte;
        $cotizacion2->cotizacion2_comision = $this->orden2_comision;
        $cotizacion2->cotizacion2_descuento = $this->orden2_descuento;
        $cotizacion2->cotizacion2_vtotal = $this->orden2_vtotal;
        $cotizacion2->cotizacion2_yellow = $this->orden2_yellow;
        $cotizacion2->cotizacion2_magenta = $this->orden2_magenta;
        $cotizacion2->cotizacion2_cyan = $this->orden2_cyan;
        $cotizacion2->cotizacion2_key = $this->orden2_key;
        $cotizacion2->cotizacion2_color1 = $this->orden2_color1;
        $cotizacion2->cotizacion2_color2 = $this->orden2_color2;
        $cotizacion2->cotizacion2_nota_tiro = $this->orden2_nota_tiro;
        $cotizacion2->cotizacion2_yellow2 = $this->orden2_yellow2;
        $cotizacion2->cotizacion2_magenta2 = $this->orden2_magenta2;
        $cotizacion2->cotizacion2_cyan2 = $this->orden2_cyan2;
        $cotizacion2->cotizacion2_key2 = $this->orden2_key2;
        $cotizacion2->cotizacion2_color12 = $this->orden2_color12;
        $cotizacion2->cotizacion2_color22 = $this->orden2_color22;
        $cotizacion2->cotizacion2_nota_retiro = $this->orden2_nota_retiro;
        $cotizacion2->cotizacion2_ancho = $this->orden2_ancho;
        $cotizacion2->cotizacion2_alto = $this->orden2_alto;
        $cotizacion2->cotizacion2_c_ancho = $this->orden2_c_ancho;
        $cotizacion2->cotizacion2_c_alto = $this->orden2_c_alto;
        $cotizacion2->cotizacion2_3d_ancho = $this->orden2_3d_ancho;
        $cotizacion2->cotizacion2_3d_alto = $this->orden2_3d_alto;
        $cotizacion2->cotizacion2_3d_profundidad = $this->orden2_3d_profundidad;
        $cotizacion2->cotizacion2_fecha_elaboro = date('Y-m-d H:i:s');
        $cotizacion2->cotizacion2_usuario_elaboro = auth()->user()->id;
        $cotizacion2->save();

        // Recuperar Acabados de cotizacion para generar cotizacion
        $acabados = Ordenp5::where('orden5_orden2', $this->id)->get();
        foreach ($acabados as $acabado) {
             $cotizacion5 = new Cotizacion5;
             $cotizacion5->cotizacion5_acabadop = $acabado->orden5_acabadop;
             $cotizacion5->cotizacion5_cotizacion2 = $cotizacion2->id;
             $cotizacion5->save();
        }

        // Recuperar Maquinas de cotizacion para generar cotizacion
        $maquinas = Ordenp3::where('orden3_orden2', $this->id)->get();
        foreach ($maquinas as $maquina) {
             $cotizacion3 = new Cotizacion3;
             $cotizacion3->cotizacion3_maquinap = $maquina->orden3_maquinap;
             $cotizacion3->cotizacion3_cotizacion2 = $cotizacion2->id;
             $cotizacion3->save();
        }

        // Recuperar Imagenes de pre-cotizacion para generar cotizacion
        $imagenes = Ordenp8::where('orden8_orden2', $this->id)->get();
        foreach ($imagenes as $imagen) {
            $cotizacion8 = new Cotizacion8;
            $cotizacion8->cotizacion8_cotizacion2 = $cotizacion2->id;
            $cotizacion8->cotizacion8_archivo = $imagen->orden8_archivo;
            $cotizacion8->cotizacion8_fh_elaboro = date('Y-m-d H:i:s');
            $cotizacion8->cotizacion8_usuario_elaboro = auth()->user()->id;
            $cotizacion8->save();

            // Recuperar imagen y copiar
            if (Storage::has("ordenes/orden_{$this->orden2_orden}/producto_{$imagen->orden8_orden2}/{$imagen->orden8_archivo}")) {
                $oldfile = "ordenes/orden_{$this->orden2_orden}/producto_{$imagen->orden8_orden2}/{$imagen->orden8_archivo}";
                $newfile = "cotizaciones/cotizacion_{$cotizacion2->cotizacion2_cotizacion}/producto_{$cotizacion8->cotizacion8_cotizacion2}/{$cotizacion8->cotizacion8_archivo}";

                // Copy file storege laravel
                Storage::copy($oldfile, $newfile);
            }
        }

        // Recuperar Materiales de pre-cotizacion para generar cotizacion
        $materiales = Ordenp4::where('orden4_orden2', $this->id)->get();
        foreach ($materiales as $material) {
             $cotizacion4 = new Cotizacion4;
             $cotizacion4->cotizacion4_cotizacion2 = $cotizacion2->id;
             $cotizacion4->cotizacion4_materialp = $material->orden4_materialp;
             $cotizacion4->cotizacion4_producto = $material->orden4_producto;
             $cotizacion4->cotizacion4_medidas = $material->orden4_medidas;
             $cotizacion4->cotizacion4_cantidad = $material->orden4_cantidad;
             $cotizacion4->cotizacion4_valor_unitario = $material->orden4_valor_unitario;
             $cotizacion4->cotizacion4_valor_total = $material->orden4_valor_total;
             $cotizacion4->cotizacion4_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion4->cotizacion4_usuario_elaboro = auth()->user()->id;
             $cotizacion4->save();
        }

        // Recuperar Areasp de cotizacion para generar precotizacion
        $areasp = Ordenp6::where('orden6_orden2', $this->id)->get();
        foreach ($areasp as $area) {
             $cotizacion6 = new Cotizacion6;
             $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
             $cotizacion6->cotizacion6_areap = $area->orden6_areap;
             $cotizacion6->cotizacion6_nombre = $area->orden6_nombre;
             $cotizacion6->cotizacion6_tiempo = $area->orden6_tiempo;
             $cotizacion6->cotizacion6_valor = $area->orden6_valor;
             $cotizacion6->save();
        }

        // Recuperar Empaques de pre-cotizacion para generar cotizacion
        $empaques = Ordenp9::where('orden9_orden2', $this->id)->get();
        foreach ($empaques as $empaque) {
             $cotizacion9 = new Cotizacion9;
             $cotizacion9->cotizacion9_cotizacion2 = $cotizacion2->id;
             $cotizacion9->cotizacion9_materialp = $empaque->orden9_materialp;
             $cotizacion9->cotizacion9_producto = $empaque->orden9_producto;
             $cotizacion9->cotizacion9_medidas = $empaque->orden9_medidas;
             $cotizacion9->cotizacion9_cantidad = $empaque->orden9_cantidad;
             $cotizacion9->cotizacion9_valor_unitario = $empaque->orden9_valor_unitario;
             $cotizacion9->cotizacion9_valor_total = $empaque->orden9_valor_total;
             $cotizacion9->cotizacion9_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion9->cotizacion9_usuario_elaboro = auth()->user()->id;
             $cotizacion9->save();
        }

        // Recuperar Transportes de pre-cotizacion para generar cotizacion
        $transportes = Ordenp10::where('orden10_orden2', $this->id)->get();
        foreach ($transportes as $transporte) {
             $cotizacion10 = new Cotizacion10;
             $cotizacion10->cotizacion10_cotizacion2 = $cotizacion2->id;
             $cotizacion10->cotizacion10_transporte = $transporte->orden10_transporte;
             $cotizacion10->cotizacion10_nombre = $transporte->orden10_nombre;
             $cotizacion10->cotizacion10_tiempo = $transporte->orden10_tiempo;
             $cotizacion10->cotizacion10_valor_unitario = $transporte->orden10_valor_unitario;
             $cotizacion10->cotizacion10_valor_total = $transporte->orden10_valor_total;
             $cotizacion10->cotizacion10_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion10->cotizacion10_usuario_elaboro = auth()->user()->id;
             $cotizacion10->save();
        }

        return $cotizacion2;
    }

    public function crearProductoOrden ($orden) {
        $orden2 = $this->replicate();
        $orden2->orden2_orden = $orden;
        $orden2->orden2_saldo = $this->orden2_cantidad;
        $orden2->orden2_fecha_elaboro = date('Y-m-d H:i:s');
        $orden2->orden2_usuario_elaboro = auth()->user()->id;
        $orden2->save();

        // Recuperar Acabados de orden para generar orden
        $acabados = Ordenp5::where('orden5_orden2', $this->id)->get();
        foreach ($acabados as $acabado) {
             $orden5 = $acabado->replicate();
             $orden5->orden5_orden2 = $orden2->id;
             $orden5->save();
        }

        // Recuperar Maquinas de orden para generar orden
        $maquinas = Ordenp3::where('orden3_orden2', $this->id)->get();
        foreach ($maquinas as $maquina) {
             $orden3 = $maquina->replicate();
             $orden3->orden3_orden2 = $orden2->id;
             $orden3->save();
        }

        // Recuperar Imagenes de pre-orden para generar orden
        $imagenes = Ordenp8::where('orden8_orden2', $this->id)->get();
        foreach ($imagenes as $imagen) {
            $orden8 = $imagen->replicate();
            $orden8->orden8_orden2 = $orden2->id;
            $orden8->orden8_fh_elaboro = date('Y-m-d H:i:s');
            $orden8->orden8_usuario_elaboro = auth()->user()->id;
            $orden8->save();

            // Recuperar imagen y copiar
            if (Storage::has("ordenes/orden_{$this->orden2_orden}/producto_{$imagen->orden8_orden2}/{$imagen->orden8_archivo}")) {
                $oldfile = "ordenes/orden_{$this->orden2_orden}/producto_{$imagen->orden8_orden2}/{$imagen->orden8_archivo}";
                $newfile = "ordenes/orden_{$orden2->orden2_orden}/producto_{$orden8->orden8_orden2}/{$orden8->orden8_archivo}";

                // Copy file storege laravel
                Storage::copy($oldfile, $newfile);
            }
        }

        // Recuperar Materiales de cotizacion para generar cotizacion
        $materiales = Ordenp4::where('orden4_orden2', $this->id)->get();
        foreach ($materiales as $material) {
             $orden4 = $material->replicate();
             $orden4->orden4_orden2 = $orden2->id;
             $orden4->orden4_fh_elaboro = date('Y-m-d H:i:s');
             $orden4->orden4_usuario_elaboro = auth()->user()->id;
             $orden4->save();
        }

        // Recuperar Areasp de orden para generar orden
        $areasp = Ordenp6::where('orden6_orden2', $this->id)->get();
        foreach ($areasp as $area) {
             $orden6 = $area->replicate();
             $orden6->orden6_orden2 = $orden2->id;
             $orden6->save();
        }

        // Recuperar Empaques de pre-orden para generar orden
        $empaques = Ordenp9::where('orden9_orden2', $this->id)->get();
        foreach ($empaques as $empaque) {
             $orden9 = $empaque->replicate();
             $orden9->orden9_orden2 = $orden2->id;
             $orden9->orden9_fh_elaboro = date('Y-m-d H:i:s');
             $orden9->orden9_usuario_elaboro = auth()->user()->id;
             $orden9->save();
        }

        // Recuperar Transportes de pre-orden para generar orden
        $transportes = Ordenp10::where('orden10_orden2', $this->id)->get();
        foreach ($transportes as $transporte) {
             $orden10 = $transporte->replicate();
             $orden10->orden10_orden2 = $orden2->id;
             $orden10->orden10_fh_elaboro = date('Y-m-d H:i:s');
             $orden10->orden10_usuario_elaboro = auth()->user()->id;
             $orden10->save();
        }

        return $orden2;
    }
}
