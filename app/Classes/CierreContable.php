<?php
namespace App\Classes;
use DB;
use App\Models\Accounting\PlanCuenta, App\Models\Accounting\SaldoTercero, App\Models\Accounting\SaldoContable;
/**
 * Class Accounting Cierre contable
 */
class CierreContable
{
    private $cierre_mes;
    private $cierre_ano;

    function __construct($mes = null, $ano = null)
    {
        $this->cierre_mes = $mes;
        $this->cierre_ano = $ano;
    }

    function generarCierre()
    {
        // Cierre saldos contables
        $cierreSaldos = $this->UpdateSaldosContablesIniciales();
        if($cierreSaldos != 'OK'){
            return " Proceso Cierre Saldos : $cierreSaldos";
        }
        // Cierre saldos terceros
        $cierreSaldosTerceros = $this->UpdateSaldosTerceroIniciales();
        if($cierreSaldosTerceros != 'OK'){
            return "Proceso cierre saldos X tercero: $cierreSaldosTerceros";
        }
        return 'OK';
    }

    function consultaMybal($mes, $ano)
    {
        if($mes == 1){
            $mes2 = 13;
            $ano2 = $ano-1;
        }else{
            $mes2 = $mes-1;
            $ano2 = $ano;
        }
        $sql = "
        SELECT plancuentas_nombre as  nombre, plancuentas_cuenta as cuenta, plancuentas_nivel1 as nivel1,plancuentas_nivel2 as nivel2,plancuentas_nivel3 as nivel3,plancuentas_nivel4 as nivel4,plancuentas_nivel5 as nivel5, plancuentas_naturaleza as naturaleza,
		(select(
		 case when plancuentas_naturaleza='D'
		   then
			  (saldoscontables_debito_inicial-saldoscontables_credito_inicial)
		   else
			  (saldoscontables_credito_inicial-saldoscontables_debito_inicial)
		   END
		)
		from koi_saldoscontables
		where
		saldoscontables_mes = $mes2
		and
		saldoscontables_ano = $ano2
		and
		saldoscontables_cuenta = plancuentas_cuenta
		)as inicial,
		(select (saldoscontables_debito_mes)
		from koi_saldoscontables
		where
		saldoscontables_mes = $mes
		and
		saldoscontables_ano = $ano
		and
		saldoscontables_cuenta = koi_plancuentas.id
		)as debitomes,
		(select (saldoscontables_credito_mes)
		from koi_saldoscontables
		where
		saldoscontables_mes = $mes
		and
		saldoscontables_ano = $ano
		and
		saldoscontables_cuenta = koi_plancuentas.id
		)as creditomes
        FROM koi_plancuentas
		WHERE koi_plancuentas.id IN (
		select s.saldoscontables_cuenta
		from koi_saldoscontables as s
		where
		s.saldoscontables_mes = $mes
		and
		s.saldoscontables_ano = $ano
		union
		select s.saldoscontables_cuenta
		from koi_saldoscontables as s
		where
		s.saldoscontables_mes = $mes2
		and
		s.saldoscontables_ano = $ano2 )
        order by   koi_plancuentas.id  ASC";
        $arSaldos = DB::select($sql);
        return $arSaldos;
    }
    function ConsultaMybalTercero($mes, $ano)
    {
        if($mes == 1){
            $mes2 = 13;
            $ano2 = $ano-1;
        }else{
            $mes2 = $mes-1;
            $ano2 = $ano;
        }
        $sql = "
            SELECT DISTINCT s1.saldosterceros_cuenta, s1.saldosterceros_tercero,
            (select (CASE when plancuentas_naturaleza = 'D'
                    THEN (s2.saldosterceros_debito_inicial-s2.saldosterceros_credito_inicial)
                    ELSE (s2.saldosterceros_credito_inicial-s2.saldosterceros_debito_inicial)
                    END)
                FROM koi_saldosterceros as s2
                WHERE s2.saldosterceros_mes = $mes2
                and s2.saldosterceros_ano = $ano2
                and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
                and s2.saldosterceros_tercero = s1.saldosterceros_tercero
            )as inicial,
            (select SUM(s2.saldosterceros_debito_mes)
                FROM koi_saldosterceros as s2
                WHERE s2.saldosterceros_mes = $mes
                and s2.saldosterceros_ano = $ano
                and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
                and s2.saldosterceros_tercero = s1.saldosterceros_tercero
            )as debitomes,
            (select SUM(s2.saldosterceros_credito_mes)
                FROM koi_saldosterceros as s2
                WHERE s2.saldosterceros_mes = $mes
                and s2.saldosterceros_ano = $ano
                and s2.saldosterceros_cuenta = s1.saldosterceros_cuenta
                and s2.saldosterceros_tercero = s1.saldosterceros_tercero
            )as creditomes,
            plancuentas_cuenta, plancuentas_naturaleza, plancuentas_nombre

            FROM koi_saldosterceros as s1, koi_plancuentas
            WHERE (s1.saldosterceros_mes = $mes OR s1.saldosterceros_mes = $mes2)";
        if($ano == $ano2) {
            $sql.=" and( s1.saldosterceros_ano = $ano)";
        }else{
            $sql.=" and( s1.saldosterceros_ano = $ano OR s1.saldosterceros_ano =".$ano2.")";
        }

        $sql .= "
            and s1.saldosterceros_cuenta = koi_plancuentas.id
            ORDER BY s1.saldosterceros_cuenta ASC, s1.saldosterceros_tercero ASC";
        $arSaldos = DB::select($sql);
        if(!is_array($arSaldos)) {
            return "Se genero un error al consultar los saldos tercero, por favor verifique la información del asiento o consulte al administrador.";
        }
        return $arSaldos;
    }
    function UpdateSaldosTerceroIniciales()
    {
        $arraySaldos = $this->ConsultaMybalTercero($this->cierre_mes, $this->cierre_ano);
        foreach ($arraySaldos as $item) {
            // Recuperar cuenta
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $item->plancuentas_cuenta)->first();
            if(!$objCuenta instanceof PlanCuenta) {
                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador (saldosTercero).";
            }

            // Recuperar niveles cuenta
            $niveles = PlanCuenta::getNivelesCuenta($objCuenta->plancuentas_cuenta);
            if(!is_array($niveles)) {
                return "Error al recuperar niveles para la cuenta {$objCuenta->plancuentas_cuenta}.";
            }

            // Prepare saldo final
            if($objCuenta->plancuentas_naturaleza == 'D'){
                $final = $item->inicial + ($item->debitomes - $item->creditomes);
            }else if($objCuenta->plancuentas_naturaleza == 'C'){
                $final = $item->inicial + ($item->creditomes - $item->debitomes);
            }

            //Verifico que exista la cuenta en el mes y ano
            $query = SaldoTercero::query();
            $query->where('saldosterceros_ano', $this->cierre_ano);
            $query->where('saldosterceros_mes', $this->cierre_mes);
            $query->where('saldosterceros_cuenta', $item->saldosterceros_cuenta);
            $query->orderBy('saldosterceros_cuenta', 'asc');
            $objSaldoTercero = $query->first();

            if (!$objSaldoTercero instanceof SaldoTercero) {
                // Crear registro en saldos terceros
                $objSaldoTercero = new SaldoTercero;
                $objSaldoTercero->saldosterceros_cuenta = $item->saldosterceros_cuenta;
                $objSaldoTercero->saldosterceros_tercero = $item->saldosterceros_tercero;
                $objSaldoTercero->saldosterceros_ano = $this->cierre_ano;
                $objSaldoTercero->saldosterceros_mes = $this->cierre_mes;
                $objSaldoTercero->saldosterceros_nivel1 = $niveles['nivel1'] ?: 0;
                $objSaldoTercero->saldosterceros_nivel2 = $niveles['nivel2'] ?: 0;
                $objSaldoTercero->saldosterceros_nivel3 = $niveles['nivel3'] ?: 0;
                $objSaldoTercero->saldosterceros_nivel4 = $niveles['nivel4'] ?: 0;
                $objSaldoTercero->saldosterceros_nivel5 = $niveles['nivel5'] ?: 0;
                $objSaldoTercero->saldosterceros_nivel6 = $niveles['nivel6'] ?: 0;
                $objSaldoTercero->saldosterceros_nivel7 = $niveles['nivel7'] ?: 0;
                $objSaldoTercero->saldosterceros_nivel8 = $niveles['nivel8'] ?: 0;
                $objSaldoTercero->saldosterceros_debito_mes = 0;
                $objSaldoTercero->saldosterceros_credito_mes = 0;
            }
            if ($objCuenta->plancuentas_naturaleza == 'D') {
                $objSaldoTercero->saldosterceros_debito_inicial =  $final;
                $objSaldoTercero->saldosterceros_credito_inicial =  0;
            }else if($objCuenta->plancuentas_naturaleza == 'C'){
                $objSaldoTercero->saldosterceros_debito_inicial =  0;
                $objSaldoTercero->saldosterceros_credito_inicial = $final;
            }else{
                return ('No se puede definir la naturaleza de la cuenta');
            }
            $objSaldoTercero->save();
        }
        return 'OK';
    }
    function UpdateSaldosContablesIniciales()
    {
        $arraySaldos = $this->consultaMybal($this->cierre_mes, $this->cierre_ano);
        if( !is_array($arraySaldos) ){
            return "Error al consultar los saldos en Mybal";
        }

        foreach ($arraySaldos as $item) {

            // Recuperar cuenta
            $objCuenta = PlanCuenta::where('plancuentas_cuenta', $item->cuenta)->first();
            if(!$objCuenta instanceof PlanCuenta) {
                return "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador (saldosContables).";
            }

            // Recuperar niveles cuenta
            $niveles = PlanCuenta::getNivelesCuenta($objCuenta->plancuentas_cuenta);
            if(!is_array($niveles)) {
                return "Error al recuperar niveles para la cuenta {$objCuenta->plancuentas_cuenta}.";
            }

            // Prepare saldo final
            if($item->naturaleza == 'D'){
                $final = $item->inicial + ($item->debitomes - $item->creditomes);
            }else if($item->naturaleza == 'C'){
                $final = $item->inicial + ($item->creditomes - $item->debitomes);
            }

            //Verifico que exista la cuenta en el mes y ano
            $query = SaldoContable::query();
            $query->where('saldoscontables_mes', $this->cierre_mes);
            $query->where('saldoscontables_ano', $this->cierre_ano);
            $query->where('saldoscontables_cuenta', $objCuenta->id);
            $objSaldoContable = $query->first();

            if (!$objSaldoContable instanceof SaldoContable) {
                // Crear registro en saldos contables
                $objSaldoContable = new SaldoContable;
                $objSaldoContable->saldoscontables_cuenta = $objCuenta->id;
                $objSaldoContable->saldoscontables_mes = $this->cierre_mes;
                $objSaldoContable->saldoscontables_ano = $this->cierre_ano;
                $objSaldoContable->saldoscontables_nivel1 = $niveles['nivel1'] ?: 0;
                $objSaldoContable->saldoscontables_nivel2 = $niveles['nivel2'] ?: 0;
                $objSaldoContable->saldoscontables_nivel3 = $niveles['nivel3'] ?: 0;
                $objSaldoContable->saldoscontables_nivel4 = $niveles['nivel4'] ?: 0;
                $objSaldoContable->saldoscontables_nivel5 = $niveles['nivel5'] ?: 0;
                $objSaldoContable->saldoscontables_nivel6 = $niveles['nivel6'] ?: 0;
                $objSaldoContable->saldoscontables_nivel7 = $niveles['nivel7'] ?: 0;
                $objSaldoContable->saldoscontables_nivel8 = $niveles['nivel8'] ?: 0;
                $objSaldoContable->saldoscontables_debito_mes =  0;
                $objSaldoContable->saldoscontables_credito_mes =  0;
            }
            if ($item->naturaleza == 'D') {
                $objSaldoContable->saldoscontables_debito_inicial =  $final;
                $objSaldoContable->saldoscontables_credito_inicial =  0;
            }else if($item->naturaleza == 'C'){
                $objSaldoContable->saldoscontables_debito_inicial =  0;
                $objSaldoContable->saldoscontables_credito_inicial = $final;
            }else{
                return ('No se puede definir la naturaleza de la cuenta');
            }
            $objSaldoContable->save();
        }
        return 'OK';
    }
}

?>
