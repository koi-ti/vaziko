<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Productop6 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_productop6';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'productop6_productop' => 'required|integer',
            'productop6_acabadop' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
