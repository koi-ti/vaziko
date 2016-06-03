<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_empresa';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['empresa_niif', 'empresa_cc_contador', 'empresa_tj_contador', 'empresa_nm_contador', 'empresa_cc_revisor', 'empresa_tj_revisor', 'empresa_nm_revisor'];

    public static function getEmpresa()
    {
    	$query = Empresa::query();
        $query->select('koi_empresa.*', 'tercero_nit', 'tercero_digito', 'tercero_regimen', 'tercero_tipo', 'tercero_persona', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', 'tercero_direccion', 'tercero_municipio', 'tercero_email', 'tercero_telefono1', 'tercero_telefono2', 'tercero_fax', 'tercero_celular', 'tercero_actividad', 'tercero_cc_representante', 'tercero_representante', 'tercero_responsable_iva', 'tercero_autoretenedor_cree', 'actividad_tarifa', 'tercero_gran_contribuyente', 'tercero_autoretenedor_renta', 'tercero_autoretenedor_ica');
		$query->join('koi_tercero', 'empresa_tercero', '=', 'koi_tercero.id');
		$query->leftJoin('koi_municipio', 'tercero_municipio', '=', 'koi_municipio.id');
		$query->leftJoin('koi_actividad', 'tercero_actividad', '=', 'koi_actividad.id');

    	return $query->first();
    }

    public function setEmpresaNmContadorAttribute($name)
    {
        $this->attributes['empresa_nm_contador'] = strtoupper($name);
    }

    public function setEmpresaNmRevisorAttribute($name)
    {
        $this->attributes['empresa_nm_revisor'] = strtoupper($name);
    }
}  