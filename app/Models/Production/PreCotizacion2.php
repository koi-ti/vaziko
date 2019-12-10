<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Validator, DB;

class PreCotizacion2 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion2';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'precotizacion2_cantidad', 'precotizacion2_referencia', 'precotizacion2_observaciones', 'precotizacion2_ancho', 'precotizacion2_alto', 'precotizacion2_c_ancho', 'precotizacion2_c_alto', 'precotizacion2_3d_ancho', 'precotizacion2_3d_alto', 'precotizacion2_3d_profundidad', 'precotizacion2_nota_tiro', 'precotizacion2_nota_retiro'
    ];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = [
        'precotizacion2_tiro', 'precotizacion2_retiro', 'precotizacion2_yellow', 'precotizacion2_magenta', 'precotizacion2_cyan', 'precotizacion2_key', 'precotizacion2_color1', 'precotizacion2_color2', 'precotizacion2_yellow2', 'precotizacion2_magenta2', 'precotizacion2_cyan2', 'precotizacion2_key2', 'precotizacion2_color12', 'precotizacion2_color22'
    ];

    public function isValid($data) {
        $rules = [
            'precotizacion2_referencia' => 'required',
            'precotizacion2_cantidad' => 'required|min:1|integer'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            // Validar Carritos
            $materialesp = isset($data['materialesp']) ? $data['materialesp'] : null;
            if (!isset($materialesp) || $materialesp == null || !is_array($materialesp) || count($materialesp) == 0) {
                $this->errors = 'Por favor ingrese materiales para el producto.';
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPreCotizacion2($precotizacion2) {
        $query = self::query();
        $query->select('koi_precotizacion2.*',
                    DB::raw("CASE WHEN productop_3d != 0 THEN CONCAT(
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
                            END AS productop_nombre"));
        $query->join('koi_productop', 'precotizacion2_productop', '=', 'koi_productop.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->where('koi_precotizacion2.id', $precotizacion2);
        return $query->first();
    }

    public static function getPreCotizaciones2($precotizacion = null) {
        $query = self::query();
        $query->select('koi_precotizacion2.id as id', 'precotizacion2_precotizacion1','precotizacion2_cantidad', 'precotizacion1_ano', 'precotizacion1_numero', 'precotizacion1_abierta', 'precotizacion1_culminada',
            DB::raw("CONCAT(precotizacion1_numero,'-',SUBSTRING(precotizacion1_ano, -2)) as precotizacion_codigo"),
            DB::raw("CASE WHEN precotizacion2_tiro != 0 THEN ( precotizacion2_yellow + precotizacion2_magenta + precotizacion2_cyan + precotizacion2_key + precotizacion2_color1 + precotizacion2_color2) ELSE '0' END AS tiro"),
            DB::raw("CASE WHEN precotizacion2_retiro != 0 THEN ( precotizacion2_yellow2 + precotizacion2_magenta2 + precotizacion2_cyan2 + precotizacion2_key2 + precotizacion2_color12 + precotizacion2_color22) ELSE '0' END AS retiro"),
            DB::raw("CASE WHEN productop_3d != 0 THEN CONCAT(
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
                        ELSE CONCAT( COALESCE(productop_nombre,'') ,' (', COALESCE(precotizacion2_referencia,'') ,')' )
                        END AS productop_nombre"));
        $query->join('koi_productop', 'precotizacion2_productop', '=', 'koi_productop.id');
        $query->join('koi_precotizacion1', 'precotizacion2_precotizacion1', '=', 'koi_precotizacion1.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        if ($precotizacion) {
            $query->where('precotizacion2_precotizacion1', $precotizacion);
            return $query->get();
        } else {
            return $query;
        }
    }
}
