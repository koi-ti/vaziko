<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Accounting\ReglaAsiento;
use App\Models\Accounting\Asiento;
use App\Models\Receivable\Factura1;
use DB;

class ReglaAsientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accounting.reglasasiento.main');
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
        $object = new \stdClass();
        $object->detalle = [];

        $data = $request->all();
        $reglas = new ReglaAsiento;
        if ($reglas->isValid($data)) {
            $factura1 = Factura1::where('factura1_numero',$request->factura_numero)->first();
            if (!$factura1 instanceof Factura1) {
                $error = "No es posible encontrar numero de factura , verifique información por favor";
                return redirect('reglasasientos')->withErrors($error)->withInput();
            }

            $object->encabezado = Asiento::getAsiento($factura1->factura1_asiento);

            // Consulto reglas
            $rules_sql ="
                SELECT * FROM koi_regla_asiento WHERE regla_documento = 'FACT'
            ";
            $query = DB::select($rules_sql);

            // Itero registro de la tabla reglas
            foreach ($query as $item) {
                // Armo sql que satisface cada regla
                $sql = "
                    $item->regla_select, plancuentas_nombre $item->regla_tabla $item->regla_union INNER JOIN koi_plancuentas ON (plancuentas_cuenta = $item->regla_cuenta)  $item->regla_condicion factura1_numero = $request->factura_numero  $item->regla_grupo";

                $query_rule = DB::select($sql);
                foreach ($query_rule as $value) {
                    // Preparo data
                    if ($value->valor != 0) {
                        // Prepare detalle asiento
                        $detalle = [];
                        $detalle['Cuenta'] = $item->regla_cuenta;
                        $detalle['Cuenta_Nombre'] = $value->plancuentas_nombre;
                        $detalle['Tercero'] = $value->nit;
                        $detalle['CentroCosto'] = $value->centrocosto;
                        $detalle['CentroCosto_Nombre'] = $value->centrocosto_nombre;
                        $detalle['Detalle'] = '';
                        $detalle['Naturaleza'] = $item->regla_naturaleza;
                        $detalle['Base'] = $value->base;
                        $detalle['Credito'] = ($item->regla_naturaleza == 'C') ? $value->valor: 0;
                        $detalle['Debito'] = ($item->regla_naturaleza == 'D') ? $value->valor: 0;
                        $object->detalle[] = $detalle;
                    }
                }
            }
            // dd($object);
            return view('accounting.reglasasiento.main', ['asiento' => $object ]);
        }
        return redirect('reglasasientos')->withErrors($reglas->errors)->withInput();
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
