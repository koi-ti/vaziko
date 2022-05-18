<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\PuntoVenta;
use App\Models\Accounting\Documento;
use DB, Log, Datatables, Cache;

class PuntoVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(PuntoVenta::query())->make(true);
        }
        return view('admin.puntosventa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.puntosventa.create');
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
            $puntoventa = new PuntoVenta;
            if ($puntoventa->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Documento
                    if ($request->has('puntoventa_documento')) {
                        $documento = Documento::find($request->puntoventa_documento);
                        if (!$documento instanceof Documento) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el documento.']);
                        }

                        $puntoventa->puntoventa_documento = $documento->id;
                    }

                    // punto de venta
                    $puntoventa->fill($data);
                    $puntoventa->save();

                    // Commit Transaction
                    DB::commit();
                    Cache::forget(PuntoVenta::$key_cache);
                    return response()->json(['success' => true, 'id' => $puntoventa->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $puntoventa->errors]);
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
        $puntoventa = PuntoVenta::with('documento')->findOrFail($id);
        if ($request->ajax()) {
            return response()->json($puntoventa);
        }
        return view('admin.puntosventa.show', compact('puntoventa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $puntoventa = PuntoVenta::findOrFail($id);
        return view('admin.puntosventa.edit', compact('puntoventa'));
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
            $puntoventa = PuntoVenta::findOrFail($id);
            if ($puntoventa->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Documento
                    if ($request->has('puntoventa_documento')) {
                        $documento = Documento::find($request->puntoventa_documento);
                        if (!$documento instanceof Documento) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el documento.']);
                        }

                        $puntoventa->puntoventa_documento = $documento->id;
                    }

                    // Punto de venta
                    $puntoventa->fill($data);
                    $puntoventa->save();

                    // Commit Transaction
                    DB::commit();
                    Cache::forget(PuntoVenta::$key_cache);
                    return response()->json(['success' => true, 'id' => $puntoventa->id]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $puntoventa->errors]);
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
