<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\OrdenpArchivo, App\Models\Production\Ordenp;
use Storage, DB;

class OrdenpArchivosController extends Controller
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
            if ($request->has('ordenp')) {
                $query = OrdenpArchivo::query();
                $query->select('koi_ordenproduccionarchivo.*');
                $query->join('koi_ordenproduccion', 'ordenarchivo_orden', '=', 'koi_ordenproduccion.id');
                $query->where('ordenarchivo_orden', $request->ordenp);
                $archivos = $query->get();

                $data = [];
                foreach ($archivos as $archivo) {
                    if (Storage::has("ordenes/orden_{$archivo->ordenarchivo_orden}/archivos/{$archivo->ordenarchivo_archivo}")) {
                        $object = new \stdClass();
                        $object->uuid = $archivo->id;
                        $object->name = $archivo->ordenarchivo_archivo;
                        $object->size = Storage::size("ordenes/orden_{$archivo->ordenarchivo_orden}/archivos/{$archivo->ordenarchivo_archivo}");
                        $object->thumbnailUrl = url("storage/ordenes/orden_{$archivo->ordenarchivo_orden}/archivos/{$archivo->ordenarchivo_archivo}");
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
            // Recuperar orden
            $orden = Ordenp::find($request->ordenp);
            if (!$orden instanceof Ordenp) {
                abort(404);
            }

            // Validar que tenga archivos
            if ($request->file('file')) {
                DB::beginTransaction();
                try {
                    $file = $request->file;

                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("ordenes/orden_{$orden->id}/archivos/{$name}", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/ordenes/orden_{$orden->id}/archivos/{$name}");

                    // Insertar archivo
                    $archivo = new OrdenpArchivo;
                    $archivo->ordenarchivo_archivo = $name;
                    $archivo->ordenarchivo_orden = $orden->id;
                    $archivo->ordenarchivo_fh_elaboro = date('Y-m-d H:i:s');
                    $archivo->ordenarchivo_usuario_elaboro = auth()->user()->id;
                    $archivo->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $archivo->id, 'name' => $archivo->ordenarchivo_archivo, 'url' => $url]);
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
                $ordenarchivo = OrdenpArchivo::find($id);
                if (!$ordenarchivo instanceof OrdenpArchivo) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el archivo de la orden de producción, por favor verifique la información o consulte al administrador.']);
                }

                $orden = Ordenp::find($request->ordenp);
                if (!$orden instanceof Ordenp) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la orden de producción, por favor verifique la información o consulte al administrador.']);
                }

                if ($ordenarchivo->ordenarchivo_orden != $orden->id) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'El archivo que esta intentando eliminar no corresponde a la orden de producción, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item detallepedido
                if (Storage::has("ordenes/orden_{$orden->id}/archivos/{$ordenarchivo->ordenarchivo_archivo}")) {
                    Storage::delete("ordenes/orden_{$orden->id}/archivos/{$ordenarchivo->ordenarchivo_archivo}");
                    $ordenarchivo->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error("OrdenpArchivosController->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
