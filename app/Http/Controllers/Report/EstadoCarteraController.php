<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Receivable\EstadoCartera;
use App\Models\Receivable\Factura4;
use App\Models\Base\Tercero;
use Excel, DB;

class EstadoCarteraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            $query = Factura4::query();
            $query->select('koi_factura4.*', 'factura1_numero', 'factura1_fecha', 'factura1_prefijo', DB::raw("DATEDIFF(factura4_vencimiento, NOW()) as days, (CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'tercero_nit', 'tercero_direccion', 'tercero_telefono1', 'municipio_nombre' );
            $query->join('koi_factura1', 'factura4_factura1', '=', 'koi_factura1.id');
            $query->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id');
            $query->join('koi_municipio', 'tercero_municipio', '=', 'koi_municipio.id');
            $query->where('factura4_saldo', '<>',  0);
            $query->whereRaw("factura1_fecha <= '$request->filter_fecha'");

            // Validate Tercero
            if ($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                if (!$tercero instanceof Tercero) {
                    session()->flash('errors', ['No es posible recuperar tercero, por favor verifique la información o consulte al administrador.']);
                    return redirect('/restadocartera')->withInput();
                }
                $query->where('factura1_tercero', $tercero->id);
            }

            $query->orderBy('tercero_nit', 'asc');
            $query->orderBy('factura4_vencimiento', 'asc');
            $data = $query->get();

            // Prepare data
            $title = "Reporte estado de cartera";
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s', 'estado_cartera', date('Y_m_d H_i_s')), function($excel) use($data, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($data, $title, $type) {
                            $sheet->loadView('reports.receivable.estadocartera.report', compact('data', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new EstadoCartera('L', 'mm', 'Letter');
                    $pdf->buldReport($data, $title);
                break;
            }
        }
        return view('reports.receivable.estadocartera.index');
    }
}
