@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7 width-20">Nit</th>
                <th class="center size-7 width-30">Nombre</th>
                <th class="center size-7 width-15">Base</th>
                <th class="center size-7 width-15">Impuestos</th>
                <th class="center size-7 width-20">Dirección</th>
			</tr>
		</thead>
		<tbody>
			{{--*/ $cuenta = '';  $tbase = $timpuesto = 0; /*--}}
			@foreach($data as $key => $item)
				@if($cuenta != $item->plancuentas_cuenta)
					@if ($key > 0) {
						<tr>
							<td colspan="2">Total</td>
							<td>{{ number_format ($tbase,2,',' , '.') }}</td>
							<td>{{ number_format ($timpuesto,2,',' , '.') }}</td>
							<td></td>
						</tr>
	                    {{--*/ $tbase = $timpuesto = 0; /*--}}
                	@endif
					<tr>
						<td colspan="5">{{ $item->plancuentas_cuenta }} - {{ $item->plancuentas_nombre }} : {{ $item->plancuentas_tasa }}</td>
					</tr>
				@endif
				{{--*/ $tbase += $item->base; $timpuesto += $item->impuesto; /*--}}
				<tr>
					<td>{{ $item->tercero_nit }}</td>
					<td>{{ $item->tercero_nombre }}</td>
					<td>{{ number_format ($item->base,2,',' , '.') }}</td>
					<td>{{ number_format ($item->impuesto,2,',' , '.') }}</td>
					<td>{{ $item->tercero_direccion }}</td>
				</tr>
				@if ( $key == $data->count()-1) {
					<tr>
						<td colspan="2" class="text-rigth">Total</td>
						<td>{{ number_format ($tbase,2,',' , '.') }}</td>
						<td>{{ number_format ($timpuesto,2,',' , '.') }}</td>
						<td></td>
					</tr>
					{{--*/ $tbase = $timpuesto = 0; /*--}}
				@endif

				{{--*/ $cuenta = $item->plancuentas_cuenta /*--}}
			@endforeach
		</tbody>
	</table>
@stop
