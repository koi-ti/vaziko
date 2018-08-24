<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Cache, Validator, DB;

class PlanCuentaNif extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_plancuentasn';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_plancuentasn';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['plancuentasn_cuenta', 'plancuentasn_nivel', 'plancuentasn_nombre', 'plancuentasn_naturaleza', 'plancuentasn_tipo', 'plancuentasn_tasa'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['plancuentasn_tercero'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['plancuentasn_centro'];


    public function isValid($data)
    {
        $rules = [
            'plancuentasn_cuenta' => 'required|max:20|min:1|unique:koi_plancuentasn',
            'plancuentasn_nombre' => 'required|max:200',
            'plancuentasn_naturaleza' => 'required',
            'plancuentasn_tercero' => 'required',
            'plancuentasn_tipo' => 'required'
        ];

        if ($this->exists){
            $rules['plancuentasn_cuenta'] .= ',plancuentasn_cuenta,' . $this->id;
        }else{
            $rules['plancuentasn_cuenta'] .= '|required';
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
        $niveles = self::getNivelesCuenta($data['plancuentasn_cuenta']);
        $error = 'La cuenta a crear no tiene un papa inmediatamente anterior.';
        switch ($data['plancuentasn_nivel']) {
            case 2:
                $padre = PlanCuentaNif::where('plancuentasn_nivel1', $niveles['nivel1'])->where('plancuentasn_nivel2', 0)->where('plancuentasn_nivel3', 0)->where('plancuentasn_nivel4', 0)->where('plancuentasn_nivel5', 0)->where('plancuentasn_nivel6', 0)->where('plancuentasn_nivel7', 0)->where('plancuentasn_nivel8', 0)->first();
                if(!$padre instanceof PlanCuentaNif) {
                    return $error;
                }
            break;

            case 3:
                $padre = PlanCuentaNif::where('plancuentasn_nivel1', $niveles['nivel1'])->where('plancuentasn_nivel2', $niveles['nivel2'])->where('plancuentasn_nivel3', 0)->where('plancuentasn_nivel4', 0)->where('plancuentasn_nivel5', 0)->where('plancuentasn_nivel6', 0)->where('plancuentasn_nivel7', 0)->where('plancuentasn_nivel8', 0)->first();
                if(!$padre instanceof PlanCuentaNif) {
                    return $error;
                }
            break;

            case 4:
                $padre = PlanCuentaNif::where('plancuentasn_nivel1', $niveles['nivel1'])->where('plancuentasn_nivel2', $niveles['nivel2'])->where('plancuentasn_nivel3', $niveles['nivel3'])->where('plancuentasn_nivel4', 0)->where('plancuentasn_nivel5', 0)->where('plancuentasn_nivel6', 0)->where('plancuentasn_nivel7', 0)->where('plancuentasn_nivel8', 0)->first();
                if(!$padre instanceof PlanCuentaNif) {
                    return $error;
                }
            break;

            case 5:
                $padre = PlanCuentaNif::where('plancuentasn_nivel1', $niveles['nivel1'])->where('plancuentasn_nivel2', $niveles['nivel2'])->where('plancuentasn_nivel3', $niveles['nivel3'])->where('plancuentasn_nivel4', $niveles['nivel4'])->where('plancuentasn_nivel5', 0)->where('plancuentasn_nivel6', 0)->where('plancuentasn_nivel7', 0)->where('plancuentasn_nivel8', 0)->first();
                if(!$padre instanceof PlanCuentaNif) {
                    return $error;
                }
            break;

            case 6:
                $padre = PlanCuentaNif::where('plancuentasn_nivel1', $niveles['nivel1'])->where('plancuentasn_nivel2', $niveles['nivel2'])->where('plancuentasn_nivel3', $niveles['nivel3'])->where('plancuentasn_nivel4', $niveles['nivel4'])->where('plancuentasn_nivel5', $niveles['nivel5'])->where('plancuentasn_nivel6', 0)->where('plancuentasn_nivel7', 0)->where('plancuentasn_nivel8', 0)->first();
                if(!$padre instanceof PlanCuentaNif) {
                    return $error;
                }
            break;

            case 7:
                $padre = PlanCuentaNif::where('plancuentasn_nivel1', $niveles['nivel1'])->where('plancuentasn_nivel2', $niveles['nivel2'])->where('plancuentasn_nivel3', $niveles['nivel3'])->where('plancuentasn_nivel4', $niveles['nivel4'])->where('plancuentasn_nivel5', $niveles['nivel5'])->where('plancuentasn_nivel6', $niveles['nivel6'])->where('plancuentasn_nivel7', 0)->where('plancuentasn_nivel8', 0)->first();
                if(!$padre instanceof PlanCuentaNif) {
                    return $error;
                }
            break;

            case 8:
                $padre = PlanCuentaNif::where('plancuentasn_nivel1', $niveles['nivel1'])->where('plancuentasn_nivel2', $niveles['nivel2'])->where('plancuentasn_nivel3', $niveles['nivel3'])->where('plancuentasn_nivel4', $niveles['nivel4'])->where('plancuentasn_nivel5', $niveles['nivel5'])->where('plancuentasn_nivel6', $niveles['nivel6'])->where('plancuentasn_nivel7', $niveles['nivel7'])->where('plancuentasn_nivel8', 0)->first();
                if(!$padre instanceof PlanCuentaNif) {
                    return $error;
                }
            break;
        }
        return 'OK';
    }

    /**
     * Funcion para verificar que no existan subniveles de la cuenta
     */
    public function validarSubnivelesCuenta()
    {
        $niveles = self::getNivelesCuenta($this->plancuentasn_cuenta);
        $nivel1 = $niveles['nivel1'];
        $nivel2 = $niveles['nivel2'];
        $nivel3 = $niveles['nivel3'];
        $nivel4 = $niveles['nivel4'];
        $nivel5 = $niveles['nivel5'];
        $nivel6 = $niveles['nivel6'];
        $nivel7 = $niveles['nivel7'];
        $nivel8 = $niveles['nivel8'];

        if($nivel1 == 0 || $nivel2 == 0 || $nivel3 == 0 || $nivel4 == 0 || $nivel5 == 0 || $nivel6 == 0 || $nivel7 == 0 || $nivel8 == 0) {

            $query = self::query();
            if($nivel1 != 0 && $nivel2 == 0 && $nivel3 == 0 && $nivel4 == 0 && $nivel5 == 0 && $nivel6 == 0 && $nivel7 == 0 && $nivel8 == 0) {
                $query->where('plancuentasn_nivel1', $nivel1);
                $query->where('plancuentasn_nivel2', '!=', 0);
            }else if($nivel1 != 0 && $nivel2 != 0 && $nivel3 == 0 && $nivel4 == 0 && $nivel5 == 0 && $nivel6 == 0 && $nivel7 == 0 && $nivel8 == 0) {
                $query->where('plancuentasn_nivel1', $nivel1);
                $query->where('plancuentasn_nivel2', $nivel2);
                $query->where('plancuentasn_nivel3', '!=', 0);
            }else if($nivel1 != 0 && $nivel2 != 0 && $nivel3 != 0 && $nivel4 == 0 && $nivel5 == 0 && $nivel6 == 0 && $nivel7 == 0 && $nivel8 == 0) {
                $query->where('plancuentasn_nivel1', $nivel1);
                $query->where('plancuentasn_nivel2', $nivel2);
                $query->where('plancuentasn_nivel3', $nivel3);
                $query->where('plancuentasn_nivel4', '!=', 0);
            }else if($nivel1 != 0 && $nivel2 != 0 && $nivel3 != 0 && $nivel4 != 0 && $nivel5 == 0 && $nivel6 == 0 && $nivel7 == 0 && $nivel8 == 0) {
                $query->where('plancuentasn_nivel1', $nivel1);
                $query->where('plancuentasn_nivel2', $nivel2);
                $query->where('plancuentasn_nivel3', $nivel3);
                $query->where('plancuentasn_nivel4', $nivel4);
                $query->where('plancuentasn_nivel5', '!=', 0);
            }else if($nivel1 != 0 && $nivel2 != 0 && $nivel3 != 0 && $nivel4 != 0 && $nivel5 != 0 && $nivel6 == 0 && $nivel7 == 0 && $nivel8 == 0) {
                $query->where('plancuentasn_nivel1', $nivel1);
                $query->where('plancuentasn_nivel2', $nivel2);
                $query->where('plancuentasn_nivel3', $nivel3);
                $query->where('plancuentasn_nivel4', $nivel4);
                $query->where('plancuentasn_nivel5', $nivel5);
                $query->where('plancuentasn_nivel6', '!=', 0);
            }else if($nivel1 != 0 && $nivel2 != 0 && $nivel3 != 0 && $nivel4 != 0 && $nivel5 != 0 && $nivel6 != 0 && $nivel7 == 0 && $nivel8 == 0) {
                $query->where('plancuentasn_nivel1', $nivel1);
                $query->where('plancuentasn_nivel2', $nivel2);
                $query->where('plancuentasn_nivel3', $nivel3);
                $query->where('plancuentasn_nivel4', $nivel4);
                $query->where('plancuentasn_nivel5', $nivel5);
                $query->where('plancuentasn_nivel6', $nivel6);
                $query->where('plancuentasn_nivel7', '!=', 0);
            }else if($nivel1 != 0 && $nivel2 != 0 && $nivel3 != 0 && $nivel4 != 0 && $nivel5 != 0 && $nivel6 != 0 && $nivel7 != 0 && $nivel8 == 0) {
                $query->where('plancuentasn_nivel1', $nivel1);
                $query->where('plancuentasn_nivel2', $nivel2);
                $query->where('plancuentasn_nivel3', $nivel3);
                $query->where('plancuentasn_nivel4', $nivel4);
                $query->where('plancuentasn_nivel5', $nivel5);
                $query->where('plancuentasn_nivel6', $nivel6);
                $query->where('plancuentasn_nivel7', $nivel7);
                $query->where('plancuentasn_nivel8', '!=', 0);
            }else{
                return "No se puede determinar el metodo de revision cuentas inferiores {$objCuenta->plancuentasn_cuenta} - Consulte al administrador";
            }
            $objSubCuenta = $query->first();

            if($objSubCuenta instanceof PlanCuentaNif){
                return "Senor usuario usted no puede realizar asientos con la cuenta {$this->plancuentasn_cuenta} debido  a que existe una subcuenta {$objSubCuenta->plancuentasn_cuenta}";
            }
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
     */
    public function setNivelesCuenta()
    {
        $niveles = self::getNivelesCuenta($this->plancuentasn_cuenta);
        if(!is_array($niveles)){
          return false;
        }

        $this->plancuentasn_nivel1 = $niveles['nivel1'];
        $this->plancuentasn_nivel2 = $niveles['nivel2'];
        $this->plancuentasn_nivel3 = $niveles['nivel3'];
        $this->plancuentasn_nivel4 = $niveles['nivel4'];
        $this->plancuentasn_nivel5 = $niveles['nivel5'];
        $this->plancuentasn_nivel6 = $niveles['nivel6'];
        $this->plancuentasn_nivel7 = $niveles['nivel7'];
        $this->plancuentasn_nivel8 = $niveles['nivel8'];

        return true;
    }

    /**
     * Funcion para recuperar cuentas a mayorizar, se realiza hasta nivel 8
     */
    public function getMayorizarCuentas()
    {
        $niveles = self::getNivelesCuenta($this->plancuentasn_cuenta);
        if(!is_array($niveles)) {
            return "Error al recuperar niveles para la cuenta {$this->plancuentasn_cuenta}.";
        }

        $cuentas = [];
        if(isset($niveles['nivel8']) && intval($niveles['nivel8'])) {
            $cuentas = [
                1 => $this->plancuentasn_cuenta,
                2 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}{$niveles['nivel5']}{$niveles['nivel6']}{$niveles['nivel7']}",
                3 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}{$niveles['nivel5']}{$niveles['nivel6']}",
                4 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}{$niveles['nivel5']}",
                5 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}",
                6 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}",
                7 => "{$niveles['nivel1']}{$niveles['nivel2']}",
                8 => "{$niveles['nivel1']}"
            ];

        }else if(isset($niveles['nivel7']) && intval($niveles['nivel7']) && !intval($niveles['nivel8'])) {
            $cuentas = [
                1 => $this->plancuentasn_cuenta,
                2 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}{$niveles['nivel5']}{$niveles['nivel6']}",
                3 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}{$niveles['nivel5']}",
                4 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}",
                5 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}",
                6 => "{$niveles['nivel1']}{$niveles['nivel2']}",
                7 => "{$niveles['nivel1']}"
            ];

        }else if(isset($niveles['nivel6']) && intval($niveles['nivel6']) && !intval($niveles['nivel7'])) {
            $cuentas = [
                1 => $this->plancuentasn_cuenta,
                2 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}{$niveles['nivel5']}",
                3 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}",
                4 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}",
                5 => "{$niveles['nivel1']}{$niveles['nivel2']}",
                6 => "{$niveles['nivel1']}"
            ];

        }else if(isset($niveles['nivel5']) && intval($niveles['nivel5']) && !intval($niveles['nivel6'])) {
            $cuentas = [
                1 => $this->plancuentasn_cuenta,
                2 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}{$niveles['nivel4']}",
                3 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}",
                4 => "{$niveles['nivel1']}{$niveles['nivel2']}",
                5 => "{$niveles['nivel1']}"
            ];

        }else if(isset($niveles['nivel4']) && intval($niveles['nivel4']) && !intval($niveles['nivel5'])) {
            $cuentas = [
                1 => $this->plancuentasn_cuenta,
                2 => "{$niveles['nivel1']}{$niveles['nivel2']}{$niveles['nivel3']}",
                3 => "{$niveles['nivel1']}{$niveles['nivel2']}",
                4 => "{$niveles['nivel1']}"
            ];

        }else if(isset($niveles['nivel3']) && intval($niveles['nivel3']) && !intval($niveles['nivel4'])) {
            $cuentas = [
                1 => $this->plancuentasn_cuenta,
                2 => "{$niveles['nivel1']}{$niveles['nivel2']}",
                3 => "{$niveles['nivel1']}"
            ];

        }else if(isset($niveles['nivel2']) && intval($niveles['nivel2']) && !intval($niveles['nivel3'])) {
            $cuentas = [
                1 => $this->plancuentasn_cuenta,
                2 => "{$niveles['nivel1']}"
            ];

        }else if(isset($niveles['nivel1']) && intval($niveles['nivel1']) && !intval($niveles['nivel2'])) {
            $cuentas = [
                1 => $this->plancuentasn_cuenta
            ];
        }
        return $cuentas;
    }

    public static function getCuenta($id)
    {
        $query = PlanCuentaNif::query();
        $query->select('koi_plancuentasn.*', 'centrocosto_nombre');
        $query->leftJoin('koi_centrocosto', 'koi_plancuentasn.plancuentasn_centro', '=', 'koi_centrocosto.id');
        $query->where('koi_plancuentasn.id', $id);
        return $query->first();
    }

    public function setPlancuentasNombreAttribute($name)
    {
        $this->attributes['plancuentasn_nombre'] = strtoupper($name);
    }

    public static function getPlanCuentas()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = PlanCuentaNif::query();
            $query->select('id', DB::raw("CONCAT(plancuentasn_cuenta, ' - ' ,plancuentasn_nombre) AS cuenta" ) );
            $collection = $query->lists('cuenta', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
