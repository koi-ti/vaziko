<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Excel, PHPExcel_Style_Fill, PHPExcel_Style_Border;

use App\Models\Accounting\PlanCuenta;

class PlanCuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.accounting.plancuentas.plancuentas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = PlanCuenta::query();
        $query->orderBy('plancuentas_cuenta', 'asc');
        $plancuentas = $query->get();

        Excel::create(sprintf('%s_%s_%s', 'vaziko_plancuentas', date('Y-m-d'), date('H:m:s')), function($excel) use($plancuentas) {
            $excel->setTitle('Plan de Unico de Cuentas - P.U.C');
            $excel->setCreator(config('koi.app.name'));
            $excel->setCompany(config('koi.name'));

            $excel->sheet('Excel', function($sheet) use($plancuentas) {
                $sheet->setFontSize(9);
                $sheet->loadView('reports.accounting.plancuentas.report', ['plancuentas' => $plancuentas]);
            });
        })->export('pdf');
        // })->export('xls');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
