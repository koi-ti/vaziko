<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounting\PlanCuenta, App\Models\Accounting\SaldoContable;
use Validator, Excel;

class BalanceComparativoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->has('type') ){
            $validator = Validator::make($request->all(), [
                'filter_initial_month' => 'required',
                'filter_initial_year' => 'required',
                'filter_end_month' => 'required',
                'filter_end_year' => 'required'
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                return redirect('/rbalancecomparativo')
                    ->withErrors($validator)
                    ->withInput();
            }

            // $saldos = SaldoContable::whereBetween('saldoscontables_mes', [$request->filter_initial_month, $request->filter_end_month])
            //                         ->whereBetween('saldoscontables_ano', [$request->filter_initial_year, $request->filter_end_year])
            //                         ->whereBetween('plancuentas_cuenta', [1, 2])
            //                         ->join('koi_plancuentas', 'saldoscontables_cuenta', '=', 'koi_plancuentas.id')
            //                         ->get();

            // Preparar datos reporte
            // $title = "Reporte balance comparativo";
            // $type = $request->type;
            // $initialmonth = $request->filter_initial_month;
            // $endmonth = $request->filter_end_month;
            // $initialnamemonth = config('koi.meses')[$request->filter_initial_month];
            // $endnamemonth = config('koi.meses')[$request->filter_end_month];
            //
            // // Generate file
            // switch ($type) {
            //     case 'xls':
            //         Excel::create( sprintf('%s_%s', 'reporte_balance_comparativo', date('Y_m_d H_m_s') ), function($excel) use($initialmonth, $endmonth, $title, $type){
            //             for( $i = $initialmonth; $i <= $endmonth; $i++ ){
            //                 // $monthname = config('koi.meses')[$i];
            //                 //
            //                 // $excel->sheet('Excel', function($sheet) use ($mes, $ano, $nmes, $auxiliar, $title, $type, $unidad){
            //                 //     $sheet->loadView('reports.accounting.balancecomparativo.reporte', compact('mes','ano', 'nmes', 'auxiliar', 'title', 'type', 'unidad'));
            //                 //     $sheet->setWidth(array('A' => 20, 'B' => 70, 'C' => 2, 'G' => 2, 'L' => 2));
            //                 //     $sheet->setHeight(array(1 => 15, 2 => 15));
            //                 //     $sheet->setFontSize(8);
            //                 // });
            //             }
            //         })->download('xls');
            //     break;
            // }
        }
        return view('reports.accounting.balancecomparativo.index');
    }
}
