<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Cotizacion2, App\Models\Production\Cotizacion8;
use DB, Log, Storage, Auth;

class Cotizacion8Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            if( $request->has('cotizacion2') ){
                $query = Cotizacion8::query();
                $query->select('koi_cotizacion8.*', 'cotizacion2_cotizacion');
                $query->join('koi_cotizacion2', 'cotizacion8_cotizacion2', '=', 'koi_cotizacion2.id');
                $query->where('cotizacion8_cotizacion2', $request->cotizacion2);
                $imagenes = $query->get();

                $data = [];
                foreach ($imagenes as $imagen) {
                    if(Storage::has("cotizaciones/cotizacion_$imagen->cotizacion2_cotizacion/producto_$imagen->cotizacion8_cotizacion2/$imagen->cotizacion8_archivo")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->cotizacion8_archivo;
                        $object->size = Storage::size("cotizaciones/cotizacion_$imagen->cotizacion2_cotizacion/producto_$imagen->cotizacion8_cotizacion2/$imagen->cotizacion8_archivo");
                        $object->thumbnailUrl = url("storage/cotizaciones/cotizacion_$imagen->cotizacion2_cotizacion/producto_$imagen->cotizacion8_cotizacion2/$imagen->cotizacion8_archivo");
                        $data[] = $object;
                    }
                }
                return response()->json($data);
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
            // Recuperar cotizacion
            $cotizacion2 = Cotizacion2::find($request->cotizacion2);
            if(!$cotizacion2 instanceof Cotizacion2){
                abort(404);
            }

            // Validar que tenga imagenes
            $file = $request->file;
            if( !empty($file) ){
                DB::beginTransaction();
                try {
                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$name", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$name");

                    // Insertar imagen
                    $imagen = new Cotizacion8;
                    $imagen->cotizacion8_archivo = $name;
                    $imagen->cotizacion8_cotizacion2 = $cotizacion2->id;
                    $imagen->cotizacion8_fh_elaboro = date('Y-m-d H:m:s');
                    $imagen->cotizacion8_usuario_elaboro = Auth::user()->id;
                    $imagen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->cotizacion8_archivo, 'url' => $url]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $cotizacion8 = Cotizacion8::find($id);
                if(!$cotizacion8 instanceof Cotizacion8){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la imagen de la cotización, por favor verifique la información o consulte al administrador.']);
                }

                $cotizacion2 = Cotizacion2::find($request->cotizacion2);
                if(!$cotizacion2 instanceof Cotizacion2){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cotización, por favor verifique la información o consulte al administrador.']);
                }

                if( $cotizacion8->cotizacion8_cotizacion2 != $cotizacion2->id ){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'La imagen que esta intentando eliminar no corresponde al detalle, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item detallepedido
                if( Storage::has("cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$cotizacion8->cotizacion8_archivo") ) {
                    Storage::delete("cotizaciones/cotizacion_$cotizacion2->cotizacion2_cotizacion/producto_$cotizacion2->id/$cotizacion8->cotizacion8_archivo");
                    $cotizacion8->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error("Cotizacion8Controller->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
