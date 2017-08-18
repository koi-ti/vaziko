<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use DB;

class DespachoCotizacion2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_despachocotizacion2';

    public $timestamps = false;

    public static function getDespacho2($despacho)
    {
        $query = DespachoCotizacion2::query();
        $query->select('koi_despachocotizacion2.*',
        	DB::raw("
                CASE
                WHEN productop_3d != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,') 3D(',
                        COALESCE(cotizacion2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                        COALESCE(cotizacion2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                        COALESCE(cotizacion2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,') A(',
                        COALESCE(cotizacion2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                        COALESCE(cotizacion2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                        COALESCE(cotizacion2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                        COALESCE(cotizacion2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,') A(',
                        COALESCE(cotizacion2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                        COALESCE(cotizacion2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN
                        CONCAT(
                        COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,') C(',
                        COALESCE(cotizacion2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                        COALESCE(cotizacion2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                ELSE
                        CONCAT(
                            COALESCE(productop_nombre,'') ,' (', COALESCE(cotizacion2_referencia,'') ,')' )
                END AS productop_nombre
            ")
        );
        $query->join('koi_cotizacion2', 'despachoc2_cotizacion2', '=', 'koi_cotizacion2.id');
        $query->join('koi_productop', 'cotizacion2_productop', '=', 'koi_productop.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->where('despachoc2_despacho', $despacho);
        return $query->get();
    }
}
