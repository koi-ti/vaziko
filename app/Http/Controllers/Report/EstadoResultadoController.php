<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Excel, DB;

class EstadoResultadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            $validator = Validator::make($request->all(), [
                'filter_initial_month' => 'required',
                'filter_initial_year' => 'required',
                'filter_end_month' => 'required',
                'filter_end_year' => 'required'
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                session()->flash('errors', $validator->errors()->all());
                return redirect('/restadoresultado')->withInput();
            }

            // Reference var
            $xmes = $request->filter_initial_month;
            $xano = $request->filter_initial_year;

            $saldos = DB::table('koi_saldoscontables')
                        ->select('plancuentas_cuenta as cuenta', 'plancuentas_nombre as nombre', DB::raw('SUM(saldoscontables_debito_mes) as mes'))
                        ->whereBetween('saldoscontables_mes', [$request->filter_initial_month, $request->filter_end_month])
                        ->whereBetween('saldoscontables_ano', [$request->filter_initial_year, $request->filter_end_year])
                        ->where('plancuentas_cuenta', '>=', 4)
                        ->join('koi_plancuentas', 'saldoscontables_cuenta', '=', 'koi_plancuentas.id')
                        ->groupBy('cuenta', 'nombre')
                        ->get();

            // Mezclar los saldos de los meses
            $saldos = array_collapse($saldos);

            // Prepare data
            $title = "Estado de resultados de ".config('koi.meses')[$request->filter_initial_month]."-$request->filter_initial_year a ".config('koi.meses')[$request->filter_end_month]."-$request->filter_end_year";
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create( sprintf('%s_%s', 'reporte_estado_resuelto', date('Y_m_d H_i_s') ), function($excel) use ($title, $type, $saldos){
                        $excel->sheet('Excel', function($sheet) use ($title, $type, $saldos){
                            $sheet->loadView('reports.accounting.estadoresultado.report', compact('title', 'type', 'saldos'));
                            $sheet->setWidth(array('A' => 15, 'B' => 60, 'C' => 25, 'D' => 25, 'E' => 25, 'F' => 25, 'G' => 25));
                            $sheet->setFontSize(8);
                        });
                    })->download('xls');
                break;
            }
        }
        return view('reports.accounting.estadoresultado.index');
    }
}
