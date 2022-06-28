<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounting\SaldoTercero, App\Models\Accounting\SaldoContable;

class MedioMagneticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            // Preparar datos reporte
            $mes = $request->filter_mes;
            $ano = $request->filter_ano;

            if ($mes == 1) {
                $mes2 = 13;
                $ano2 = $ano - 1;
            } else {
                $mes2 = $mes - 1;
                $ano2 = $ano;
            }

        }
        return view('reports.accounting.mediomagnetico.index');
    }

}
