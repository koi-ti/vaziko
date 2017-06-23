@extends('receivable.facturas.export.layout', ['type' => 'pdf', 'title' => $title])

@section('content')

	<div class="container-factura">
		<tr>
			<th width="83%" class="left"></th>
			<th width="17%" class="center">{{ $factura->id }}</th>
		</tr>
	</div>

	<div class="container-encabezado">
		<div class="tercero-info">
			<tr>
				<th class="left"></th>
				<th class="left">{{ $factura->tercero_nombre }}</th>
			</tr>

			<tr>
				<th class="left"></th>
				<th class="left">{{ $factura->tercero_direccion }}</th>
			</tr>
		</div>

		<div class="tercero-info2">
			<tr>
				<th width="10%" class="left"></th>
				<th width="20%" class="left">{{ $factura->tercero_nit }}</th>
				
				<th width="10%" class="left"></th>
				@if( !empty($factura->tercero_telefono1) )
					<th width="20%" class="left">{{ $factura->tercero_telefono1 }}</th>
				@elseif ( !empty($factura->tercero_telefono2) )
					<th width="20%" class="left">{{ $factura->tercero_telefono2 }}</th>
				@elseif ( !empty($factura->tercero_celular) )
					<th width="20%" class="left">{{ $factura->tercero_celular }}</th>
				@else 
					<th width="20%" class="left"></th>
				@endif

				<th width="10%" class="left"></th>
				<th width="20%" class="left">{{ $factura->municipio_nombre }}</th>
			</tr>
		</div>

		<div class="tercero-info3">
			<tr>
				<th width="7%" class="left"></th>
				<th width="23%" class="left">{{ $factura->factura1_fecha }}</th>
				
				<th width="15%" class="left"></th>
				<th width="20%" class="left">{{ $factura->factura1_fecha_vencimiento }}</th>
				
				<th width="15%" class="left"></th>
				<th width="20%" class="left">xxxxxxx</th>
			</tr>
		</div>
	</div>

	<div class="container-body">
		@if(count($detalle) > 0)
			
			{{--*/ $i = 0; /*--}}
			@foreach($detalle as $ordenp2)
				{{--*/ $totalRow = $ordenp2->factura2_cantidad * $ordenp2->orden2_precio_venta; /*--}}
				<tr>

					<td width="8%" class="left">{{ $ordenp2->orden2_id }}</td>
					<td width="51%" class="left">{{ $ordenp2->productop_nombre }}</td>
					<td width="10%" class="center">{{ $ordenp2->factura2_cantidad }}</td>
					<td width="13%" class="right">{{ number_format($ordenp2->orden2_precio_venta,2,'.',',') }}</td>
					<td width="17%"class="right">{{ number_format($totalRow,2,'.',',') }}</td>
				</tr>

				{{--*/ if( ++$i == 12 ) break; /*--}}
			@endforeach

		@endif
	</div>

	<div class="container-footer">
			<tr>
				<th width="83%" class="right"></th>
				<td width="17%" class="right">{{ number_format($factura->factura1_subtotal,2,'.',',') }}</td>
			</tr>

			<tr>
				<th width="83%" class="right"></th>
				<td width="17%" class="right">{{ number_format($factura->factura1_iva,2,'.',',') }}</td>
			</tr>
			<tr>
				<th width="83%" class="right"></th>
				<td width="17%" class="right">{{ number_format($factura->factura1_retefuente,2,'.',',') }}</td>
			</tr>
			<tr>
				<th width="83%" class="right"></th>
				<td width="17%" class="right">{{ number_format($factura->factura1_reteica,2,'.',',') }}</td>
			</tr>
			<tr>
				<th width="83%" class="right"></th>
				<td width="17%" class="right">{{ number_format($factura->factura1_reteiva,2,'.',',') }}</td>
			</tr>

			<tr>
				<th width="83%" class="right"></th>
				<td width="17%" class="right">{{ number_format($factura->factura1_total,2,'.',',') }}</td>
			</tr>
	</div>
@stop