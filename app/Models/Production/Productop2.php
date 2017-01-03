<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Productop2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_productop2';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['productop2_tip'];

    public function isValid($data)
    {
        $rules = [
            'productop2_productop' => 'required|integer',
            'productop2_tip' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function setProductop2TipAttribute($tip)
    {
        $this->attributes['productop2_tip'] = strtoupper($tip);
    }
}
