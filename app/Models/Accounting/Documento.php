<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_documento';

    public $timestamps = false;

    public static function getDocument($id)
    {
        $query = Documento::query();
        $query->select('koi_documento.*', 'folder_nombre');
        $query->leftJoin('koi_folder', 'documento_folder', '=', 'koi_folder.id');
        $query->where('koi_documento.id', $id);
        return $query->first();
    }
}
