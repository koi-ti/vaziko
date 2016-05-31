<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use Validator;

class PlanCuenta extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_plancuentas';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['plancuentas_cuenta', 'plancuentas_nivel', 'plancuentas_nombre', 'plancuentas_centro', 'plancuentas_naturaleza', 'plancuentas_tercero', 'plancuentas_tipo', 'plancuentas_tasa'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['plancuentas_tercero'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['plancuentas_centro'];


    public function isValid($data)
    {
        $rules = [
            'plancuentas_cuenta' => 'required|max:20|min:1|unique:koi_plancuentas',
            'plancuentas_nombre' => 'required|max:200',
            'plancuentas_naturaleza' => 'required',
            'plancuentas_tercero' => 'required',
            'plancuentas_tipo' => 'required'
        ];

        if ($this->exists){
            $rules['plancuentas_cuenta'] .= ',plancuentas_cuenta,' . $this->id;
        }else{
            $rules['plancuentas_cuenta'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getCuenta($id)
    {
        $query = PlanCuenta::query();
        $query->select('koi_plancuentas.*', 'centrocosto_nombre');
        $query->leftJoin('koi_centrocosto', 'koi_plancuentas.plancuentas_centro', '=', 'koi_centrocosto.id');
        $query->where('koi_plancuentas.id', $id);
        return $query->first();
    }

    public function setPlancuentasNombreAttribute($name)
    {
        $this->attributes['plancuentas_nombre'] = strtoupper($name);
    }
}
