<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion8;

class PreCotizacion8Controller extends Controller
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
                $data = PreCotizacion8::getPreCotizaciones8($request->producto, $request->precotizacion2);
            }
            return response()->json($data);
        }
        abort(404);
    }
}
