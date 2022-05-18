<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Traslado1 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_traslado1';

    public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'traslado1_sucursal', 'traslado1_destino', 'traslado1_fecha', 'traslado1_observaciones'
    ];

    public function isValid($data) {
        $rules = [
            'traslado1_sucursal' => 'required|integer',
            'traslado1_destino' => 'required|integer',
            'traslado1_numero' => 'required|integer',
            'traslado1_fecha' => 'required|date_format:Y-m-d'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
			// Validar Carrito
			$detalle = isset($data['detalle']) ? $data['detalle'] : null;
			if (!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese detalle para el tralado.';
                return false;
            }

            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTraslado($id) {
        $query = Traslado1::query();
        $query->select('koi_traslado1.*', 'o.sucursal_nombre as origen', 'd.sucursal_nombre as destino', 'u.username as username_elaboro');
        $query->join('koi_sucursal as o', 'traslado1_sucursal', '=', 'o.id');
        $query->join('koi_sucursal as d', 'traslado1_destino', '=', 'd.id');
        $query->join('koi_tercero as u', 'traslado1_usuario_elaboro', '=', 'u.id');
        $query->where('koi_traslado1.id', $id);
        return $query->first();
    }

    public function setTraslado1ObservacionesAttribute($observaciones) {
        $this->attributes['traslado1_observaciones'] = strtoupper($observaciones);
    }
}
