<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\SubtipoProductop, App\Models\Production\TipoProductop;
use DB, Log, Datatables, Cache;

class SubtipoProductopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         if($request->ajax()){
             $query = SubtipoProductop::query();
             $query->join('koi_tipoproductop', 'subtipoproductop_tipoproductop', '=', 'koi_tipoproductop.id');

             if( $request->has('datatables') ) {
                 $query->select('koi_subtipoproductop.*', 'tipoproductop_nombre');
                 return Datatables::of($query->get())->make(true);
             }

             if( $request->has('typeproduct') ){
                 $query->select('koi_subtipoproductop.*');
                 $query->where('subtipoproductop_tipoproductop', $request->typeproduct);
                 $query->where('subtipoproductop_activo', true);
             }
             return response()->json($query->get());
         }
         return view('production.subtipoproductosp.index', ['empresa' => parent::getPaginacion()]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.subtipoproductosp.create');
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

            $subtipoproductop = new SubtipoProductop;
            if ($subtipoproductop->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tipo de productop
                    $tipoproductop = TipoProductop::find( $request->subtipoproductop_tipoproductop );
                    if(!$tipoproductop instanceof TipoProductop){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de producto, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Subtipo de productop
                    $subtipoproductop->fill($data);
                    $subtipoproductop->fillBoolean($data);
                    $subtipoproductop->subtipoproductop_tipoproductop = $tipoproductop->id;
                    $subtipoproductop->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( SubtipoProductop::$key_cache );
                    return response()->json(['success' => true, 'id' => $subtipoproductop->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subtipoproductop->errors]);
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
         $subtipoproductop = SubtipoProductop::select('koi_subtipoproductop.*', 'tipoproductop_nombre')
                            ->join('koi_tipoproductop', 'subtipoproductop_tipoproductop', '=', 'koi_tipoproductop.id')
                            ->where('koi_subtipoproductop.id', $id)
                            ->first();
         if ($request->ajax()) {
             return response()->json($subtipoproductop);
         }
         return view('production.subtipoproductosp.show', ['subtipoproductop' => $subtipoproductop]);
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
         $subtipoproductop = SubtipoProductop::findOrFail($id);
         return view('production.subtipoproductosp.edit', ['subtipoproductop' => $subtipoproductop]);
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

            $subtipoproductop = SubtipoProductop::findOrFail($id);
            if ($subtipoproductop->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tipo de productop
                    $tipoproductop = TipoProductop::find( $request->subtipoproductop_tipoproductop );
                    if(!$tipoproductop instanceof TipoProductop){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de producto, por favor verifique la informacion o consulte al administrador.']);
                    }

                    // Subtipo de productop
                    $subtipoproductop->fill($data);
                    $subtipoproductop->fillBoolean($data);
                    $subtipoproductop->subtipoproductop_tipoproductop = $tipoproductop->id;
                    $subtipoproductop->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( SubtipoProductop::$key_cache );
                    return response()->json(['success' => true, 'id' => $subtipoproductop->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subtipoproductop->errors]);
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
}
