<?php

namespace App\Http\Controllers\Receivable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receivable\Factura3;

class Factura3Controller extends Controller
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
            if ($request->has('orden_id')) {
                $data = Factura3::get();
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
            $factura3 = new Factura3;
            if ($factura3->isValid($data)) {
                try {
                    return response()->json(['success' => true, 'id' => uniqid(), 'factura3_observaciones'=>$request->factura3_observaciones]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $factura3->errors]);
        }
        abort(403);
    }
}
