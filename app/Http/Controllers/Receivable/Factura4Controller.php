<?php

namespace App\Http\Controllers\Receivable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receivable\Factura4;
use DB;

class Factura4Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Factura4::query();
            $query->select('koi_factura4.*', 'factura1_numero', 'factura1_fecha');
            $query->join('koi_factura1', 'factura4_factura1', '=', 'koi_factura1.id');
            $query->where('factura4_saldo', '<>',  0);
            $query->orderBy('factura4_vencimiento', 'desc');

            if ($request->has('tercero_id')) {
                // Pestaña Cartera tercero
                $query->addSelect('puntoventa_prefijo', DB::raw("DATEDIFF(factura4_vencimiento, NOW() ) as days"));
                $query->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id');
                $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');
                $query->where('factura1_tercero', $request->tercero_id);
            }

            if ($request->has('factura')) {
                $query->where('factura4_factura1', $request->factura);
            }

            return response()->json($query->get());
        }
    }
}
