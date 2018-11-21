<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
        if( $request->has('type') ){
            $validator = Validator::make($request->all(), [
                'filter_fecha' => 'required',
                'filter_tercero' => 'required'
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                return redirect('/rcarteraedades')
                    ->withErrors($validator)
                    ->withInput();
            }

            $query = Factura4::query();
            $query->select('koi_factura4.*', 'factura1_numero', 'factura1_fecha', 'factura1_prefijo', DB::raw('DATEDIFF(factura4_vencimiento, NOW() ) as days'), DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'tercero_nit');
            $query->join('koi_factura1', 'factura4_factura1', '=', 'koi_factura1.id');
            $query->join('koi_tercero', 'factura1_tercero', '=', 'koi_tercero.id');
            $query->where('factura4_saldo', '<>',  0);
            $query->whereRaw("factura1_fecha <= '$request->filter_fecha'");
            if($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();

                // Validate Tercero
                if (!$tercero instanceof Tercero) {
                    return redirect('/rcarteraedades')
                    ->withErrors("No es posible recuperar tercero, por favor verifique la información o consulte al administrador.")
                    ->withInput();
                }
                $query->where('factura1_tercero', $tercero->id);
            }
            $query->orderBy('tercero_nit', 'asc');
            $query->orderBy('factura4_vencimiento', 'asc');
            $data = $query->get();

            // Prepare data
            $title = "Reporte cartera por edades";
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s', 'cartera_edades', date('Y_m_d H_m_s')), function($excel) use($data, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($data, $title, $type) {
                            $sheet->loadView('reports.receivable.carteraedades.report', compact('data', 'title', 'type'));
                        });
                    })->download('xls');
                break;
            }
        }
        return view('reports.receivable.carteraedades.index');
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
        //
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
    public function destroy($id)
    {
        //
    }
}
