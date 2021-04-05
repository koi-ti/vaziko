<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class SaldoTercero extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_saldosterceros';

    public $timestamps = false;

    public function tercero ()
    {
        return $this->hasOne('App\Models\Base\Tercero', 'id', 'saldosterceros_tercero');
    }
}
