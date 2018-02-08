<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Validator;
class ReglaAsiento extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'koi_regla_asiento';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'factura_numero' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
