<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Folder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_folder';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'folder_codigo', 'folder_nombre'
    ];

    public function isValid($data) {
        $rules = [
            'folder_codigo' => 'required|max:4|min:1|unique:koi_folder',
            'folder_nombre' => 'required|max:50'
        ];

        if ($this->exists) {
            $rules['folder_codigo'] .= ",folder_codigo,{$this->id}";
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getFolders() {
        // if (Cache::has('_folders')) {
        //     return Cache::get('_folders');
        // }

        // return Cache::rememberForever('_folders', function() {
            $query = Folder::query();
            $query->orderby('folder_nombre', 'asc');
            $collection = $query->lists('folder_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        // });
    }
}
