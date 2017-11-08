<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class TiempoOrdenp extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_tiempoordenp';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tiempoordenp_fecha', 'tiempoordenp_hora_inicio', 'tiempoordenp_hora_fin'];

    public function isValid($data)
    {
        $rules = [
            'tiempoordenp_fecha' => 'required|date_format:Y-m-d',
            'tiempoordenp_hora_inicio' => 'required|date_format:H:m',
            'tiempoordenp_hora_fin' => 'required|date_format:H:m',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
