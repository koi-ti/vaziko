<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Acabadop, App\Models\Production\Productop, App\Models\Production\Productop6;
use DB, Log;

class Productop6Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Productop6::query();
            $query->where('productop6_productop', $request->productop_id);
            $query->select('koi_productop6.*', 'koi_acabadop.id as acabadop_id', 'acabadop_nombre');
            $query->join('koi_acabadop', 'productop6_acabadop', '=', 'koi_acabadop.id');
            $query->orderBy('koi_productop6.id', 'asc');
            return response()->json( $query->get() );
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
            $productop6 = new Productop6;
            if ($productop6->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $productop = Productop::find($request->productop6_productop);
                    if (!$productop instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar Acabadop
                    $acabadop = Acabadop::find($request->productop6_acabadop);
                    if (!$acabadop instanceof Acabadop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar acabado, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar unique
                    $productop6uq = Productop6::where('productop6_productop', $productop->id)->where('productop6_acabadop', $acabadop->id)->first();
                    if ($productop6uq instanceof Productop6) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "El acabado {$acabadop->acabadop_nombre} ya se encuentra asociada a este producto."]);
                    }

                    // acabado
                    $productop6->productop6_productop = $productop->id;
                    $productop6->productop6_acabadop = $acabadop->id;
                    $productop6->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $productop6->id, 'acabadop_id' => $acabadop->id, 'acabadop_nombre' => $acabadop->acabadop_nombre]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $productop6->errors]);
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

                $productop6 = Productop6::find($id);
                if(!$productop6 instanceof Productop6){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar acabado, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Eliminar item productop6
                $productop6->delete();

                DB::commit();
                return response()->json(['success' => true]);

            } catch(\Exception $e) {
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Productop6Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
