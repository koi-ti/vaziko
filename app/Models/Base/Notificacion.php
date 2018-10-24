<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Tercero;

class Notificacion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_notificaciones';

    public $timestamps = false;

    public static function nuevaNotificacion($tercero, $title, $descripcion, $fh) {
        // Recupero instancia de Tercero(Auth::user)
        $tercero = Tercero::find($tercero);
        if(!$tercero instanceof Tercero) {
            return 'No es posible recuperar tercero, verifique información ó por favor consulte al administrador.';
        }

        // Create new notificacion
        $notificacion = new Notificacion;
        $notificacion->notificacion_tercero = $tercero->id;
        $notificacion->notificacion_fh = $fh;
        $notificacion->notificacion_descripcion = $descripcion;
        $notificacion->notificacion_titulo = $title;
        $notificacion->save();
    }
}
