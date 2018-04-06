@extends('production.precotizaciones.productos.main')

@section('breadcrumb')
	<li><a href="{{ route('precotizaciones.index') }}">Ordenes</a></li>
	<li><a href="{{ route('precotizaciones.edit', ['precotizacion' => $precotizacion->id]) }}">{{ $precotizacion->precotizacion_codigo }}</a></li>
	<li class="active">Producto</li>
@stop

@section('module')
	<div class="box box-success" id="precotizaciones-productos-show">
		<div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('precotizaciones.show', ['precotizacion' => $precotizacion->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @if($precotizacion->precotizacion1_abierta)
	                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
	                    <a href="{{ route('precotizaciones.productos.edit', ['productos' => $precotizacion2->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
	                </div>
	         	@endif
            </div>
        </div>

        <div class="box-body">
			<div class="row">
				<label class="control-label col-md-1">Código</label>
				<div class="form-group col-md-1">
					<div>{{ $precotizacion->precotizacion_codigo }}</div>
				</div>
				<label class="control-label col-md-1">Producto</label>
				<div class="form-group col-md-7">
					<div>{{ $precotizacion2->productop_nombre }}</div>
				</div>
			</div>

			<div class="row">
				<label class="control-label col-md-1">Cantidad</label>
				<div class="form-group col-md-1">
					<div>{{ $precotizacion2->precotizacion2_cantidad }}</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12" id="fine-uploader"></div>
			</div><br>

			<div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Impresiones</h3>
                </div>

				<div class="box-body table-responsive no-padding">
					<table id="browse-precotizacion-producto-impresiones-list" class="table table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th width="70%">Detalle</th>
								<th width="15%">Alto</th>
								<th width="15%">Ancho</th>
							</tr>
						</thead>
						<tbody>
							@foreach( App\Models\Production\PreCotizacion5::getPreCotizaciones5( $precotizacion2->id ) as $impresion )
								<tr>
									<td class="text-left">{{ $impresion->precotizacion5_texto }}</td>
									<td class="text-left">{{ $impresion->precotizacion5_alto }}</td>
									<td class="text-left">{{ $impresion->precotizacion5_ancho }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="box box-success">
				<div class="box-header with-border">
                    <h3 class="box-title">Materiales de producción</h3>
                </div>

				<div class="box-body table-responsive no-padding">
					<table id="browse-precotizacion-producto-materiales-list" class="table table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th width="30%">Proveedor</th>
								<th width="15%">Material</th>
								<th width="20%">Dimensiones</th>
								<th width="5%">Cantidad</th>
								<th width="15%">Valor unidad</th>
								<th width="15%">Valor</th>
							</tr>
						</thead>
						<tbody>
							{{--*/ $total = 0; /*--}}
							@foreach( App\Models\Production\PreCotizacion3::getPreCotizaciones3( $precotizacion2->id ) as $materialp )
								<tr>
									<td>{{ $materialp->tercero_nombre }}</td>
									<td>{{ $materialp->materialp_nombre }}</td>
									<td>{{ $materialp->precotizacion3_medidas }}</td>
									<td class="text-center">{{ $materialp->precotizacion3_cantidad }}</td>
									<td class="text-right">{{ number_format($materialp->precotizacion3_valor_unitario, 2, ',', '.') }}</td>
									<td class="text-right">{{ number_format($materialp->precotizacion3_valor_total, 2, ',', '.') }}</td>
								</tr>
								{{--*/ $total += $materialp->precotizacion3_valor_total; /*--}}
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4"></td>
								<th class="text-right">Total</th>
								<th class="text-right" id="total">{{ number_format($total, 2, ',', '.') }}</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop
