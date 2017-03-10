<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class PermisoRol extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_permiso_rol';

	public $incrementing = false;

    public $timestamps = false;
}
