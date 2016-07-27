@extends('reports.layout', ['title' => 'Plan de Unico de Cuentas - P.U.C'])

@section('content')
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="15%" style="text-align:left">CUENTA</th>
				<th width="76%" style="text-align:left">NOMBRE</th>
				<th width="3%" style="text-align:center">NV</th>
				<th width="3%" style="text-align:center">C/D</th>
				<th width="3%" style="text-align:center">TER</th>
			</tr>
		</thead>

		<tbody>
			@foreach($plancuentas as $cuenta)
				<tr>
					<td style="text-align:left">{{ $cuenta->plancuentas_cuenta }}</td>
					<td style="text-align:left">{{ $cuenta->plancuentas_nombre }}</td>
					<td style="text-align:center">{{ $cuenta->plancuentas_nivel }}</td>
					<td style="text-align:center">{{ $cuenta->plancuentas_naturaleza }}</td>
					<td style="text-align:center">{{ $cuenta->plancuentas_tercero ? 'SI' : 'NO' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
