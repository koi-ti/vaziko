<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Bitacora;
use App\Models\Production\CotizacionArchivo, App\Models\Production\Cotizacion1;
use Storage, DB, Log;

class CotizacionArchivosController extends Controller
{
    public function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('cotizacion')) {
                $query = CotizacionArchivo::query();
                $query->select('koi_cotizacionarchivo.*');
                $query->join('koi_cotizacion1', 'cotizacionarchivo_cotizacion', '=', 'koi_cotizacion1.id');
                $query->where('cotizacionarchivo_cotizacion', $request->cotizacion);
                $archivos = $query->get();

                $data = [];
                foreach ($archivos as $archivo) {
                    if (Storage::has("cotizaciones/cotizacion_{$archivo->cotizacionarchivo_cotizacion}/archivos/{$archivo->cotizacionarchivo_archivo}")) {
                        $object = new \stdClass();
                        $object->uuid = $archivo->id;
                        $object->name = $archivo->cotizacionarchivo_archivo;
                        $object->size = Storage::size("cotizaciones/cotizacion_{$archivo->cotizacionarchivo_cotizacion}/archivos/{$archivo->cotizacionarchivo_archivo}");
                        $object->thumbnailUrl = url("storage/cotizaciones/cotizacion_{$archivo->cotizacionarchivo_cotizacion}/archivos/{$archivo->cotizacionarchivo_archivo}");
                        $data[] = $object;
                    }
                }
            }
            return response()->json($data);
        }
        abort(404);
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
            $cotizacion = Cotizacion1::find($request->cotizacion);
            if (!$cotizacion instanceof Cotizacion1) {
                abort(404);
            }

            // Validar que tenga archivos
            if ($request->file('file')) {
                DB::beginTransaction();
                try {
                    $file = $request->file;

                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("cotizaciones/cotizacion_{$cotizacion->id}/archivos/$name", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/cotizaciones/cotizacion_{$cotizacion->id}/archivos/$name");

                    // Insertar archivo
                    $archivo = new CotizacionArchivo;
                    $archivo->cotizacionarchivo_archivo = $name;
                    $archivo->cotizacionarchivo_cotizacion = $cotizacion->id;
                    $archivo->cotizacionarchivo_fh_elaboro = date('Y-m-d H:i:s');
                    $archivo->cotizacionarchivo_usuario_elaboro = auth()->user()->id;
                    $archivo->save();

                    // Crear bitacora
                    Bitacora::createBitacora($cotizacion, [], "Se agrego un archivo {$name}", 'Archivos', 'C', $request->ip());

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $archivo->id, 'name' => $archivo->cotizacionarchivo_archivo, 'url' => $url]);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
        }
        abort(404);
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
                $cotizacionarchivo = CotizacionArchivo::find($id);
                if (!$cotizacionarchivo instanceof CotizacionArchivo) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el archivo, por favor verifique la información o consulte al administrador.']);
                }

                $cotizacion = Cotizacion1::find($request->cotizacion);
                if (!$cotizacion instanceof Cotizacion1) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cotizacion, por favor verifique la información o consulte al administrador.']);
                }

                if ($cotizacionarchivo->cotizacionarchivo_cotizacion != $cotizacion->id) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'El archivo que esta intentando eliminar no corresponde a la cotización, por favor verifique la información o consulte al administrador.']);
                }

                // Crear bitacora
                Bitacora::createBitacora($cotizacion, [], "Se elimino el archivo {$cotizacionarchivo->cotizacionarchivo_archivo}", 'Archivos', 'D');

                // Eliminar item detallepedido
                if (Storage::has("cotizaciones/cotizacion_{$cotizacion->id}/archivos/{$cotizacionarchivo->cotizacionarchivo_archivo}")) {
                    Storage::delete("cotizaciones/cotizacion_{$cotizacion->id}/archivos/{$cotizacionarchivo->cotizacionarchivo_archivo}");
                    $cotizacionarchivo->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error("CotizacionArchivosController->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
    }
}
