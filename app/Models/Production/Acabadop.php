<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Acabadop extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_acabadop';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['acabadop_nombre', 'acabadop_descripcion'];

    public function isValid($data)
    {
        $rules = [
            'acabadop_nombre' => 'required|max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function setAcabadopDescripcionAttribute($descripcion)
    {
        $this->attributes['acabadop_descripcion'] = strtoupper($descripcion);
    }
}
