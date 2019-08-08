<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\CierreContable;
use App\Models\Base\Empresa;
use DB, Log, Session;

class CierreMensualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Recuperar Empresa
        $empresa = Empresa::getEmpresa();
        $date = date('Y-m-d',strtotime("$empresa->empresa_fecha_cierre_contabilidad + 1 month") );
        $month = date('n', strtotime($date));

        // Prepare data msg
        $year = date('Y', strtotime($date));
        $mes_msg = strtoupper(config('koi.meses')[$month]);

        return view('accounting.cierremensual.index', ['mes' => $mes_msg, 'year' => $year]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = Empresa::getEmpresa();
        $date = date('Y-m-d',strtotime("$empresa->empresa_fecha_cierre_contabilidad + 1 month") );
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date));
        DB::beginTransaction();
        try {
            // Creo el objeto para manejar el cierre contable
            $objCierre = new CierreContable($month, $year);
            $cierreContable = $objCierre->generarCierre();
            if ($cierreContable == 'OK') {
                // Update date empresa
                $empresa->empresa_fecha_cierre_contabilidad = $date;
                $empresa->save();

                // Prepare msg for view
                $mes_msg = strtoupper(config('koi.meses')[$month]);

                // Commit Transaction
                DB::commit();

                //  Enviar mensaje
                Session::flash('message', "El CIERRE CONTABLE para el mes de $mes_msg  de $year se ha realizado con exito!");
            }else{
                DB::rollback();
                //  Enviar mensaje
                Session::flash('error', $cierreContable);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Session::flash('error', trans('app.exception'));
        }
        // Redirect
        return redirect()->route('cierresmensuales.index');
    }
}
