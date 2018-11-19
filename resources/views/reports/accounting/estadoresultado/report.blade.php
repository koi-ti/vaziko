@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th>CUENTA</th>
                <th>NOMBRE</th>
                <th>SALDO AUXILIAR</th>
                <th>SALDO SUBCUENTA</th>
                <th>SALDO CUENTA</th>
                <th>SALDO GRUPO</th>
                <th>SALDO TOTAL</th>
			</tr>
		</thead>
		<tbody>
			@foreach( $saldos as $saldo )
				<tr>
					<td>{{ $saldo->cuenta }}</td>
					<td>{{ $saldo->nombre }}</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
					<td>-</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
