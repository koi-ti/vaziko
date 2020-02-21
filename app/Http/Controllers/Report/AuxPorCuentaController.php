<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\AuxPorCuenta;
use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use App\Models\Base\Tercero;
use Excel, DB, Validator;

class AuxPorCuentaController extends Controller
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
                'mes' => 'required|numeric|min:1|max:12',
                'ano' => 'required|numeric|min:2015',
                'cuenta_inicio' => 'required|numeric'
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                session()->flash('errors', $validator->errors()->all());
                return redirect('/rauxporcuenta')->withInput();
            }

            // Saldo inicial de la cuenta
            $saldo = new \stdClass();
            $saldo->inicial = 0 ;
            $saldo->debitomes = 0 ;
            $saldo->creditomes = 0 ;
            $saldo->final = 0 ;

            // Query
            $query = Asiento2::query();
            $query->select('asiento2_detalle', 'asiento2_debito as debito', 'asiento2_credito as credito', 'asiento1_numero', DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date"),'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'documento_nombre', 'folder_codigo');
            $query->join('koi_asiento1','asiento2_asiento','=','koi_asiento1.id');
            $query->join('koi_tercero', 'asiento2_beneficiario', '=', 'koi_tercero.id');
            $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
            $query->leftJoin('koi_folder', 'koi_documento.documento_folder', '=', 'koi_folder.id');
            $query->where('koi_asiento1.asiento1_ano', $request->ano);
            $query->where('koi_asiento1.asiento1_mes', $request->mes);

            // Filters
            if ($request->has('cuenta_inicio')) {
                $cuenta = PlanCuenta::where('plancuentas_cuenta',$request->cuenta_inicio)->first();
                // Validate Plan Cuenta
                if (!$cuenta instanceof PlanCuenta) {
                    session()->flash('errors', ['No es posible recuperar plan  de cuenta, por favor verifique la información o consulte al administrador.']);
                    return redirect('/rauxporcuenta')->withInput();
                }

                // Sql saldos
                $mes = $request->mes;
                $ano = $request->ano;
                if ($mes == 1) {
                    $mes2 = 13;
                    $ano2 = $ano - 1;
                } else {
                    $mes2 = $mes - 1;
                    $ano2 = $ano;
                }

                // Query saldo inicial de la cuenta
                $sqlSaldo = "
                SELECT plancuentas_cuenta,
                (select (CASE when plancuentas_naturaleza = 'D'
                        THEN (saldoscontables_debito_inicial - saldoscontables_credito_inicial)
                        ELSE (saldoscontables_credito_inicial - saldoscontables_debito_inicial)
                        END)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes2
                    and saldoscontables_ano = $ano2
                    and saldoscontables_cuenta = $cuenta->id
                ) as inicial,
                (select (CASE when plancuentas_naturaleza = 'D'
                        THEN (saldoscontables_debito_inicial - saldoscontables_credito_inicial)
                        ELSE (saldoscontables_credito_inicial - saldoscontables_debito_inicial)
                        END)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes
                    and saldoscontables_ano = $ano
                    and saldoscontables_cuenta = $cuenta->id
                ) as final,
                (select (saldoscontables_debito_mes)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes
                    and saldoscontables_ano = $ano
                    and saldoscontables_cuenta = $cuenta->id
                ) as debitomes,
                (select (saldoscontables_credito_mes)
                    FROM koi_saldoscontables
                    WHERE saldoscontables_mes = $mes
                    and saldoscontables_ano = $ano
                    and saldoscontables_cuenta = $cuenta->id
                ) as creditomes
                FROM koi_plancuentas
                WHERE koi_plancuentas.id IN (
                    SELECT s.saldoscontables_cuenta
                    FROM koi_saldoscontables as s
                    WHERE s.saldoscontables_mes = $mes AND s.saldoscontables_ano = $ano AND s.saldoscontables_cuenta = $cuenta->id
                    UNION
                    SELECT s.saldoscontables_cuenta
                    FROM koi_saldoscontables as s
                    WHERE s.saldoscontables_mes = $mes2 AND s.saldoscontables_ano = $ano2 AND s.saldoscontables_cuenta = $cuenta->id
                )";
                $query->where('asiento2_cuenta', $cuenta->id);
            }

            // Ordenrs
            $query->orderBy('koi_asiento1.asiento1_ano', 'desc');
            $query->orderBy('koi_asiento1.asiento1_mes', 'asc');
            $query->orderBy('koi_asiento1.asiento1_dia', 'asc');

            // Prepare data
            $auxcontable = $query->get();
            $saldoInicial = DB::selectOne($sqlSaldo);

            if (!is_null($saldoInicial)) {
                $saldo->inicial = !is_null($saldoInicial->inicial) ? $saldo->inicial : 0 ;
                $saldo->debitomes = !is_null($saldoInicial->debitomes) ? $saldo->debitomes : 0 ;
                $saldo->creditomes = !is_null($saldoInicial->creditomes) ? $saldo->creditomes : 0 ;
                $saldo->final = !is_null($saldo->final) ? $saldo->final : 0 ;
            }

            $title = sprintf('%s %s %s', 'Libro auxiliar por cuenta ',  config('koi.meses')[$request->mes], $request->ano) ;
            $subtitle = "$cuenta->plancuentas_cuenta - $cuenta->plancuentas_nombre";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'libroporcuenta', date('Y_m_d'), date('H_i_s')), function($excel) use($auxcontable, $saldo, $title, $subtitle, $type) {
                        $excel->sheet('Excel', function($sheet) use($auxcontable,$saldo, $title, $subtitle,$type) {
                            $sheet->loadView('reports.accounting.auxporcuenta.report', compact('auxcontable', 'saldo','title', 'subtitle','type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new AuxPorCuenta('L', 'mm', 'A4');
                    $pdf->buldReport($auxcontable, $saldo, $title, $subtitle);
                break;
            }
        }
        return view('reports.accounting.auxporcuenta.index');
    }
}
