<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Auth;

use App\Models\Accounting\Asiento, App\Models\Accounting\Documento, App\Models\Base\Tercero;

class AsientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Asiento::query();
            $query->select('koi_asiento1.id as id', 'asiento1_numero', 'asiento1_mes', 'asiento1_ano', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre"));
            $query->join('koi_tercero', 'koi_asiento1.asiento1_beneficiario', '=', 'koi_tercero.id');
            return Datatables::of($query)->make(true);
        }
        return view('accounting.asiento.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.asiento.create');
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
             
            $asiento = new Asiento;
            if ($asiento->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->asiento1_beneficiario)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);                    
                    }

                    // Recuerar documento
                    $documento = Documento::where('id', $request->asiento1_documento)->first();
                    if(!$documento instanceof Documento) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, por favor verifique la información del asiento o consulte al administrador.']);                    
                    }
                    $consecutivo = $documento->documento_consecutivo + 1;

                    // Asiento
                    $asiento->fill($data);
                    $asiento->asiento1_numero = $consecutivo;
                    $asiento->asiento1_beneficiario = $tercero->id;
                    $asiento->asiento1_usuario_elaboro = Auth::user()->id;
                    $asiento->asiento1_fecha_elaboro = date('Y-m-d H:m:s');
                    $asiento->save();

                    // Actualizar consecutivo
                    $documento->documento_consecutivo = $consecutivo;
                    $documento->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asiento->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $asiento->errors]);
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
        $asiento = Asiento::getAsiento($id);
        if($asiento instanceof Asiento){       
            return view('accounting.asiento.show', ['asiento' => $asiento]);
        }
        abort(404);
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
