<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Factura3 extends Model
{
/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_factura3';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'factura3_observaciones' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
