<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

use Validator;

class Documento extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_documento';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['documento_codigo', 'documento_nombre', 'documento_folder', 'documento_tipo_consecutivo'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['documento_nif', 'documento_actual'];

    public function isValid($data)
    {
        $rules = [
            'documento_codigo' => 'required|max:20|min:1|unique:koi_documento',
            'documento_nombre' => 'required|max:200',
            'documento_folder' => 'required',
            'documento_tipo_consecutivo' => 'required|max:1'
        ];

        if ($this->exists){
            $rules['documento_codigo'] .= ',documento_codigo,' . $this->id;
        }else{
            $rules['documento_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getDocument($id)
    {
        $query = Documento::query();
        $query->select('koi_documento.*', 'folder_nombre');
        $query->leftJoin('koi_folder', 'documento_folder', '=', 'koi_folder.id');
        $query->where('koi_documento.id', $id);
        return $query->first();
    }

    public static function getDocuments()
    {
        // if (Cache::has('_documents')) {
        //     return Cache::get('_documents');
        // }

        // return Cache::rememberForever('_documents', function() {
            $query = Documento::query();
            $query->orderby('documento_nombre', 'asc');
            $collection = $query->lists('documento_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        // });
    }
}
