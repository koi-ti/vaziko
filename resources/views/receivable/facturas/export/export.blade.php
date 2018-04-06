@extends('receivable.facturas.export.layout', ['type' => 'pdf', 'title' => $title])

@section('content')

	<div class="container-factura">
		<tr>
			<th width="83%" class="left"></th>
			<th width="17%" class="center">{{ $factura->id }}</th>
		</tr>
	</div>

	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th class="left"></th>
			<th class="left" colspan="6">{{ $factura->tercero_nombre }}</th>
		</tr>

		<tr>
			<th class="left"></th>
			<th class="left" colspan="6">{{ $factura->tercero_direccion }}</th>
		</tr>

		<tr>
			<th width="8%"></th>
			<th width="20%" class="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $factura->tercero_nit }}</th>

			<th width="11%" class="left"></th>
			@if( !empty($factura->tercero_telefono1) )
				<th width="20%" class="center">&nbsp;&nbsp;&nbsp;{{ $factura->tercero_telefono1 }}</th>
			@elseif ( !empty($factura->tercero_telefono2) )
				<th width="20%" class="center">&nbsp;&nbsp;&nbsp;{{ $factura->tercero_telefono2 }}</th>
			@elseif ( !empty($factura->tercero_celular) )
				<th width="20%" class="center">&nbsp;&nbsp;&nbsp;{{ $factura->tercero_celular }}</th>
			@else
				<th width="20%" class="center"></th>
			@endif

			<th width="11%" class="left"></th>
			<th colspan="2" class="center">{{ $factura->municipio_nombre }}</th>
		</tr>

		<tr>
			<th width="8%" class="left"></th>
			<th width="20%" class="left">{{ $factura->factura1_fecha }}</th>

			<th width="8%" class="left"></th>
			<th width="20%" class="center">{{ $factura->factura1_fecha_vencimiento }}</th>

			<th width="8%" class="left"></th>
			@if( ($factura->factura1_cuotas == 1) )
				<th colspan="2" class="center">CONTADO</th>
			@else
				<th colspan="2" class="center">CREDITO</th>
			@endif
		</tr>
	</table>

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="6%" class="left"></th>
				<th width="40%" class="left"></th>
				<th width="8%" class="center"></th>
				<th width="12%" class="left"></th>
				<th width="14%" class="center"></th>
			</tr>
		</thead>
		<tbody>
			@if(count($detalle) > 0)
				@foreach($detalle as $ordenp2)
					{{--*/ $totalRow = $ordenp2->factura2_cantidad * $ordenp2->orden2_total_valor_unitario; /*--}}
					<tr>
						<td class="left">{{ $ordenp2->orden2_id }}</td>
						<td class="left">{{ $ordenp2->productop_nombre }}</td>
						<td class="center">{{ $ordenp2->factura2_cantidad }}</td>
						<td class="right">{{ number_format($ordenp2->orden2_total_valor_unitario,2,'.',',') }}</td>
						<td class="right">{{ number_format($totalRow,2,'.',',') }}</td>
					</tr>
				@endforeach

				@if( count($detalle) < 24 )
					@for($i = count($detalle); $i < 24; $i++)
						<tr>
							<td colspan="5"></td>
						</tr>
					@endfor
				@endif
			@endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" rowspan="8"></td>
			</tr>
			<tr>
				<td colspan="2" class="right">{{ number_format($factura->factura1_subtotal,2,'.',',') }}</td>
			</tr>

			<tr>
				<td colspan="2" class="right">{{ number_format($factura->factura1_iva,2,'.',',') }}</td>
			</tr>
			<tr>
				<td colspan="2" class="right">{{ number_format($factura->factura1_retefuente,2,'.',',') }}</td>
			</tr>
			<tr>
				<td colspan="2" class="right">{{ number_format($factura->factura1_reteica,2,'.',',') }}</td>
			</tr>
			<tr>
				<td colspan="2" class="right">{{ number_format($factura->factura1_reteiva,2,'.',',') }}</td>
			</tr>

			<tr>
				<td colspan="2" class="right">{{ number_format($factura->factura1_total,2,'.',',') }}</td>
			</tr>
		</tfoot>
	</table>
@stop
