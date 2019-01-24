<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Treasury\Facturap;
use App\Models\Base\Tercero;
use View, App, Excel, Validator, DB;

class HistorialProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            // Prepare array
            $historyProveider = [];

            if ($request->has('filter_tercero')) {

                // Recuperate tercero
                $tercero =  Tercero::select('id', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"))->where('tercero_nit', $request->filter_tercero)->first();

                // Initial position the array
                $i = 0;

                // Querie factura proveedor
                $facturaProveedor = Facturap::historyProviderReport($tercero, $historyProveider, $i);
                $historyProveider = $facturaProveedor->facturaProveedor;
                $i = $facturaProveedor->position;

            }
            // Prepare data
            $title = "Historial del proveedor $tercero->tercero_nombre";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s', 'historyProveider', date('Y_m_d H_i_s')), function($excel) use($historyProveider, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($historyProveider, $title, $type) {
                            $sheet->loadView('reports.treasury.historialproveedores.report', compact('historyProveider', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reports.treasury.historialproveedores.report',  compact('historyProveider', 'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s.pdf', 'historyProveider', date('Y_m_d H_i_s')));
                break;
            }
        }
        return view('reports.treasury.historialproveedores.index');
    }
}
