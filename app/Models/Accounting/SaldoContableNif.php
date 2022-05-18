<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class SaldoContableNif extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_saldoscontablesn';

    public $timestamps = false;
}
