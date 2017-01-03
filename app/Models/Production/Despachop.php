<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Despachop extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_despachop1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['despachop1_observacion', 'despachop1_transporte'];

    public function isValid($data)
    {
        $rules = [
            'despachop1_contacto' => 'required|integer',
            'despachop1_orden' => 'required|integer',
            'despachop1_telefono' => 'required',
            'despachop1_nombre' => 'required',
            'despachop1_transporte' => 'max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}