<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accounting\PlanCuenta, App\Models\Accounting\PlanCuentaNif, App\Models\Accounting\CentroCosto;
use DB, Log, Datatables;

class PlanCuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = PlanCuenta::query();
            $query->select('koi_plancuentas.id as id', 'plancuentas_cuenta', 'plancuentas_nivel', 'plancuentas_nombre', 'plancuentas_naturaleza', 'plancuentas_tercero', 'plancuentas_tasa', 'plancuentas_centro', 'plancuentas_tipo', 'plancuentas_equivalente', 'plancuentasn_cuenta');
            $query->leftJoin('koi_plancuentasn', 'plancuentas_equivalente', '=', 'koi_plancuentasn.id');

            // Persistent data filter
            if ($request->has('persistent') && $request->persistent) {
                session(['search_plancuentas_cuenta' => $request->has('plancuentas_cuenta') ? $request->plancuentas_cuenta : '']);
                session(['search_plancuentas_nombre' => $request->has('plancuentas_nombre') ? $request->plancuentas_nombre : '']);
            }

            return Datatables::of($query)
                ->filter(function ($query) use ($request) {
                    // Cuenta
                    if ($request->has('plancuentas_cuenta')) {
                        $query->whereRaw("plancuentas_cuenta LIKE '%{$request->plancuentas_cuenta}%'");
                    }
                    // Nombre
                    if ($request->has('plancuentas_nombre')) {
                        $query->whereRaw("plancuentas_nombre LIKE '%{$request->plancuentas_nombre}%'");
                    }
                })
                ->make(true);
        }
        return view('accounting.plancuentas.index', ['empresa' => parent::getPaginacion()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.plancuentas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $plancuenta = new PlanCuenta;
            if ($plancuenta->isValid($data)) {
                DB::beginTransaction();
                try {
                    if ( $request->has('plancuentas_centro') ){
                        // Validar centro costos
                        $centrocosto = CentroCosto::find($request->plancuentas_centro);
                        if (!$centrocosto instanceof CentroCosto){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el centro de costo, por favor verifique la información o consulte a su administrador']);
                        }

                        $plancuenta->plancuentas_centro = $centrocosto->id;
                    }

                    // Cuenta
                    $plancuenta->fill($data);
                    $plancuenta->fillBoolean($data);
                    $plancuenta->setNivelesCuenta();

                    if ($request->has('plancuentas_equivalente')) {
                        // Nif
                        $nif = PlanCuentaNif::find($request->plancuentas_equivalente);
                        if (!$nif instanceof PlanCuentaNif) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => "No es posible recuperar plan de cuenta NIF, por favor verifique la información o consulte a su administrador"]);
                        }

                        // Verifico que no existan subniveles de la cuenta que estoy realizando el asiento
                        $result = $nif->validarSubnivelesCuenta();
                        if ($result != 'OK') {
                            return $result;
                        }
                        $plancuenta->plancuentas_equivalente = $nif->id;
                    }
                    $plancuenta->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $plancuenta->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $plancuenta->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $plancuenta = PlanCuenta::getCuenta($id);
        if ($plancuenta instanceof PlanCuenta) {
            if ($request->ajax()) {
                return response()->json($plancuenta);
            }
            return view('accounting.plancuentas.show', compact('plancuenta'));
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plancuenta = PlanCuenta::findOrFail($id);
        return view('accounting.plancuentas.edit', compact('plancuenta'));
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
            $plancuenta = PlanCuenta::findOrFail($id);
            if ($plancuenta->isValid($data)) {
                DB::beginTransaction();
                try {
                    if ( $request->has('plancuentas_centro') ){
                        // Validar centro costos
                        $centrocosto = CentroCosto::find($request->plancuentas_centro);
                        if (!$centrocosto instanceof CentroCosto){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el centro de costo, por favor verifique la información o consulte a su administrador']);
                        }

                        $plancuenta->plancuentas_centro = $centrocosto->id;
                    }

                    // Cuenta
                    $plancuenta->fill($data);
                    $plancuenta->fillBoolean($data);
                    $plancuenta->setNivelesCuenta();

                    if ($request->has('plancuentas_equivalente')) {
                        // Nif
                        $nif = PlanCuentaNif::find($request->plancuentas_equivalente);
                        if (!$nif instanceof PlanCuentaNif) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => "No es posible recuperar plan de cuenta NIF, por favor verifique la información o consulte a su administrador"]);
                        }

                        // Verifico que no existan subniveles de la cuenta que estoy realizando el asiento
                        $result = $nif->validarSubnivelesCuenta();
                        if ($result != 'OK') {
                            return response()->json(['success' => false, 'errors' => "No es posible que el plan de cuenta nif $nif->plancuentasn_nombre sea un equivalente, por favor verifique la información o consulte a su administrador" ]);
                        }
                        $plancuenta->plancuentas_equivalente = $nif->id;
                    }
                    $plancuenta->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $plancuenta->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $plancuenta->errors]);
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
     * Display a level of account.
     *
     * @return \Illuminate\Http\Response
     */
    public function nivel(Request $request)
    {
        $nivel = '';
        switch (strlen($request->plancuentas_cuenta)) {
            case '1': $nivel = 1; break;
            case '2': $nivel = 2; break;
            case '4': $nivel = 3; break;
            case '6': $nivel = 4; break;
            case '8': $nivel = 5; break;
            case '11': $nivel = 6; break;
            case '13': $nivel = 7; break;
            case '15': $nivel = 8; break;
        }
        return response()->json(['success' => true, 'nivel' => $nivel]);
    }
}
