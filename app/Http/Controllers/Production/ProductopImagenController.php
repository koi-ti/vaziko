<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\ProductopImagen, App\Models\Production\Productop;
use Storage, DB;

class ProductopImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = [];
            if ($request->has('productop')) {
                $query = ProductopImagen::query();
                $query->where('productopimagen_productop', $request->productop);
                $imagenes = $query->get();

                foreach ($imagenes as $imagen) {
                    if (Storage::has("productosp/productop_{$imagen->productopimagen_productop}/{$imagen->productopimagen_archivo}")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->productopimagen_archivo;
                        $object->size = Storage::size("productosp/productop_{$imagen->productopimagen_productop}/{$imagen->productopimagen_archivo}");
                        $object->thumbnailUrl = url("storage/productosp/productop_{$imagen->productopimagen_productop}/{$imagen->productopimagen_archivo}");
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
            // Recuperar productop
            $productop = Productop::find($request->productop);
            if (!$productop instanceof Productop) {
                abort(404);
            }

            // Validar que tenga imagenes
            $file = $request->file;
            if (!empty($file)) {
                DB::beginTransaction();
                try {
                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("productosp/productop_{$productop->id}/{$name}", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/productosp/productop_{$productop->id}/{$name}");

                    // Insertar imagen
                    $imagen = new ProductopImagen;
                    $imagen->productopimagen_archivo = $name;
                    $imagen->productopimagen_productop = $productop->id;
                    $imagen->productopimagen_fh_elaboro = date('Y-m-d H:i:s');
                    $imagen->productopimagen_usuario_elaboro = auth()->user()->id;
                    $imagen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->productopimagen_archivo, 'url' => $url]);
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
                $productopimagen = ProductopImagen::find($id);
                if (!$productopimagen instanceof ProductopImagen) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la imagen, por favor verifique la información o consulte al administrador.']);
                }

                $productop = Productop::find($request->productop);
                if (!$productop instanceof Productop) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el producto, por favor verifique la información o consulte al administrador.']);
                }

                if ($productopimagen->productopimagen_productop != $productop->id) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'La imagen que esta intentando eliminar no corresponde a la producto, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar
                if (Storage::has("productosp/productop_{$productopimagen->productopimagen_productop}/{$productopimagen->productopimagen_archivo}")) {
                    Storage::delete("productosp/productop_{$productopimagen->productopimagen_productop}/{$productopimagen->productopimagen_archivo}");
                }

                $productopimagen->delete();

                DB::commit();
                return response()->json(['success' => true]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error("ProductopImagenController->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
