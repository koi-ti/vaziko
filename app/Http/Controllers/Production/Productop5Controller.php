<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log;

use App\Models\Production\Materialp, App\Models\Production\Productop, App\Models\Production\Productop5;

class Productop5Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $query = Productop5::query();
            $query->where('productop5_productop', $request->productop_id);
            $query->select('koi_productop5.*', 'koi_materialp.id as materialp_id', 'materialp_nombre');
            $query->join('koi_materialp', 'productop5_materialp', '=', 'koi_materialp.id');
            $query->orderBy('koi_productop5.id', 'asc');
            return response()->json( $query->get() );
        }
        abort(404);
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
        if ($request->ajax()) {
            $data = $request->all();

            $productop5 = new Productop5;
            if ($productop5->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar producto
                    $productop = Productop::find($request->productop5_productop);
                    if(!$productop instanceof Productop) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar materialp
                    $materialp = Materialp::find($request->productop5_materialp);
                    if(!$materialp instanceof Materialp) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar material, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar unique
                    $productop5uq = Productop5::where('productop5_productop', $productop->id)->where('productop5_materialp', $materialp->id)->first();
                    if($productop5uq instanceof Productop5) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "El material {$materialp->materialp_nombre} ya se encuentra asociada a este producto."]);
                    }

                    // material
                    $productop5->productop5_productop = $productop->id;
                    $productop5->productop5_materialp = $materialp->id;
                    $productop5->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $productop5->id, 'materialp_id' => $materialp->id, 'materialp_nombre' => $materialp->materialp_nombre]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $productop5->errors]);
        }
        abort(403);
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
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {

                $productop5 = Productop5::find($id);
                if(!$productop5 instanceof Productop5){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar material, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Eliminar item productop5
                $productop5->delete();

                DB::commit();
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Productop5Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
