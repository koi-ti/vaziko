<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Auth, DB;

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
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['cotizacion2_tiro', 'cotizacion2_retiro', 'cotizacion2_yellow', 'cotizacion2_magenta', 'cotizacion2_cyan', 'cotizacion2_key', 'cotizacion2_color1', 'cotizacion2_color2', 'cotizacion2_yellow2', 'cotizacion2_magenta2', 'cotizacion2_cyan2', 'cotizacion2_key2', 'cotizacion2_color12', 'cotizacion2_color22'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cotizacion2_referencia', 'cotizacion2_precio_formula', 'cotizacion2_round_formula', 'cotizacion2_precio_venta', 'cotizacion2_observaciones', 'cotizacion2_ancho', 'cotizacion2_alto', 'cotizacion2_c_ancho', 'cotizacion2_c_alto', 'cotizacion2_3d_ancho', 'cotizacion2_3d_alto', 'cotizacion2_3d_profundidad', 'cotizacion2_nota_tiro', 'cotizacion2_nota_retiro'];

    public function isValid($data)
    {
        $rules = [
            'cotizacion2_referencia' => 'required|max:200',
            'cotizacion2_cantidad' => 'required|min:1|integer',
            'cotizacion2_round_formula' => 'integer',
            'cotizacion2_precio_venta' => 'required',
            'cotizacion2_ancho' => 'numeric|min:0',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function calcString($mathString)
    {
   	 	$cf_DoCalc = @create_function("", "return (" . $mathString . ");" );
        return $cf_DoCalc();
    }

    public static function getCotizaciones2( $cotizacion )
    {
        $query = Cotizacion2::query();
        $query->select('koi_cotizacion2.id as id', 'cotizacion2_cotizacion','cotizacion2_cantidad', 'cotizacion2_saldo', 'cotizacion2_facturado',
            ( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) ? 'cotizacion2_precio_venta' : DB::raw('0 as cotizacion2_precio_venta') ),
            ( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) ? DB::raw('(cotizacion2_cantidad * cotizacion2_precio_venta) as cotizacion2_precio_total') : DB::raw('0 as cotizacion2_precio_total') ),

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
        $query->join('koi_productop', 'cotizacion2_productop', '=', 'koi_productop.id');
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

    public static function getCotizacion2( $cotizacion2 )
    {
        $query = Cotizacion2::query();
        $query->select('koi_cotizacion2.*',
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
        $query->join('koi_productop', 'cotizacion2_productop', '=', 'koi_productop.id');
        $query->leftJoin('koi_unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
        $query->leftJoin('koi_unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
        $query->leftJoin('koi_unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
        $query->leftJoin('koi_unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
        $query->leftJoin('koi_unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
        $query->leftJoin('koi_unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
        $query->leftJoin('koi_unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');
        $query->where('koi_cotizacion2.id', $cotizacion2);
        return $query->first();
    }
}
