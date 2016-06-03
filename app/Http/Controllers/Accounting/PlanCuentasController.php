<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables;

use App\Models\Accounting\PlanCuenta, App\Models\Accounting\CentroCosto;

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
            $query->select('id', 'plancuentas_cuenta', 'plancuentas_nivel', 'plancuentas_nombre', 'plancuentas_naturaleza');
            return Datatables::of($query)->make(true);
        }
        return view('accounting.plancuentas.index');
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
                    // Cuenta
                    $plancuenta->fill($data);
                    $plancuenta->fillBoolean($data);
                    $plancuenta->setNivelesCuenta();
                    $plancuenta->save();


                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $plancuenta->id]);
                }catch(\Exception $e){
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
        if($plancuenta instanceof PlanCuenta){
            if ($request->ajax()) {
                return response()->json($plancuenta);    
            }        
            return view('accounting.plancuentas.show', ['plancuenta' => $plancuenta]);
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
        return view('accounting.plancuentas.edit', ['plancuenta' => $plancuenta]);
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
                    // Cuenta
                    $plancuenta->fill($data);
                    $plancuenta->fillBoolean($data);
                    $plancuenta->setNivelesCuenta();
                    $plancuenta->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $plancuenta->id]);
                }catch(\Exception $e){
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

    /**
     * Search plan cuentas.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->has('plancuentas_cuenta')) {
            $plancuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
            if($plancuenta instanceof PlanCuenta) {
                return response()->json(['success' => true, 'plancuentas_nombre' => $plancuenta->plancuentas_nombre]);
            }
        }
        return response()->json(['success' => false]);
    }
}