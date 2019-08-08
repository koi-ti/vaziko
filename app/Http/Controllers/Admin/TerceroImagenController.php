<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\TerceroImagen, App\Models\Base\Tercero;
use Storage, Auth, DB;

class TerceroImagenController extends Controller
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
        if ($request->ajax()) {
            if ($request->has('tercero_id')) {
                $query = TerceroImagen::query();
                $query->select('koi_terceroimagen.*');
                $query->join('koi_tercero', 'terceroimagen_tercero', '=', 'koi_tercero.id');
                $query->where('terceroimagen_tercero', $request->tercero_id);
                $imagenes = $query->get();

                $data = [];
                foreach ($imagenes as $imagen) {
                    if (Storage::has("terceros/tercero_$imagen->terceroimagen_tercero/archivos/$imagen->terceroimagen_archivo")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->terceroimagen_archivo;
                        $object->size = Storage::size("terceros/tercero_$imagen->terceroimagen_tercero/archivos/$imagen->terceroimagen_archivo");
                        $object->thumbnailUrl = url("storage/terceros/tercero_$imagen->terceroimagen_tercero/archivos/$imagen->terceroimagen_archivo");
                        $data[] = $object;
                    }
                }
            }

        }
        return response()->json($data);
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
            // Recuperar tercero
            $tercero = Tercero::find($request->tercero_id);
            if (!$tercero instanceof Tercero) {
                abort(404);
            }

            // Validar que tenga imagenes
            $file = $request->file;
            if (!empty($file)) {
                DB::beginTransaction();
                try {
                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("terceros/tercero_$tercero->id/archivos/$name", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/terceros/tercero_$tercero->id/archivos/$name");

                    // Insertar imagen
                    $imagen = new TerceroImagen;
                    $imagen->terceroimagen_archivo = $name;
                    $imagen->terceroimagen_tercero = $tercero->id;
                    $imagen->terceroimagen_fh_elaboro = date('Y-m-d H:i:s');
                    $imagen->terceroimagen_usuario_elaboro = Auth::user()->id;
                    $imagen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->terceroimagen_archivo, 'url' => $url]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
        }
        abort(403);
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
                $terceroimagen = TerceroImagen::find($id);
                if (!$terceroimagen instanceof TerceroImagen) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el archivo del tercero, por favor verifique la información o consulte al administrador.']);
                }

                $tercero = Tercero::find($request->tercero_id);
                if (!$tercero instanceof Tercero) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tercero, por favor verifique la información o consulte al administrador.']);
                }

                if ($terceroimagen->terceroimagen_tercero != $tercero->id) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'La imagen que esta intentando eliminar no corresponde al tercero, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item detalle
                if (Storage::has("terceros/tercero_$tercero->id/archivos/$terceroimagen->terceroimagen_archivo")) {
                    Storage::delete("terceros/tercero_$tercero->id/archivos/$terceroimagen->terceroimagen_archivo");
                    $terceroimagen->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error("TerceroImagenController->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
