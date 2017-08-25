@extends('reports.layout', ['type' => 'pdf', 'title' => $title])

@section('content')

	<table class="brtable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			@if($orden->orden_anulada)
				<tr>
					<th class="center titleespecial" colspan="6">ANULADA</th>
				</tr>
            @endif

            @if($orden->orden_abierta)
				<tr>
					<th class="center titleespecial" colspan="6">LA ORDEN ACTUALMENTE ESTA ABIERTA Y SUJETA A CAMBIOS</th>
				</tr>
			@endif
			<tr>
				<th width="10%" class="left">Código</th>
				<td width="15%" class="left">{{ $orden->orden_codigo }}</td>
				<th width="10%" class="left">Referencia</th>
				<td class="left" colspan="3">{{ $orden->orden_referencia }}</td>
			</tr>

			<tr>
				<th class="left">F. Inicio</th>
				<td class="left">{{ $orden->orden_fecha_inicio }}</td>
				<th class="left">F. Entrega</th>
				<td width="15%" class="left">{{ $orden->orden_fecha_entrega }}</td>
				<th width="10%" class="left">H. Entrega</th>
				<td width="40%" class="left">{{ $orden->orden_hora_entrega }}</td>
			</tr>

			<tr>
				<th class="left">Cliente</th>
				<td class="left">{{ $orden->tercero_nit }}</td>
				<td class="left" colspan="4">{{ $orden->tercero_nombre }}</td>
			</tr>

			<tr>
				<th class="left">Contacto</th>
				<td class="left" colspan="3">{{ $orden->tcontacto_nombre }}</td>
				<th class="left">Teléfono</th>
				<td class="left">{{ $orden->tcontacto_telefono }}</td>
			</tr>

			<tr>
				<th class="left">Forma pago</th>
				<td class="left">{{ $orden->orden_formapago ? config('koi.produccion.formaspago')[$orden->orden_formapago] : ''  }}</td>
				<th class="left">Suministran</th>
				<td class="left" colspan="3">{{ $orden->orden_suministran }}</td>
			</tr>
			<tr>
				<th class="left height-40">Detalle</th>
				<td class="left height-40" colspan="5">{{ $orden->orden_observaciones }}</td>
			</tr>
			<tr>
				<th class="left height-40">Terminado</th>
				<td class="left height-40" colspan="5">{{ $orden->orden_terminado }}</td>
			</tr>
		</tbody>
	</table>

	<br />
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
	        <tr>
	            <th>Código</th>
	            <th>Nombre</th>
	            <th>Cantidad</th>
	            <th>Facturado</th>
	            <th>Precio</th>
	            <th>Total</th>
	        </tr>
       	<thead>
   		<tbody>
			@if(count($detalle) > 0)
				{{--*/ $tunidades = $tfacturado = $tsubtotal = $tcredito = 0; /*--}}
				@foreach($detalle as $ordenp2)
					<tr>
						<td class="left">{{ $ordenp2->id }}</td>
						<td class="left">{{ $ordenp2->productop_nombre }}</td>
						<td class="center">{{ $ordenp2->orden2_cantidad }}</td>
						<td class="center">{{ $ordenp2->orden2_facturado }}</td>
						<td class="right">{{ number_format($ordenp2->orden2_precio_venta,2,',','.') }}</td>
						<td class="right">{{ number_format($ordenp2->orden2_precio_total,2,',','.') }}</td>
					</tr>

					{{-- Calculo totales --}}
					{{--*/
						$tunidades += $ordenp2->orden2_cantidad;
						$tsubtotal += $ordenp2->orden2_precio_total;
						$tfacturado += $ordenp2->orden2_facturado;
						//$tdebito += $ordenp2->ordenp2_debito;
					/*--}}
				@endforeach
				{{--*/ $tiva = $tsubtotal * ($orden->orden_iva / 100); /*--}}
				<tr>
					<td colspan="2" class="right bold">Subtotal</td>
					<td class="center bold">{{ $tunidades }}</td>
					<td class="center bold">{{ $tfacturado }}</td>
					<td colspan="2" class="right bold">{{ number_format($tsubtotal,2,',','.') }}</td>
				</tr>
				<tr>
					<td colspan="2" class="right bold">Iva ({{ $orden->orden_iva }}%)</td>
					<td colspan="4" class="right bold">{{ number_format($tiva,2,',','.') }}</td>
				</tr>
				<tr>
					<td colspan="2" class="right bold">Total</td>
					<td colspan="4" class="right bold">{{ number_format(($tsubtotal + $tiva),2,',','.') }}</td>
				</tr>
			@endif
		</tbody>
    </table>
@stop
