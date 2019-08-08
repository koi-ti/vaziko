<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class SaldosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('saldos')) {
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

            $user = auth()->user()->id;

            // Definir la ruta del proyecto
            define('ARTISAN_BINARY',base_path().'/artisan');
            call_in_background("update:saldos {$request->filter_mes} {$request->filter_ano} {$user}");

            return redirect()->back()->withSuccess('Se ha enviado la rutina, cuando termine se le notificara.');
        }
        return view('accounting.saldos.main');
    }
}
