<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion3;

class Cotizacion3Controller extends Controller
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
            if ($request->has('cotizacion2')) {
                $data = Cotizacion3::getCotizaciones3($request->producto, $request->cotizacion2);
            }
            return response()->json($data);
        }
        abort(404);
    }
}
