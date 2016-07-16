<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Asiento2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_asiento2';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'plancuentas_cuenta' => 'required|integer',
            'tercero_nit' => 'required|integer',
            'asiento2_naturaleza' => 'required'        
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
