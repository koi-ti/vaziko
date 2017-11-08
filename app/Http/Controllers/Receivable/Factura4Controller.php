<?php

namespace App\Http\Controllers\Receivable;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Receivable\Factura4, App\Models\Base\Tercero;
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
        if($request->ajax()){
            $facturadas = [];

            $query = Factura4::query();
            if ($request->has('tercero')) {
                // Pestaña Cartera tercero
                $tercero = Tercero::find($request->tercero);
                if(!$tercero instanceof Tercero){
                    return response()->json(['success' => false, 'errors' => 'No se pudo recuperar el cliente, por favor verifique la informacion o consulte al administrador']);
                }
                $query->select('koi_factura4.*', 'factura1_fecha','factura1_puntoventa','puntoventa_prefijo','factura1_tercero', 'koi_factura1.id as factura1_numero', DB::raw("DATEDIFF(factura4_vencimiento, NOW() ) as days"));
                $query->join('koi_factura1', 'factura4_factura1', '=', 'koi_factura1.id');
                $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');
                $query->where('factura1_tercero', $tercero->id);
                $query->where('factura4_saldo', '<>',  0);
                $query->orderBy('factura4_vencimiento', 'desc');
                $facturadas = $query->get();
            }

            if($request->has('factura1_id')){
                $query->select('koi_factura4.*', 'koi_factura1.factura1_fecha');
                $query->join('koi_factura1', 'factura4_factura1', '=', 'koi_factura1.id');
                $query->join('koi_puntoventa', 'factura1_puntoventa', '=', 'koi_puntoventa.id');
                $query->where('factura4_saldo', '<>',  0);
                $query->where('factura4_factura1', $request->factura1_id);
                $facturadas = $query->get();
            }

        }
        return response()->json($facturadas);
    }
}
