<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Validator, DB;

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
            'orden2_round' => 'required|min:-3|max:3|numeric',
            'orden2_volumen' => 'min:0|max:100|integer',
            'orden2_margen_materialp' => 'min:0|max:100|numeric',
            'orden2_margen_areap' => 'min:0|max:100|numeric',
            'orden2_margen_empaque' => 'min:0|max:100|numeric',
            'orden2_margen_transporte' => 'min:0|max:100|numeric',
            'orden2_descuento' => 'min:0|max:100|numeric',
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
        $query->select('koi_ordenproduccion2.id as id', 'orden2_orden','orden2_cantidad', 'orden2_saldo', 'orden2_facturado', 'orden2_total_valor_unitario',
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'ordenes']) ? 'orden2_total_valor_unitario' : DB::raw('0 as orden2_total_valor_unitario') ),
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'ordenes']) ? DB::raw('(orden2_total_valor_unitario * orden2_cantidad) as orden2_precio_total') : DB::raw('0 as orden2_precio_total') ),
            DB::raw("
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
                        CONCAT(
                            COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                END AS productop_nombre
            ")
        );
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
        $query->select('koi_ordenproduccion2.*',
            DB::raw("
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
                        CONCAT(
                            COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                END AS productop_nombre
            ")
        );
        $query->join('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');

        $query->where('koi_ordenproduccion2.id', $ordenp2);
        return $query->first();
    }

    // Index detail
    public static function getDetails() {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.id as id', 'orden2_productop', 'orden2_orden', 'orden_abierta', 'orden_anulada', 'orden_culminada', 'orden_cliente', DB::raw('(orden2_cantidad - orden2_facturado) as orden2_cantidad'), 'orden2_saldo', 'orden2_facturado', 'orden2_total_valor_unitario', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), 'orden_numero', 'orden_ano',
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'ordenes']) ? 'orden2_total_valor_unitario' : DB::raw('0 as orden2_total_valor_unitario') ),
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'ordenes']) ? DB::raw('(orden2_total_valor_unitario * orden2_cantidad) as orden2_precio_total') : DB::raw('0 as orden2_precio_total') ),
            DB::raw("
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
                        CONCAT(
                            COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                END AS productop_nombre
            ")
        );
        $query->join('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
        $query->join('koi_ordenproduccion', 'orden2_orden', '=', 'koi_ordenproduccion.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->whereRaw('(orden2_cantidad - orden2_facturado) <> 0');
        $query->whereRaw('orden2_total_valor_unitario <> 0');
        return $query;
    }

    // Search detail
    public static function getDetail($id) {
        $query = Ordenp2::query();
        $query->select('koi_ordenproduccion2.id as id', 'orden2_orden', DB::raw('(orden2_cantidad - orden2_facturado) as orden2_cantidad'), 'orden2_saldo', 'orden2_facturado', 'orden2_total_valor_unitario', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), 'orden_numero', 'orden_ano',
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'ordenes']) ? 'orden2_total_valor_unitario' : DB::raw('0 as orden2_total_valor_unitario') ),
            (auth()->user()->ability('admin', 'opcional2', ['module' => 'ordenes']) ? DB::raw('(orden2_total_valor_unitario * orden2_cantidad) as orden2_precio_total') : DB::raw('0 as orden2_precio_total') ),
            DB::raw("
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
                        CONCAT(
                            COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                END AS productop_nombre
            ")
        );
        $query->join('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
        $query->join('koi_ordenproduccion', 'orden2_orden', '=', 'koi_ordenproduccion.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->whereRaw('(orden2_cantidad - orden2_facturado) > 0');
        $query->whereRaw('orden2_total_valor_unitario <> 0');
        // $query->where('orden_abierta', true); Nota: se quita para pruebas de asientos
        $query->where('koi_ordenproduccion2.id', $id);
        return $query->first();
    }

    public function scopeDetalle ($query) {
        $query->select('koi_ordenproduccion2.id as id', 'orden2_orden', 'orden_cliente', 'orden2_cantidad', 'orden2_saldo', 'orden2_facturado', 'orden2_total_valor_unitario', DB::raw("(orden2_cantidad-orden2_facturado)*orden2_total_valor_unitario as total"),
            DB::raw("
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
                        CONCAT(
                            COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                END AS productop_nombre
            ")
        );
        $query->join('koi_productop', 'orden2_productop', '=', 'koi_productop.id');
        $query->join('koi_ordenproduccion', 'orden2_orden', '=', 'koi_ordenproduccion.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->whereRaw('orden2_total_valor_unitario <> 0');
        return $query;
    }
}
