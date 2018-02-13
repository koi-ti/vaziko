<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Tiempop, App\Models\Base\Tercero, App\Models\Production\Ordenp, App\Models\Production\Areap, App\Models\Production\Actividadp, App\Models\Production\SubActividadp;
use View, App, Validator, DB;

class TiempopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->has('type')){
            $data = $request->all();

            $validator = Validator::make($data, [
                'fecha_inicial' => 'required',
                'fecha_final' => 'required',
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                return redirect('/rtiemposp')
                    ->withErrors($validator)
                    ->withInput();
            }

            // Validar fecha inicial no puede ser mayor a la final
            if($request->fecha_final < $request->fecha_inicial ){
                return redirect('/rtiemposp')
                    ->withErrors('La fecha final no puede ser menor a la inicial.')
                    ->withInput();
            }

            // Recuperar terceros
            if( count($request->tiempop_tercero) <= 0 ){
                return redirect('/rtiemposp')
                    ->withErrors('Por favor agregue un funcionario para generar el reporte.')
                    ->withInput();
            }

            $tiempos = [];
            foreach ($request->tiempop_tercero as $rtercero) {
                $object = new \stdClass();

                $query = Tercero::query();
                $query->select('koi_tercero.id', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, ( CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END) )ELSE tercero_razonsocial END) AS tercero_nombre"));
                $query->where('tercero_nit', $rtercero);
                $tercero = $query->first();

                if(!$tercero instanceof Tercero){
                    return redirect('/rtiemposp')
                        ->withErrors("No es posible recuperar el funcionario $tercero->tercero_nombre, por favor verifique la información o consulte al administrador.")
                        ->withInput();

                }
                $object->tercero = $tercero;

                // Recuperar tiempos del tercero
                $query = Tiempop::query();
                $query->select('koi_tiempop.*', 'actividadp_nombre', 'subactividadp_nombre', 'areap_nombre', DB::raw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) as orden_codigo"), DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END),
                    ' (', orden_referencia ,')'
                    ) AS tercero_nombre"
                ));
                $query->leftJoin('koi_ordenproduccion', 'tiempop_ordenp', '=', 'koi_ordenproduccion.id');
                $query->leftJoin('koi_tercero', 'orden_cliente', '=', 'koi_tercero.id');
                $query->leftJoin('koi_subactividadp', 'tiempop_subactividadp', '=', 'koi_subactividadp.id');
                $query->join('koi_actividadp', 'tiempop_actividadp', '=', 'koi_actividadp.id');
                $query->join('koi_areap', 'tiempop_areap', '=', 'koi_areap.id');
                $query->where('tiempop_tercero', $tercero->id);
                $query->where('tiempop_fecha', '>=', $request->fecha_inicial);
                $query->where('tiempop_fecha', '<=', $request->fecha_final);
                $query->orderBy('tiempop_fecha', 'asc');
                $tiemposp = $query->get();

                $object->tiemposp = $tiemposp;
                $tiempos[] = $object;
            }

            $fechai = $request->fecha_inicial;
            $fechaf = $request->fecha_final;

            // Preparar datos reporte
            $title = sprintf('%s %s %s %s', 'Tiempos de producción de ', $fechai, ' a ', $fechaf );
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reports.production.tiemposp.report',  compact('tiempos', 'fechai', 'fechaf', 'title', 'type'))->render());
                    $pdf->setPaper('A4', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'tiempos_de_producción', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reports.production.tiemposp.index');
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
