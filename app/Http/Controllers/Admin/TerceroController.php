<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables;

use App\Models\Base\Tercero, App\Models\Base\Actividad;

class TerceroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Tercero::query();
            $query->select('id', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre")
            );
            return Datatables::of($query)->make(true);
        }
        return view('admin.terceros.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.terceros.create');
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
            
            $tercero = new Tercero;
            if ($tercero->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tercero
                    $tercero->fill($data);
                    $tercero->fillBoolean($data);
                    $tercero->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tercero->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tercero->errors]);
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
        $tercero = Tercero::findOrFail($id);
        $actividad = Actividad::findOrFail($tercero->tercero_actividad);

        return view('admin.terceros.show', ['tercero' => $tercero, 'actividad' => $actividad]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tercero = Tercero::findOrFail($id);
        return view('admin.terceros.edit', ['tercero' => $tercero]);
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
            
            $tercero = Tercero::findOrFail($id);
            if ($tercero->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tercero
                    $tercero->fill($data);
                    $tercero->fillBoolean($data);
                    $tercero->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tercero->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tercero->errors]);
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

    /**
     * Display a digit of verification from document partner.
     *
     * @return \Illuminate\Http\Response
     */
    public function dv(Request $request)
    {
        // Calc dv      
        $primer = substr($request->tercero_nit,0,1);
        $longitud = strlen($request->tercero_nit);
        $verificacion = [ 
            0=>71, 1=>67, 2=>59, 
            3=>53, 4=>47, 5=>43, 
            6=>41, 7=>37, 8=>29, 
            9=>23, 10=>19, 11=>17,
            12=>13, 13=>7, 14=>3 
        ]; 
        //$a contendra el valor de la sumatoria de los productos de cada posicion del nit * el factor correspondiente en el array de verificacion
        //$b residuo($a,11)
        //si $b=0 => digito =0
        //si $b=1 => digito =1
        //si $b!=0 && $b!=1 => digito =11-$b 
        $a = 0;
        $posicionnit = ($longitud-1);
        for($i=14; $i >= (15-$longitud); $i--) {
            $a += ($verificacion[$i]*substr($request->tercero_nit, $posicionnit,1));
            $posicionnit--;
        }       

        $b = $a%11;
        if($b==0) {       
            $dv = 0;
        }else if($b==1) {
            $dv = 1;
        }else {
            $dv = (11-$b);
        }

        $persona = '';
        $documento = '';
        if(($primer==8||$primer==9)&&($longitud==9)) {
            $persona = 2;
            $documento = 'NI';
        }

        return response()->json(['success' => true, 'dv' => $dv, 'persona' => $persona, 'documento' => $documento]);
    }

    /**
     * Display % rcree of activity.
     *
     * @return \Illuminate\Http\Response
     */
    public function rcree(Request $request)
    {
        $rcree = '';
        if($request->has('tercero_actividad')){
            $actividad = Actividad::findOrFail($request->tercero_actividad);
            $rcree = $actividad->actividad_tarifa;
        }
        return response()->json(['success' => true, 'rcree' => $rcree]);
    }
    
}
