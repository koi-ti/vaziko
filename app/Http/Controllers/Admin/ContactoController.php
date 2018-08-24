<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Base\Contacto;
use DB, Log, Datatables;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            if($request->has('tercero_id')) {
                // Collection
                $query = Contacto::query();
                $query->select('koi_tcontacto.*');
                $query->where('tcontacto_tercero', $request->tercero_id);
                return response()->json( $query->get() );

            }else{
                // Search datatables
                $query = Contacto::query();
                $query->select('koi_tcontacto.id', 'tcontacto_nombres', 'tcontacto_apellidos', 'tcontacto_telefono', DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as municipio_nombre"), 'tcontacto_direccion', 'tcontacto_direccion_nomenclatura', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_municipio', 'tcontacto_email');
                $query->leftJoin('koi_municipio', 'tcontacto_municipio', '=', 'koi_municipio.id');
                $query->leftJoin('koi_departamento', 'koi_municipio.departamento_codigo', '=', 'koi_departamento.departamento_codigo');

                return Datatables::of($query)
                    ->filter(function($query) use($request) {
                        // Tercero
                        if($request->has('tcontacto_tercero')) {
                            $query->where('tcontacto_tercero', $request->tcontacto_tercero);
                        }

                        // Nombres
                        if($request->has('tcontacto_nombres')) {
                            $query->whereRaw("tcontacto_nombres LIKE '%{$request->tcontacto_nombres}%'");
                        }

                        // Apellidos
                        if($request->has('tcontacto_apellidos')) {
                            $query->whereRaw("tcontacto_apellidos LIKE '%{$request->tcontacto_apellidos}%'");
                        }
                    })
                    ->make(true);
            }
        }
        abort(404);
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
        if ($request->ajax()) {
            $data = $request->all();
            $contacto = new Contacto;
            if ($contacto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::find($request->tcontacto_tercero);
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Contacto
                    $contacto->fill($data);
                    $contacto->tcontacto_tercero = $tercero->id;
                    $contacto->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $contacto->id, 'tcontacto_nombre' => "{$contacto->tcontacto_nombres} {$contacto->tcontacto_apellidos}"]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $contacto->errors]);
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
        if ($request->ajax()) {
            $data = $request->all();
            $contacto = Contacto::findOrFail($id);
            if ($contacto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Contacto
                    $contacto->fill($data);
                    $contacto->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $contacto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $contacto->errors]);
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
