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
            // Validar cuenta
            $valid = $this->validarTienePadre($data);
            if($valid != 'OK') {
                $this->errors = $valid;
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function validarTienePadre(Array $data)
    {
        // Recuperamos niveles cuenta
        $niveles = self::getNivelesCuenta($data['plancuentas_cuenta']);
        $error = 'La cuenta a crear no tiene un papa inmediatamente anterior.';
        switch ($data['plancuentas_nivel']) {
            case 2:
                $padre = PlanCuenta::where('plancuentas_nivel1', $niveles['nivel1'])->where('plancuentas_nivel2', 0)->where('plancuentas_nivel3', 0)->where('plancuentas_nivel4', 0)->where('plancuentas_nivel5', 0)->where('plancuentas_nivel6', 0)->where('plancuentas_nivel7', 0)->where('plancuentas_nivel8', 0)->first();
                if(!$padre instanceof PlanCuenta) {  
                    return $error;
                }
            break;

            case 3:
                $padre = PlanCuenta::where('plancuentas_nivel1', $niveles['nivel1'])->where('plancuentas_nivel2', $niveles['nivel2'])->where('plancuentas_nivel3', 0)->where('plancuentas_nivel4', 0)->where('plancuentas_nivel5', 0)->where('plancuentas_nivel6', 0)->where('plancuentas_nivel7', 0)->where('plancuentas_nivel8', 0)->first();
                if(!$padre instanceof PlanCuenta) {  
                    return $error;
                }
            break;

            case 4:
                $padre = PlanCuenta::where('plancuentas_nivel1', $niveles['nivel1'])->where('plancuentas_nivel2', $niveles['nivel2'])->where('plancuentas_nivel3', $niveles['nivel3'])->where('plancuentas_nivel4', 0)->where('plancuentas_nivel5', 0)->where('plancuentas_nivel6', 0)->where('plancuentas_nivel7', 0)->where('plancuentas_nivel8', 0)->first();
                if(!$padre instanceof PlanCuenta) {  
                    return $error;
                }
            break;

            case 5:
                $padre = PlanCuenta::where('plancuentas_nivel1', $niveles['nivel1'])->where('plancuentas_nivel2', $niveles['nivel2'])->where('plancuentas_nivel3', $niveles['nivel3'])->where('plancuentas_nivel4', $niveles['nivel4'])->where('plancuentas_nivel5', 0)->where('plancuentas_nivel6', 0)->where('plancuentas_nivel7', 0)->where('plancuentas_nivel8', 0)->first();
                if(!$padre instanceof PlanCuenta) {  
                    return $error;
                }
            break;

            case 6:
                $padre = PlanCuenta::where('plancuentas_nivel1', $niveles['nivel1'])->where('plancuentas_nivel2', $niveles['nivel2'])->where('plancuentas_nivel3', $niveles['nivel3'])->where('plancuentas_nivel4', $niveles['nivel4'])->where('plancuentas_nivel5', $niveles['nivel5'])->where('plancuentas_nivel6', 0)->where('plancuentas_nivel7', 0)->where('plancuentas_nivel8', 0)->first();
                if(!$padre instanceof PlanCuenta) {  
                    return $error;
                }
            break;

            case 7:
                $padre = PlanCuenta::where('plancuentas_nivel1', $niveles['nivel1'])->where('plancuentas_nivel2', $niveles['nivel2'])->where('plancuentas_nivel3', $niveles['nivel3'])->where('plancuentas_nivel4', $niveles['nivel4'])->where('plancuentas_nivel5', $niveles['nivel5'])->where('plancuentas_nivel6', $niveles['nivel6'])->where('plancuentas_nivel7', 0)->where('plancuentas_nivel8', 0)->first();
                if(!$padre instanceof PlanCuenta) {  
                    return $error;
                }
            break;

            case 8:
                $padre = PlanCuenta::where('plancuentas_nivel1', $niveles['nivel1'])->where('plancuentas_nivel2', $niveles['nivel2'])->where('plancuentas_nivel3', $niveles['nivel3'])->where('plancuentas_nivel4', $niveles['nivel4'])->where('plancuentas_nivel5', $niveles['nivel5'])->where('plancuentas_nivel6', $niveles['nivel6'])->where('plancuentas_nivel7', $niveles['nivel7'])->where('plancuentas_nivel8', 0)->first();
                if(!$padre instanceof PlanCuenta) {  
                    return $error;
                }
            break;
        }
        return 'OK';
    }

    /**
     * Funcion para recuperar los niveles de una cuenta, el seteo se realiza hasta el nivel 8
     *
     * @var array cta
     */
    public static function getNivelesCuenta($cta = NULL)
    {
        $nivel1 = substr($cta,0,1);
        $nivel2 = substr($cta,1,1);
        $nivel3 = substr($cta,2,2);
        $nivel4 = substr($cta,4,2);
        $nivel5 = substr($cta,6,2);
        $nivel6 = substr($cta,8,3);
        $nivel7 = substr($cta,11,2);
        $nivel8 = substr($cta,13,2);

        $array['nivel1'] = $nivel1;
        $array['nivel2'] = $nivel2;
        $array['nivel3'] = $nivel3;
        $array['nivel4'] = $nivel4;
        $array['nivel5'] = $nivel5;
        $array['nivel6'] = $nivel6;
        $array['nivel7'] = $nivel7;
        $array['nivel8'] = $nivel8;

        return $array;
    }

    /**
     * Funcion para setear los niveles de una cuenta, el seteo se realiza hasta el nivel 8
     *
     * @var array cta
     */
    public function setNivelesCuenta()
    {
        $niveles = self::getNivelesCuenta($this->plancuentas_cuenta);
        if(!is_array($niveles)){
          return false;
        }

        $this->plancuentas_nivel1 = $niveles['nivel1'];
        $this->plancuentas_nivel2 = $niveles['nivel2'];
        $this->plancuentas_nivel3 = $niveles['nivel3'];
        $this->plancuentas_nivel4 = $niveles['nivel4'];
        $this->plancuentas_nivel5 = $niveles['nivel5'];
        $this->plancuentas_nivel6 = $niveles['nivel6'];
        $this->plancuentas_nivel7 = $niveles['nivel7'];
        $this->plancuentas_nivel8 = $niveles['nivel8'];
        
        return true;
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