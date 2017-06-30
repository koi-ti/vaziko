<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Cotizacion1 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion1';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'cotizacion1_numero' => 'required|integer',
            'cotizacion1_ano' => 'required|integer',
            'cotizacion1_fecha' => 'required',
            'cotizacion1_entrega' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {

            // // Validar Carritos
            // $cotizacion2 = isset($data['cotizacion2']) ? $data['cotizacion2'] : null;
            // if(!isset($cotizacion2) || $cotizacion2 == null || !is_array($cotizacion2) || count($cotizacion2) == 0) {
            //     $this->errors = 'Por favor ingrese toda la informacion del detalle.';
            //     return false;
            // }

            // $cotizacion3 = isset($data['cotizacion3']) ? $data['cotizacion3'] : null;
            // if(!isset($cotizacion3) || $cotizacion3 == null || !is_array($cotizacion3) || count($cotizacion3) == 0) {
            //     $this->errors = 'Por favor ingrese toda la informacion del detalle.';
            //     return false;
            // }

            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
