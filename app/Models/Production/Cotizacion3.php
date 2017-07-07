<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Cotizacion3 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion3';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cotizacion3_horas', 'cotizacion3_valor', 'cotizacion3_nombre'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['cotizacion3_areap'];

    public function isValid($data)
    {
        $rules = [
            'cotizacion3_horas' => 'required|integer',
            'cotizacion3_valor' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
