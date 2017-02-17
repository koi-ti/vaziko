<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Rol extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_rol';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description'];

    public function isValid($data)
    {
        $rules = [
            'name' => 'unique:koi_rol',
            'display_name' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
