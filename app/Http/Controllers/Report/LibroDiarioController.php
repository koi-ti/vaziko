<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Reports\Accounting\LibroDiario;
use App\Models\Accounting\Asiento;
use Excel, Validator, DB;

class LibroDiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            $month = $request->filter_mes;
            $year = $request->filter_ano;

            // Asiento
            $query = Asiento::query();
            $query->select(DB::raw("SUM(asiento2_debito) as debito, SUM(asiento2_credito) as credito"), 'plancuentas_nombre', 'plancuentas_cuenta', 'plancuentas_nivel');
            $query->join('koi_asiento2', 'koi_asiento1.id', '=', 'koi_asiento2.asiento2_asiento');
            $query->join('koi_plancuentas', 'koi_asiento2.asiento2_cuenta', '=', 'koi_plancuentas.id');
            $query->where('asiento1_ano', $year);
            $query->where('asiento1_mes', $month);
            $query->groupBy('plancuentas_cuenta');
            $data = $query->get();

            // Prepare data
            $monthName = config('koi.meses')[$month];
            $title = "Libro diario {$monthName} de {$year}";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s %s', "Libro Diario {$monthName}", date('Y')), function ($excel) use ($data, $title, $type) {
                        $excel->sheet('Excel', function ($sheet) use ($data, $title, $type) {
                            $sheet->loadView('reports.accounting.librodiario.report', compact('data', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new LibroDiario;
                    $pdf->buldReport($data, $title);
                break;
            }
        }
        return view('reports.accounting.librodiario.index');
    }
}
