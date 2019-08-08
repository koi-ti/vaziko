<?php

namespace App\Http\Controllers\Treasury;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Treasury\Facturap2;

class FacturapCuotasController extends Controller
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
            if ($request->has('facturap1')) {
                $query = Facturap2::query();
                $query->where('facturap2_factura', $request->facturap1);
                $data = $query->get();
            }
            return response()->json($data);
        }
        abort(404);
    }
}
