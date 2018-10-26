@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
            <tr>
                <th colspan="2"></th>
                <th class="center" colspan="2">Saldo anterior</th>
                <th class="center" colspan="2">Movimientos</th>
                <th class="center" colspan="2">Nuevo saldo</th>
            </tr>
			<tr>
                <th class="center"width="10%">Cuenta</th>
                <th class="center" width="25%">Nombre</th>
                <th class="center">Debito</th>
                <th class="center">Credito</th>
                <th class="center">Debito</th>
                <th class="center">Credito</th>
                <th class="center">Debito</th>
                <th class="center">Credito</th>
			</tr>
		</thead>
        <!--  Inicializo variables de footer 'TOTALES'-->
        {{--*/ $tdebitoinicial = $tcreditoinicial = $tdebitomes = $tcreditomes = $tsdebito = $tscredito = 0  /*--}}
        <tbody>
            @foreach($saldos as $saldo)
            <!--  Inicializo variables para el encabezado de 'NUEVO SALDO'-->
            {{--*/  $sdebito = $saldo->debitoinicial + $saldo->debitomes; $scredito = $saldo->creditoinicial + $saldo->creditomes; /*--}}
                <tr>
                    <td>{{ $saldo->cuenta }}</td>
                    <td>{{ $saldo->nombre }}</td>
                    <td class="right">{{ number_format($saldo->debitoinicial, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($saldo->creditoinicial, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($saldo->debitomes, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($saldo->creditomes, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($sdebito, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($scredito, 2, ',', '.') }}</td>
                </tr>
                {{--*/ $tdebitoinicial += $saldo->debitoinicial; $tcreditoinicial += $saldo->creditoinicial; $tdebitomes += $saldo->debitomes; $tcreditomes += $saldo->creditomes; $tsdebito += $sdebito; $tscredito += $scredito ; /*--}}
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="bold right"> TOTALES</td>
                <td class="right">{{ number_format ($tdebitoinicial,2,',' , '.') }}</td>
                <td class="right">{{ number_format ($tcreditoinicial,2,',' , '.') }}</td>
                <td class="right">{{ number_format ($tdebitomes,2,',' , '.') }}</td>
                <td class="right">{{ number_format ($tcreditomes,2,',' , '.') }}</td>
                <td class="right">{{ number_format ($tsdebito,2,',' , '.') }}</td>
                <td class="right">{{ number_format ($tscredito,2,',' , '.') }}</td>
            </tr>
        </tfoot>
	</table>
@stop
