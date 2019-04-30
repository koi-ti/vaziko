<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp;
use DB;

class AgendaOrdenespController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            $recogida1 = Ordenp::select(DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2),' ',orden_referencia) as title, CONCAT(orden_fecha_recogida1,'T',orden_hora_recogida1) as start, (CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre, 'R1' as type, 0 as saldo"), 'koi_ordenproduccion.id as orden_id', 'orden_referencia', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_cliente', 'tercero_nit', 'orden_abierta', 'orden_anulada', 'orden_culminada', 'orden_fecha_recogida1', 'orden_hora_recogida1', 'orden_fecha_recogida2', 'orden_hora_recogida2')
                                ->whereBetween('orden_fecha_recogida1', [$request->start, $request->end])
                                ->where('orden_abierta', true)
                                ->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');

            $recogida2 = Ordenp::select(DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2),' ',orden_referencia) as title, CONCAT(orden_fecha_recogida2,'T',orden_hora_recogida2) as start, (CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre, 'R2' as type, 0 as saldo"), 'koi_ordenproduccion.id as orden_id', 'orden_referencia', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_cliente', 'tercero_nit', 'orden_abierta', 'orden_anulada', 'orden_culminada', 'orden_fecha_recogida1', 'orden_hora_recogida1', 'orden_fecha_recogida2', 'orden_hora_recogida2')
                                ->whereBetween('orden_fecha_recogida2', [$request->start, $request->end])
                                ->where('orden_abierta', true)
                                ->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');

            $ordenes = Ordenp::select(DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2),' ',orden_referencia) as title, CONCAT(orden_fecha_entrega,'T',orden_hora_entrega) as start, (CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre, CASE WHEN SUM(orden2_saldo) = 0 THEN 'RR' ELSE 'OR' END AS type, SUM(orden2_saldo) AS saldo"), 'koi_ordenproduccion.id as orden_id', 'orden_referencia', 'orden_fecha_entrega', 'orden_hora_entrega', 'orden_cliente', 'tercero_nit', 'orden_abierta', 'orden_anulada', 'orden_culminada', 'orden_fecha_recogida1', 'orden_hora_recogida1', 'orden_fecha_recogida2', 'orden_hora_recogida2')
                                ->whereBetween('orden_fecha_entrega', [$request->start, $request->end])
                                ->join('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id')
                                ->leftjoin('koi_ordenproduccion2', 'koi_ordenproduccion.id', '=', 'koi_ordenproduccion2.orden2_orden')
                                ->union($recogida1)
                                ->union($recogida2)
                                ->groupBy('orden_id')
                                ->get();

            return response()->json($ordenes);
        }

        $abiertas = Ordenp::query()->schedule()->abiertas()->pluck('total');
        $cerradas = Ordenp::query()->schedule()->cerradas()->pluck('total');
        $culminadas = Ordenp::query()->schedule()->culminadas()->pluck('total');

        // Prepare data getSchedul
        return view('production.agendaordenes.main', compact('abiertas', 'cerradas', 'culminadas'));
    }
}
