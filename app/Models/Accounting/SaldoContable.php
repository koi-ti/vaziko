<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class SaldoContable extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_saldoscontables';

    public $timestamps = false;
}
