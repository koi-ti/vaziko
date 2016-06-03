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

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['asiento2_cuenta', 'asiento2_beneficiario', 'asiento2_beneficiario'];

    public function isValid($data)
    {
        $rules = [
            'asiento2_cuenta' => 'required|integer',
            'asiento2_beneficiario_nit' => 'required|integer',
            'asiento2_naturaleza' => 'required',
            'asiento2_valor' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
