<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Folders extends Model
{

    protected $table = 'koi_folder';

    public $timestamps = false;

    public static function getFolder()
    {
        $query = folder::query();
        $query =select('koi_folder.*');
        return $query->first();
    }
}

    /**
     * The database table used by the model.
     *
     * @var string
     */