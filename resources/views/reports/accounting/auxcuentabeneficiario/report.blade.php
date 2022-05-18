@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<p>{{$subtitleTercero}}</p>
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7 width-10">Fecha</th>
                <th class="center size-7 width-15">Folder</th>
                <th class="center size-7 width-15">Doc contable</th>
                <th class="center size-7 width-30">Detalle</th>
                <th class="center size-7">Debito</th>
                <th class="center size-7">Credito</th>
                <th class="center size-7">Saldo</th>
			</tr>
		</thead>
		<tbody>
			{{--*/
				$tercero = '' ;
				$debito = $credito = $tdebito = $tcredito = 0;
			/*--}}
			<tr>
				<td colspan="7">{{ $subtitle }}</td>
			</tr>
			@foreach($auxcontable as $key => $item)
				@if($tercero != $item->tercero_nit)
					@if($key > 0)
						{{--*/ list($nit, $nombre) = explode('-', $nombre); /*--}}
						<tr>
							<th colspan="4">TOTAL {{ $nombre }}</th>
							<th>{{ $tdebito }}</th>
							<th>{{ $tcredito }}</th>

							<!-- Obtener saldo -->
							{{--*/ $saldo = $tdebito - $tcredito /*--}}
							@if ($tdebito < $tcredito)
								{{--*/ $saldo = ($tcredito - $tdebito).' CR' /*--}}
							@endif

							<th>{{ $saldo }}</th>
							{{--*/ $tdebito = $tcredito = 0; /*--}}
						</tr>
					@endif
					{{--*/ $nombre = "$item->tercero_nit - $item->tercero_nombre"; /*--}}
					<tr>
						<td colspan="7">{{ $nombre }}</td>
					</tr>
				@endif
				<tr>
					<td>{{ $item->date }}</td>
					<td>{{ $item->folder_nombre }}</td>
					<td>{{ $item->documento_nombre }}</td>
					<td>{{ $item->asiento2_detalle }}</td>
					<td>{{ $item->debito }}</td>
					<td>{{ $item->credito }}</td>

					<!-- Obtener saldo -->
					{{--*/ $saldo = $item->debito - $item->credito /*--}}
					@if ($item->debito < $item->credito)
						{{--*/ $saldo = ($item->credito - $item->debito).' CR' /*--}}
					@endif

					<td>{{ $saldo }}</td>
				</tr>
				{{--*/
					$tercero = $item->tercero_nit;
					$debito += $item->debito;
					$credito += $item->credito;
					$tdebito += $item->debito;
					$tcredito +=  $item->credito;
				/*--}}
				@if ($key == $auxcontable->count()-1)
					{{--*/ list($nit, $nombre) = explode('-', $nombre); /*--}}
					<tr>
						<th colspan="4">TOTAL {{ $nombre }}</th>
						<th>{{ $tdebito }}</th>
						<th>{{ $tcredito }}</th>

						<!-- Obtener saldo -->
						{{--*/ $saldo = $tdebito - $tcredito /*--}}
						@if ($tdebito < $tcredito)
							{{--*/ $saldo = ($tcredito - $tdebito).' CR' /*--}}
						@endif

						<th>{{ $saldo }}</th>
						{{--*/ $tdebito = $tcredito = 0; /*--}}
					</tr>
				@endif
			@endforeach
			<tr>
				<th colspan="4">TOTALES</th>
				<th>{{ $debito }}</th>
				<th>{{ $credito }}</th>

				<!-- Obtener saldo -->
				{{--*/ $saldo = $debito - $credito /*--}}
				@if ($debito < $credito)
					{{--*/ $saldo = ($credito - $debito).' CR' /*--}}
				@endif
				<th>{{ $saldo }}</th>
			</tr>
		</tbody>
	</table>
@stop
