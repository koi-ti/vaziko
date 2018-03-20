<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use Validator;

class ReporteTiempop extends Model
{
    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'fecha_inicial' => 'required',
            'fecha_final' => 'required',
            'tiempop_tercero' => 'required',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            // Validar fecha inicial no puede ser mayor a la final
            if( $data['fecha_final'] < $data['fecha_inicial'] ){
                $this->errors = "La fecha de inicio no puede ser mayor a la fecha final.";
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
