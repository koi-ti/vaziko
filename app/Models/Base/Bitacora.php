<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_bitacora';

    public $timestamps = false;

    public static function createBitacora($morph, $original = [], $changes, $module, $action) {
        if (is_array($changes)) {
            $cambios = '';
            foreach ($changes as $key => $value) {
                if ($original[$key] != $value) {
                    $name = ucfirst(explode('_', $key)[1]);
                    $cambios .= "{$name}: '{$original[$key]}' a '$value' \r\n";
                }
            }
        } else {
            $cambios = $changes;
        }

        if ($cambios) {
            $bitacora = new self;
            $bitacora->bitacora_accion = $action;
            $bitacora->bitacora_usuario_elaboro = auth()->user()->id;
            $bitacora->bitacora_fh_elaboro = date('Y-m-d H:i:s');
            $bitacora->bitacora_modulo = $module;
            $bitacora->bitacora_cambios = $cambios;

            $morph->bitacora()->save($bitacora);
        }
    }

    public function bitacora () {
        return $this->morphTo();
    }

    public function tercero () {
        return $this->hasOne('App\Models\Base\Tercero', 'id', 'bitacora_usuario_elaboro');
    }
}
