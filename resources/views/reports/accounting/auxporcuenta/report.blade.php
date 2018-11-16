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
				<th colspan="4">{{$subtitle}}</th>
				<th>{{number_format ($saldo->inicial,2,',' , '.')}}</th>
				<th>{{number_format ($saldo->debitomes,2,',' , '.')}}</th>
				<th>{{number_format ($saldo->creditomes,2,',' , '.')}}</th>
				<th>{{number_format ($saldo->final,2,',' , '.')}}</th>
			</tr>
			@foreach($auxcontable as $key => $item)
				<tr>
					<td>{{$item->date}}</td>
					<td>{{$item->folder_codigo}}</td>
					<td>{{$item->documento_nombre}}</td>
					<td>{{utf8_decode($item->asiento2_detalle)}}</td>
					<td></td>
					<td>{{number_format ($item->debito,2,',' , '.')}}</td>
					<td>{{number_format ($item->credito,2,',' , '.')}}</td>

					<!--  Obtener saldo -->
					@if ($item->debito < $item->credito)
						{{--*/ $saldo->inicial -= $item->credito - $item->debito; /*--}}
					@else
						{{--*/ $saldo->inicial -= $item->debito - $item->credito; /*--}}
					@endif

					<td>{{number_format ($saldo->inicial,2,',' , '.')}}</td>
				</tr>
				{{--*/
					$nombre = "$item->tercero_nit - $item->tercero_nombre";
					$debito += $item->debito;
					$credito += $item->credito;
				/*--}}
				<tr>
					<td colspan="8">{{$nombre}}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="5">TOTALES</th>
				<th>{{number_format ($debito,2,',' , '.')}}</th>
				<th>{{number_format ($credito,2,',' , '.')}}</th>
				<th>{{number_format ($saldo->inicial,2,',' , '.')}}</th>
			</tr>
		</tfoot>
	</table>
@stop
