<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Empresa;
use Validator, DB;

class AsientoNif extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_asienton1';

    public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asienton1_mes', 'asienton1_ano', 'asienton1_dia', 'asienton1_folder', 'asienton1_documento', 'asienton1_numero', 'asienton1_detalle', 'asienton1_documentos', 'asienton1_id_documentos'
    ];

    public function isValid($data) {
        $rules = [
            'asienton1_mes' => 'required|integer',
            'asienton1_ano' => 'required|integer',
            'asienton1_dia' => 'required|integer',
            'asienton1_numero' => 'required|integer',
            'asienton1_folder' => 'required|integer',
            'asienton1_documento' => 'required|integer',
            'asienton1_beneficiario' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            // // Validar mes || año en curso
            // if ( $data['asienton1_ano'] == date('Y') && (date('n') < $data['asienton1_mes'])) {
            //     $this->errors = "La fecha no puede ser mayor al mes en curso";
            //     return false;
            // }
            // Armo fecha del asiento
            $fecha_asienton = "{$data['asienton1_ano']}-{$data['asienton1_mes']}-{$data['asienton1_dia']}";

            // Recuperar empresa
            $empresa = Empresa::select('empresa_fecha_cierre_contabilidad as fecha_cierre')->first();
            if (!$empresa instanceof Empresa) {
                $this->errors = 'No es posible definir fecha para el asiento contable';
                return false;
            }
            // Validar contra fecha de cierre
            if (strtotime($fecha_asienton) <= strtotime($empresa->fecha_cierre)) {
                $this->errors = "La fecha que intenta realizar el asiento: $fecha_asienton no esta PERMITIDA. Es menor a la del cierre contable : $empresa->fecha_cierre";
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getAsientoNif($id) {
        $query = AsientoNif::query();
        $query->select('koi_asienton1.*', 'folder_nombre', 'documento_nombre', 't.tercero_nit', 'documento_tipo_consecutivo', DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2) ELSE t.tercero_razonsocial END) as tercero_nombre"), 'u.username as username_elaboro');
        $query->join('koi_tercero as t', 'asienton1_beneficiario', '=', 't.id');
        $query->join('koi_tercero as u', 'asienton1_usuario_elaboro', '=', 'u.id');
        $query->join('koi_documento', 'asienton1_documento', '=', 'koi_documento.id');
        $query->join('koi_folder', 'asienton1_folder', '=', 'koi_folder.id');
        $query->where('koi_asienton1.id', $id);
        // dd($query->first());
        return $query->first();
    }

    public function setAsiento1DetalleAttribute($detail) {
        $this->attributes['asienton1_detalle'] = strtoupper($detail);
    }

    /**
    * Traer detalles del asienton.
    */
    public function detalle() {
        return $this->hasMany('App\Models\Accounting\AsientoNif2', 'asienton2_asiento', 'id');
    }
}
