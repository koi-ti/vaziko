@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7">GRUPO</th>
                <th class="center size-7">CUENTA</th>
                <th class="center size-7">SUB-CUENTA</th>
                <th class="center size-7">AUXILIAR</th>
                <th class="center size-7">SUB-AUXILIAR</th>
                <th class="center size-7">DESCRIPCION</th>
                <th class="center size-7">FECHA</th>
                <th class="center size-7">SALDO ANTERIOR</th>
                <th class="center size-7">DEBITOS</th>
                <th class="center size-7">CREDITOS</th>
                <th class="center size-7">NUEVO SALDO</th>
			</tr>
		</thead>
		<tbody>
			@foreach($saldos as $saldo)
				@if( strlen($saldo->p_cuenta) > 1 )
					{{--*/
						$currentbalance = ($saldo->naturaleza == 'D') ? ($saldo->debitoinicial-$saldo->creditoinicial) : ($saldo->creditoinicial-$saldo->debitoinicial);
						$newbalance = ($saldo->naturaleza == 'D') ? (($saldo->debitomes-$saldo->creditomes)+$currentbalance) : (($saldo->creditomes-$saldo->debitomes)+$currentbalance);
					/*--}}
					<tr>
						<td class="size-6">{{ $saldo->grupo }}</td>
						<td class="size-6">{{ $saldo->cuenta }}</td>
						<td class="size-6">{{ $saldo->subcuenta }}</td>
						<td class="size-6">{{ $saldo->auxiliar }}</td>
						<td class="size-6">{{ $saldo->subauxiliar }}</td>
						<td class="size-6">{{ $saldo->descripcion }}</td>
						<td class="size-6">{!! $saldo->saldo_mes."/".$saldo->saldo_ano !!}</td>
						<td class="size-6">{{ $currentbalance }}</td>
						<td class="size-6">{{ $saldo->debitomes }}</td>
						<td class="size-6">{{ $saldo->creditomes }}</td>
						<td class="size-6">{{ $newbalance }}</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
@stop
