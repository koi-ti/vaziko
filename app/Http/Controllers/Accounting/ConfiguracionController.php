<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\CierreContable;
use App\Models\Base\Empresa;
use DB, Log, Carbon\Carbon;

class ConfiguracionController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,consultar', ['only' => ['index', 'show']]);
        $this->middleware('ability:admin,cierre|saldos', ['only' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Recuperar Empresa
        $empresa = Empresa::getEmpresa();
        $fechaCierre = Carbon::parse($empresa->empresa_fecha_cierre_contabilidad)->addMonths(1);
        return view('accounting.configuracion.main', ['message' => config('koi.meses')[$fechaCierre->month] . " de " . $fechaCierre->year]);
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
            if (!$request->has('state')) {
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la opción.']);
            }

            // Initialize transaction
            DB::beginTransaction();
            try {
                // Recuperar empresa
                $empresa = Empresa::getEmpresa();
                $fechaCierre = Carbon::parse($empresa->empresa_fecha_cierre_contabilidad);

                // Switch
                switch ($request->state) {
                    case 'closing':
                        if (!auth()->user()->ability('admin', 'cierre', ['module' => 'configuracion'])) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No tiene permisos para esta acción.']);
                        }

                        // Creo el objeto para manejar el cierre contable
                        $fechaCierre = $fechaCierre->addMonths(1);
                        $objCierre = new CierreContable($fechaCierre->month, $fechaCierre->year);
                        $cierreContable = $objCierre->generarCierre();
                        if ($cierreContable == 'OK') {
                            // Update date empresa
                            $empresa->empresa_fecha_cierre_contabilidad = $fechaCierre;
                            $empresa->save();

                            $message = 'El cierre contable se ha realizado con exito!';
                        }
                        break;
                    case 'balance':
                        if (!auth()->user()->ability('admin', 'saldos', ['module' => 'configuracion'])) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No tiene permisos para esta acción.']);
                        }

                        $user = auth()->user()->id;
                        define('ARTISAN_BINARY',base_path().'/artisan');
                        call_in_background("update:saldos {$fechaCierre->month} {$fechaCierre->year} {$user}");
                        $message = 'Se estan actualizando los saldos, cuando termine se le notificara.!';
                        break;
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => $message]);
            } catch(\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
    }
}
