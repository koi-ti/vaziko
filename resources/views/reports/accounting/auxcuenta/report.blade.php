@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<p>{{ $subtitle }}</p>
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7 width-5">Número Documento</th>
				<th class="center size-7 width-5">Tipo Documento</th>
                <th class="center size-7 width-5">Fecha</th>
                <th class="center size-7 width-5">Nit</th>
                <th class="center size-7 width-5">Nombre</th>
                <th class="center size-7 width-5">Detalle</th>
                <th class="center size-7 width-5">Debito</th>
                <th class="center size-7 width-5">Credito</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $item)
				<tr>
					<td class="center size-7 width-5">{{ $item->asientoId }}</td>
					<td class="center size-7 width-5">{{ $item->documento_nombre }}</td>
					<td class="center size-7 width-5">{{ $item->fecha }}</td>
					<td class="center size-7 width-5">{{ $item->tercero_nit }}</td>
					<td class="center size-7 width-5">{{ $item->tercero_nombre }}</td>
					<td class="center size-7 width-5">{{ utf8_decode($item->detalle) }}</td>
					<td class="center size-7 width-5">{{ number_format($item->debito) }}</td>
					<td class="center size-7 width-5">{{ number_format($item->credito) }}</td>
					{{--
					<td>{{ $item->folder_codigo }}</td>
					<td>{{ $item->documento_nombre }}</td>
					--}}
				</tr>
				
			@endforeach
		</tbody>
	</table>
@stop
