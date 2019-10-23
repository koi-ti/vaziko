<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Tiempop, App\Models\Production\Actividadp, App\Models\Production\SubActividadp, App\Models\Production\Ordenp, App\Models\Production\Areap;
use DB, Log, Auth;

class TiempopController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,consultar');
        $this->middleware('ability:admin,crear|editar', ['only' => ['store', 'update']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('production.tiemposp.main');
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
            $data = $request->all();
            $tiempop = new Tiempop;
            if ($tiempop->isValid($data)) {
                DB::beginTransaction();
                try {
                    $itemcodigo = $itemtercero = $itemsubactividadp = null;

                    // Validar rango hora inicio
                    $query = Tiempop::query();
                    $query->where('tiempop_tercero', Auth::user()->id);
                    $query->where('tiempop_fecha', $request->tiempop_fecha);
                    $query->where(function ($query) use ($request){
                        $query->where('tiempop_hora_inicio', '<=', $request->tiempop_hora_inicio);
                        $query->where('tiempop_hora_fin', '>', $request->tiempop_hora_inicio);
                    });
                    $rango = $query->get();

                    if (count($rango) > 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'La hora de inicio no puede interferir con otras ya registradas, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar Actividadop
                    $actividadp = Actividadp::find($request->tiempop_actividadp);
                    if (!$actividadp instanceof Actividadp) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar actividad de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar Areap
                    $areap = Areap::find($request->tiempop_areap);
                    if (!$areap instanceof Areap) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar area de producción, por favor verifique la información o consulte al administrador.']);
                    }

                    if ($request->has('tiempop_ordenp')) {
                        // Recuperar Ordenp
                        $ordenp = Ordenp::getOrdenp($request->tiempop_ordenp);
                        if (!$ordenp instanceof Ordenp) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        if ($ordenp->orden_anulada && (!$ordenp->orden_culminada || !$ordenp->orden_abierta)) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'La orden de producción no es válida.']);
                        }

                        $tiempop->tiempop_ordenp = $ordenp->id;
                        $itemcodigo = $ordenp->orden_codigo;
                        $itemtercero = $ordenp->tercero_nombre;
                    }

                    // Recuperar Subactividadp
                    if ($request->has('tiempop_subactividadp')) {
                        $subactividadp = SubActividadp::find( $request->tiempop_subactividadp );
                        if (!$subactividadp instanceof SubActividadp) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar subactividad de producción, por favor verifique la información o consulte al administrador.']);
                        }

                        // Validar que sean validas actividadp y subactividadp
                        if ($actividadp->id != $subactividadp->subactividadp_actividadp) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'La actividad no esta relacionada con la subactividad, por favor verifique la información o consulte al administrador.']);
                        }

                        $tiempop->tiempop_subactividadp = $subactividadp->id;
                        $itemsubactividadp = $subactividadp->subactividadp_nombre;
                    }

                    // Tiempop
                    $tiempop->fill($data);
                    $tiempop->tiempop_actividadp = $actividadp->id;
                    $tiempop->tiempop_areap = $areap->id;
                    $tiempop->tiempop_tercero = Auth::user()->id;
                    $tiempop->tiempop_fh_elaboro = date('Y-m-d H:i:s');
                    $tiempop->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tiempop->id, 'msg' => 'Se ha registrado el tiempo con exito!']);
                } catch(\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tiempop->errors]);
        }
        abort(403);
    }
}
