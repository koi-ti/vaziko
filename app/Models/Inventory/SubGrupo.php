<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

use Validator;

class SubGrupo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_subgrupo';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subgrupo_codigo', 'subgrupo_nombre'];

    public function isValid($data)
    {
        $rules = [
            'subgrupo_codigo' => 'required|max:4|min:1|unique:koi_subgrupo',
            'subgrupo_nombre' => 'required|max:50'
        ];

        if ($this->exists){
            $rules['subgrupo_codigo'] .= ',subgrupo_codigo,' . $this->id;
        }else{
            $rules['subgrupo_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
