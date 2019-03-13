<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\OrdenpImagen, App\Models\Production\Ordenp;
use Storage, Auth, DB;

class OrdenpImagenesController extends Controller
{
    public function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        if( $request->ajax() ){

            if( $request->has('ordenp') ){
                $query = OrdenpImagen::query();
                $query->select('koi_ordenproduccionimagen.*');
                $query->join('koi_ordenproduccion', 'ordenimagen_orden', '=', 'koi_ordenproduccion.id');
                $query->where('ordenimagen_orden', $request->ordenp);
                $imagenes = $query->get();

                $data = [];
                foreach ($imagenes as $imagen) {
                    if(Storage::has("ordenes/orden_$imagen->ordenimagen_orden/imagenes/$imagen->ordenimagen_archivo")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->ordenimagen_archivo;
                        $object->size = Storage::size("ordenes/orden_$imagen->ordenimagen_orden/imagenes/$imagen->ordenimagen_archivo");
                        $object->thumbnailUrl = url("storage/ordenes/orden_$imagen->ordenimagen_orden/imagenes/$imagen->ordenimagen_archivo");
                        $data[] = $object;
                    }
                }
            }

        }
        return response()->json($data);
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
            // Recuperar orden
            $orden = Ordenp::find($request->ordenp);
            if(!$orden instanceof Ordenp){
                abort(404);
            }

            // Validar que tenga imagenes
            $file = $request->file;
            if( !empty($file) ){
                DB::beginTransaction();
                try {
                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("ordenes/orden_$orden->id/imagenes/$name", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/ordenes/orden_$orden->id/imagenes/$name");

                    // Insertar imagen
                    $imagen = new OrdenpImagen;
                    $imagen->ordenimagen_archivo = $name;
                    $imagen->ordenimagen_orden = $orden->id;
                    $imagen->ordenimagen_fh_elaboro = date('Y-m-d H:i:s');
                    $imagen->ordenimagen_usuario_elaboro = Auth::user()->id;
                    $imagen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->ordenimagen_archivo, 'url' => $url]);
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
                $ordenimagen = OrdenpImagen::find($id);
                if(!$ordenimagen instanceof OrdenpImagen){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la imagen de la orden de producción, por favor verifique la información o consulte al administrador.']);
                }

                $orden = Ordenp::find($request->ordenp);
                if(!$orden instanceof Ordenp){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la orden de producción, por favor verifique la información o consulte al administrador.']);
                }

                if( $ordenimagen->ordenimagen_orden != $orden->id ){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'La imagen que esta intentando eliminar no corresponde a la orden de producción, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item detallepedido
                if( Storage::has("ordenes/orden_$orden->id/imagenes/$ordenimagen->ordenimagen_archivo") ) {
                    Storage::delete("ordenes/orden_$orden->id/imagenes/$ordenimagen->ordenimagen_archivo");
                    $ordenimagen->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error("OrdenpImagenController->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
