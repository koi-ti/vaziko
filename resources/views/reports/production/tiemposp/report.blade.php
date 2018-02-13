@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	@foreach( $tiempos as $funcionario )
		<table class="tbtitle">
		    <thead>
		        <tr><td class="size-8 center bold">{{ $funcionario->tercero->tercero_nombre }}</td></tr>
		        <tr><td class="size-8 center bold">NIT: {{ $funcionario->tercero->tercero_nit }}</td></tr>
		    </thead>
		</table>

		<table class="rtable" border="0" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th width="3%" class="center">#</th>
					<th width="40%" class="left">ORDEN</th>
					<th width="10%" class="center">ACTIVIDAD</th>
					<th width="10%" class="center">SUBACTIVIDAD</th>
					<th width="10%" class="center">AREA</th>
					<th width="10%" class="center">FECHA</th>
					<th width="5%" class="center">HORA INICIO</th>
					<th width="5%" class="center">HORA FIN</th>
				</tr>
			</thead>
			<tbody>
				@foreach($funcionario->tiemposp as $item)
					<tr>
						<td class="center">{{ $item->id }}</td>
						<td>{{ isset($item->orden_codigo) && isset( $item->tercero_nombre ) ? $item->orden_codigo.' '.$item->tercero_nombre : '-' }}</td>
						<td>{{ $item->actividadp_nombre }}</td>
						<td>{{ isset($item->subactividadp_nombre) ? $item->subactividadp_nombre : '-' }}</td>
						<td>{{ $item->areap_nombre }}</td>
						<td>{{ $item->tiempop_fecha }}</td>
						<td class="center">{{ date('H:i', strtotime($item->tiempop_hora_inicio) ) }}</td>
						<td class="center">{{ date('H:i', strtotime($item->tiempop_hora_fin) ) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<br><br><br>
	@endforeach
@stop
