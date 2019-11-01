@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="left width-15">CUENTA</th>
				<th class="left width-40">NOMBRE</th>
				<th class="center width-10">INICIAL</th>
				<th class="center width-10">DEBITO</th>
				<th class="center width-10">CREDITO</th>
				<th class="center width-10">FINAL</th>
			</tr>
		</thead>
		<tbody>
			@if (count($saldos) > 0)
				{{--*/ $sdebito = $scredito = $tfinal = $tinicio = 0; /*--}}
				@foreach($saldos as $saldo)
					{{--*/
						if ($saldo->plancuentas_naturaleza == 'D') {
							$final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
						} else if ($saldo->plancuentas_naturaleza == 'C') {
							$final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
						}
					/*--}}

					<tr>
						<td class="left">{{ $saldo->plancuentas_cuenta }}</td>
						<td class="left">{{ $saldo->plancuentas_nombre }}</td>
						<td class="right">{{ number_format($saldo->inicial,2,'.',',') }}</td>
						<td class="right">{{ number_format($saldo->debitomes,2,'.',',') }}</td>
						<td class="right">{{ number_format($saldo->creditomes,2,'.',',') }}</td>
						<td class="right">{{ number_format($final,2,'.',',') }}</td>

						{{-- Calculo totales --}}
						{{--*/
							if ($saldo->plancuentas_nivel == 1) {
								$sdebito = $saldo->debitomes + $sdebito;
								$scredito = $saldo->creditomes + $scredito;
								$tfinal += $final;
								$tinicio += $saldo->inicial;
							}
						/*--}}
					</tr>
				@endforeach
				<tr>
					<td colspan="2" class="right bold">TOTAL</td>
					<td class="right bold">{{ number_format($tinicio,2,'.',',') }}</td>
					<td class="right bold">{{ number_format($sdebito,2,'.',',') }}</td>
					<td class="right bold">{{ number_format($scredito,2,'.',',') }}</td>
					<td class="right bold">{{ number_format($tfinal,2,'.',',') }}</td>
				</tr>
			@endif
		</tbody>
	</table>
@stop
