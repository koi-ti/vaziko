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
				<label class="control-label col-md-1">Ancho</label>
				<div class="form-group col-md-2">
					<div>{{ $precotizacion2->precotizacion2_ancho }}</div>
				</div>
				<label class="control-label col-md-1">Alto</label>
				<div class="form-group col-md-2">
					<div>{{ $precotizacion2->precotizacion2_alto }}</div>
				</div>
				<label class="control-label col-md-1">Cantidad</label>
				<div class="form-group col-md-2">
					<div>{{ $precotizacion2->precotizacion2_cantidad }}</div>
				</div>
			</div>

			@if($producto->productop_abierto || $producto->productop_cerrado)
				<div class="box box-success">
					<div class="box-body">
						@if($producto->productop_abierto)
							<div class="row">
								<label class="col-sm-offset-1 col-sm-1 control-label">Abierto</label>
								<label for="precotizacion2_ancho" class="col-sm-1 control-label text-right">Ancho</label>
								<div class="form-group col-md-3">
									<div class="col-md-9">
										{{ $precotizacion2->precotizacion2_ancho }}
									</div>
									<div class="col-md-3 text-left">{{ $producto->m1_sigla }}</div>
								</div>

								<label for="precotizacion2_alto" class="col-sm-1 control-label text-right">Alto</label>
								<div class="form-group col-md-3">
									<div class="col-md-9">
										{{ $precotizacion2->precotizacion2_alto }}
									</div>
									<div class="col-md-3 text-left">{{ $producto->m2_sigla }}</div>
								</div>
							</div>
						@endif

						@if($producto->productop_cerrado)
							<div class="row">
								<label class="col-sm-offset-1 col-sm-1 control-label">Cerrado</label>
								<label for="precotizacion2_c_ancho" class="col-sm-1 control-label text-right">Ancho</label>
								<div class="form-group col-md-3">
									<div class="col-md-9">
										{{ $precotizacion2->precotizacion2_c_ancho }}
									</div>
									<div class="col-md-3 text-left">{{ $producto->m3_sigla }}</div>
								</div>

								<label for="precotizacion2_c_alto" class="col-sm-1 control-label text-right">Alto</label>
								<div class="form-group col-md-3">
									<div class="col-md-9">
										{{ $precotizacion2->precotizacion2_c_alto }}
									</div>
									<div class="col-md-3 text-left">{{ $producto->m4_sigla }}</div>
								</div>
							</div>
						@endif
					</div>
				</div>
			@endif

			@if($producto->productop_3d)
				<div class="box box-success">
					<div class="box-body">
						<div class="row">
							<label class="col-sm-offset-1 col-sm-1 control-label">3D</label>
							<label for="precotizacion2_3d_ancho" class="col-sm-1 control-label text-right">Ancho</label>
							<div class="form-group col-md-2">
								<div class="col-md-9">
									{{ $precotizacion2->precotizacion2_3d_ancho }}
								</div>
								<div class="col-md-3 text-left">{{ $producto->m5_sigla }}</div>
							</div>

							<label for="precotizacion2_3d_alto" class="col-sm-1 control-label text-right">Alto</label>
							<div class="form-group col-md-2">
								<div class="col-md-9">
									{{ $precotizacion2->precotizacion2_3d_alto }}
								</div>
								<div class="col-md-3 text-left">{{ $producto->m6_sigla }}</div>
							</div>

							<label for="precotizacion2_3d_profundidad" class="col-sm-1 control-label text-right">Profundidad</label>
							<div class="form-group col-md-2">
								<div class="col-md-9">
									{{ $precotizacion2->precotizacion2_3d_profundidad }}
								</div>
								<div class="col-md-3 text-left">{{ $producto->m7_sigla }}</div>
							</div>
						</div>
					</div>
				</div>
			@endif

			@if($producto->productop_tiro || $producto->productop_retiro)
				<div class="box box-success">
					<div class="box-body">
						<div class="row">
							<label class="col-sm-offset-2 col-sm-1 col-xs-offset-2 col-xs-1 control-label"></label>
							<label class="col-sm-1 col-xs-1 control-label">C</label>
							<label class="col-sm-1 col-xs-1 control-label">M</label>
							<label class="col-sm-1 col-xs-1 control-label">Y</label>
							<label class="col-sm-1 col-xs-1 control-label">K</label>
							<label class="col-sm-1 col-xs-1 control-label">P1</label>
							<label class="col-sm-1 col-xs-1 control-label">P2</label>
						</div>

						@if($producto->productop_tiro)
							<div class="row">
								<div class="col-sm-offset-2 col-md-1 col-xs-3">
									<label for="precotizacion2_tiro" class="control-label">T</label>
									<input type="checkbox" disabled id="precotizacion2_tiro" name="precotizacion2_tiro" value="precotizacion2_tiro" {{ $precotizacion2->precotizacion2_tiro ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_yellow" name="precotizacion2_yellow" value="precotizacion2_yellow" {{ $precotizacion2->precotizacion2_yellow ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_magenta" name="precotizacion2_magenta" value="precotizacion2_magenta" {{ $precotizacion2->precotizacion2_magenta ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_cyan" name="precotizacion2_cyan" value="precotizacion2_cyan" {{ $precotizacion2->precotizacion2_cyan ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_key" name="precotizacion2_key" value="precotizacion2_key" {{ $precotizacion2->precotizacion2_key ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_color1" name="precotizacion2_color1" value="precotizacion2_color1" {{ $precotizacion2->precotizacion2_color1 ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_color2" name="precotizacion2_color2" value="precotizacion2_color2" {{ $precotizacion2->precotizacion2_color2 ? 'checked': '' }}>
								</div>
							</div>
						@endif

						@if($producto->productop_retiro)
							<div class="row">
								<div class="col-sm-offset-2 col-md-1 col-xs-3">
									<label for="precotizacion2_retiro" class="control-label">R</label>
									<input type="checkbox" disabled id="precotizacion2_retiro" name="precotizacion2_retiro" value="precotizacion2_retiro" {{ $precotizacion2->precotizacion2_retiro ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_yellow2" name="precotizacion2_yellow2" value="precotizacion2_yellow2" {{ $precotizacion2->precotizacion2_yellow2 ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_magenta2" name="precotizacion2_magenta2" value="precotizacion2_magenta2" {{ $precotizacion2->precotizacion2_magenta2 ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_cyan2" name="precotizacion2_cyan2" value="precotizacion2_cyan2" {{ $precotizacion2->precotizacion2_cyan2 ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_key2" name="precotizacion2_key2" value="precotizacion2_key2" {{ $precotizacion2->precotizacion2_key2 ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_color12" name="precotizacion2_color12" value="precotizacion2_color12" {{ $precotizacion2->precotizacion2_color12 ? 'checked': '' }}>
								</div>
								<div class="col-md-1 col-xs-1">
									<input type="checkbox" disabled id="precotizacion2_color22" name="precotizacion2_color22" value="precotizacion2_color22" {{ $precotizacion2->precotizacion2_color22 ? 'checked': '' }}>
								</div>
							</div>
						@endif

						<div class="row">
							@if($producto->productop_tiro)
								<div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
									<label for="precotizacion2_nota_tiro" class="control-label">Nota tiro</label>
									<div>{{ $precotizacion2->precotizacion2_nota_tiro }}</div>
								</div>
							@endif

							@if($producto->productop_retiro)
								<div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
									<label for="precotizacion2_nota_retiro" class="control-label">Nota retiro</label>
									<div>{{ $precotizacion2->precotizacion2_nota_retiro }}</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			@endif

			<div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Imágenes</h3>
                </div>

				<div class="box-body table-responsive no-padding">
					<div id="fine-uploader"></div>
				</div>
			</div>

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
								<th width="15%">Insumo</th>
								<th width="10%">Dimensiones</th>
								<th width="5%">Cantidad</th>
								<th width="12%">Valor unidad</th>
								<th width="12%">Valor</th>
							</tr>
						</thead>
						<tbody>
							{{--*/ $total = 0; /*--}}
							@foreach( App\Models\Production\PreCotizacion3::getPreCotizaciones3( $precotizacion2->id ) as $materialp )
								<tr>
									<td>{{ $materialp->tercero_nombre }}</td>
									<td>{{ $materialp->materialp_nombre }}</td>
									<td>{!! isset($materialp->producto_nombre) ? $materialp->producto_nombre : "-" !!}</td>
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
								<td colspan="5"></td>
								<th class="text-right">Total</th>
								<th class="text-right" id="total">{{ number_format($total, 2, ',', '.') }}</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>

			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">Áreas de producción</h3>
				</div>
				<div class="box-body">
					<div class="box-body table-responsive no-padding">
	                    <table id="browse-precotizacion-producto-areas-list" class="table table-bordered" cellspacing="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Área</th>
	                                <th>Nombre</th>
	                                <th>Horas</th>
	                                <th>Valor</th>
	                                <th>Total</th>
	                            </tr>
	                        </thead>
							<tbody>
								{{-- variables para calcular las areas --}}
								{{--*/ $area = $sumareap = $totalareap = 0; /*--}}
								@foreach( App\Models\Production\PreCotizacion6::getPreCotizaciones6( $precotizacion2->id ) as $areap)
									{{--*/
										$tiempo = explode(':', $areap->precotizacion6_tiempo);
										$area = round( ($tiempo[0] + ($tiempo[1] / 60)) * $areap->precotizacion6_valor );
										$sumareap += $area;
										$totalareap = round( $sumareap / $precotizacion2->precotizacion2_cantidad );
									/*--}}

									<tr>
										<td>{{ $areap->areap_nombre == '' ? '-': $areap->areap_nombre }}</td>
		                                <td>{{ $areap->precotizacion6_nombre == '' ? '-': $areap->precotizacion6_nombre }}</td>
		                                <td class="text-left">{{  $areap->precotizacion6_tiempo }}</td>
										<td class="text-right">{{ number_format($areap->precotizacion6_valor, 2, ',', '.') }}</td>
		                                <td class="text-right">{{ number_format($area, 2, ',', '.') }}</td>
									</tr>
								@endforeach
							</tbody>
	                        <tfoot>
	                            <tr>
	                                <td colspan="3"></td>
	                                <th class="text-right">Total</th>
	                                <th class="text-right">{{ number_format($sumareap, 2, ',', '.') }}</th>
	                            </tr>
	                        </tfoot>
	                    </table>
	                </div>
				</div>
			</div>
		</div>
	</div>
@stop
