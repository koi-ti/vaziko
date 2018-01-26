@extends('production.cotizaciones.report.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<div class="body">
		<table class="rtable" border="0" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<td colspan="10">
						{{-- Title --}}
						{{--*/ $empresa = App\Models\Base\Empresa::getEmpresa(); /*--}}
						@include('production.cotizaciones.report.title')
					</td>
				</tr>
				<tr>
					<th align="left" valign="top" class="border-tbl">Referencia:</th>
					<td colspan="2" valign="top" class="border-tbr">{{ $cotizacion->cotizacion1_referencia }}</td>
					<th align="left" valign="top" class="border-tbl">Suministran:</th>
					<td colspan="6" valign="top" class="border-tbr">{{ $cotizacion->cotizacion1_suministran }}</td>
				</tr>
				<tr>
					<th colspan="6" align="left" class="border">Cliente</th>
					<th colspan="2" align="left" class="border">Asegurado por:</th>
					<th colspan="2" align="left" class="border">Transporte:</th>
				</tr>
				<tr>
					<th align="left" class="border-left">Compañia:</th>
					<td colspan="2" class="noborder">{{ $cotizacion->tercero_nombre }}</td>
					<th align="left" class="noborder">Nit:</th>
					<td colspan="2" class="noborder">{{ $cotizacion->tercero_nit }}</td>

					<td colspan="2" rowspan="2" class="border"></td>
					<td colspan="2" rowspan="2" class="border"></td>
				</tr>
				<tr>
					<th align="left" class="border-left">Dirección:</th>
					<td colspan="2" class="noborder">{{ $cotizacion->tercero_direccion }}</td>
					<th align="left" class="noborder">Celular:</th>
					<td colspan="2" class="noborder">{{ $cotizacion->tercero_celular }}</td>
				</tr>
				<tr>
					<th align="left" class="border-left">Contacto:</th>
					<td colspan="2" class="noborder">{{ $cotizacion->tcontacto_nombre }}</td>
					<th align="left" class="noborder">Teléfono:</th>
					@if( !empty( $cotizacion->tercero_telefono1 ) )
						<td colspan="2" class="noborder">{{ $cotizacion->tercero_telefono1 }}</td>
					@else
						<td colspan="2" class="noborder">{{ $cotizacion->tercero_telefono2 }}</td>
					@endif
					<th colspan="2" align="left" class="border">Tomado por:</th>
					<td colspan="2" class="border">{{ Auth::user()->getName() }}</td>
				</tr>
				<tr>
					<th align="left" class="border-left">Email:</th>
					<td colspan="2" class="noborder">{{ $cotizacion->tcontacto_email }}</td>
					<th align="left" class="noborder">Ciudad:</th>
					<td colspan="2" class="noborder">{{ $cotizacion->municipio_nombre }}</td>
					<th colspan="2" align="left" class="border">Términos:</th>
					<td colspan="2" class="border">{{ $cotizacion->cotizacion1_formapago }}</td>
				</tr>
				<tr>
					<td colspan="3" align="center" class="border">Descripción</td>
					<td align="center" class="border">Cantidad</td>
					<td colspan="2" align="right" class="border">Precio Unitario</td>
					<td colspan="2" align="right" class="border">I.V.A</td>
					<td colspan="2" align="right" class="border">Total</td>
				</tr>
			</thead>
			<tbody>
				{{--*/ $iva = $productoIva = $total = $preciototal = 0 /*--}}
				@foreach( $data as $cotizacion2 )
					{{--*/
						$iva = $cotizacion2->detalle->cotizacion1_iva / 100;
						$productoIva = $cotizacion2->detalle->cotizacion2_total_valor_unitario * $iva;
						$preciototal += $cotizacion2->detalle->cotizacion2_precio_total;
					/*--}}
					<tr>
						<td colspan="3" class="border-cell">
							<br>
							{{ $cotizacion2->detalle->productop_nombre }}<br>
							@if( isset($cotizacion2->materialesp) )
								{{ "Material: $cotizacion2->materialesp" }} <br>
							@endif
							@if( isset($cotizacion2->acabadosp) )
								{{ "Acabado: $cotizacion2->acabadosp" }} <br>
							@endif
							@if( $cotizacion2->detalle->tiro || $cotizacion2->detalle->retiro )
								{{ "Tintas: {$cotizacion2->detalle->tiro} / {$cotizacion2->detalle->retiro}" }}
							@endif
						</td>
						<td class="border-cell" align="center">{{ $cotizacion2->detalle->cotizacion2_cantidad }}</td>
						<td colspan="2" class="border-cell" align="right">{{ number_format($cotizacion2->detalle->cotizacion2_total_valor_unitario, 2, ',', '.') }}</td>
						<td colspan="2" class="border-cell" align="right">{{ number_format($productoIva, 2, ',', '.') }}</td>
						<td colspan="2" class="border-cell" align="right">{{ number_format($cotizacion2->detalle->cotizacion2_precio_total, 2, ',', '.') }}</td>
					</tr>
					@endforeach
			</tbody>
			<tfoot>
				{{-- Calcular iva total cotizacion --}}
				{{--*/ $calculoiva = $totaliva = $totalcotizacion = 0; /*--}}
				{{--*/
					$calculoiva = $preciototal * $iva;
					$totalcotizacion = $calculoiva + $preciototal;
				/*--}}
				<tr>
					<td colspan="6" class="border-top" align="left" valign="top"></td>
					<th colspan="2" align="left" class="border" valign="top">I.V.A({{ $cotizacion2->detalle->cotizacion1_iva }}%)</th>
					<th colspan="2" align="right" class="border" valign="top">{{ number_format($calculoiva, 2, ',', '.') }}</th>
				</tr>
				<tr>
					<td colspan="6" class="noborder" align="left" valign="top"></td>
					<th colspan="2" align="left" class="border" valign="top">Valor Total</th>
					<th colspan="2" align="right" class="border" valign="top">{{ number_format($totalcotizacion, 2, ',', '.') }}</th>
				</tr>
			</tfoot>
		</table>

		<div class="">
			<p><b>Notas:</b> {{ $cotizacion->cotizacion1_terminado }}</p>
		</div>
	</div>

	<div class="footer">
		<table class="rtable" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td rowspan="5" colspan="3" class="noborder">
					<p>
						Si esta cotización es aprobada, agradecemos se nos autorice la ejecución del trabajo por escrito o por correo electrónico, o se nos devuelva la cotización con firma y sello, junto con la correspondiente orden de compra. Esta cotización es válida por ocho días a partir de su fecha. Toda impresión digital, por la naturaleza de este proceso y según el sustrato en que se imprima, puede presentar en su tiraje una variación de color de +‐6% en relación con el original, lo cual se considera aceptable. Por las mismas razones, esta variación en impresión offset se considera normal en un rango de +‐8%. La impresión digital para exteriores no se debe limpiar con solventes.
					</p>
				</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2" align="center">_____________________________</td>
			</tr>
			<tr>
				<th colspan="2" align="center">Aprobación Cliente</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
@stop
