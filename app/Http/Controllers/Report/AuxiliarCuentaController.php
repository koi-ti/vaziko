<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Reports\Accounting\AuxiliarCuenta;
use App\Models\Base\Tercero;
use App\Models\Accounting\Asiento2, App\Models\Accounting\PlanCuenta;
use Excel, DB, Validator;

class AuxiliarCuentaController extends Controller
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
                'filter_mes' => 'required|numeric|min:1|max:12',
                'filter_ano' => 'required|numeric|min:2015',
                'filter_cuenta' => 'required|numeric'
            ]);

            // Validar que sean requeridos
            if ($validator->fails()) {
                session()->flash('errors', $validator->errors()->all());
                return redirect('/rauxporcuenta')->withInput();
            }

            // Query asiento
            $query = Asiento2::query();
            $query->select('asiento2_detalle AS detalle', 'asiento2_debito AS debito', 'asiento2_credito AS credito', DB::raw("CONCAT(asiento1_ano, '-', asiento1_mes, '-', asiento1_dia) as fecha"), 'documento_nombre', 'folder_codigo');
            $query->tercero();
            $query->join('koi_asiento1','asiento2_asiento','=','koi_asiento1.id');
            $query->join('koi_documento', 'asiento1_documento', '=', 'koi_documento.id');
            $query->leftJoin('koi_folder', 'koi_documento.documento_folder', '=', 'koi_folder.id');
            $query->where('koi_asiento1.asiento1_ano', $request->filter_ano);
            $query->where('koi_asiento1.asiento1_mes', $request->filter_mes);

            // Filter plan de cuenta
            $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->filter_cuenta)->first();
            if (!$cuenta instanceof PlanCuenta) {
                session()->flash('errors', ['No es posible recuperar plan  de cuenta, por favor verifique la información o consulte al administrador.']);
                return redirect('/rauxporcuenta')->withInput();
            }
            $query->where('asiento2_cuenta', $cuenta->id);

            // Ordenrs
            $query->orderBy('koi_asiento1.asiento1_ano', 'desc');
            $query->orderBy('koi_asiento1.asiento1_mes', 'asc');
            $query->orderBy('koi_asiento1.asiento1_dia', 'asc');
            $data = $query->get();

            // Sql saldos
            $mes = $request->filter_mes;
            $ano = $request->filter_ano;
            if ($mes == 1) {
                $mes2 = 13;
                $ano2 = $ano - 1;
            } else {
                $mes2 = $mes - 1;
                $ano2 = $ano;
            }

            // Query saldo inicial de la cuenta
            $sql = "SELECT plancuentas_cuenta,
                (SELECT (CASE WHEN plancuentas_naturaleza = 'D' THEN (saldoscontables_debito_inicial - saldoscontables_credito_inicial) ELSE (saldoscontables_credito_inicial - saldoscontables_debito_inicial) END) FROM koi_saldoscontables WHERE saldoscontables_mes = {$mes2} AND saldoscontables_ano = {$ano2} AND saldoscontables_cuenta = {$cuenta->id}) AS inicial,
                (SELECT (CASE when plancuentas_naturaleza = 'D' THEN (saldoscontables_debito_inicial - saldoscontables_credito_inicial) ELSE (saldoscontables_credito_inicial - saldoscontables_debito_inicial) END) FROM koi_saldoscontables WHERE saldoscontables_mes = {$mes} AND saldoscontables_ano = {$ano} AND saldoscontables_cuenta = {$cuenta->id}) AS final,
                (SELECT (saldoscontables_debito_mes) FROM koi_saldoscontables WHERE saldoscontables_mes = {$mes} AND saldoscontables_ano = {$ano} AND saldoscontables_cuenta = {$cuenta->id}) AS debitomes,
                (SELECT (saldoscontables_credito_mes) FROM koi_saldoscontables WHERE saldoscontables_mes = {$mes} AND saldoscontables_ano = {$ano} AND saldoscontables_cuenta = {$cuenta->id}) AS creditomes
            FROM koi_plancuentas
            WHERE koi_plancuentas.id IN
            (
                SELECT s.saldoscontables_cuenta FROM koi_saldoscontables as s WHERE s.saldoscontables_mes = {$mes} AND s.saldoscontables_ano = {$ano} AND s.saldoscontables_cuenta = {$cuenta->id}
                UNION
                SELECT s.saldoscontables_cuenta FROM koi_saldoscontables as s WHERE s.saldoscontables_mes = $mes2 AND s.saldoscontables_ano = $ano2 AND s.saldoscontables_cuenta = {$cuenta->id}
            )
            ";
            $saldoInicial = DB::selectOne($sql);

            // Saldo inicial de la cuenta
            $saldo = new \stdClass();
            $saldo->inicial = 0 ;
            $saldo->debitomes = 0 ;
            $saldo->creditomes = 0 ;
            $saldo->final = 0 ;

            if (!is_null($saldoInicial)) {
                $saldo->inicial = !is_null($saldoInicial->inicial) ? $saldo->inicial : 0 ;
                $saldo->debitomes = !is_null($saldoInicial->debitomes) ? $saldo->debitomes : 0 ;
                $saldo->creditomes = !is_null($saldoInicial->creditomes) ? $saldo->creditomes : 0 ;
                $saldo->final = !is_null($saldo->final) ? $saldo->final : 0 ;
            }

            $monthName = config('koi.meses')[$request->filter_mes];
            $title = "Libro auxiliar por cuenta {$monthName} {$request->filter_ano}";
            $subtitle = "{$cuenta->plancuentas_cuenta} - {$cuenta->plancuentas_nombre}";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create($title, function ($excel) use ($data, $saldo, $title, $subtitle, $type) {
                        $excel->sheet('Excel', function ($sheet) use ($data, $saldo, $title, $subtitle, $type) {
                            $sheet->loadView('reports.accounting.auxcuenta.report', compact('data', 'saldo', 'title', 'subtitle', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new AuxiliarCuenta('L', 'mm', 'A4');
                    $pdf->buldReport($data, $saldo, $title, $subtitle);
                break;
            }
        }
        return view('reports.accounting.auxcuenta.index');
    }
}
