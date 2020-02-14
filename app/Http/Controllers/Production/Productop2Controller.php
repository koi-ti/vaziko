<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Productop, App\Models\Production\Productop2;
use DB, Log;

class Productop2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('productop_id')) {
                $query = Productop2::query();
                $query->where('productop2_productop', $request->productop_id);
                $query->orderBy('id', 'asc');
                $data = $query->get();
            }
            return response()->json($data);
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
            $productop2 = new Productop2;
            if ($productop2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $productop = Productop::find($request->productop2_productop);
                    if (!$productop instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Area
                    $productop2->fill($data);
                    $productop2->productop2_productop = $productop->id;
                    $productop2->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $productop2->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $productop2->errors]);
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
                $productop2 = Productop2::find($id);
                if (!$productop2 instanceof Productop2) {
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar tip, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Eliminar item productop2
                $productop2->delete();

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Productop2Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
