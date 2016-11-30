<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth, DB, Log, Datatables;

use App\Models\Production\Ordenp, App\Models\Base\Tercero;

class OrdenpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ordenp::query();
            $query->select(DB::raw("CONCAT(ordenproduccion0_numero,'-',SUBSTRING(ordenproduccion0_ano, -2)) as ordenp_codigo"), 'ordenproduccion0_numero as ordenp_numero', 'ordenproduccion0_ano as ordenp_ano', 'ordenproduccion0_fecha_elaboro as ordenp_fecha',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('koi_tercero', 'ordenproduccion0_tercero', '=', 'koi_tercero.id');

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Orden codigo
                    if($request->has('ordenp_numero')) {
                        $query->whereRaw("CONCAT(ordenproduccion0_numero,'-',SUBSTRING(ordenproduccion0_ano, -2)) LIKE '%{$request->ordenp_numero}%'");
                    }
                    // Tercero nit
                    if($request->has('ordenp_tercero_nit')) {
                        $query->where('tercero_nit', $request->ordenp_tercero_nit);
                    }
                    // Tercero id
                    if($request->has('ordenp_tercero_id')) {
                        $query->whereRaw('ordenproduccion0_tercero', $request->ordenp_tercero_id);
                    }
                })
                ->make(true);
        }
        return view('production.ordenes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.ordenes.create');
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

            $orden = new Ordenp;
            if ($orden->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->orden_cliente)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar numero orden
                    $numero = DB::table('koi_ordenproduccion')->where('orden_ano', date('Y'))->max('orden_numero');
                    if(!is_integer($numero)) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar numero orden, por favor verifique la información o consulte al administrador.']);
                    }
                    $numero ++;

                    // Orden de produccion
                    $orden->fill($data);
                    $orden->orden_cliente = $tercero->id;
                    $orden->orden_ano = date('Y');
                    $orden->orden_numero = $numero;
                    $orden->orden_usuario_elaboro = Auth::user()->id;
                    $orden->orden_fecha_elaboro = date('Y-m-d H:m:s');
                    $orden->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $orden->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden->errors]);
        }
        abort(403);
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

    /**
     * Search orden.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->has('ordenp_codigo')) {
            $ordenp = Ordenp::select(
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            )
            ->join('koi_tercero', 'ordenproduccion0_tercero', '=', 'koi_tercero.id')
            ->whereRaw("CONCAT(ordenproduccion0_numero,'-',SUBSTRING(ordenproduccion0_ano, -2)) = '{$request->ordenp_codigo}'")->first();
            if($ordenp instanceof Ordenp) {
                return response()->json(['success' => true, 'tercero_nombre' => $ordenp->tercero_nombre]);
            }
        }
        return response()->json(['success' => false]);
    }
}
