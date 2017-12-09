<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Accounting\PlanCuentaNif, App\Models\Accounting\CentroCosto;
use DB, Log, Cache, Datatables;

class PlanCuentasNifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = PlanCuentaNif::query();
            $query->select('id', 'plancuentasn_cuenta', 'plancuentasn_nivel', 'plancuentasn_nombre', 'plancuentasn_naturaleza', 'plancuentasn_tercero', 'plancuentasn_tasa', 'plancuentasn_centro', 'plancuentasn_tipo');
            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['search_plancuentasn_cuenta' => $request->has('plancuentasn_cuenta') ? $request->plancuentasn_cuenta : '']);
                session(['search_plancuentasn_nombre' => $request->has('plancuentasn_nombre') ? $request->plancuentasn_nombre : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Cuenta
                    if($request->has('plancuentasn_cuenta')) {
                        $query->whereRaw("plancuentasn_cuenta LIKE '%{$request->plancuentasn_cuenta}%'");
                    }
                    // Nombre
                    if($request->has('plancuentasn_nombre')) {
                        $query->whereRaw("plancuentasn_nombre LIKE '%{$request->plancuentasn_nombre}%'");
                    }
                })
                ->make(true);
        }
        return view('accounting.plancuentasnif.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.plancuentasnif.create');
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

            $plancuentanif = new PlanCuentanif;
            if ($plancuentanif->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Cuenta
                    $plancuentanif->fill($data);
                    $plancuentanif->fillBoolean($data);
                    $plancuentanif->setNivelesCuenta();
                    $plancuentanif->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( PlanCuentaNif::$key_cache );

                    return response()->json(['success' => true, 'id' => $plancuentanif->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $plancuentanif->errors]);
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
        $plancuentanif = PlanCuentaNif::getCuenta($id);
        if($plancuentanif instanceof PlanCuentaNif){
            if ($request->ajax()) {
                return response()->json($plancuentanif);
            }
            return view('accounting.plancuentasnif.show', ['plancuentanif' => $plancuentanif]);
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
        $plancuentanif = PlanCuentaNif::findOrFail($id);
        return view('accounting.plancuentasnif.edit', ['plancuentanif' => $plancuentanif]);
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

            $plancuentanif = PlanCuentaNif::findOrFail($id);
            if ($plancuentanif->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Cuenta
                    $plancuentanif->fill($data);
                    $plancuentanif->fillBoolean($data);
                    $plancuentanif->setNivelesCuenta();
                    $plancuentanif->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( PlanCuentaNif::$key_cache );

                    return response()->json(['success' => true, 'id' => $plancuentanif->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $plancuentanif->errors]);
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
        switch (strlen($request->plancuentasn_cuenta)) {
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

    /**
     * Search plan cuentas.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->has('plancuentasn_cuenta')) {
            $plancuentanif = PlanCuentaNif::where('plancuentasn_cuenta', $request->plancuentasn_cuenta)->first();
            if($plancuentanif instanceof PlanCuenta) {
                return response()->json(['success' => true, 'plancuentasn_nombre' => $plancuentanif->plancuentasn_nombre, 'plancuentasn_tasa' => $plancuentanif->plancuentasn_tasa, 'plancuentasn_centro' => $plancuentanif->plancuentasn_centro, 'plancuentasn_naturaleza' => $plancuentanif->plancuentasn_naturaleza, 'plancuentasn_tipo' => $plancuentanif->plancuentasn_tipo]);
            }
        }
        return response()->json(['success' => false]);
    }
}
