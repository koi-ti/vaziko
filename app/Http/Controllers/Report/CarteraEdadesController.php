<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Reports\Receivable\CarteraEdades;
use App\Models\Receivable\Factura4, App\Models\Base\Tercero;
use Validator, Excel, DB;

class CarteraEdadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            $validator = Validator::make($request->all(), [
                'filter_fecha' => 'required',
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                session()->flash('errors', $validator->errors()->all());
                return redirect('/rcarteraedades')->withInput();
            }

            $query = Factura4::query();
            $query->select('koi_factura4.*', 'factura1_numero', 'factura1_fecha', 'factura1_prefijo', DB::raw('DATEDIFF(factura4_vencimiento, NOW() ) as days'), DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'tercero_nit');
            $query->join('koi_factura1', 'factura4_factura1', '=', 'koi_factura1.id');
            $query->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id');
            $query->where('factura4_saldo', '<>',  0);
            $query->whereRaw("factura1_fecha <= '$request->filter_fecha'");

            if ($request->has('filter_tercero')) {
                // Validate Tercero
                $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                if (!$tercero instanceof Tercero) {
                    session()->flash('errors', ['No es posible recuperar tercero, por favor verifique la información o consulte al administrador.']);
                    return redirect('/rcarteraedades')->withInput();
                }
                $query->where('factura1_tercero', $tercero->id);
            }

            $query->orderBy('tercero_nit', 'asc');
            $query->orderBy('factura1_numero', 'asc');
            $data = $query->get();

            // Prepare data
            $title = "Reporte cartera por edades";
            $type = $request->type;

            $headerdays = ['MORA > 360', 'MORA >180 Y <= 360', 'MORA > 90 Y <= 180', 'MORA > 60 Y <= 90', 'MORA > 30 Y <= 60', 'MORA > 0 Y <= 30', 'DE 0 A 30', 'DE 31 A 60', 'DE 61 A 90', 'DE 91 A 180', 'DE 181 A 360', '> 360'];

            // Generate file
            switch ($type) {
                case 'pdf':
                    $pdf = new CarteraEdades('L', 'mm', 'A3');
                    $pdf->buldReport($data, $title);
                break;

                case 'xls':
                    Excel::create(sprintf('%s_%s', 'cartera_edades', date('Y_m_d H_i_s')), function($excel) use($data, $title, $type, $headerdays) {
                        $excel->sheet('Excel', function($sheet) use($data, $title, $type, $headerdays) {
                            $sheet->loadView('reports.receivable.carteraedades.report', compact('data', 'title', 'type', 'headerdays'));
                            $sheet->setWidth(array('A' => 15, 'B' => 50, 'C' => 10, 'D' => 15, 'E' => 10, 'F' => 20, 'G' => 20, 'H' => 20, 'I' => 20, 'J' => 20, 'K' => 20, 'L' => 20, 'M' => 20, 'N' => 20, 'O' => 20, 'P' => 20, 'Q' => 20, 'R' => 20));
                            $sheet->setFontFamily('Liberation Serif');
                            $sheet->setFontSize(11);
                        });
                    })->download('xls');
                break;
            }
        }
        return view('reports.receivable.carteraedades.index');
    }
}
