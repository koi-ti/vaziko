@extends('production.cotizaciones.export.layout', ['type' => 'pdf', 'title' => $title])

@section('content')

	<table class="brtable" border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td width="30%" class="left bold">Fecha</td>
			<td width="70%" class="left bold">Tomado por</td>
		</tr>

		<tr>
			<td width="30%" class="left">{{ $cotizacion->cotizacion1_fecha_inicio }}</td>
			<td width="70%" class="left">{{ Auth::user()->getName() }}</td>
		</tr>
		<tr>
			<td colspan="2" class="bold">Cliente</td>
		</tr>
	</table>

	<table class="brtable" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th width="10%" class="left border-left">Compañia:</th>
			<th width="40%" class="left">{{ $cotizacion->tercero_nombre }}</th>

			<th width="10%" class="left">Nit:</th>
			<th width="40%" class="left border-right">{{ $cotizacion->tercero_nit }}</th>
		</tr>
		<tr>
			<th width="10%" class="left border-left">Contacto</th>
			<th width="40%" class="left">{{ $cotizacion->tcontacto_nombre }}</th>

			<th width="10%" class="left">Email:</th>
			<th width="40%" class="left border-right">{{ $cotizacion->tcontacto_email }}</th>
		</tr>
		<tr>
			<th width="10%" class="left border-left">Teléfono</th>
			@if( !empty( $cotizacion->tercero_telefono1 ) )
				<th width="40%" class="left">{{ $cotizacion->tercero_telefono1 }}</th>
			@else
				<th width="40%" class="left">{{ $cotizacion->tercero_telefono2 }}</th>
			@endif

			<th width="10%" class="left">Celular</th>
			<th width="40%" class="left border-right">{{ $cotizacion->tercero_celular }}</th>
		</tr>
	</table>

	<table class="brtable" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th width="10%" class="left border-left">Direccion</th>
			<th width="60%" class="left">{{ $cotizacion->tercero_direccion }}</th>

			<th width="10%" class="left">Ciudad</th>
			<th width="20%" class="left border-right">{{ $cotizacion->municipio_nombre }}</th>
		</tr>
	</table>

	<table class="brtable" border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td width="50%" class="center">Referencia</td>
			<td width="50%" class="left">Terminos</td>
		</tr>
		<tr>
			<th class="left">{{ $cotizacion->cotizacion1_referencia }}</th>
			<th class="left">{{ $cotizacion->cotizacion1_terminado }}</th>
		</tr>
	</table>

	<table class="brtable" border="1" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="49%" class="center">Descripción</td>
				<td width="10%" class="center">Cantidad</td>
				<td width="13%" class="center">Precio Unitario</td>
				<td width="13%" class="center">IVA</td>
				<td width="13%" class="center">Total</td>
			</tr>
			{{--*/ $iva = $fiva = $total = 0 /*--}}
			@foreach( $object->cotizacion2 as $cotizacion2 )
				{{--*/
					$iva = $cotizacion2->cotizacion2->cotizacion1_iva / 100;
					$fiva = $cotizacion2->cotizacion2->cotizacion2_total_valor_unitario * $iva;
					$total += $cotizacion2->cotizacion2->cotizacion2_precio_total;
				/*--}}
				<tr>
					<td>
						<br>
						{{ $cotizacion2->cotizacion2->productop_nombre }}<br><br>
						{{ isset($cotizacion2->maquinasp) ? 'Maquina: '. $cotizacion2->maquinasp : null }}<br>
						{{ isset($cotizacion2->materialesp) ? 'Material: '. $cotizacion2->materialesp : null }}<br>
						{{ isset($cotizacion2->acabadosp) ? 'Acabado: '. $cotizacion2->acabadosp : null }}
					</td>
					<td class="center">{{ $cotizacion2->cotizacion2->cotizacion2_cantidad }}</td>
					<td class="right">{{ number_format($cotizacion2->cotizacion2->cotizacion2_total_valor_unitario, 2, ',', '.') }}</td>
					<td class="right">{{ number_format($fiva, 2, ',', '.') }}</td>
					<td class="right">{{ number_format($cotizacion2->cotizacion2->cotizacion2_precio_total, 2, ',', '.') }}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td rowspan="5" colspan="3" class="noborder">
		            <p>
		                Si esta cotización es aprobada, agradecemos nos autorice(n) la ejecución por escrito, correo electrónico o nos
		                devuelva(n) la presente firmada y sellada autorizando la cotización, junto con una orden de compra.
		                Esta cotización es válida por 8 días a partir de la fecha del encabezado. Todo trabajo en impresión digital puede
		                tener una variación de color hasta de un 6% dependiendo del sustrato en que se imprima. La impresión digital para
		                exteriores no se debe limpiar con solventes.
		            </p>
		        </td>
		        <th class="left">Valor Total</th>
		        <th class="right">{{ number_format($total, 2, ',', '.') }}</th>
		    </tr>
			<tr>
				<td class="noborder"></td>
				<td class="noborder"></td>
			</tr>
			<tr>
				<td class="noborder"></td>
				<td class="noborder"></td>
			</tr>
			<tr>
				<td class="noborder"></td>
				<td class="noborder"></td>
			</tr>
			<tr>
				<td class="noborder"></td>
				<td class="noborder"></td>
			</tr>
		</tfoot>
	</table>
@stop
