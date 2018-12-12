<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion3, App\Models\Production\Cotizacion4, App\Models\Production\Ordenp4;
use DB;

class ProductoHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $detalle = [];
        if ($request->ajax()) {

            $unioinpre = PreCotizacion3::select('precotizacion3_valor_unitario as valor', 'precotizacion3_fh_elaboro as fecha', DB::raw("'PRE' as type"))
                                            ->where('precotizacion3_producto', $request->producto_id)
                                            ->limit(10)
                                            ->orderBy('fecha', 'desc');

            $unioncot = Cotizacion4::select('cotizacion4_valor_unitario as valor', 'cotizacion4_fh_elaboro as fecha', DB::raw("'COT' as type"))
                                        ->where('cotizacion4_producto', $request->producto_id)
                                        ->limit(10)
                                        ->orderBy('fecha', 'desc');

            $detalle = Ordenp4::select('orden4_valor_unitario as valor', 'orden4_fh_elaboro as fecha', DB::raw("'ORD' as type"))
                                    ->where('orden4_producto', $request->producto_id)
                                    ->limit(10)
                                    ->union($unioinpre)
                                    ->union($unioncot)
                                    ->orderBy('fecha', 'asc')
                                    ->get();

            return response()->json($detalle);
        }
        return response()->json($detalle);
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
        //
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
    public function destroy($id)
    {
        //
    }
}
