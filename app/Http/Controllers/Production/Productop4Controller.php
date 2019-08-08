<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Maquinap, App\Models\Production\Productop, App\Models\Production\Productop4;
use DB, Log;

class Productop4Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Productop4::query();
            $query->where('productop4_productop', $request->productop_id);
            $query->select('koi_productop4.*', 'koi_maquinap.id as maquinap_id', 'maquinap_nombre');
            $query->join('koi_maquinap', 'productop4_maquinap', '=', 'koi_maquinap.id');
            $query->orderBy('koi_productop4.id', 'asc');
            return response()->json($query->get());
        }
        abort(404);
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
            $productop4 = new Productop4;
            if ($productop4->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $productop = Productop::find($request->productop4_productop);
                    if (!$productop instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar maquinap
                    $maquinap = Maquinap::find($request->productop4_maquinap);
                    if (!$maquinap instanceof Maquinap) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar maquina, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar unique
                    $productop4uq = Productop4::where('productop4_productop', $productop->id)->where('productop4_maquinap', $maquinap->id)->first();
                    if ($productop4uq instanceof Productop4) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "El área {$maquinap->maquinap_nombre} ya se encuentra asociada a este producto."]);
                    }

                    // Maquina
                    $productop4->productop4_productop = $productop->id;
                    $productop4->productop4_maquinap = $maquinap->id;
                    $productop4->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $productop4->id, 'maquinap_id' => $maquinap->id, 'maquinap_nombre' => $maquinap->maquinap_nombre]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $productop4->errors]);
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $productop4 = Productop4::find($id);
                if (!$productop4 instanceof Productop4) {
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar maquina, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Eliminar item productop4
                $productop4->delete();

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Productop4Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
