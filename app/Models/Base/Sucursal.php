<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Sucursal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_sucursal';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sucursal_nombre'];

    public function isValid($data)
    {
        $rules = [
            'sucursal_nombre' => 'required|max:100|unique:koi_sucursal'
        ];

        if ($this->exists){
            $rules['sucursal_nombre'] .= ',sucursal_nombre,' . $this->id;
        }else{
            $rules['sucursal_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
