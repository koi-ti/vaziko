@extends('reports.layout', ['type' => 'pdf', 'title' => $title])

@section('content')

	<table class="brtable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			@if($cotizacion->cotizacion1_anulada)
				<tr>
					<th class="center titleespecial" colspan="6">ANULADA</th>
				</tr>
            @endif

            @if($cotizacion->cotizacion1_abierta)
				<tr>
					<th class="center titleespecial" colspan="6">LA COTIZACIÓN ACTUALMENTE ESTA ABIERTA Y SUJETA A CAMBIOS</th>
				</tr>
			@endif
			<tr>
				<th width="10%" class="left">Código</th>
				<td width="15%" class="left">{{ $cotizacion->cotizacion_codigo }}</td>
				<th width="10%" class="left">Referencia</th>
				<td class="left" colspan="3">{{ $cotizacion->cotizacion1_referencia }}</td>
			</tr>

			<tr>
				<th class="left">F. Inicio</th>
				<td class="left">{{ $cotizacion->cotizacion1_fecha_inicio }}</td>
				<th class="left">F. Entrega</th>
				<td width="15%" class="left">{{ $cotizacion->cotizacion1_fecha_entrega }}</td>
				<th width="10%" class="left">H. Entrega</th>
				<td width="40%" class="left">{{ $cotizacion->cotizacion1_hora_entrega }}</td>
			</tr>

			<tr>
				<th class="left">Cliente</th>
				<td class="left">{{ $cotizacion->tercero_nit }}</td>
				<td class="left" colspan="4">{{ $cotizacion->tercero_nombre }}</td>
			</tr>

			<tr>
				<th class="left">Contacto</th>
				<td class="left" colspan="3">{{ $cotizacion->tcontacto_nombre }}</td>
				<th class="left">Teléfono</th>
				<td class="left">{{ $cotizacion->tcontacto_telefono }}</td>
			</tr>

			<tr>
				<th class="left">Forma pago</th>
				<td class="left">{{ $cotizacion->cotizacion1_formapago ? config('koi.produccion.formaspago')[$cotizacion->cotizacion1_formapago] : ''  }}</td>
				<th class="left">Suministran</th>
				<td class="left" colspan="3">{{ $cotizacion->cotizacion1_suministran }}</td>
			</tr>
			<tr>
				<th class="left height-40">Detalle</th>
				<td class="left height-40" colspan="5">{{ $cotizacion->cotizacion1_observaciones }}</td>
			</tr>
			<tr>
				<th class="left height-40">Terminado</th>
				<td class="left height-40" colspan="5">{{ $cotizacion->cotizacion1_terminado }}</td>
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
				@foreach($detalle as $cotizacion2)
					<tr>
						<td class="left">{{ $cotizacion2->id }}</td>
						<td class="left">{{ $cotizacion2->productop_nombre }}</td>
						<td class="center">{{ $cotizacion2->cotizacion2_cantidad }}</td>
						<td class="center">{{ $cotizacion2->cotizacion2_facturado }}</td>
						<td class="right">{{ number_format($cotizacion2->cotizacion2_precio_venta,2,',','.') }}</td>
						<td class="right">{{ number_format($cotizacion2->cotizacion2_precio_total,2,',','.') }}</td>
					</tr>

					{{-- Calculo totales --}}
					{{--*/
						$tunidades += $cotizacion2->cotizacion2_cantidad;
						$tsubtotal += $cotizacion2->cotizacion2_precio_total;
						$tfacturado += $cotizacion2->cotizacion2_facturado;
						//$tdebito += $cotizacion2->cotizacion2_debito;
					/*--}}
				@endforeach
				{{--*/ $tiva = $tsubtotal * ($cotizacion->cotizacion1_iva / 100); /*--}}
				<tr>
					<td colspan="2" class="right bold">Subtotal</td>
					<td class="center bold">{{ $tunidades }}</td>
					<td class="center bold">{{ $tfacturado }}</td>
					<td colspan="2" class="right bold">{{ number_format($tsubtotal,2,',','.') }}</td>
				</tr>
				<tr>
					<td colspan="2" class="right bold">Iva ({{ $cotizacion->cotizacion1_iva }}%)</td>
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
