<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use Validator, DB;

class CentroCosto extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_centrocosto';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['centrocosto_centro', 'centrocosto_codigo', 'centrocosto_nombre', 'centrocosto_tipo', 'centrocosto_descripcion1', 'centrocosto_descripcion2', 'centrocosto_estructura'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['centrocosto_activo'];

    public function isValid($data)
    {
        $rules = [
            'centrocosto_codigo' => 'required|max:4|min:1|unique_with:koi_centrocosto,centrocosto_centro',
            'centrocosto_centro' => 'required|max:20',
            'centrocosto_nombre' => 'required|max:200',
            'centrocosto_tipo' => 'required|max:1',
            'centrocosto_descripcion1' => 'max:200',
            'centrocosto_descripcion2' => 'max:200'
        ];

        if ($this->exists){
            $rules['centrocosto_codigo'] .= ',centrocosto_codigo,' . $this->id;
        }else{
            $rules['centrocosto_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function setCentrocostoCodigoAttribute($code)
    {
        $this->attributes['centrocosto_codigo'] = strtoupper($code);
    }

    public function setCentrocostoNombreAttribute($name)
    {
        $this->attributes['centrocosto_nombre'] = strtoupper($name);
    }

    public static function getCentrosCosto($centrocosto_estructura = null)
    {
        $query = CentroCosto::query();
        $query->select('id', DB::raw("CONCAT(centrocosto_codigo, centrocosto_centro, ' - ', centrocosto_nombre) as centrocosto_nombre"));
        $query->orderby('centrocosto_nombre', 'asc');
        
        if($centrocosto_estructura != null){
            $query->where('centrocosto_estructura', $centrocosto_estructura);
        }

        $collection = $query->lists('centrocosto_nombre', 'id');

        $collection->prepend('', '');
        return $collection;
    }
}
