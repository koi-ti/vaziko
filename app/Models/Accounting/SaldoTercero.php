<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class SaldoTercero extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_saldosterceros';

    public $timestamps = false;

    public function tercero()
    {
        return $this->hasOne('App\Models\Base\Tercero', 'id', 'saldosterceros_tercero');
    }

    public function cuenta()
    {
        return $this->hasOne('App\Models\Accounting\PlanCuenta', 'id', 'saldosterceros_cuenta');
    }

    public static function getInitialReportBalanceGeneral($saldotercero, $mes2, $ano2)
    {
        $query = self::query();
        $query->select('id', 'saldosterceros_cuenta', 'saldosterceros_credito_inicial', 'saldosterceros_debito_inicial');
        $query->where('saldosterceros_tercero', $saldotercero->saldosterceros_tercero);
        $query->where('saldosterceros_cuenta', $saldotercero->saldosterceros_cuenta);
        $query->where('saldosterceros_mes', $mes2);
        $query->where('saldosterceros_ano', $ano2);
        $query->with([
            'cuenta' => function ($qcuenta) {
                $qcuenta->select('id', 'plancuentas_naturaleza');
            },
        ]);
        $calc_inicial = $query->first();
        $inicial = 0;
        if ($calc_inicial != null) {
            if ($calc_inicial->cuenta->plancuentas_naturaleza == 'C') {
                $inicial = $calc_inicial->saldosterceros_credito_inicial - $calc_inicial->saldosterceros_debito_inicial;
            } else {
                $inicial = $calc_inicial->saldosterceros_debito_inicial - $calc_inicial->saldosterceros_credito_inicial;
            }
        }
        return $inicial;
    }
}
