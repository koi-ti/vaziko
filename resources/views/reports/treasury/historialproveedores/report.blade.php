@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="15%">DOCUMENTO</th>
				<th width="15%">NÚMERO</th>
				<th width="50%">REGIONAL</th>
				<th width="10%">AFEC DOCUMENTO</th>
				<th width="15%">AFEC NÚMERO</th>
				<th width="15%">AFEC CTA</th>
				<th width="15%">FECHA E</th>
				<th width="15%">FECHA DOC</th>
				<th width="15%">FECHA PAGO</th>
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
						<td>{{ $historyProveider[$i]['documento'] }}</td>
						<td>{{ $historyProveider[$i]['numero'] }}</td>
						<td>{{ $historyProveider[$i]['sucursal'] }}</td>
						<td>{{ $historyProveider[$i]['docafecta'] }}</td>
						<td>{{ $historyProveider[$i]['id_docafecta'] }}</td>
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
