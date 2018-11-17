@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<p>{{$subtitle}}</p>
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7 width-10">Fecha</th>
                <th class="center size-7 width-15">Folder</th>
                <th class="center size-7 width-15">Doc contable</th>
                <th class="center size-7 width-30">Detalle</th>
                <th class="center size-7">Sdo anterior</th>
                <th class="center size-7">Debito</th>
                <th class="center size-7">Credito</th>
                <th class="center size-7">Saldo</th>
			</tr>
		</thead>
		<tbody>
			{{--*/ $debito = $credito = 0; /*--}}

			<tr>
				<th colspan="4">{{ $subtitle }}</th>
				<th>{{ $saldo->inicial }}</th>
				<th>{{ $saldo->debitomes }}</th>
				<th>{{ $saldo->creditomes }}</th>
				<th>{{ $saldo->final }}</th>
			</tr>
			@foreach($auxcontable as $key => $item)
				<tr>
					<td>{{ $item->date }}</td>
					<td>{{ $item->folder_codigo }}</td>
					<td>{{ $item->documento_nombre }}</td>
					<td>{{ utf8_decode($item->asiento2_detalle) }}</td>
					<td></td>
					<td>{{ $item->debito }}</td>
					<td>{{ $item->credito }}</td>

					<!--  Obtener saldo -->
					@if ($item->debito < $item->credito)
						{{--*/ $saldo->inicial -= $item->credito - $item->debito; /*--}}
					@else
						{{--*/ $saldo->inicial -= $item->debito - $item->credito; /*--}}
					@endif

					<td>{{ $saldo->inicial }}</td>
				</tr>
				{{--*/
					$nombre = "$item->tercero_nit - $item->tercero_nombre";
					$debito += $item->debito;
					$credito += $item->credito;
				/*--}}
				<tr>
					<td colspan="8">{{ $nombre }}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="5">TOTALES</th>
				<th>{{ $debito }}</th>
				<th>{{ $credito }}</th>
				<th>{{ $saldo->inicial }}</th>
			</tr>
		</tfoot>
	</table>
@stop
