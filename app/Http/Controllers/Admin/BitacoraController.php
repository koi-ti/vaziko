<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion1, App\Models\Production\Ordenp;

class BitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('cotizacion')) {
                $cotizacion = Cotizacion1::with(['bitacora' => function ($bitacora) {
                    $bitacora->informacion();
                }])->find($request->cotizacion);
                $data = $cotizacion->bitacora;
            }
            if ($request->has('ordenp')) {
                $ordenp = Ordenp::with(['bitacora' => function ($bitacora) use ($request) {
                    if ($request->has('estado')) {
                        $bitacora->where('bitacora_modulo', 'Estados');
                    } else {
                        $bitacora->where('bitacora_modulo', '!=', 'Estados');
                    }
                    $bitacora->informacion();
                }])->find($request->ordenp);
                $data = $ordenp->bitacora;
            }
            return response()->json($data);
        }
        abort(404);
    }
}
