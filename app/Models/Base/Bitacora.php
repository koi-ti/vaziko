<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_bitacora';

    public $timestamps = false;
}
