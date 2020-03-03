<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp2, App\Models\Production\Ordenp8;
use DB, Log, Storage;

class DetalleImagenespController extends Controller
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
            if ($request->has('orden2')) {
                $query = Ordenp8::query();
                $query->select('koi_ordenproduccion8.*', 'orden2_orden');
                $query->join('koi_ordenproduccion2', 'orden8_orden2', '=', 'koi_ordenproduccion2.id');
                $query->where('orden8_orden2', $request->orden2);
                $imagenes = $query->get();

                $data = [];
                foreach ($imagenes as $imagen) {
                    if (Storage::has("ordenes/orden_$imagen->orden2_orden/producto_$imagen->orden8_orden2/$imagen->orden8_archivo")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->orden8_archivo;
                        $object->size = Storage::size("ordenes/orden_$imagen->orden2_orden/producto_$imagen->orden8_orden2/$imagen->orden8_archivo");
                        $object->thumbnailUrl = url("storage/ordenes/orden_$imagen->orden2_orden/producto_$imagen->orden8_orden2/$imagen->orden8_archivo");
                        $data[] = $object;
                    }
                }
                return response()->json($data);
            }
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
            // Recuperar orden
            $orden2 = Ordenp2::find($request->orden2);
            if (!$orden2 instanceof Ordenp2) {
                abort(404);
            }

            // Validar que tenga imagenes
            $file = $request->file;
            if (!empty($file)) {
                DB::beginTransaction();
                try {
                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("ordenes/orden_$orden2->orden2_orden/producto_$orden2->id/$name", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/ordenes/orden_$orden2->orden2_orden/producto_$orden2->id/$name");

                    // Insertar imagen
                    $imagen = new Ordenp8;
                    $imagen->orden8_archivo = $name;
                    $imagen->orden8_orden2 = $orden2->id;
                    $imagen->orden8_fh_elaboro = date('Y-m-d H:i:s');
                    $imagen->orden8_usuario_elaboro = auth()->user()->id;
                    $imagen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->orden8_archivo, 'url' => $url]);
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
                $orden8 = Ordenp8::find($id);
                if (!$orden8 instanceof Ordenp8) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la imagen de la orden de producción, por favor verifique la información o consulte al administrador.']);
                }

                $orden2 = Ordenp2::find($request->orden2);
                if (!$orden2 instanceof Ordenp2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la orden de producción, por favor verifique la información o consulte al administrador.']);
                }

                if ($orden8->orden8_orden2 != $orden2->id) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'La imagen que esta intentando eliminar no corresponde al detalle, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item detallepedido
                if (Storage::has("ordenes/orden_$orden2->orden2_orden/producto_$orden2->id/$orden8->orden8_archivo")) {
                    Storage::delete("ordenes/orden_$orden2->orden2_orden/producto_$orden2->id/$orden8->orden8_archivo");
                    $orden8->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error("Ordenp8Controller->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
