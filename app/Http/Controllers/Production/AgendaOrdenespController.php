<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp, App\Models\Production\Cotizacion1;
use DB, Excel;

class AgendaOrdenespController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('role:admin', ['only' => 'exportar']);
    }

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

        $schedule = new \stdClass();
        if (auth()->user()->hasRole('admin')) {
            $schedule->op_abiertas = number_format(Ordenp::query()->schedule()->abiertas()->pluck('total'),2,',','.');
            $schedule->op_recogidas = number_format(Ordenp::query()->schedule()->abiertas()->recogidas()->pluck('total'),2,',','.');
            $schedule->op_incumplidas = number_format(Ordenp::query()->schedule()->abiertas()->incumplidas()->pluck('total'),2,',','.');
            $schedule->op_remisionadas = number_format(Ordenp::query()->schedule()->abiertas()->remisionadas()->pluck('total'),2,',','.');
            $schedule->co_abiertas = number_format(Cotizacion1::query()->schedule()->abiertas()->pluck('total'),2,',','.');
        } else {
            $schedule->op_abiertas = '-';
            $schedule->op_recogidas = '-';
            $schedule->op_incumplidas = '-';
            $schedule->op_remisionadas = '-';
            $schedule->co_abiertas = '-';
        }

        // Prepare data getSchedul
        return view('production.agendaordenes.main', compact('schedule'));
    }

    public function exportar(Request $request)
    {
        $abiertas = Ordenp::query()->orden()->abiertas()->get();
        $remisionadas = Ordenp::query()->orden('R')->abiertas()->get();
        $recogidas = Ordenp::query()->orden()->abiertas()->recogidas()->get();
        $incumplidas = Ordenp::query()->orden()->abiertas()->incumplidas()->get();

        Excel::create(sprintf('%s_%s', 'agendaordenes', date('Y_m_d_H_i_s')), function ($excel) use ($abiertas, $remisionadas, $recogidas, $incumplidas) {
            $excel->sheet('Abiertas', function ($sheet) use ($abiertas) {
                $sheet->loadView('production.agendaordenes.reporte.abiertas', compact('abiertas'));
            });
            $excel->sheet('Remisionadas', function ($sheet) use ($remisionadas) {
                $sheet->loadView('production.agendaordenes.reporte.remisionadas', compact('remisionadas'));
            });
            $excel->sheet('Recogidas', function ($sheet) use ($recogidas) {
                $sheet->loadView('production.agendaordenes.reporte.recogidas', compact('recogidas'));
            });
            $excel->sheet('Incumplidas', function ($sheet) use ($incumplidas) {
                $sheet->loadView('production.agendaordenes.reporte.incumplidas', compact('incumplidas'));
            });
            $excel->setActiveSheetIndex(0);
        })->download('xlsx');
    }
}
