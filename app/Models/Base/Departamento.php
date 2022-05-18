<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_departamento';

    public $timestamps = false;
}
