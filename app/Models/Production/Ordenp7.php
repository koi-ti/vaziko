<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

class Ordenp7 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_ordenproduccion7';

    public $timestamps = false;

    public static function getOrdenesp7($ordenp2 = null)
    {
        $query = Ordenp7::query();
        $query->where('orden7_orden2', $ordenp2);
        return $query->get();
    }
}
