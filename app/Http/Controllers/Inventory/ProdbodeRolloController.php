<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\ProdbodeRollo;

class ProdbodeRolloController extends Controller
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
            if ($request->has('producto') && $request->has('sucursal')) {
                $query = ProdbodeRollo::query();
                $query->where('prodboderollo_producto', $request->producto);
                $query->where('prodboderollo_sucursal', $request->sucursal);
                $query->whereRaw('prodboderollo_saldo > 0');
                $data = $query->get();
            }
            return response()->json($data);
        }
        abort(404);
    }
}
