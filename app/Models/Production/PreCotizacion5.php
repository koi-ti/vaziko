<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Validator;

class PreCotizacion5 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_precotizacion5';

    public $timestamps = false;

    protected $fillable = ['precotizacion5_texto', 'precotizacion5_alto', 'precotizacion5_ancho'];

    public function isValid($data)
    {
        $rules = [
            'precotizacion5_texto' => 'required|max:150',
            'precotizacion5_alto' => 'required|max:10',
            'precotizacion5_ancho' => 'required|max:10',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPreCotizaciones5($precotizacion2 = null)
    {
        $query = PreCotizacion5::query();
        $query->where('precotizacion5_precotizacion2', $precotizacion2);
        return $query->get();
    }
}
