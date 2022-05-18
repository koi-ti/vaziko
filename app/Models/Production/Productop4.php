<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Productop4 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_productop4';

    public $timestamps = false;

    public function isValid($data) {
        $rules = [
            'productop4_productop' => 'required|integer',
            'productop4_maquinap' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
