<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Validator;

class UsuarioRol extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_usuario_rol';

    public $timestamps = false;

    
    public function isValid($data)
    {
        $rules = [
            'display_name' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
