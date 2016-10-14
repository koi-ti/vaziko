<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Grupo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_grupo';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['grupo_codigo', 'grupo_nombre'];

    public function isValid($data)
    {
        $rules = [
            'grupo_codigo' => 'required|max:4|min:1|unique:koi_grupo',
            'grupo_nombre' => 'required|max:50'
        ];

        if ($this->exists){
            $rules['grupo_codigo'] .= ',grupo_codigo,' . $this->id;
        }else{
            $rules['grupo_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
