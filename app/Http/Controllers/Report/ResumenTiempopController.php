<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Reports\Production\ResumenTiempoProduccion;
use App\Models\Base\Tercero, App\Models\Production\Tiempop;
use Validator, DB;

class ResumenTiempopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            $data = $request->all();

            $validator = Validator::make($data, [
                'filter_fecha_inicial' => 'required',
                'filter_fecha_final' => 'required',
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                return redirect('/rresumentiemposp')
                    ->withErrors($validator)
                    ->withInput();
            }

            // Validar fecha inicial no puede ser mayor a la final
            if($request->fecha_final < $request->fecha_inicial ){
                return redirect('/rresumentiemposp')
                    ->withErrors('La fecha final no puede ser menor a la inicial.')
                    ->withInput();
            }

            if ( !empty($request->filter_funcionario_nombre) ) {
                $tercero = Tercero::where('tercero_nit', $request->filter_funcionario)->first();
                if (!$tercero instanceof Tercero) {
                    return redirect('/rresumentiemposp')
                        ->withErrors('No es posible recuperar el funcionario.')
                        ->withInput();
                }
            }

            $query = Tiempop::query();
            $query->select(DB::raw("SUM(TIME_TO_SEC(TIMEDIFF(tiempop_hora_fin, tiempop_hora_inicio))) as time, COUNT(*) as ordenes, (CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, ( CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END) )ELSE tercero_razonsocial END) AS tercero_nombre"), 'tiempop_actividadp', 'tiempop_subactividadp', 'tiempop_hora_inicio', 'tiempop_hora_fin', 'tercero_nit', 'actividadp_nombre', 'subactividadp_nombre');
            $query->whereNull('tiempop_ordenp');
            $query->whereBetween('tiempop_fecha', [$request->filter_fecha_inicial, $request->filter_fecha_final]);
            $query->join('koi_tercero', 'tiempop_tercero', '=', 'koi_tercero.id');
            $query->join('koi_actividadp', 'tiempop_actividadp', '=', 'koi_actividadp.id');
            $query->leftjoin('koi_subactividadp', 'tiempop_subactividadp', '=', 'koi_subactividadp.id');
            if (!empty($request->filter_funcionario_nombre)) {
                $query->where('tiempop_tercero', $tercero->id);
            }
            $query->groupBy('tiempop_actividadp', 'tiempop_subactividadp');
            $sinordenes = $query->get();

            $query = Tiempop::query();
            $query->select(DB::raw("SUM(TIME_TO_SEC(TIMEDIFF(tiempop_hora_fin, tiempop_hora_inicio))) as time, COUNT(*) as ordenes, (CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, ( CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END) )ELSE tercero_razonsocial END) AS tercero_nombre"), 'tiempop_actividadp', 'tiempop_subactividadp', 'tiempop_hora_inicio', 'tiempop_hora_fin', 'tercero_nit', 'actividadp_nombre', 'subactividadp_nombre');
            $query->whereNotNull('tiempop_ordenp');
            $query->whereBetween('tiempop_fecha', [$request->filter_fecha_inicial, $request->filter_fecha_final]);
            $query->join('koi_tercero', 'tiempop_tercero', '=', 'koi_tercero.id');
            $query->join('koi_actividadp', 'tiempop_actividadp', '=', 'koi_actividadp.id');
            $query->leftjoin('koi_subactividadp', 'tiempop_subactividadp', '=', 'koi_subactividadp.id');
            if (!empty($request->filter_funcionario_nombre)) {
                $query->where('tiempop_tercero', $tercero->id);
            }
            $query->groupBy('tiempop_actividadp', 'tiempop_subactividadp');
            $conordenes = $query->get();

            // Preparar datos reporte
            $title = utf8_decode("Resumen tiempos de producción de $request->filter_fecha_inicial a $request->filter_fecha_final");
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'pdf':
                    $pdf = new ResumenTiempoProduccion('L', 'mm', 'A4');
                    $pdf->buldReport($sinordenes, $conordenes, $title);
                break;
            }
        }
        return view('reports.production.resumentiemposp.index');
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
