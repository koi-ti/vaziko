<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

class Cotizacion7 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion7';

    public $timestamps = false;

    public static function getCotizaciones7($cotizacion2 = null)
    {
        $query = Cotizacion7::query();
        $query->where('cotizacion7_cotizacion2', $cotizacion2);
        return $query->get();
    }
}
