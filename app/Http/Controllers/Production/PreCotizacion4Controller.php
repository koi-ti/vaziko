<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\PreCotizacion4;
use Storage;

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
        if ($request->ajax()) {
            if ($request->has('precotizacion2')) {
                $query = PreCotizacion4::query();
                $query->select('koi_precotizacion4.*', 'precotizacion2_precotizacion1');
                $query->join('koi_precotizacion2', 'precotizacion4_precotizacion2', '=', 'koi_precotizacion2.id');
                $query->where('precotizacion4_precotizacion2', $request->precotizacion2);
                $imagenes = $query->get();

                $data = [];
                foreach ($imagenes as $imagen) {
                    if (Storage::has("pre-cotizaciones/precotizacion_{$imagen->precotizacion2_precotizacion1}/producto_{$imagen->precotizacion4_precotizacion2}/{$imagen->precotizacion4_archivo}")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->precotizacion4_archivo;
                        $object->size = Storage::size("pre-cotizaciones/precotizacion_{$imagen->precotizacion2_precotizacion1}/producto_{$imagen->precotizacion4_precotizacion2}/{$imagen->precotizacion4_archivo}");
                        $object->thumbnailUrl = url("storage/pre-cotizaciones/precotizacion_{$imagen->precotizacion2_precotizacion1}/producto_{$imagen->precotizacion4_precotizacion2}/{$imagen->precotizacion4_archivo}");
                        $data[] = $object;
                    }
                }
                return response()->json($data);
            }
        }
        abort(404);
    }
}
