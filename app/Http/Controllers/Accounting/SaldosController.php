<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth, Validator, Carbon\Carbon;

class SaldosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->has('saldos') ){
            // Validate fields
            $validator = Validator::make($request->all(), [
                'filter_mes' => 'required',
                'filter_ano' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect('/saldos')
                        ->withErrors($validator)
                        ->withInput();
            }

            $user = Auth::user()->id;

            // Definir la ruta del proyecto
            define('ARTISAN_BINARY',base_path().'/artisan');
            call_in_background("update:saldos {$request->filter_mes} {$request->filter_ano} {$user}");

            return redirect()->back()->withSuccess('Se ha enviado la rutina, cuando termine se le notificara.');
        }
        return view('accounting.saldos.main');
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
