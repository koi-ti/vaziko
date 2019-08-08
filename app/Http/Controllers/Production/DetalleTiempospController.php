<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Production\Tiempop, App\Models\Production\Actividadp, App\Models\Production\SubActividadp, App\Models\Production\Ordenp, App\Models\Production\Areap;
use DB, Log, Auth, Carbon\Carbon;

class DetalleTiempospController extends Controller
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
            if ($request->type == 'tiemposp') {
                $data = Tiempop::getTiemposp();
            }

            if ($request->type == 'ordenp') {
                $data = Tiempop::getTiempospOrdenp($request->orden2_orden);
            }

            return response()->json($data);
        }
        abort(404);
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
        if ($request->ajax()) {
            $data = $request->all();
            $type = $request->type;

            $tiempop = Tiempop::findOrFail( $id );
            if (!$tiempop instanceof Tiempop) {
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tiempo de la orden, por favor verifique la información o consulte al administrador.']);
            }

            switch ($type) {
                case 'tiemposp':
                    if ($tiempop->tiempop_tercero != Auth::user()->id) {
                        return response()->json(['success' => false, 'errors' => 'El tiempo que esta intentando editar no corresponde al tercero, por favor verifique la información o consulte al administrador.']);
                    }

                    $convertinitialtime = Carbon::parse("$request->tiempop_hora_inicio:00")->toTimeString();
                    $convertendtime = Carbon::parse("$request->tiempop_hora_fin:00")->toTimeString();

                    // Validar rango hora inicio
                    $query = Tiempop::query();
                    $query->where('tiempop_tercero', Auth::user()->id);
                    $query->where('tiempop_fecha', $request->tiempop_fecha);
                    $query->where(function ($query) use ($convertinitialtime, $convertendtime, $tiempop){
                        $query->where('tiempop_hora_inicio', '<=', $convertinitialtime);
                        $query->where('tiempop_hora_fin', '>', $convertendtime);
                        $query->where('koi_tiempop.id', '!=', $tiempop->id);
                    });
                    $rango = $query->get();

                    if (count($rango) > 0) {
                        return response()->json(['success' => false, 'errors' => 'La hora de inicio no puede interferir con otras ya registradas, por favor verifique la información o consulte al administrador.']);
                    }

                    if ($convertendtime <= $convertinitialtime) {
                        return response()->json(['success' => false, 'errors' => 'La hora de inicio no puede ser mayor o igual a la final.']);
                    }

                    // Recuperar ordenp
                    $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '$request->tiempop_ordenp_edit'")->first();
                    if (!$ordenp instanceof Ordenp) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar la orden, por favor verifique la información o consulte al administrador.']);
                    }

                    DB::beginTransaction();
                    try{
                        // Tiempop
                        $tiempop->fill($data);
                        $tiempop->tiempop_ordenp = $ordenp->id;
                        $tiempop->save();

                        // Commit Transaction
                        DB::commit();
                        return response()->json(['success' => true, 'msg' => 'El tiempo se edito con exito.']);
                    } catch(\Exception $e) {
                        DB::rollback();
                        Log::error($e->getMessage());
                        return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                    }
                    break;

                case 'ordenp':
                    if ($tiempop->isValid($data)) {
                       DB::beginTransaction();
                       try{
                           $subactividadp = null;
                           // Recuperar Actividadp
                           $actividadp = Actividadp::find($request->tiempop_actividadp);
                           if (!$actividadp instanceof Actividadp) {
                               DB::rollback();
                               return  response()->json(['success' => false, 'errors' => 'No es posible recuperar la actividad de producción, por favor verifique la información o consulte al administrador.']);
                           }

                           // Recuperar SubActividadp
                           if (!empty($request->tiempop_subactividadp)) {
                               $subactividadp = SubActividadp::find( $request->tiempop_subactividadp );
                               if (!$subactividadp instanceof SubActividadp) {
                                   DB::rollback();
                                   return  response()->json(['success' => false, 'errors' => 'No es posible recuperar la subactividad de producción, por favor verifique la información o consulte al administrador.']);
                               }

                               if ($subactividadp->subactividadp_actividadp != $actividadp->id) {
                                   DB::rollback();
                                   return  response()->json(['success' => false, 'errors' => 'La subactividad no corresponde a la actividad de producción, por favor verifique la información o consulte al administrador.']);
                               }
                               $tiempop->tiempop_subactividadp = $subactividadp->id;
                               $subactividadp = $subactividadp->subactividadp_nombre;
                           } else {
                               $tiempop->tiempop_subactividadp = null;
                           }

                           // Recuperar Areap
                           $areap = Areap::find($request->tiempop_areap);
                           if (!$areap instanceof Areap) {
                               DB::rollback();
                               return  response()->json(['success' => false, 'errors' => 'No es posible recuperar el área de producción, por favor verifique la información o consulte al administrador.']);
                           }

                           // Tiempop
                           $tiempop->fill($data);
                           $tiempop->tiempop_actividadp = $actividadp->id;
                           $tiempop->tiempop_areap = $areap->id;
                           $tiempop->save();

                           // Commit Transaction
                           DB::commit();
                           return response()->json(['success' => true, 'actividadp_nombre' => $actividadp->actividadp_nombre, 'subactividadp_nombre' => $subactividadp, 'areap_nombre' => $areap->areap_nombre, 'msg' => 'El tiempo se edito con exito.']);
                       } catch(\Exception $e) {
                           DB::rollback();
                           Log::error($e->getMessage());
                           return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                       }
                   }
                   break;

                default:
                    return response()->json(['success' => false, 'errors' => 'La acción no esta asignada a ningun modulo, por favor verifique la información o consulte al administrador.']);
                    break;
            }
            return response()->json(['success' => false, 'errors' => $tiempop->errors]);
        }
        abort(404);
    }
}
