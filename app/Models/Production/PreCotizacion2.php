<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator;

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
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['precotizacion2_tiro', 'precotizacion2_retiro', 'precotizacion2_yellow', 'precotizacion2_magenta', 'precotizacion2_cyan', 'precotizacion2_key', 'precotizacion2_color1', 'precotizacion2_color2', 'precotizacion2_yellow2', 'precotizacion2_magenta2', 'precotizacion2_cyan2', 'precotizacion2_key2', 'precotizacion2_color12', 'precotizacion2_color22'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['precotizacion2_cantidad', 'precotizacion2_observaciones', 'precotizacion2_ancho', 'precotizacion2_alto', 'precotizacion2_c_ancho', 'precotizacion2_c_alto', 'precotizacion2_3d_ancho', 'precotizacion2_3d_alto', 'precotizacion2_3d_profundidad', 'precotizacion2_nota_tiro', 'precotizacion2_nota_retiro'];

    public function isValid($data)
    {
        $rules = [
            'precotizacion2_cantidad' => 'required|min:1|integer',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {

            // Validar Carritos
            $impresiones = isset($data['impresiones']) ? $data['impresiones'] : null;
            if(!isset($impresiones) || $impresiones == null || !is_array($impresiones) || count($impresiones) == 0) {
                $this->errors = 'Por favor ingrese impresiones para el producto.';
                return false;
            }

            $materialesp = isset($data['materialesp']) ? $data['materialesp'] : null;
            if(!isset($materialesp) || $materialesp == null || !is_array($materialesp) || count($materialesp) == 0) {
                $this->errors = 'Por favor ingrese materiales para el producto.';
                return false;
            }

            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPreCotizacion2( $precotizacion2 )
    {
        $query = PreCotizacion2::query();
        $query->select('koi_precotizacion2.*', 'productop_nombre');
        $query->join('koi_productop', 'precotizacion2_productop', '=', 'koi_productop.id');
        $query->where('koi_precotizacion2.id', $precotizacion2);
        return $query->first();
    }

    public static function getPreCotizaciones2( $precotizacion )
    {
        $query = PreCotizacion2::query();
        $query->select('koi_precotizacion2.*', 'productop_nombre');
        $query->join('koi_productop', 'precotizacion2_productop', '=', 'koi_productop.id');
        $query->where('precotizacion2_precotizacion1', $precotizacion);
        return $query->get();
    }
}
