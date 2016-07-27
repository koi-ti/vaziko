@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="15%" class="left">CUENTA</th>
				<th width="70%" class="left">NOMBRE</th>
				<th width="5%" class="center">NV</th>
				<th width="5%" class="center">C/D</th>
				<th width="5%" class="center">TER</th>
			</tr>
		</thead>
		<tbody>
			@foreach($plancuentas as $cuenta)
				<tr>
					<td class="left">{{ $cuenta->plancuentas_cuenta }}</td>
					<td class="left">{{ $cuenta->plancuentas_nombre }}</td>
					<td class="center">{{ $cuenta->plancuentas_nivel }}</td>
					<td class="center">{{ $cuenta->plancuentas_naturaleza }}</td>
					<td class="center">{{ $cuenta->plancuentas_tercero ? 'SI' : 'NO' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
