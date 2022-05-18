<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion9;

class PreCotizacion9Controller extends Controller
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
            if ($request->has('precotizacion2')) {
                $data = PreCotizacion9::getPreCotizaciones9($request->precotizacion2);
            }
            return response()->json($data);
        }
        abort(404);
    }
}
