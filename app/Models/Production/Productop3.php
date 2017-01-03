<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Productop3 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_productop3';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'productop3_productop' => 'required|integer',
            'productop3_areap' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
