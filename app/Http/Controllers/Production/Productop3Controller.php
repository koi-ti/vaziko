<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Areap, App\Models\Production\Productop, App\Models\Production\Productop3;
use DB, Log;

class Productop3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Productop3::query();
            $query->where('productop3_productop', $request->productop_id);
            $query->select('koi_productop3.*', 'areap_nombre');
            $query->join('koi_areap', 'productop3_areap', '=', 'koi_areap.id');
            $query->orderBy('koi_productop3.id', 'asc');
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
            $productop3 = new Productop3;
            if ($productop3->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $productop = Productop::find($request->productop3_productop);
                    if (!$productop instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar areap
                    $areap = Areap::find($request->productop3_areap);
                    if (!$areap instanceof Areap) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar area, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar unique
                    $productop3uq = Productop3::where('productop3_productop', $productop->id)->where('productop3_areap', $areap->id)->first();
                    if ($productop3uq instanceof Productop3) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "El área {$areap->areap_nombre} ya se encuentra asociada a este producto."]);
                    }

                    // Area
                    $productop3->productop3_productop = $productop->id;
                    $productop3->productop3_areap = $areap->id;
                    $productop3->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $productop3->id, 'areap_nombre' => $areap->areap_nombre]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $productop3->errors]);
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
                $productop3 = Productop3::find($id);
                if (!$productop3 instanceof Productop3) {
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar area, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Eliminar item productop3
                $productop3->delete();

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Productop3Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
