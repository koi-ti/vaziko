@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="left width-15">CUENTA</th>
				<th class="left width-60">NOMBRE</th>
				<th class="center width-5">NV</th>
				<th class="center width-5">C/D</th>
				<th class="center width-5">TER</th>
				<th class="center width-10">TASA</th>
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
