<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\AsientoNifContableDocumento;
use App\Models\Accounting\AsientoNif, App\Models\Accounting\AsientoNif2, App\Models\Accounting\PlanCuentaNif, App\Models\Base\Tercero, App\Models\Accounting\Documento, App\Models\Accounting\CentroCosto;
use DB, Log, Datatables, Auth, View, App;

class AsientoNifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AsientoNif::query();
            $query->select('koi_asienton1.id as id', 'asienton1_numero', 'asienton1_mes', 'asienton1_ano', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre"), 'asienton1_preguardado');
            $query->join('koi_tercero', 'koi_asienton1.asienton1_beneficiario', '=', 'koi_tercero.id');
            return Datatables::of($query->get())->make(true);
        }
        return view('accounting.asientonif.index', ['empresa' => parent::getPaginacion()]);
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
    public function show(Request $request, $id)
    {
        $asientoNif = AsientoNif::getAsientoNif($id);
        if(!$asientoNif instanceof AsientoNif){
            abort(404);
        }
        if ($request->ajax()) {
            return response()->json($asientoNif);
        }

        return view('accounting.asientonif.show', ['asientoNif' => $asientoNif]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asientoNif = AsientoNif::findOrFail($id);
        // Get document and valid show or edit
        $documento = Documento::find($asientoNif->asienton1_documento);
        if($asientoNif->asienton1_preguardado == false || $documento->documento_actual == true ) {
            return redirect()->route('asientosnif.show', ['asientoNif' => $asientoNif]);
        }

        return view('accounting.asientonif.create', ['asientoNif' => $asientoNif]);
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
        if ($request->ajax()) {
            $data = $request->all();

            $asientoNif = AsientoNif::findOrFail($id);
            if ($asientoNif->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Preparar cuentas
                    // Recupero items asiento ;
                    $query = AsientoNif2::query();
                    $query->select('koi_asienton2.*', 'plancuentasn_cuenta', 'plancuentasn_tipo', 'tercero_nit',
                        DB::raw("(CASE WHEN asienton2_credito != 0 THEN 'C' ELSE 'D' END) as asienton2_naturaleza")
                    );
                    $query->join('koi_tercero', 'asienton2_beneficiario', '=', 'koi_tercero.id');
                    $query->join('koi_plancuentasn', 'asienton2_cuenta', '=', 'koi_plancuentasn.id');
                    $query->where('asienton2_asiento', $asientoNif->id);
                    $asientoNif2 = $query->get();

                    $cuentas = [];
                    foreach ($asientoNif2 as $item) {
                        $arCuenta = [];
                        $arCuenta['Id'] = $item->id;
                        $arCuenta['Cuenta'] = $item->plancuentasn_cuenta;
                        $arCuenta['Tercero'] = $item->tercero_nit;
                        $arCuenta['Naturaleza'] = $item->asienton2_naturaleza;
                        $arCuenta['CentroCosto'] = $item->asienton2_centro;
                        $arCuenta['Base'] = $item->asienton2_base;
                        $arCuenta['Credito'] = $item->asienton2_credito;
                        $arCuenta['Debito'] = $item->asienton2_debito;
                        $cuentas[] = $arCuenta;
                    }


                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoNifContableDocumento($data, $asientoNif);
                    if($objAsiento->asientoNif_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asientoNif_error]);
                    }

                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($cuentas);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar asiento
                    $result = $objAsiento->insertarAsientoNif();
                    if($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }
                    // Insertar movimientos asiento
                    foreach ($asientoNif2 as $item) {
                        $result = $item->movimientos();
                        if($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                    }
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asientoNif->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $asientoNif->errors]);
        }
        abort(403);
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

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function exportar($id)
    {
        $asientoNif = AsientoNif::getAsientoNif($id);
        if(!$asientoNif instanceof AsientoNif){
            abort(404);
        }
        $detalle = AsientoNif2::getAsientoNif2($asientoNif->id);
        $title = 'Asiento contable NIF';

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('accounting.asientonif.export',  compact('asientoNif', 'detalle' ,'title'))->render());
        return $pdf->download(sprintf('%s_%s_%s_%s.pdf', 'asientoNif', $asientoNif->id, date('Y_m_d'), date('H_i_s')));
    }
}
