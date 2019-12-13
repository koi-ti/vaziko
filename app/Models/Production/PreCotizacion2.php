<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use DB, Storage;

class PreCotizacion2 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion2';

    public $timestamps = false;

    public static function getPreCotizacion2($precotizacion2) {
        $query = self::query();
        $query->select('koi_precotizacion2.*');
        $query->producto();
        $query->where('koi_precotizacion2.id', $precotizacion2);
        return $query->first();
    }

    public static function getPreCotizaciones2($precotizacion = null) {
        $query = self::query();
        $query->select('koi_precotizacion2.id as id', 'precotizacion2_precotizacion1','precotizacion2_cantidad', 'precotizacion1_ano', 'precotizacion1_numero', 'precotizacion1_abierta', 'precotizacion1_culminada',
            DB::raw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"),
            DB::raw("CASE WHEN precotizacion2_tiro != 0 THEN (precotizacion2_yellow + precotizacion2_magenta + precotizacion2_cyan + precotizacion2_key + precotizacion2_color1 + precotizacion2_color2) ELSE '0' END AS tiro"),
            DB::raw("CASE WHEN precotizacion2_retiro != 0 THEN (precotizacion2_yellow2 + precotizacion2_magenta2 + precotizacion2_cyan2 + precotizacion2_key2 + precotizacion2_color12 + precotizacion2_color22) ELSE '0' END AS retiro"));
        $query->producto();
        $query->join('koi_precotizacion1', 'precotizacion2_precotizacion1', '=', 'koi_precotizacion1.id');
        if ($precotizacion) {
            $query->where('precotizacion2_precotizacion1', $precotizacion);
            return $query->get();
        } else {
            return $query;
        }
    }

    public function scopeProducto ($query) {
        return $query->addSelect(DB::raw("
                            CASE WHEN productop_3d != 0 THEN CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(precotizacion2_referencia,'') ,') 3D(',
                                    COALESCE(precotizacion2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                                    COALESCE(precotizacion2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                                    COALESCE(precotizacion2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                            WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(precotizacion2_referencia,'') ,') A(',
                                    COALESCE(precotizacion2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                    COALESCE(precotizacion2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                                    COALESCE(precotizacion2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                    COALESCE(precotizacion2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                            WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(precotizacion2_referencia,'') ,') A(',
                                    COALESCE(precotizacion2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                    COALESCE(precotizacion2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                            WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(precotizacion2_referencia,'') ,') C(',
                                    COALESCE(precotizacion2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                    COALESCE(precotizacion2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                            ELSE CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(precotizacion2_referencia,'') ,')' )
                            END AS productop_nombre"))
                        ->join('koi_productop', 'precotizacion2_productop', '=', 'koi_productop.id')
                        ->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id')
                        ->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id')
                        ->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id')
                        ->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id')
                        ->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id')
                        ->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id')
                        ->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
    }

    public function crear ($cotizacion) {
        $cotizacion2 = new Cotizacion2;
        $cotizacion2->cotizacion2_cotizacion = $cotizacion;
        $cotizacion2->cotizacion2_productop = $this->precotizacion2_productop;
        $cotizacion2->cotizacion2_observaciones = $this->precotizacion2_observaciones;
        $cotizacion2->cotizacion2_cantidad = $this->precotizacion2_cantidad;
        $cotizacion2->cotizacion2_saldo = $this->precotizacion2_cantidad;
        $cotizacion2->cotizacion2_referencia = $this->precotizacion2_referencia;
        $cotizacion2->cotizacion2_tiro = $this->precotizacion2_tiro;
        $cotizacion2->cotizacion2_retiro = $this->precotizacion2_retiro;
        $cotizacion2->cotizacion2_yellow = $this->precotizacion2_yellow;
        $cotizacion2->cotizacion2_magenta = $this->precotizacion2_magenta;
        $cotizacion2->cotizacion2_cyan = $this->precotizacion2_cyan;
        $cotizacion2->cotizacion2_key = $this->precotizacion2_key;
        $cotizacion2->cotizacion2_color1 = $this->precotizacion2_color1;
        $cotizacion2->cotizacion2_color2 = $this->precotizacion2_color2;
        $cotizacion2->cotizacion2_nota_tiro = $this->precotizacion2_nota_tiro;
        $cotizacion2->cotizacion2_yellow2 = $this->precotizacion2_yellow2;
        $cotizacion2->cotizacion2_magenta2 = $this->precotizacion2_magenta2;
        $cotizacion2->cotizacion2_cyan2 = $this->precotizacion2_cyan2;
        $cotizacion2->cotizacion2_key2 = $this->precotizacion2_key2;
        $cotizacion2->cotizacion2_color12 = $this->precotizacion2_color12;
        $cotizacion2->cotizacion2_color22 = $this->precotizacion2_color22;
        $cotizacion2->cotizacion2_nota_retiro = $this->precotizacion2_nota_retiro;
        $cotizacion2->cotizacion2_ancho = $this->precotizacion2_ancho;
        $cotizacion2->cotizacion2_alto = $this->precotizacion2_alto;
        $cotizacion2->cotizacion2_c_ancho = $this->precotizacion2_c_ancho;
        $cotizacion2->cotizacion2_c_alto = $this->precotizacion2_c_alto;
        $cotizacion2->cotizacion2_3d_ancho = $this->precotizacion2_3d_ancho;
        $cotizacion2->cotizacion2_3d_alto = $this->precotizacion2_3d_alto;
        $cotizacion2->cotizacion2_3d_profundidad = $this->precotizacion2_3d_profundidad;
        $cotizacion2->cotizacion2_margen_materialp = 30;
        $cotizacion2->cotizacion2_margen_areap = 30;
        $cotizacion2->cotizacion2_margen_empaque = 30;
        $cotizacion2->cotizacion2_margen_transporte = 30;
        $cotizacion2->cotizacion2_fecha_elaboro = date('Y-m-d H:i:s');
        $cotizacion2->cotizacion2_usuario_elaboro = auth()->user()->id;
        $cotizacion2->save();

        // Recuperar Acabados de cotizacion para generar cotizacion
        $acabados = PreCotizacion7::where('precotizacion7_precotizacion2', $this->id)->get();
        foreach ($acabados as $acabado) {
             $cotizacion5 = new Cotizacion5;
             $cotizacion5->cotizacion5_acabadop = $acabado->precotizacion7_acabadop;
             $cotizacion5->cotizacion5_cotizacion2 = $cotizacion2->id;
             $cotizacion5->save();
        }

        // Recuperar Maquinas de cotizacion para generar cotizacion
        $maquinas = PreCotizacion8::where('precotizacion8_precotizacion2', $this->id)->get();
        foreach ($maquinas as $maquina) {
             $cotizacion3 = new Cotizacion3;
             $cotizacion3->cotizacion3_maquinap = $maquina->precotizacion8_maquinap;
             $cotizacion3->cotizacion3_cotizacion2 = $cotizacion2->id;
             $cotizacion3->save();
        }

        // Recuperar Imagenes de pre-cotizacion para generar cotizacion
        $imagenes = PreCotizacion4::where('precotizacion4_precotizacion2', $this->id)->get();
        foreach ($imagenes as $imagen) {
            $cotizacion8 = new Cotizacion8;
            $cotizacion8->cotizacion8_cotizacion2 = $cotizacion2->id;
            $cotizacion8->cotizacion8_archivo = $imagen->precotizacion4_archivo;
            $cotizacion8->cotizacion8_fh_elaboro = date('Y-m-d H:i:s');
            $cotizacion8->cotizacion8_usuario_elaboro = auth()->user()->id;
            $cotizacion8->save();

            // Recuperar imagen y copiar
            if (Storage::has("pre-cotizaciones/precotizacion_{$this->precotizacion2_precotizacion1}/producto_{$imagen->precotizacion4_precotizacion2}/{$imagen->precotizacion4_archivo}")) {
                $oldfile = "pre-cotizaciones/precotizacion_{$this->precotizacion2_precotizacion1}/producto_{$imagen->precotizacion4_precotizacion2}/{$imagen->precotizacion4_archivo}";
                $newfile = "cotizaciones/cotizacion_{$cotizacion2->cotizacion2_cotizacion}/producto_{$cotizacion8->cotizacion8_cotizacion2}/{$cotizacion8->cotizacion8_archivo}";

                // Copy file storege laravel
                Storage::copy($oldfile, $newfile);
            }
        }

        // Recuperar Materiales de pre-cotizacion para generar cotizacion
        $totalmaterialesp  = $totalareasp = $totalempaques = $totaltransportes = 0;
        $materiales = PreCotizacion3::where('precotizacion3_precotizacion2', $this->id)->get();
        foreach ($materiales as $material) {
             $cotizacion4 = new Cotizacion4;
             $cotizacion4->cotizacion4_cotizacion2 = $cotizacion2->id;
             $cotizacion4->cotizacion4_materialp = $material->precotizacion3_materialp;
             $cotizacion4->cotizacion4_producto = $material->precotizacion3_producto;
             $cotizacion4->cotizacion4_medidas = $material->precotizacion3_medidas;
             $cotizacion4->cotizacion4_cantidad = $material->precotizacion3_cantidad;
             $cotizacion4->cotizacion4_valor_unitario = $material->precotizacion3_valor_unitario;
             $cotizacion4->cotizacion4_valor_total = $material->precotizacion3_valor_total;
             $cotizacion4->cotizacion4_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion4->cotizacion4_usuario_elaboro = auth()->user()->id;
             $cotizacion4->save();

             $totalmaterialesp += $material->precotizacion3_valor_total;
        }

        // Recuperar Areasp de cotizacion para generar precotizacion
        $areasp = PreCotizacion6::select('koi_precotizacion6.*', DB::raw("((SUBSTRING_INDEX(precotizacion6_tiempo, ':', -1) / 60) + SUBSTRING_INDEX(precotizacion6_tiempo, ':', 1)) * precotizacion6_valor as total_areap"))->where('precotizacion6_precotizacion2', $this->id)->get();
        foreach ($areasp as $area) {
             $cotizacion6 = new Cotizacion6;
             $cotizacion6->cotizacion6_cotizacion2 = $cotizacion2->id;
             $cotizacion6->cotizacion6_areap = $area->precotizacion6_areap;
             $cotizacion6->cotizacion6_nombre = $area->precotizacion6_nombre;
             $cotizacion6->cotizacion6_tiempo = $area->precotizacion6_tiempo;
             $cotizacion6->cotizacion6_valor = $area->precotizacion6_valor;
             $cotizacion6->save();

             $totalareasp += $area->total_areap;
        }

        // Recuperar Empaques de pre-cotizacion para generar cotizacion
        $empaques = PreCotizacion9::where('precotizacion9_precotizacion2', $this->id)->get();
        foreach ($empaques as $empaque) {
             $cotizacion9 = new Cotizacion9;
             $cotizacion9->cotizacion9_cotizacion2 = $cotizacion2->id;
             $cotizacion9->cotizacion9_materialp = $empaque->precotizacion9_materialp;
             $cotizacion9->cotizacion9_producto = $empaque->precotizacion9_producto;
             $cotizacion9->cotizacion9_medidas = $empaque->precotizacion9_medidas;
             $cotizacion9->cotizacion9_cantidad = $empaque->precotizacion9_cantidad;
             $cotizacion9->cotizacion9_valor_unitario = $empaque->precotizacion9_valor_unitario;
             $cotizacion9->cotizacion9_valor_total = $empaque->precotizacion9_valor_total;
             $cotizacion9->cotizacion9_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion9->cotizacion9_usuario_elaboro = auth()->user()->id;
             $cotizacion9->save();

             $totalempaques += $empaque->precotizacion9_valor_total;
        }

        // Recuperar Transportes de pre-cotizacion para generar cotizacion
        $transportes = PreCotizacion10::where('precotizacion10_precotizacion2', $this->id)->get();
        foreach ($transportes as $transporte) {
             $cotizacion10 = new Cotizacion10;
             $cotizacion10->cotizacion10_cotizacion2 = $cotizacion2->id;
             $cotizacion10->cotizacion10_materialp = $transporte->precotizacion10_materialp;
             $cotizacion10->cotizacion10_producto = $transporte->precotizacion10_producto;
             $cotizacion10->cotizacion10_medidas = $transporte->precotizacion10_medidas;
             $cotizacion10->cotizacion10_cantidad = $transporte->precotizacion10_cantidad;
             $cotizacion10->cotizacion10_valor_unitario = $transporte->precotizacion10_valor_unitario;
             $cotizacion10->cotizacion10_valor_total = $transporte->precotizacion10_valor_total;
             $cotizacion10->cotizacion10_fh_elaboro = date('Y-m-d H:i:s');
             $cotizacion10->cotizacion10_usuario_elaboro = auth()->user()->id;
             $cotizacion10->save();

             $totaltransportes += $transporte->precotizacion10_valor_total;
        }

        // Actualizar precio en cotizacion2;
        $materiales = round(($totalmaterialesp/$this->precotizacion2_cantidad)/((100-30)/100));
        $areasp = round($totalareasp/$this->precotizacion2_cantidad)/((100-30)/100);
        $empaques = round(($totalempaques/$this->precotizacion2_cantidad)/((100-30)/100));
        $transportes = round(($totaltransportes/$this->precotizacion2_cantidad)/((100-30)/100));
        $subtotal = $materiales + $areasp + $empaques + $transportes;
        $comision = ($subtotal/((100-0)/100)) * (1-(((100-0)/100)));

        $cotizacion2->cotizacion2_total_valor_unitario = round($subtotal+$comision);
        $cotizacion2->save();

        return $cotizacion2;
    }
}
