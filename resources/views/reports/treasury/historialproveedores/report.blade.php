@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="6%">NÚMERO</th>
				<th width="15%">SUCURSAL</th>
				<th width="7%">ASIENTO</th>
				<th width="7%">NIF</th>
				<th width="5%">CUOTAS</th>
				<th width="10%">FECHA E</th>
				<th width="10%">F DOC</th>
				<th width="10%">F PAGO</th>
				<th width="15%">DEBITO</th>
				<th width="15%">CREDITO</th>
			</tr>
		</thead>
		<tbody>
			@if (empty($historyProveider))
				<tr class="subtitle">
					<th colspan="11" class="center">NO SE ENCUENTRAN REGISTROS PARA ESTE REPORTE</th>
				</tr>
			@else
				@for($i = 0; $i < count($historyProveider); $i++)
					<tr>
						<td>{{ $historyProveider[$i]['numero'] }}</td>
						<td>{{ $historyProveider[$i]['sucursal'] }}</td>
						<td>{{ $historyProveider[$i]['asiento'] }}</td>
						<td>{{ $historyProveider[$i]['asientonif'] }}</td>
						<td class="center">{{ $historyProveider[$i]['cuota'] }}</td>
						<td>{{ $historyProveider[$i]['elaboro_fh'] }}</td>
						<td>{{ $historyProveider[$i]['elaboro_fh'] }}</td>
						<td>{{ $historyProveider[$i]['elaboro_fh'] }}</td>

						@if ($historyProveider[$i]['naturaleza'] == 'C')
							<td>{{ 0 }}</td>
							<td>{{ number_format ($historyProveider[$i]['valor']) }}</td>
						@else
							<td>{{ number_format ($historyProveider[$i]['valor']) }}</td>
							<td>{{ 0 }}</td>
						@endif
					</tr>
				@endfor
			@endif
		</tbody>
	</table>
@stop
