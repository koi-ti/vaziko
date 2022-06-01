@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
    <table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th align="center">CUENTA</th>
                <th align="center">NOMBRE</th>
                <th align="center">INICIAL</th>
                <th align="center">DEBITO</th>
                <th align="center">CREDITO</th>
                <th align="center">FINAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saldos as $saldo)
                <?php $result = $saldo->validarSubnivelesCuenta(); ?>

                @if (count($saldo->saldosterceros) || $result != 'OK')
                    <tr>
                        <th align="right">{{ $saldo->plancuentas_cuenta }}</th>
                        <th align="left">{{ $saldo->plancuentas_nombre }}</th>
                        <th align="right"></th>
                        <th align="right"></th>
                        <th align="right"></th>
                        <th align="right"></th>
                    </tr>
                    <?php $total_inicial = 0; ?>
                    <?php $total_final = 0; ?>
                    @foreach ($saldo->saldosterceros as $saldotercero)
                        <?php
                        $inicial = App\Models\Accounting\SaldoTercero::getInitialReportBalanceGeneral($saldotercero, $mes2, $ano2);
                        $final = $inicial + $saldotercero->debitomes - $saldotercero->creditomes;
                        $total_inicial += $inicial;
                        $total_final += $final;
                        ?>
                        <tr>
                            <td align="right">{{ $saldotercero->tercero->tercero_nit }}</td>
                            <td align="left">{{ $saldotercero->tercero->tercero_nombre }}</td>
                            <td align="right">{{ number_format($inicial, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($saldotercero->debitomes, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($saldotercero->creditomes, 2, ',', '.') }}</td>
                            <td align="right">{{ number_format($final, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    @if (count($saldo->saldosterceros))
                        <tr>
                            <th align="right">TOTAL</th>
                            <th align="left">{{ $saldo->plancuentas_cuenta }} - {{ $saldo->plancuentas_nombre }}</th>
                            <th align="right">{{ number_format($total_inicial, 2, ',', '.') }}</th>
                            <th align="right">{{ number_format($saldo->saldosterceros->sum('debitomes'), 2, ',', '.') }}
                            </th>
                            <th align="right">{{ number_format($saldo->saldosterceros->sum('creditomes'), 2, ',', '.') }}
                            </th>
                            <th align="right">{{ $total_final }}</th>
                        </tr>
                        <tr>
                            <th></th>
                        </tr>
                    @endif
                @endif
            @endforeach
    </table>
@stop
