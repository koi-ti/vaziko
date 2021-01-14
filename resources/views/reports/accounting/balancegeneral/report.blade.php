@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="left width-15">CUENTA</th>
				<th class="left width-60">DESCRIPCIÓN</th>
				<th class="left width-10">SALDO</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $item)
				<tr>
					<td>{{ $item->plancuentas_cuenta }}</td>
					<td>{{ $item->plancuentas_nombre }}</td>
					<td>{{ $item->plancuentas_tasa }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
