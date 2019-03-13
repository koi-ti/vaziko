<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion4, App\Models\Production\PreCotizacion2;
use DB, Log, Storage, Auth;

class PreCotizacion4Controller extends Controller
{
    public function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            if( $request->has('precotizacion2') ){
                $query = PreCotizacion4::query();
                $query->select('koi_precotizacion4.*', 'precotizacion2_precotizacion1');
                $query->join('koi_precotizacion2', 'precotizacion4_precotizacion2', '=', 'koi_precotizacion2.id');
                $query->where('precotizacion4_precotizacion2', $request->precotizacion2);
                $imagenes = $query->get();

                $data = [];
                foreach ($imagenes as $imagen) {
                    if(Storage::has("pre-cotizaciones/precotizacion_$imagen->precotizacion2_precotizacion1/producto_$imagen->precotizacion4_precotizacion2/$imagen->precotizacion4_archivo")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->precotizacion4_archivo;
                        $object->size = Storage::size("pre-cotizaciones/precotizacion_$imagen->precotizacion2_precotizacion1/producto_$imagen->precotizacion4_precotizacion2/$imagen->precotizacion4_archivo");
                        $object->thumbnailUrl = url("storage/pre-cotizaciones/precotizacion_$imagen->precotizacion2_precotizacion1/producto_$imagen->precotizacion4_precotizacion2/$imagen->precotizacion4_archivo");
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
            // Recuperar precotizacion
            $precotizacion2 = PreCotizacion2::find( $request->precotizacion2 );
            if(!$precotizacion2 instanceof PreCotizacion2){
                abort(404);
            }

            // Validar que tenga imagenes
            $file = $request->file;
            if( !empty($file) ){
                DB::beginTransaction();
                try {

                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id/$name", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id/$name");

                    // Insertar imagen
                    $imagen = new PreCotizacion4;
                    $imagen->precotizacion4_archivo = $name;
                    $imagen->precotizacion4_precotizacion2 = $precotizacion2->id;
                    $imagen->precotizacion4_fh_elaboro = date('Y-m-d H:i:s');
                    $imagen->precotizacion4_usuario_elaboro = Auth::user()->id;
                    $imagen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->precotizacion4_archivo, 'url' => $url]);
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
                $precotizacion4 = PreCotizacion4::find($id);
                if(!$precotizacion4 instanceof PreCotizacion4){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la imagen de la pre-cotización, por favor verifique la información o consulte al administrador.']);
                }

                $precotizacion2 = PreCotizacion2::find($request->precotizacion2);
                if(!$precotizacion2 instanceof PreCotizacion2){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la pre-cotización, por favor verifique la información o consulte al administrador.']);
                }

                if( $precotizacion4->precotizacion4_precotizacion2 != $precotizacion2->id ){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'La imagen que esta intentando eliminar no corresponde al detalle, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item detallepedido
                if( Storage::has("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id/$precotizacion4->precotizacion4_archivo") ) {
                    Storage::delete("pre-cotizaciones/precotizacion_$precotizacion2->precotizacion2_precotizacion1/producto_$precotizacion2->id/$precotizacion4->precotizacion4_archivo");
                    $precotizacion4->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error("PreCotizacion4Controller->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
