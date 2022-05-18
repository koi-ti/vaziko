@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
            <tr>
                <th colspan="2"></th>
                <th class="center" colspan="2">Saldo Anterior</th>
                <th class="center" colspan="2">Movimiento del mes</th>
                <th class="center" colspan="2">Nuevo Saldo</th>
            </tr>
			<tr>
                <th class="center width-10">Cuenta</th>
                <th class="center width-25">Nombre</th>
                <th class="center">Debitos</th>
                <th class="center">Créditos</th>
                <th class="center">Debitos</th>
                <th class="center">Créditos</th>
                <th class="center">Debitos</th>
                <th class="center">Créditos</th>
			</tr>
		</thead>

        {{--*/
			$saldoAnteriorDebito = $saldoAnteriorCredito = $movimientoDebito = $movimientoCredito = $nuevoDebito = $nuevoCredito = 0
		/*--}}
        <tbody>
            @foreach($data as $item)
            	{{--*/
					$saldoDebito = $item->debitoinicial + $item->debitomes;
					$saldoCredito = $item->creditoinicial + $item->creditomes;
				/*--}}
                <tr>
                    <td>{{ $item->cuenta }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td class="right">{{ number_format($item->debitoinicial, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($item->creditoinicial, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($item->debitomes, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($item->creditomes, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($saldoDebito, 2, ',', '.') }}</td>
                    <td class="right">{{ number_format($saldoCredito, 2, ',', '.') }}</td>
                </tr>
                {{--*/
					$saldoAnteriorDebito += $item->debitoinicial;
					$saldoAnteriorCredito += $item->creditoinicial;
					$movimientoDebito += $item->debitomes;
					$movimientoCredito += $item->creditomes;
					$nuevoDebito += $saldoDebito;
					$nuevoCredito += $saldoCredito;
				/*--}}
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="bold right"> TOTALES</td>
                <td class="right">{{ number_format($saldoAnteriorDebito, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($saldoAnteriorCredito, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($movimientoDebito, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($movimientoCredito, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($nuevoDebito, 2, ',', '.') }}</td>
                <td class="right">{{ number_format($nuevoCredito, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
	</table>
@stop
