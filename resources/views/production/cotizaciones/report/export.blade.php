@extends('production.cotizaciones.report.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	<div class="body">
		<div class="table">
			<div class="rows">
				<div style="width:53%;" class="cell center">Descripción</div>
				<div style="width:7%;" class="cell center">Cantidad</div>
				<div style="width:13%;" class="cell center">Precio Unitario</div>
				<div style="width:13%;" class="cell center">I.V.A</div>
				<div style="width:13%;" class="cell center">Total</div>
			</div>
			{{--*/ $iva = $fiva = $total = 0 /*--}}
			@foreach( $object->cotizacion2 as $cotizacion2 )
				{{--*/
					$iva = $cotizacion2->cotizacion2->cotizacion1_iva / 100;
					$fiva = $cotizacion2->cotizacion2->cotizacion2_total_valor_unitario * $iva;
					$total += $cotizacion2->cotizacion2->cotizacion2_precio_total;
				/*--}}
				<div class="rows">
					<div class="cell border-cell">
						<br>
						{{ $cotizacion2->cotizacion2->productop_nombre }}<br>
						{{ isset($cotizacion2->materialesp) ? 'Material: '. $cotizacion2->materialesp : null }}<br>
						{{ isset($cotizacion2->acabadosp) ? 'Acabado: '. $cotizacion2->acabadosp : null }}
					</div>
					<div class="cell border-cell center">{{ $cotizacion2->cotizacion2->cotizacion2_cantidad }}</div>
					<div class="cell border-cell right">{{ number_format($cotizacion2->cotizacion2->cotizacion2_total_valor_unitario, 2, ',', '.') }}</div>
					<div class="cell border-cell right">{{ number_format($fiva, 2, ',', '.') }}</div>
					<div class="cell border-cell right">{{ number_format($cotizacion2->cotizacion2->cotizacion2_precio_total, 2, ',', '.') }}</div>
				</div>
			@endforeach
			<div class="rows">
				<div class="cell right border-top" colspan="3"></div>
				<div class="cell right size-7 bold">Valor Total</div>
				<div class="cell right size-7 bold">{{ number_format($total, 2, ',', '.') }}</div>
			</div>
		</div>
	</div>

	<div class="footer">
		<div class="table">
			<div class="rows">
				<div rowspan="5" colspan="3" class="cell noborder size-6">
					<p>
						Si esta cotización es aprobada, agradecemos se nos autorice la ejecución del trabajo por escrito o por correo electrónico, o se nos devuelva la cotización con firma y sello, junto con la correspondiente orden de compra. Esta cotización es válida por ocho días a partir de su fecha.Toda impresión digital, por la naturaleza de este proceso y según el sustrato en que se imprima, puede presentar en su tiraje una variación de color de +‐6% en relación con el original, lo cual se considera aceptable. Por las mismas razones, estavariación en impresión offset se considera normal en un rango de +‐8%. La impresión digital para exteriores no se debe limpiar con solventes.
					</p>
				</div>
				<div class="cell left noborder"></div>
				<div class="cell right noborder"></div>
			</div>
			<div class="rows">
				<div class="cell noborder"></div>
				<div class="cell noborder"></div>
			</div>
			<div class="rows">
				<div class="cell noborder"></div>
				<div class="cell noborder"></div>
			</div>
			<div class="rows">
				<div class="cell center noborder" colspan="2">
					<p>
						_________________________<br>
						Aprobación Cliente
					</p>
				</div>
			</div>
			<div class="rows">
				<div class="cell noborder"></div>
				<div class="cell noborder"></div>
			</div>
		</div>
	</div>
@stop
