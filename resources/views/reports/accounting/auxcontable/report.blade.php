@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7 width-5"></th>
                <th class="center size-7 width-5">Fecha</th>
                <th class="center size-7 width-15">Doc contable</th>
                <th class="center size-7 width-5">N° asiento</th>
                <th class="center size-7 width-10">Tercero</th>
                <th class="center size-7 width-25">Nombre</th>
                <th class="center size-7 width-15">Doc origen</th>
                <th class="center size-7 width-5">N° origen</th>
                <th class="center size-7">Debito</th>
                <th class="center size-7">Credito</th>
                <th class="center size-7">Base</th>
			</tr>
		</thead>
		<tbody>
			@foreach($auxcontable as $item)
				<tr>
					<td class="size-6">{{ $item->cuenta }}</td>
					<td class="size-6">{{ $item->date }}</td>
					<td class="size-6">{{ $item->documento_nombre }}</td>
					<td class="size-6">{{ $item->asiento1_numero }}</td>
					<td class="size-6">{{ $item->tercero_nit }}</td>
					<td class="size-6">{{ $item->tercero_nombre }}</td>
					<td class="center">-</td>
					<td class="center">-</td>
					<td class="size-6">{{ $item->debito }}</td>
					<td class="size-6">{{ $item->credito }}</td>
					<td class="size-6">{{ $item->base }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
