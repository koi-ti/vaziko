<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_permiso';

    public $timestamps = false;
}
