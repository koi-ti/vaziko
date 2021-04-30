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
			@if (count($saldos) > 0)
				{{--*/
					$lastNivel = $cuenta = $saldoDebito = $saldoCredito = $totalFinal = $totalInicio = 0;
				/*--}}
				@foreach ($saldos as $saldo)
					{{--*/
						if ($saldo->plancuentas_naturaleza == 'D') {
							$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
						} else if ($saldo->plancuentas_naturaleza == 'C') {
							$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
						}
					/*--}}

					@if ($tercero)
						@if ($saldo->plancuentas_cuenta != $cuenta)
							<tr>
								<th align="right">{{ $saldo->plancuentas_cuenta }}</th>
								<th colspan="5" align="left">{{ $saldo->plancuentas_nombre }}</th>
							</tr>
							<tr>
								<td align="right">{{ $saldo->tercero_nit }}</td>
								<td align="left" class="left">{{ $saldo->tercero_nombre }}</td>
								<td align="right">{{ number_format($saldo->inicial, 2, '.', ',') }}</td>
								<td align="right">{{ number_format($saldo->debitomes, 2, '.', ',') }}</td>
								<td align="right">{{ number_format($saldo->creditomes, 2, '.', ',') }}</td>
								<td align="right">{{ number_format($final, 2, '.', ',') }}</td>
							</tr>
						@else
							<tr>
								<td align="right">{{ $saldo->tercero_nit }}</td>
								<td align="left">{{ $saldo->tercero_nombre }}</td>
								<td align="right">{{ number_format($saldo->inicial, 2, '.', ',') }}</td>
								<td align="right">{{ number_format($saldo->debitomes, 2, '.', ',') }}</td>
								<td align="right">{{ number_format($saldo->creditomes, 2, '.', ',') }}</td>
								<td align="right">{{ number_format($final, 2, '.', ',') }}</td>
							</tr>
						@endif
					@else
						@if (($saldo->plancuentas_nivel == 3 && $lastNivel != 2) || ($saldo->plancuentas_nivel == 2 && $lastNivel > 3))
							<tr>
								<td colspan="6"></td>
							</tr>
						@endif

						<tr>
							@if ($saldo->plancuentas_nivel <= 2)
								<th align="right">{{ $saldo->plancuentas_cuenta }}</th>
							@else
								<td align="right">{{ $saldo->plancuentas_cuenta }}</td>
							@endif
							<td align="left">{{ $saldo->plancuentas_nombre }}</td>
							<td align="right">{{ number_format($saldo->inicial, 2, '.', ',') }}</td>
							<td align="right">{{ number_format($saldo->debitomes, 2, '.', ',') }}</td>
							<td align="right">{{ number_format($saldo->creditomes, 2, '.', ',') }}</td>
							<td align="right">{{ number_format($final, 2, '.', ',') }}</td>
						</tr>

						{{--*/
							$lastNivel = $saldo->plancuentas_nivel;
						/*--}}
					@endif

					{{-- Calculo totales --}}
					{{--*/
						if ($saldo->plancuentas_nivel == 1) {
							$saldoDebito = $saldo->debitomes + $saldoDebito;
							$saldoCredito = $saldo->creditomes + $saldoCredito;
							$totalFinal += $final;
							$totalInicio += $saldo->inicial;
						}

						$cuenta = $saldo->plancuentas_cuenta;
					/*--}}
				@endforeach
				<tr>
					<td colspan="2" align="right">TOTAL</td>
					<td align="right" class="right bold">{{ number_format($totalInicio, 2, '.', ',') }}</td>
					<td align="right" class="right bold">{{ number_format($saldoDebito, 2, '.', ',') }}</td>
					<td align="right" class="right bold">{{ number_format($saldoCredito, 2, '.', ',') }}</td>
					<td align="right" class="right bold">{{ number_format($totalFinal, 2, '.', ',') }}</td>
				</tr>
			@endif
		</tbody>
	</table>
@stop
