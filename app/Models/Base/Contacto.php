<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Contacto extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_tcontacto';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tcontacto_nombres', 'tcontacto_apellidos', 'tcontacto_municipio', 'tcontacto_direccion', 'tcontacto_telefono', 'tcontacto_celular', 'tcontacto_email', 'tcontacto_cargo'];

    public function isValid($data)
    {
        $rules = [
            'tcontacto_nombres' => 'required|max:200',
            'tcontacto_apellidos' => 'required|max:200',
            'tcontacto_email' => 'max:200',
            'tcontacto_municipio' => 'required',
            'tcontacto_telefono' => 'required',
            'tcontacto_cargo' => 'max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
