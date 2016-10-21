<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Traslado2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_traslado2';

    public $timestamps = false;

 	public function isValid($data)
    {
        $rules = [
            'producto_codigo' => 'required',
            'traslado2_cantidad' => 'required'
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
