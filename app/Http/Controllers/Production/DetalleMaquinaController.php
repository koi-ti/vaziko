<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp3;

class DetalleMaquinaController extends Controller
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
            if ($request->has('orden2')) {
                $data = Ordenp3::getOrdenesp3($request->producto, $request->orden2);
            }
            return response()->json($data);
        }
        abort(404);
    }
}
