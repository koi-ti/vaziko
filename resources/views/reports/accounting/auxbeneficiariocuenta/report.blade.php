@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	{{-- <p>{{ $titleTercero }}</p> --}}
	
	<p>Tercero: {{ $filter_tercero }}</p>
	<p>Cuenta: {{ $filter_cuenta }}</p>
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="center size-7 width-15">Tercero</th>
				<th class="center size-7 width-15">Nit</th>
				<th class="center size-7 width-15">Cuenta</th>
				<th class="center size-7 width-15">Cuenta nombre</th>
                <th class="center size-7 width-15">Documento</th>
                <th class="center size-7 width-10">Fecha</th>
                <th class="center size-7 width-15">Folder</th>
                <th class="center size-7 width-30">Detalle</th>
                <th class="center size-7">Debito</th>
                <th class="center size-7">Credito</th>
                <th class="center size-7">Saldo</th>
				<th class="center size-7">CR</th>
			</tr>
		</thead>
		<tbody>
			{{--*/
				$tercero = $cuenta = '' ;
				$debito = $credito = $tdebito = $tcredito = 0;
			/*--}}
			@foreach ($data as $item)
				<tr>
					<td class="center size-7 width-5">{{ $item->tercero_nombre }}</td>
					<td class="center size-7 width-5">{{ $item->tercero_nit }}</td>
					<td class="center size-7 width-5">{{ $item->plancuentas_cuenta }}</td>
					<td class="center size-7 width-5">{{ $item->plancuentas_nombre }}</td>
					<td class="center size-7 width-5">{{ $item->documento_nombre }}</td>
					<td class="center size-7 width-5">{{ $item->fecha }}</td>
					<td class="center size-7 width-5">{{ $item->folder_nombre }}</td>
					<td class="center size-7">{{ utf8_decode($item->detalle) }}</td>
					<td align="right">{{ number_format($item->debito, 2, ',', '.') }}</td>
					<td align="right">{{ number_format($item->credito, 2, ',', '.') }}</td>
					<!-- Obtener saldo -->
					{{--*/
						$saldo = $item->debito - $item->credito;
						$cr = '';
					/*--}}
					@if ($item->debito < $item->credito)
						{{-- $saldo = ($item->credito - $item->debito).' CR' --}}
						{{--*/ $saldo = ($item->credito - $item->debito) /*--}}
						{{--*/ $cr = ' CR' /*--}}
					@endif
					<td align="right">{{ number_format($saldo, 2, ',', '.') }}</td>
					<td>{{ $cr }}</td>
				</tr>
				
			@endforeach
			<tr>
				<th colspan="4">TOTALES</th>
				<th>{{ $debito }}</th>
				<th>{{ $credito }}</th>
				<!-- Obtener saldo -->
				{{--*/
					$saldo = $debito - $credito
				/*--}}
				@if ($debito < $credito)
					{{--*/ $saldo = ($credito - $debito).' CR' /*--}}
				@endif
				<th>{{ $saldo }}</th>
			</tr>
		</tbody>
	</table>
@stop
