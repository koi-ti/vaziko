<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp10, App\Models\Production\Areap;
use DB, Log;

class DetalleTransportesController extends Controller
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
            if ($request->has('orden2')) {
                $data = Ordenp10::getOrdenesp10($request->orden2);
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
            $orden10 = new Ordenp10;
            if ($orden10->isValid($data)) {
                try {
                    if ($request->has('orden10_transporte')) {
                        $transporte = Areap::find($request->orden10_transporte);
                        if (!$transporte instanceof Areap) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el transporte de producción, por favor verifique la información o consulte al administrador.']);
                        }
                    }

                    $tiempo = "{$request->orden10_horas}:{$request->orden10_minutos}";

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'transporte_nombre' => isset($transporte) ? $transporte->areap_nombre : '-', 'orden10_tiempo' => $tiempo]);
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden10->errors]);
        }
        abort(403);
    }
}
