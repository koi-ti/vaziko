<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

use Validator, DB;

class Asiento extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_asiento1';

    public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['asiento1_mes', 'asiento1_ano', 'asiento1_dia', 'asiento1_folder', 'asiento1_documento', 'asiento1_numero', 'asiento1_detalle'];

    public function isValid($data)
    {
        $rules = [
            'asiento1_mes' => 'required|integer',
            'asiento1_ano' => 'required|integer',
            'asiento1_dia' => 'required|integer',
            'asiento1_numero' => 'required|integer',
            'asiento1_folder' => 'required|integer',
            'asiento1_documento' => 'required|integer',
            'asiento1_beneficiario' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getAsiento($id)
    {
        $query = Asiento::query();
        $query->select('koi_asiento1.*', 'folder_nombre', 'documento_nombre', 'tercero_nit', 'documento_tipo_consecutivo', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre"));
        $query->join('koi_tercero', 'asiento1_beneficiario', '=', 'koi_tercero.id');
        $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
        $query->join('koi_folder', 'asiento1_folder', '=', 'koi_folder.id');
        $query->where('koi_asiento1.id', $id);
        return $query->first();
    }

    public function setAsiento1DetalleAttribute($detail)
    {
        $this->attributes['asiento1_detalle'] = strtoupper($detail);
    }
}
