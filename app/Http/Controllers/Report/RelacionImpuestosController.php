<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\RelacionImpuestos;
use App\Models\Accounting\Asiento2;
use App\Models\Base\Tercero;
use Excel, View, App, DB;

class RelacionImpuestosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('type')) {
            list($año, $mes, $dia) = (explode('-',$request->fecha_inicial));
            list($añoF, $mesF, $diaF) = (explode('-',$request->fecha_final));
            $fechaI = sprintf('%s-%s-%s', intval($año), intval($mes), intval($dia));
            $fechaF = sprintf('%s-%s-%s', intval($añoF), intval($mesF), intval($diaF));

            $query = Asiento2::query();
            $query->select(DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"),'tercero_nit', 'tercero_direccion','tercero_telefono1','plancuentas_nombre', 'plancuentas_cuenta', 'plancuentas_tasa', DB::raw('SUM((plancuentas_tasa / 100) * asiento2_base) as impuesto, SUM(asiento2_base) as base'), DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date") );
            $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
            $query->join('koi_plancuentas', 'asiento2_cuenta', '=', 'koi_plancuentas.id');
            $query->join('koi_asiento1', 'asiento2_asiento', '=', 'koi_asiento1.id');
            $query->whereRaw("plancuentas_cuenta >= '$request->cuenta_inicio'");
            $query->whereRaw("plancuentas_cuenta <= '$request->cuenta_fin'");
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) >= '$fechaI'");
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) <= '$fechaF'");

            // Filter tercero
            if($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                // Validate Tercero
                if (!$tercero instanceof Tercero) {
                    return redirect('/rimpuestos')
                    ->withErrors("No es posible recuperar tercero, por favor verifique la información o consulte al administrador.")
                    ->withInput();
                }
                $query->where('asiento2_beneficiario', $tercero->id);
            }
            $query->groupBy('tercero_nit','plancuentas_cuenta');
            $query->orderBy('plancuentas_cuenta', 'asc');
            $data = $query->get();

            // Prepare data
            $title = "Reporte relación de impuestos durante el período de $request->fecha_inicial hasta $request->fecha_final";
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'relacion_impuestos', date('Y_m_d'), date('H_m_s')), function($excel) use($data, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($data, $title, $type) {
                            $sheet->loadView('reports.accounting.impuestos.report', compact('data', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new RelacionImpuestos('L', 'mm', 'Letter');
                    $pdf->buldReport($data, $title);
                break;
            }
        }

        return view('reports.accounting.impuestos.index');
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
