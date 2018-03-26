@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7" width="20%">Nit</th>
                <th class="center size-7" width="30%">Nombre</th>
                <th class="center size-7" width="15%">Base</th>
                <th class="center size-7" width="15%">Impuestos</th>
                <th class="center size-7" width="20%">Dirección</th>
			</tr>
		</thead>
		<tbody>
			{{--*/ $cuenta = '' /*--}}
		</tbody>
	</table>
@stop
