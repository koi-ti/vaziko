<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Validator, DB, Storage;

class Cotizacion2 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion2';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'cotizacion2_referencia', 'cotizacion2_observaciones', 'cotizacion2_transporte_formula', 'cotizacion2_viaticos_formula', 'cotizacion2_precio_formula', 'cotizacion2_precio_venta', 'cotizacion2_ancho', 'cotizacion2_alto', 'cotizacion2_c_ancho', 'cotizacion2_c_alto', 'cotizacion2_3d_ancho', 'cotizacion2_3d_alto', 'cotizacion2_3d_profundidad', 'cotizacion2_nota_tiro', 'cotizacion2_nota_retiro', 'cotizacion2_transporte', 'cotizacion2_viaticos', 'cotizacion2_volumen', 'cotizacion2_vtotal', 'cotizacion2_total_valor_unitario', 'cotizacion2_round', 'cotizacion2_margen_materialp', 'cotizacion2_margen_areap', 'cotizacion2_margen_empaque', 'cotizacion2_margen_transporte', 'cotizacion2_descuento', 'cotizacion2_comision'
    ];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = [
        'cotizacion2_tiro', 'cotizacion2_retiro', 'cotizacion2_yellow', 'cotizacion2_magenta', 'cotizacion2_cyan', 'cotizacion2_key', 'cotizacion2_color1', 'cotizacion2_color2', 'cotizacion2_yellow2', 'cotizacion2_magenta2', 'cotizacion2_cyan2', 'cotizacion2_key2', 'cotizacion2_color12', 'cotizacion2_color22'
    ];

    public function isValid($data) {
        $rules = [
            'cotizacion2_referencia' => 'required|max:200',
            'cotizacion2_cantidad' => 'required|min:1|integer',
            'cotizacion2_round' => 'required|min:-3|max:3|numeric',
            'cotizacion2_precio_venta' => 'required',
            'cotizacion2_ancho' => 'numeric|min:0',
            'cotizacion2_volumen' => 'min:0|max:100|integer',
            'cotizacion2_margen_materialp' => 'min:0|max:100|numeric',
            'cotizacion2_margen_areap' => 'min:0|max:100|numeric',
            'cotizacion2_margen_empaque' => 'min:0|max:100|numeric',
            'cotizacion2_margen_transporte' => 'min:0|max:100|numeric',
            'cotizacion2_descuento' => 'min:0|max:100|numeric',
            'cotizacion2_comision' => 'min:0|max:100|numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getCotizaciones2($cotizacion = null) {
        $query = self::query();
        $query->select('koi_cotizacion2.id as id', 'cotizacion2_cotizacion','cotizacion2_cantidad', 'cotizacion2_saldo', 'cotizacion2_facturado', 'cotizacion1_iva', 'cotizacion2_total_valor_unitario', 'cotizacion1_ano', 'cotizacion1_numero', 'cotizacion1_abierta', 'cotizacion1_anulada',
            DB::raw("CONCAT(cotizacion1_numero,'-',SUBSTRING(cotizacion1_ano, -2)) as cotizacion_codigo"),
            DB::raw("CASE WHEN cotizacion2_tiro != 0 THEN ( cotizacion2_yellow + cotizacion2_magenta + cotizacion2_cyan + cotizacion2_key + cotizacion2_color1 + cotizacion2_color2) ELSE '0' END AS tiro"),
            DB::raw("CASE WHEN cotizacion2_retiro != 0 THEN ( cotizacion2_yellow2 + cotizacion2_magenta2 + cotizacion2_cyan2 + cotizacion2_key2 + cotizacion2_color12 + cotizacion2_color22) ELSE '0' END AS retiro"),
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) ? 'cotizacion2_total_valor_unitario' : DB::raw('0 as cotizacion2_total_valor_unitario')),
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) ? DB::raw('(cotizacion2_total_valor_unitario * cotizacion2_cantidad) as cotizacion2_precio_total') : DB::raw('0 as cotizacion2_precio_total')));
        $query->producto();
        $query->join('koi_cotizacion1', 'cotizacion2_cotizacion', '=', 'koi_cotizacion1.id');
        if ($cotizacion) {
            $query->where('cotizacion2_cotizacion', $cotizacion);
            return $query->get();
        } else {
            return $query;
        }
    }

    public static function getExportCotizaciones2($cotizacion) {
        $query = self::query();
        $query->select('koi_cotizacion2.id as id', 'cotizacion2_referencia', 'productop_nombre', 'cotizacion2_cotizacion','cotizacion2_cantidad', 'cotizacion2_saldo', 'cotizacion2_facturado', 'cotizacion1_iva', 'cotizacion2_total_valor_unitario',
            DB::raw("CASE WHEN cotizacion2_tiro != 0 THEN ( cotizacion2_yellow + cotizacion2_magenta + cotizacion2_cyan + cotizacion2_key + cotizacion2_color1 + cotizacion2_color2) ELSE '0' END AS tiro"),
            DB::raw("CASE WHEN cotizacion2_retiro != 0 THEN ( cotizacion2_yellow2 + cotizacion2_magenta2 + cotizacion2_cyan2 + cotizacion2_key2 + cotizacion2_color12 + cotizacion2_color22) ELSE '0' END AS retiro"),
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) ? 'cotizacion2_total_valor_unitario' : DB::raw('0 as cotizacion2_total_valor_unitario')),
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) ? DB::raw('(cotizacion2_total_valor_unitario * cotizacion2_cantidad) as cotizacion2_precio_total') : DB::raw('0 as cotizacion2_precio_total') ),
            DB::raw("CASE WHEN productop_3d != 0 THEN CONCAT(
                            '3D(',
                            COALESCE(cotizacion2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                            COALESCE(cotizacion2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                            COALESCE(cotizacion2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                        WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN CONCAT(
                            'A(',
                            COALESCE(cotizacion2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                            COALESCE(cotizacion2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                            COALESCE(cotizacion2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                            COALESCE(cotizacion2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                        WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN CONCAT(
                            'A(',
                            COALESCE(cotizacion2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                            COALESCE(cotizacion2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                        WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN CONCAT(
                            'C(',
                            COALESCE(cotizacion2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                            COALESCE(cotizacion2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                        END as medidas")
        );
        $query->join('koi_productop', 'cotizacion2_productop', '=', 'koi_productop.id');
        $query->join('koi_cotizacion1', 'cotizacion2_cotizacion', '=', 'koi_cotizacion1.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->where('cotizacion2_cotizacion', $cotizacion);
        return $query->get();
    }

    public static function getCotizacion2($cotizacion2) {
        $query = self::query();
        $query->select('koi_cotizacion2.*');
        $query->producto();
        $query->where('koi_cotizacion2.id', $cotizacion2);
        return $query->first();
    }

    public function scopeProducto ($query) {
        return $query->addSelect(DB::raw("
                            CASE WHEN productop_3d != 0 THEN CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,') 3D(',
                                    COALESCE(cotizacion2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                                    COALESCE(cotizacion2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                                    COALESCE(cotizacion2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                            WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,') A(',
                                    COALESCE(cotizacion2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                    COALESCE(cotizacion2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                                    COALESCE(cotizacion2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                    COALESCE(cotizacion2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                            WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,') A(',
                                    COALESCE(cotizacion2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                    COALESCE(cotizacion2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                            WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,') C(',
                                    COALESCE(cotizacion2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                    COALESCE(cotizacion2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                            ELSE CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,')' )
                            END AS productop_nombre"))
                    ->join('koi_productop', 'cotizacion2_productop', '=', 'koi_productop.id')
                    ->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id')
                    ->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id')
                    ->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id')
                    ->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id')
                    ->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id')
                    ->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id')
                    ->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
    }

    public function crearProductoCotizacion ($cotizacion) {
        $cotizacion2 = $this->replicate();
        $cotizacion2->cotizacion2_cotizacion = $cotizacion;
        $cotizacion2->cotizacion2_saldo = $this->cotizacion2_cantidad;
        $cotizacion2->cotizacion2_fecha_elaboro = date('Y-m-d H:i:s');
        $cotizacion2->cotizacion2_usuario_elaboro = auth()->user()->id;
        $cotizacion2->save();

        // Recuperar Acabados de cotizacion para generar cotizacion
        $acabados = Cotizacion5::where('cotizacion5_cotizacion2', $this->id)->get();
        foreach ($acabados as $acabado) {
             $cotizacion5 = $acabado->replicate();
             $cotizacion5->cotizacion5_cotizacion2 = $cotizacion2->id;
             $cotizacion5->save();
        }

        // Recuperar Maquinas de cotizacion para generar cotizacion
        $maquinas = Cotizacion3::where('cotizacion3_cotizacion2', $this->id)->get();
        foreach ($maquinas as $maquina) {
             $cotizacion3 = $maquina->replicate();
             $cotizacion3->cotizacion3_cotizacion2 = $cotizacion2->id;
             $cotizacion3->save();
        }

        // Recuperar Imagenes de pre-cotizacion para generar cotizacion
        $imagenes = Cotizacion8::where('cotizacion8_cotizacion2', $this->id)->get();
        foreach ($imagenes as $imagen) {
            $cotizacion8 = $imagen->replicate();
            $cotizacion8->cotizacion8_cotizacion2 = $cotizacion2->id;
            $cotizacion8->cotizacion8_fh_elaboro = date('Y-m-d H:i:s');
            $cotizacion8->cotizacion8_usuario_elaboro = auth()->user()->id;
            $cotizacion8->save();

            // Recuperar imagen y copiar
            if (Storage::has("cotizaciones/cotizacion_{$this->cotizacion2_cotizacion}/producto_{$imagen->cotizacion8_cotizacion2}/{$imagen->cotizacion8_archivo}")) {
                $oldfile = "cotizaciones/cotizacion_{$this->cotizacion2_cotizacion}/producto_{$imagen->cotizacion8_cotizacion2}/{$imagen->cotizacion8_archivo}";
                $newfile = "cotizaciones/cotizacion_{$cotizacion2->cotizacion2_cotizacion}/producto_{$cotizacion8->cotizacion8_cotizacion2}/{$cotizacion8->cotizacion8_archivo}";

                // Copy file storege laravel
                Storage::copy($oldfile, $newfile);
            }
        }

        // Recuperar Materiales de cotizacion para generar cotizacion
        $materiales = Cotizacion4::where('cotizacion4_cotizacion2', $this->id)->get();
        foreach ($materiales as $material) {
             $cotizacion4 = $material->replicate();
             $cotizacion4->cotizacion4_cotizacion2 = $cotizacion2->id;
             $cotizacion4->cotizacion4_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion4->cotizacion4_usuario_elaboro = auth()->user()->id;
             $cotizacion4->save();
        }

        // Recuperar Areasp de cotizacion para generar cotizacion
        $areasp = Cotizacion6::where('cotizacion6_cotizacion2', $this->id)->get();
        foreach ($areasp as $area) {
             $cotizacion6 = $area->replicate();
             $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
             $cotizacion6->save();
        }

        // Recuperar Empaques de pre-cotizacion para generar cotizacion
        $empaques = Cotizacion9::where('cotizacion9_cotizacion2', $this->id)->get();
        foreach ($empaques as $empaque) {
             $cotizacion9 = $empaque->replicate();
             $cotizacion9->cotizacion9_cotizacion2 = $cotizacion2->id;
             $cotizacion9->cotizacion9_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion9->cotizacion9_usuario_elaboro = auth()->user()->id;
             $cotizacion9->save();
        }

        // Recuperar Transportes de pre-cotizacion para generar cotizacion
        $transportes = Cotizacion10::where('cotizacion10_cotizacion2', $this->id)->get();
        foreach ($transportes as $transporte) {
             $cotizacion10 = $transporte->replicate();
             $cotizacion10->cotizacion10_cotizacion2 = $cotizacion2->id;
             $cotizacion10->cotizacion10_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion10->cotizacion10_usuario_elaboro = auth()->user()->id;
             $cotizacion10->save();
        }

        return $cotizacion2;
    }

    public function crearProductoOrden ($orden) {
        $orden2 = new Ordenp2;
        $orden2->orden2_orden = $orden;
        $orden2->orden2_productop = $this->cotizacion2_productop;
        $orden2->orden2_referencia = $this->cotizacion2_referencia;
        $orden2->orden2_cantidad = $this->cotizacion2_cantidad;
        $orden2->orden2_saldo = $this->cotizacion2_cantidad;
        $orden2->orden2_precio_formula = $this->cotizacion2_precio_formula;
        $orden2->orden2_transporte_formula = $this->cotizacion2_transporte_formula;
        $orden2->orden2_viaticos_formula = $this->cotizacion2_viaticos_formula;
        $orden2->orden2_viaticos = $this->cotizacion2_viaticos;
        $orden2->orden2_transporte = $this->cotizacion2_transporte;
        $orden2->orden2_precio_venta = $this->cotizacion2_precio_venta;
        $orden2->orden2_total_valor_unitario = $this->cotizacion2_total_valor_unitario;
        $orden2->orden2_entregado = 0;
        $orden2->orden2_observaciones = $this->cotizacion2_observaciones;
        $orden2->orden2_tiro = $this->cotizacion2_tiro;
        $orden2->orden2_retiro = $this->cotizacion2_retiro;
        $orden2->orden2_volumen = $this->cotizacion2_volumen;
        $orden2->orden2_round = $this->cotizacion2_round;
        $orden2->orden2_margen_materialp = $this->cotizacion2_margen_materialp;
        $orden2->orden2_margen_areap = $this->cotizacion2_margen_areap;
        $orden2->orden2_margen_empaque = $this->cotizacion2_margen_empaque;
        $orden2->orden2_margen_transporte = $this->cotizacion2_margen_transporte;
        $orden2->orden2_comision = $this->cotizacion2_comision;
        $orden2->orden2_descuento = $this->cotizacion2_descuento;
        $orden2->orden2_vtotal = $this->cotizacion2_vtotal;
        $orden2->orden2_yellow = $this->cotizacion2_yellow;
        $orden2->orden2_magenta = $this->cotizacion2_magenta;
        $orden2->orden2_cyan = $this->cotizacion2_cyan;
        $orden2->orden2_key = $this->cotizacion2_key;
        $orden2->orden2_color1 = $this->cotizacion2_color1;
        $orden2->orden2_color2 = $this->cotizacion2_color2;
        $orden2->orden2_nota_tiro = $this->cotizacion2_nota_tiro;
        $orden2->orden2_yellow2 = $this->cotizacion2_yellow2;
        $orden2->orden2_magenta2 = $this->cotizacion2_magenta2;
        $orden2->orden2_cyan2 = $this->cotizacion2_cyan2;
        $orden2->orden2_key2 = $this->cotizacion2_key2;
        $orden2->orden2_color12 = $this->cotizacion2_color12;
        $orden2->orden2_color22 = $this->cotizacion2_color22;
        $orden2->orden2_nota_retiro = $this->cotizacion2_nota_retiro;
        $orden2->orden2_ancho = $this->cotizacion2_ancho;
        $orden2->orden2_alto = $this->cotizacion2_alto;
        $orden2->orden2_c_ancho = $this->cotizacion2_c_ancho;
        $orden2->orden2_c_alto = $this->cotizacion2_c_alto;
        $orden2->orden2_3d_ancho = $this->cotizacion2_3d_ancho;
        $orden2->orden2_3d_alto = $this->cotizacion2_3d_alto;
        $orden2->orden2_3d_profundidad = $this->cotizacion2_3d_profundidad;
        $orden2->orden2_fecha_elaboro = date('Y-m-d H:i:s');
        $orden2->orden2_usuario_elaboro = auth()->user()->id;
        $orden2->save();

        // Recuperar Acabados de orden para generar orden
        $acabados = Cotizacion5::where('cotizacion5_cotizacion2', $this->id)->get();
        foreach ($acabados as $acabado) {
             $orden5 = new Ordenp5;
             $orden5->orden5_acabadop = $acabado->cotizacion5_acabadop;
             $orden5->orden5_orden2 = $orden2->id;
             $orden5->save();
        }

        // Recuperar Maquinas de orden para generar orden
        $maquinas = Cotizacion3::where('cotizacion3_cotizacion2', $this->id)->get();
        foreach ($maquinas as $maquina) {
             $orden3 = new Ordenp3;
             $orden3->orden3_maquinap = $maquina->cotizacion3_maquinap;
             $orden3->orden3_orden2 = $orden2->id;
             $orden3->save();
        }

        // Recuperar Imagenes de pre-orden para generar orden
        $imagenes = Cotizacion8::where('cotizacion8_cotizacion2', $this->id)->get();
        foreach ($imagenes as $imagen) {
            $orden8 = new Ordenp8;
            $orden8->orden8_orden2 = $orden2->id;
            $orden8->orden8_archivo = $imagen->cotizacion8_archivo;
            $orden8->orden8_fh_elaboro = date('Y-m-d H:i:s');
            $orden8->orden8_usuario_elaboro = auth()->user()->id;
            $orden8->save();

            // Recuperar imagen y copiar
            if (Storage::has("cotizaciones/cotizacion_{$this->cotizacion2_cotizacion}/producto_{$imagen->cotizacion8_cotizacion2}/{$imagen->cotizacion8_archivo}")) {
                $oldfile = "cotizaciones/cotizacion_{$this->cotizacion2_cotizacion}/producto_{$imagen->cotizacion8_cotizacion2}/{$imagen->cotizacion8_archivo}";
                $newfile = "ordenes/orden_{$orden2->orden2_orden}/producto_{$orden8->orden8_orden2}/{$orden8->orden8_archivo}";

                // Copy file storege laravel
                Storage::copy($oldfile, $newfile);
            }
        }

        // Recuperar Materiales de pre-cotizacion para generar cotizacion
        $materiales = Cotizacion4::where('cotizacion4_cotizacion2', $this->id)->get();
        foreach ($materiales as $material) {
             $orden4 = new Ordenp4;
             $orden4->orden4_orden2 = $orden2->id;
             $orden4->orden4_materialp = $material->cotizacion4_materialp;
             $orden4->orden4_producto = $material->cotizacion4_producto;
             $orden4->orden4_medidas = $material->cotizacion4_medidas;
             $orden4->orden4_cantidad = $material->cotizacion4_cantidad;
             $orden4->orden4_valor_unitario = $material->cotizacion4_valor_unitario;
             $orden4->orden4_valor_total = $material->cotizacion4_valor_total;
             $orden4->orden4_fh_elaboro = date('Y-m-d H:i:s');
             $orden4->orden4_usuario_elaboro = auth()->user()->id;
             $orden4->save();
        }

        // Recuperar Areasp de orden para generar preorden
        $areasp = Cotizacion6::where('cotizacion6_cotizacion2', $this->id)->get();
        foreach ($areasp as $area) {
             $orden6 = new Ordenp6;
             $orden6->orden6_orden2 = $orden2->id;
             $orden6->orden6_areap = $area->cotizacion6_areap;
             $orden6->orden6_nombre = $area->cotizacion6_nombre;
             $orden6->orden6_tiempo = $area->cotizacion6_tiempo;
             $orden6->orden6_valor = $area->cotizacion6_valor;
             $orden6->save();
        }

        // Recuperar Empaques de pre-orden para generar orden
        $empaques = Cotizacion9::where('cotizacion9_cotizacion2', $this->id)->get();
        foreach ($empaques as $empaque) {
             $orden9 = new Ordenp9;
             $orden9->orden9_orden2 = $orden2->id;
             $orden9->orden9_materialp = $empaque->cotizacion9_materialp;
             $orden9->orden9_producto = $empaque->cotizacion9_producto;
             $orden9->orden9_medidas = $empaque->cotizacion9_medidas;
             $orden9->orden9_cantidad = $empaque->cotizacion9_cantidad;
             $orden9->orden9_valor_unitario = $empaque->cotizacion9_valor_unitario;
             $orden9->orden9_valor_total = $empaque->cotizacion9_valor_total;
             $orden9->orden9_fh_elaboro = date('Y-m-d H:i:s');
             $orden9->orden9_usuario_elaboro = auth()->user()->id;
             $orden9->save();
        }

        // Recuperar Transportes de pre-orden para generar orden
        $transportes = Cotizacion10::where('cotizacion10_cotizacion2', $this->id)->get();
        foreach ($transportes as $transporte) {
             $orden10 = new Ordenp10;
             $orden10->orden10_orden2 = $orden2->id;
             $orden10->orden10_materialp = $transporte->cotizacion10_materialp;
             $orden10->orden10_producto = $transporte->cotizacion10_producto;
             $orden10->orden10_medidas = $transporte->cotizacion10_medidas;
             $orden10->orden10_cantidad = $transporte->cotizacion10_cantidad;
             $orden10->orden10_valor_unitario = $transporte->cotizacion10_valor_unitario;
             $orden10->orden10_valor_total = $transporte->cotizacion10_valor_total;
             $orden10->orden10_fh_elaboro = date('Y-m-d H:i:s');
             $orden10->orden10_usuario_elaboro = auth()->user()->id;
             $orden10->save();
        }

        return $orden2;
    }
}
