<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Ordenp4, App\Models\Production\PreCotizacion9, App\Models\Production\Cotizacion9, App\Models\Production\Ordenp9;
use DB;

class ProductoHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $detalle = [];
        if ($request->ajax()) {
            if ($request->has('call')) {
                if ($request->call == 'materialp') {
                    $unioinpre = PreCotizacion3::select('id', 'precotizacion3_valor_unitario as valor', 'precotizacion3_fh_elaboro as fecha', DB::raw("'PRE' as type"))->where('precotizacion3_producto', $request->producto_id)->limit(10)->orderBy('id', 'desc');

                    $unioncot = Cotizacion4::select('id', 'cotizacion4_valor_unitario as valor', 'cotizacion4_fh_elaboro as fecha', DB::raw("'COT' as type"))->where('cotizacion4_producto', $request->producto_id)->limit(10)->orderBy('id', 'desc');

                    $detalle = Ordenp4::select('id', 'orden4_valor_unitario as valor', 'orden4_fh_elaboro as fecha', DB::raw("'ORD' as type"))->where('orden4_producto', $request->producto_id)->limit(10)->union($unioinpre)->union($unioncot)->orderBy('fecha', 'asc')->get();
                } else {
                    $unioinpre = PreCotizacion9::select('id', 'precotizacion9_valor_unitario as valor', 'precotizacion9_fh_elaboro as fecha', DB::raw("'PRE' as type"))->where('precotizacion9_producto', $request->producto_id)->limit(10)->orderBy('id', 'desc');

                    $unioncot = Cotizacion9::select('id', 'cotizacion9_valor_unitario as valor', 'cotizacion9_fh_elaboro as fecha', DB::raw("'COT' as type"))->where('cotizacion9_producto', $request->producto_id)->limit(10)->orderBy('id', 'desc');

                    $detalle = Ordenp9::select('id', 'orden9_valor_unitario as valor', 'orden9_fh_elaboro as fecha', DB::raw("'ORD' as type"))->where('orden9_producto', $request->producto_id)->limit(10)->union($unioinpre)->union($unioncot)->orderBy('fecha', 'asc')->get();
                }
            }
            return response()->json($detalle);
        }
        return response()->json($detalle);
    }
}
