<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Accounting\PlanCuenta;
use App\Models\Base\Empresa;
use Excel, View, App, Fpdf;

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
                    // Header paper
                    $empresa = Empresa::getEmpresa();
                    Fpdf::AddPage();
                    Fpdf::SetFont('Arial','B',11);
                    Fpdf::Cell(190,5,utf8_decode($empresa->tercero_razonsocial),0,0,'C');
                    Fpdf::SetXY(85,17);
                    Fpdf::SetFont('Arial','B',10);
                    Fpdf::Cell(40,5,"NIT: $empresa->tercero_nit",0,0,'C');
                    Fpdf::Line(22,22,180,22);
                    Fpdf::SetXY(85,23);
                    Fpdf::Cell(40, 5, utf8_decode($title), 0, 0,'C');
                    Fpdf::Ln();

                    // Header table
                    Fpdf::Cell(30,5,'CUENTA',1);
                    Fpdf::Cell(90,5,'NOMBRE',1);
                    Fpdf::Cell(10,5,'NV',1);
                    Fpdf::Cell(15,5,'C/D',1);
                    Fpdf::Cell(20,5,'TER',1);
                    Fpdf::Cell(25,5,'TASA',1);
                    Fpdf::Ln();

                    // Data table
                    $fill = false;
                    Fpdf::SetFillColor(247,247,247);
                    Fpdf::SetFont('Arial', '', 8);
                    foreach($plancuentas as $cuenta)
                    {
                        $fill = !$fill;
                        Fpdf::Cell(30,5,$cuenta->plancuentas_cuenta,'',0,'R',$fill);
                        Fpdf::Cell(90,5,utf8_decode($cuenta->plancuentas_nombre),'',0,'',$fill);
                        Fpdf::Cell(10,5,$cuenta->plancuentas_nivel ,'',0,'',$fill);
                        Fpdf::Cell(15,5,$cuenta->plancuentas_naturaleza,'',0,'',$fill);
                        Fpdf::Cell(20,5,($cuenta->plancuentas_tercero ? 'SI': 'NO') ,'',0,'',$fill);
                        Fpdf::Cell(25,5,$cuenta->plancuentas_tasa,'',0,'',$fill);
                        Fpdf::Ln();
                    }
                    Fpdf::Output(sprintf('%s_%s_%s.pdf', 'plancuentas', date('Y_m_d'), date('H_m_s')),'d');
                break;
            }
        }

        return view('reports.accounting.plancuentas.index');
    }
}
