@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="15%" class="left">CUENTA</th>
				<th width="62%" class="left">NOMBRE</th>
				<th width="5%" class="center">NV</th>
				<th width="5%" class="center">C/D</th>
				<th width="5%" class="center">TER</th>
				<th width="8%" class="center">TASA</th>
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
					<td class="right">{{ $cuenta->plancuentas_tasa }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
