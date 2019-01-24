<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Notificacion, App\Models\Base\Tercero;
use DB, Auth;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = auth()->user()->notifications();

        if($request->ajax()){
            if($request->has('searchDate')){
                if(!empty($request->searchDate)){
                    $query->whereRaw("notificacion_fh LIKE '%{$request->searchDate}%'");
                }
            }

            if($request->has('searchEstado')){
                if(!empty($request->searchEstado)){
                    if($request->searchEstado == 'T'){
                        $query->where('notificacion_visto', true);
                    }else{
                        $query->where('notificacion_visto', false);
                    }
                }
            }

            $notifications = $query->paginate(10);

            return response()->json( view('admin.notificaciones.filter')->with('notificaciones', $notifications)->render() );
        }
        return view('admin.notificaciones.main')->with('notificaciones', $query->paginate(10));
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
        if($request->ajax()) {
            // Recuperar tercero
            $tercero = Tercero::find(Auth::user()->id);
            if(!$tercero instanceof Tercero){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información del asiento o consulte al administrador.']);
            }

            // Recuperar Notificacion
            $notification = Notificacion::find($request->notification);
            if(!$notification instanceof Notificacion){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la notificación, por favor verifique la información del asiento o consulte al administrador.']);
            }

            // Validar
            if( $notification->notificacion_tercero != $tercero->id ){
                return response()->json(['success' => false, 'errors' => 'La notificación no correponde al cliente, por favor verifique la información del asiento o consulte al administrador.']);
            }

            DB::beginTransaction();
            try{
                // Update Notificacion
                $notification->notificacion_visto = true;
                $notification->notificacion_fh_visto = date('Y-m-d H:i:s');
                $notification->save();

                // Commit
                DB::commit();
                return response()->json(['success' => true, 'id' => $notification->id]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
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
