<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\PlanCuentas;
use App\Models\Accounting\PlanCuenta;
use Excel, View, App;

class PlanCuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('type')) {
            $query = PlanCuenta::query();

            // Filters
            if($request->has('nivel')) {
                $query->where('plancuentas_nivel', '<=', $request->nivel);
            }

            $query->orderBy('plancuentas_cuenta', 'asc');
            $plancuentas = $query->get();

            // Prepare data
            $title = 'Plan de único de cuentas - P.U.C';
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'plancuentas', date('Y_m_d'), date('H_m_s')), function($excel) use($plancuentas, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($plancuentas, $title, $type) {
                            $sheet->loadView('reports.accounting.plancuentas.report', compact('plancuentas', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new PlanCuentas;
                    $pdf->buldReport($plancuentas, $title);
                break;
            }
        }

        return view('reports.accounting.plancuentas.index');
    }
}
