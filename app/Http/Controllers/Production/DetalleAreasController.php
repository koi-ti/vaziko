<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp6, App\Models\Production\Ordenp2, App\Models\Production\Areap;
use DB, Log;

class DetalleAreasController extends Controller
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
                $data = Ordenp6::getOrdenesp6($request->orden2);
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
            $orden6 = new Ordenp6;
            if ($orden6->isValid($data)) {
                try {
                    $areap_nombre = null;
                    if ($request->orden6_horas == 0 && $request->orden6_minutos == 0) {
                        return response()->json(['success' => false, 'errors' => 'No puede ingresar horas y minutos en 0.']);
                    }

                    if (empty(trim($request->orden6_valor)) || is_null(trim($request->orden6_valor))) {
                        return response()->json(['success' => false, 'errors' => 'El campo valor es obligatorio.']);
                    }

                    // Recuperar areap
                    if (!empty($request->orden6_areap)) {
                        $areap = Areap::find($request->orden6_areap);
                        if (!$areap instanceof Areap) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el area.']);
                        }
                        $areap_nombre = $areap->areap_nombre;
                    } else {
                        if (empty(trim($request->orden6_nombre)) || is_null(trim($request->orden6_nombre))) {
                            return response()->json(['success' => false, 'errors' => 'El campo nombre es obligatorio cuando no tiene area.']);
                        }
                    }

                    // Commit Transaction
                    return response()->json(['success' => true, 'id' => uniqid(), 'areap_nombre' => $areap_nombre, 'orden6_tiempo' => "{$request->orden6_horas}:{$request->orden6_minutos}"]);
                } catch(\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden6->errors]);
        }
        abort(403);
    }
}
