<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ProductoHistorial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_productohistorial';

    public $timestamps = false;
}
