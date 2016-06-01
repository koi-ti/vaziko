<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_folder';

    public $timestamps = false;

    public static function getFolders()
    {
        // if (Cache::has('_folders')) {
        //     return Cache::get('_folders');    
        // }

        // return Cache::rememberForever('_folders', function() {
            $query = Folder::query();
            $query->orderby('folder_nombre', 'asc');
            $collection = $query->lists('folder_nombre', 'id');
            return $collection;
        // });
    }
}
