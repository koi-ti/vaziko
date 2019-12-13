<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion5;

class Cotizacion5Controller extends Controller
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
                $data = Cotizacion5::getCotizaciones5($request->producto, $request->cotizacion2);
            }
            return response()->json($data);
        }
        abort(404);
    }
}
