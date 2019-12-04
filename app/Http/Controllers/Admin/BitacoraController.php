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
                $cotizacion = Cotizacion1::with('bitacora')->find($request->cotizacion);
                $data = $cotizacion->bitacora;
            }
            if ($request->has('ordenp')) {
                $ordenp = Ordenp::with('bitacora')->find($request->ordenp);
                $data = $ordenp->bitacora;
            }
            return response()->json($data);
        }
        abort(404);
    }
}
