@extends('production.cotizaciones.report.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<div class="body">
		<table class="rtable" border="0" cellspacing="0" cellpadding="0">
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
				<td colspan="2" class="border">{{ $cotizacion->usuario_nombre }}</td>
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
			{{--*/
				$iva = $ivaunitario = $ivatotal = $totalproducto = $subtotalcotizacion = $ivacotizacion = $totalcotizacion = 0;
				$imagenes = [];
			/*--}}

			@foreach ($data as $cotizacion2)
					{{--*/
						$iva = $cotizacion->cotizacion1_iva / 100;
						$ivaunitario = $cotizacion2->cotizacion2_total_valor_unitario * $iva;
						$ivatotal = $ivaunitario * $cotizacion2->cotizacion2_cantidad;
						$totalproducto = $cotizacion2->cotizacion2_precio_total + $ivatotal;
						$subtotalcotizacion += $cotizacion2->cotizacion2_precio_total;
					/*--}}
					<tr>
						<td colspan="3" class="border-cell">
							<p>
								Producto: <b>{{ $cotizacion2->productop_nombre }}</b><br>
								Referencia: <b>{{ $cotizacion2->cotizacion2_referencia }}</b><br>
								Medidas: {{ $cotizacion2->medidas }}<br>
								{!! isset($cotizacion2->materialp_nombre) ? "Material: $cotizacion2->materialp_nombre <br>" : "" !!}
								{!! isset($cotizacion2->acabadop_nombre) ? "Acabado: $cotizacion2->acabadop_nombre <br>" : ""  !!}
								{!! isset($cotizacion2->empaque_nombre) ? "Empaque: $cotizacion2->empaque_nombre <br>" : ""  !!}
								@if( $cotizacion2->tiro || $cotizacion2->retiro )
									{{ "Tintas: {$cotizacion2->tiro} / {$cotizacion2->retiro}" }}
								@endif
							</p>
							@if ($cotizacion2->imagenes != [])
								<table width="100%">
									@foreach(array_chunk($cotizacion2->imagenes, 2) as $chunk)
										<tr>
											@foreach($chunk as $imagen)
												<td>
													<img src="{{ $imagen }}" alt="cotizacion" style="width:150px; height: 100px;">
												</td>
											@endforeach
										</tr>
									@endforeach
								</table>
							@endif
						</td>
						<td class="border-cell" align="center">{{ $cotizacion2->cotizacion2_cantidad }}</td>
						<td colspan="2" class="border-cell" align="right">{{ number_format($cotizacion2->cotizacion2_total_valor_unitario, 2, ',', '.') }}</td>
						<td colspan="2" class="border-cell" align="right">{{ number_format($ivaunitario, 2, ',', '.') }}</td>
						<td colspan="2" class="border-cell" align="right">{{ number_format($totalproducto, 2, ',', '.') }}</td>
					</tr>
				@endforeach
			{{--*/
				$ivacotizacion = round($subtotalcotizacion * $iva);
				$totalcotizacion = $ivacotizacion + $subtotalcotizacion;
			/*--}}
			<tr>
				<td colspan="4" class="border-top" align="left" valign="top"></td>
				<th colspan="2" align="left" class="border" valign="top">Subtotal</th>
				<th colspan="2" align="left" class="border" valign="top">I.V.A({{$cotizacion->cotizacion1_iva}}%)</th>
				<th colspan="2" align="left" class="border" valign="top">Valor Total</th>
			</tr>
			<tr>
				<td colspan="4" class="noborder" align="left" valign="top"></td>
				<th colspan="2" align="right" class="border" valign="top">{{ number_format($subtotalcotizacion, 2, ',', '.') }}</th>
				<th colspan="2" align="right" class="border" valign="top">{{ number_format($ivacotizacion, 2, ',', '.') }}</th>
				<th colspan="2" align="right" class="border" valign="top">{{ number_format($totalcotizacion, 2, ',', '.') }}</th>
			</tr>
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
