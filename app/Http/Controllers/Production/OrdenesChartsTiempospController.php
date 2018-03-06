<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Production\Ordenp, App\Models\Production\Tiempop;
use DB;

class OrdenesChartsTiempospController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $ordenp = Ordenp::find($request->orden_id);
            if( !$ordenp instanceof Ordenp ){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la orden']);
            }

            // Construir object con graficas
            $object = new \stdClass();
            $query = Tiempop::query();
            $query->select( DB::raw("CONCAT(tercero_nombre1, ' ',tercero_apellido1) AS tercero_nombre, SUM(TIMESTAMPDIFF(MINUTE, tiempop_hora_inicio, tiempop_hora_fin) ) as tiempo_x_empleado"));
            $query->join('koi_tercero', 'tiempop_tercero', '=', 'koi_tercero.id');
            $query->where('tiempop_ordenp', $ordenp->id);
            $query->groupBy('tercero_nombre');
            $empleados = $query->get();

            // Armar objecto para la grafica
            $chartempleado = new \stdClass();
            $chartempleado->labels = [];
            $chartempleado->data = [];
            foreach ($empleados as $empleado) {
                $chartempleado->labels[] = $empleado->tercero_nombre;
                $chartempleado->data[] = $empleado->tiempo_x_empleado;
            }
            $object->chartempleado = $chartempleado;

            $areasp = Tiempop::select('areap_nombre', DB::raw("TIMESTAMPDIFF (MINUTE, tiempop_hora_inicio, tiempop_hora_fin) as tiempo_x_area"))
                ->join('koi_areap', 'tiempop_areap', '=', 'koi_areap.id')
                ->where('tiempop_ordenp', $ordenp->id)
                ->groupBy('areap_nombre')
                ->get();

            // Armar objecto para la grafica
            $chartareap = new \stdClass();
            $chartareap->labels = [];
            $chartareap->data = [];
            foreach ($areasp as $areap) {
                $chartareap->labels[] = $areap->areap_nombre;
                $chartareap->data[] = $areap->tiempo_x_area;
            }
            $object->chartareap = $chartareap;

            $tiempototal = Tiempop::select(DB::raw("SUM( TIMESTAMPDIFF (MINUTE, tiempop_hora_inicio, tiempop_hora_fin) ) as tiempo_total"))->first();
            $object->tiempototal = $tiempototal->tiempo_total;

            $object->success = true;
            return response()->json($object);
        }
        abort(404);
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
