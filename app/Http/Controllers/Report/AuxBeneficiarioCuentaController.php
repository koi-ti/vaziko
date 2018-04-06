<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\AuxBeneficiarioCuenta;
use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use App\Models\Base\Tercero;
use View, App, Excel, DB, Validator;

class AuxBeneficiarioCuentaController extends Controller
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
            $sql = '';
            $title = sprintf('%s %s %s', 'Mayor y balance de ',  config('koi.meses')[$request->mes_inicial], $request->ano_inicial);
            $type = $request->type;
            $mes = $request->mes_inicial;
            $ano = $request->ano_inicial;
            $auxcontable = [];

            if($mes == 1) {
                $mes2 = 13;
                $ano2 = $ano - 1;
            }else{
                $mes2 = $mes - 1;
                $ano2 = $ano;
            }

            // Preparar sql
            $sql = "
                SELECT cuenta.plancuentas_nombre, cuenta.plancuentas_cuenta, cuenta.plancuentas_naturaleza, cuenta.plancuentas_nivel, (CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,'',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2, (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)) ELSE t.tercero_razonsocial END) AS tercero_nombre, t.tercero_nit,
                (select (CASE when cuenta.plancuentas_naturaleza = 'D'
                        THEN (saldoscontables_debito_inicial - saldoscontables_credito_inicial)
                        ELSE (saldoscontables_credito_inicial - saldoscontables_debito_inicial)
                        END)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes2
                    and saldoscontables_ano = $ano2
                    and saldoscontables_cuenta = cuenta.id
                ) as inicial,
                (select (saldoscontables_debito_mes)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes
                    and saldoscontables_ano = $ano
                    and saldoscontables_cuenta = cuenta.id
                ) as debitomes,
                (select (saldoscontables_credito_mes)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes
                    and saldoscontables_ano = $ano
                    and saldoscontables_cuenta = cuenta.id
                ) as creditomes
                FROM koi_plancuentas as cuenta, koi_tercero as t, koi_asiento2 as asiento2
                WHERE cuenta.id IN (
                    SELECT s.saldoscontables_cuenta
                    FROM koi_saldoscontables as s
                    WHERE s.saldoscontables_mes = $mes AND s.saldoscontables_ano = $ano
                    UNION
                    SELECT s.saldoscontables_cuenta
                    FROM koi_saldoscontables as s
                    WHERE s.saldoscontables_mes = $mes2 AND s.saldoscontables_ano = $ano2
                )
                AND t.id = asiento2.asiento2_beneficiario";

            // Filters
            if($request->has('filter_cuenta') ) {
                $sql .= "
                    AND RPAD(cuenta.plancuentas_cuenta, 15, 0) >= RPAD({$request->filter_cuenta}, 15, 0)";
            }
            if($request->has('filter_tercero') ) {
                $sql .= "
                    AND t.tercero_nit = $request->filter_tercero";
            }
            $sql .= " ORDER BY t.tercero_nit, cuenta.plancuentas_cuenta ASC";
            $auxcontable = DB::select($sql);

            dd($auxcontable);
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'auxcuentabeneficiario', date('Y_m_d'), date('H_m_s')), function($excel) use($auxcontable, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($auxcontable, $title, $type) {
                            $sheet->loadView('reports.accounting.auxcuentabeneficiario.report', compact('auxcontable', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new AuxBeneficiarioCuenta('L','mm','A4');
                    $pdf->buldReport($auxcontable, $title, $subtitle, $subtitleTercero);
                break;
            }
        }
        return view('reports.accounting.auxbeneficiariocuenta.index');
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
        //
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
