<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion3;

class PreCotizacion3Controller extends Controller
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
                $data = PreCotizacion3::getPreCotizaciones3($request->precotizacion2);
            }
            return response()->json($data);
        }
        abort(404);
    }
}
