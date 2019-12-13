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

    public function crear ($cotizacion) {
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
}
