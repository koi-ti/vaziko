<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Excel, View, App;

use App\Models\Accounting\PlanCuenta;

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
                $query->where('plancuentas_nivel', $request->nivel);
            }

            $query->orderBy('plancuentas_cuenta', 'asc');
            $plancuentas = $query->get();

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML(View::make('reports.accounting.plancuentas.report', ['plancuentas' => $plancuentas])->render());
            $pdf->setPaper('A4', 'letter')->setWarnings(false);

            return $pdf->stream(sprintf('%s_%s_%s.pdf', 'plancuentas', date('Y-m-d'), date('H:m:s')));

            // return $dompdf->stream('invoice', ['Attachment'=>0);

            // Excel::create(sprintf('%s_%s_%s', 'vaziko_plancuentas', date('Y-m-d'), date('H:m:s')), function($excel) use($plancuentas) {
            //     $excel->setTitle('Plan de Unico de Cuentas - P.U.C');
            //     $excel->setCreator(config('koi.app.name'));
            //     $excel->setCompany(config('koi.name'));

            //     $excel->sheet('Excel', function($sheet) use($plancuentas) {
            //         $sheet->setFontSize(9);
            //         $sheet->loadView('reports.accounting.plancuentas.report', ['plancuentas' => $plancuentas]);
            //     });
            // })->download('pdf');

        }

        return view('reports.accounting.plancuentas.index');
    }
}
