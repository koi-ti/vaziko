<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accounting\Asiento2, App\Models\Accounting\AsientoMovimiento;
use DB;

class AsientoMovimientoController extends Controller
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
            if ($request->has('asiento2')) {
                // Recuperar detalle del asiento
                $asiento2 = Asiento2::find($request->asiento2);
                if ($asiento2 instanceof Asiento2) {
                    // Si el detalle es nuevo
                    $data = AsientoMovimiento::getMovements($asiento2);
                }
            }
            return response()->json($data);
        }
    }
}
