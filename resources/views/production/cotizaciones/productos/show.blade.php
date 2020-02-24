@extends('production.cotizaciones.productos.main')

@section('module')
	<section class="content-header">
		<h1>
			Cotizaciones <small>Administración de cotizaciones</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
			<li><a href="{{ route('cotizaciones.index') }}">Cotización</a></li>
			<li><a href="{{ route('cotizaciones.edit', ['cotizaciones' => $cotizacion->id]) }}">{{ $cotizacion->cotizacion_codigo }}</a></li>
			<li class="active">Producto</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-success" id="cotizaciones-productos-show">
			<div class="box-header with-border">
	            <div class="row">
	                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
	                    <a href="{{ route('cotizaciones.show', ['cotizaciones' => $cotizacion->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
	                </div>
	            </div>
	        </div>
			<div class="box-body">
				<div class="alert alert-danger">
					<h4><b>Información general</b></h4>
					<div class="row">
						<label class="col-md-2 control-label">Referencia</label>
						<div class="form-group col-md-10">
							{{ $cotizacion->cotizacion1_referencia }}
						</div>
					</div>
					<div class="row">
						<label class="col-md-2 control-label">Cliente</label>
						<div class="form-group col-md-10">
							{{ $cotizacion->tercero_nit }} - {{ $cotizacion->tercero_nombre }}
						</div>
					</div>
					<div class="row">
						<label class="col-md-2 control-label">Estado</label>
						<div class="form-group col-md-10">
							<span class="label label-{{ in_array($cotizacion->cotizacion1_estados, ['PC', 'PF']) ? 'warning' : 'success' }}">{{ config('koi.produccion.estados')[$cotizacion->cotizacion1_estados] }}</span>
						</div>
					</div>
					<div class="row">
						<label class="col-md-2 control-label">Cotización</label>
						<div class="form-group col-md-10">
							{{ $cotizacion->cotizacion_codigo }}
						</div>
					</div>
					<div class="row">
						<label class="col-md-2 control-label">Código producto</label>
						<div class="form-group col-md-10">
							{{ $producto->id }}
						</div>
					</div>
					<div class="row">
						<label class="col-md-2 control-label">Producto</label>
						<div class="form-group col-md-10">
							{{ $cotizacion2->productop_nombre }}
						</div>
					</div>
				</div>
				<div class="row">
					<label class="control-label col-md-1">Referencia</label>
					<div class="form-group col-md-8">
						<div>{{ $cotizacion2->cotizacion2_referencia }}</div>
					</div>
					<label class="control-label col-md-1">Cantidad</label>
					<div class="form-group col-md-1">
						<div>{{ $cotizacion2->cotizacion2_cantidad }}</div>
					</div>
				</div>
				<div class="row">
					<label class="col-sm-1 control-label">Observaciones</label>
					<div class="form-group col-md-11">
						<textarea placeholder="Observaciones" class="form-control" rows="2" disabled>{{ $cotizacion2->cotizacion2_observaciones }}</textarea>
					</div>
				</div><br>

				@if ($producto->productop_abierto || $producto->productop_cerrado)
					<div class="box box-danger">
						<div class="box-body">
							@if ($producto->productop_abierto)
								<div class="row">
									<label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Abierto</label>
									<label for="cotizacion2_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
									<div class="form-group col-xs-10 col-sm-3">
										<div class="col-xs-10 col-sm-9">
											{{ $cotizacion2->cotizacion2_ancho }}
										</div>
										<div class="col-xs-2 col-sm-3 text-left">{{ $producto->m1_sigla }}</div>
									</div>

									<label for="cotizacion2_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
									<div class="form-group col-xs-10 col-sm-3">
										<div class="col-xs-10 col-sm-9">
											{{ $cotizacion2->cotizacion2_alto }}
										</div>
										<div class="col-xs-2 col-sm-3 text-left">{{ $producto->m2_sigla }}</div>
									</div>
								</div>
							@endif

							@if ($producto->productop_cerrado)
								<div class="row">
									<label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Cerrado</label>
									<label for="cotizacion2_c_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
									<div class="form-group col-xs-10 col-sm-3">
										<div class="col-xs-10 col-sm-9">
											{{ $cotizacion2->cotizacion2_c_ancho }}
										</div>
										<div class="col-xs-2 col-sm-3 text-left">{{ $producto->m3_sigla }}</div>
									</div>

									<label for="cotizacion2_c_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
									<div class="form-group col-xs-10 col-sm-3">
										<div class="col-xs-10 col-sm-9">
											{{ $cotizacion2->cotizacion2_c_alto }}
										</div>
										<div class="col-xs-2 col-sm-3 text-left">{{ $producto->m4_sigla }}</div>
									</div>
								</div>
							@endif
						</div>
					</div>
				@endif

				@if ($producto->productop_3d)
	                <div class="box box-danger">
	                    <div class="box-body">
	                        <div class="row">
	                            <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">3D</label>
	                            <label for="cotizacion2_3d_ancho" class="col-xs-3 col-sm-1 control-label text-left">Ancho</label>
	                            <div class="form-group col-xs-9 col-sm-2">
	                                <div class="col-xs-10 col-sm-9">
	                                	{{ $cotizacion2->cotizacion2_3d_ancho }}
	                                </div>
	                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m5_sigla }}</div>
	                            </div>

	                            <label for="cotizacion2_3d_alto" class="col-xs-3 col-sm-1 control-label text-left">Alto</label>
	                            <div class="form-group col-xs-9 col-sm-2">
	                                <div class="col-xs-10 col-sm-9">
	                                	{{ $cotizacion2->cotizacion2_3d_alto }}
	                                </div>
	                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m6_sigla }}</div>
	                            </div>

	                            <label for="cotizacion2_3d_profundidad" class="col-xs-3 col-sm-1 control-label text-left">Profundidad</label>
	                            <div class="form-group col-xs-9 col-sm-2">
	                                <div class="col-xs-10 col-sm-9">
	                                	{{ $cotizacion2->cotizacion2_3d_profundidad }}
	                                </div>
	                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m7_sigla }}</div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            @endif

				@if ($producto->productop_tiro || $producto->productop_retiro)
	                <div class="box box-danger">
	                    <div class="box-body">
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3 col-xs-12">
									<table class="table">
										<thead>
											<tr>
												<th class="text-center"></th>
												<th class="text-center">C</th>
												<th class="text-center">M</th>
												<th class="text-center">Y</th>
												<th class="text-center">K</th>
												<th class="text-center">P1</th>
												<th class="text-center">P2</th>
											</tr>
										</thead>
										<tbody>
											@if ($producto->productop_tiro)
												<tr>
													<th class="text-center">T <input type="checkbox" disabled {{ $cotizacion2->cotizacion2_tiro ? 'checked': '' }}></th>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_yellow ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_magenta ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_cyan ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_key ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_color1 ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_color2 ? 'checked': '' }}></td>
												</tr>
											@endif
											@if ($producto->productop_retiro)
												<tr>
													<th class="text-center">R <input type="checkbox" disabled {{ $cotizacion2->cotizacion2_retiro ? 'checked': '' }}></th>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_yellow2 ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_magenta2 ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_cyan2 ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_key2 ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_color12 ? 'checked': '' }}></td>
													<td class="text-center"><input type="checkbox" disabled {{ $cotizacion2->cotizacion2_color22 ? 'checked': '' }}></td>
												</tr>
											@endif
										</tbody>
									</table>
								</div>
							</div>

	                        <div class="row">
	                            @if ($producto->productop_tiro)
	                                <div class="form-group @if ($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
	                                    <label for="cotizacion2_nota_tiro" class="control-label">Nota tiro</label>
	                                    <div>{{ $cotizacion2->cotizacion2_nota_tiro }}</div>
	                                </div>
	                            @endif

	                            @if ($producto->productop_retiro)
	                                <div class="form-group @if ($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
	                                    <label for="cotizacion2_nota_retiro" class="control-label">Nota retiro</label>
	                                    <div>{{ $cotizacion2->cotizacion2_nota_retiro }}</div>
	                                </div>
	                            @endif
	                        </div>
	                    </div>
	                </div>
	            @endif

				@if ($producto->tips->count())
					<div class="row">
						<div class="col-sm-12">
							<div class="box box-danger">
								<div class="box-header with-border">
									<h3 class="box-title">Tips del producto</h3>
								</div>
								<div class="box-body">
									<ul class="list-group">
										@foreach ($producto->tips as $tip)
											<li class="list-group-item">{{ $tip->productop2_tip }}</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>
				@endif

				<div class="row">
					{{-- Content maquinas --}}
					<div class="col-sm-6">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Máquinas de producción</h3>
							</div>
							<div class="box-body">
								@foreach (App\Models\Production\Cotizacion3::getCotizaciones3($producto->id, $cotizacion2->id) as $maquina)
									<div class="row">
										<div class="form-group col-md-12">
											<label class="checkbox-inline without-padding white-space-normal" for="cotizacion3_maquinap_{{ $maquina->id }}">
												<input type="checkbox" id="cotizacion3_maquinap_{{ $maquina->id }}" name="cotizacion3_maquinap_{{ $maquina->id }}" value="cotizacion3_maquinap_{{ $maquina->id }}" {{ $maquina->activo ? 'checked': '' }} disabled> {{ $maquina->maquinap_nombre }}
											</label>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>

					{{-- Content acabados --}}
	                <div class="col-sm-6">
	                    <div class="box box-danger">
	                        <div class="box-header with-border">
	                            <h3 class="box-title">Acabados de producción</h3>
	                        </div>
	                        <div class="box-body">
	                            @foreach (App\Models\Production\Cotizacion5::getCotizaciones5($producto->id, $cotizacion2->id) as $acabado)
	                                <div class="row">
	                                    <div class="form-group col-md-12">
	                                        <label class="checkbox-inline without-padding white-space-normal" for="cotizacion5_acabadop_{{ $acabado->id }}">
	                                            <input type="checkbox" id="cotizacion5_acabadop_{{ $acabado->id }}" name="cotizacion5_acabadop_{{ $acabado->id }}" value="cotizacion5_acabadop_{{ $acabado->id }}" {{ $acabado->activo ? 'checked': '' }} disabled> {{ $acabado->acabadop_nombre }}
	                                        </label>
	                                    </div>
	                                </div>
	                            @endforeach
	                        </div>
	                    </div>
	                </div>
	        	</div>

				@ability ('precios' | 'cotizaciones')
					<div class="box box-danger">
						<div class="box-header with-border">
							<h3 class="box-title">Fórmulas</h3>
						</div>
						<div class="box-body">
							<div class="row">
								<label class="control-label col-md-1">Fórmula</label>
								<div class="form-group col-md-6">
									<div>{{ $cotizacion2->cotizacion2_precio_formula }}</div>
								</div>

								<label class="control-label col-md-1">Precio</label>
								<div class="form-group col-md-4">
									<div>{{ number_format($cotizacion2->cotizacion2_precio_venta, 2, ',', '.') }}</div>
								</div>
							</div>
							<div class="row">
								<label class="control-label col-md-1">Fórmula</label>
								<div class="form-group col-md-6">
									<div>{{ $cotizacion2->cotizacion2_viaticos_formula }}</div>
								</div>

								<label class="control-label col-md-1">Viáticos</label>
								<div class="form-group col-md-4">
									<div>{{ number_format($cotizacion2->cotizacion2_viaticos, 2, ',', '.') }}</div>
								</div>
							</div>
						</div>
					</div>
				@endability

				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Imágenes</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<div class="fine-uploader"></div>
					</div>
				</div>

				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Materiales de producción</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table id="browse-cotizacion-producto-materiales-list" class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="25%">Material</th>
									<th width="25%">Insumo</th>
									<th width="10%">Medidas</th>
									<th width="10%">Cantidad</th>
									@ability ('precios' | 'cotizaciones')
										{{--*/ $totalmaterialesp = 0; /*--}}

										<th width="15%">Valor unidad</th>
										<th width="15%">Valor</th>
									@endability
								</tr>
							</thead>
							<tbody>
								@foreach (App\Models\Production\Cotizacion4::getCotizaciones4( $cotizacion2->id) as $materialp)
									<tr>
										<td>{{ $materialp->materialp_nombre }}</td>
										<td>{{ isset($materialp->producto_nombre) ? $materialp->producto_nombre : '-' }}</td>
										<td>{{ $materialp->cotizacion4_medidas }}</td>
										<td>{{ $materialp->cotizacion4_cantidad }}</td>
										@ability ('precios' | 'cotizaciones')
											<td class="text-right">{{ number_format($materialp->cotizacion4_valor_unitario, 2, ',', '.') }}</td>
											<td class="text-right">{{ number_format($materialp->cotizacion4_valor_total, 2, ',', '.') }}</td>

											{{--*/ $totalmaterialesp += $materialp->cotizacion4_valor_total; /*--}}
										@endability
									</tr>
								@endforeach
							</tbody>
							@ability ('precios' | 'cotizaciones')
								<tfoot>
									<tr>
										<td colspan="4"></td>
										<th class="text-right">Total</th>
										<th class="text-right" id="total">{{ number_format($totalmaterialesp, 2, ',', '.') }}</th>
									</tr>
								</tfoot>
							@endability
						</table>
					</div>
				</div>

				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Áreas de producción</h3>
					</div>
					<div class="box-body">
						<div class="box-body table-responsive no-padding">
		                    <table id="browse-cotizacion-producto-areas-list" class="table table-bordered" cellspacing="0" width="100%">
		                        <thead>
		                            <tr>
		                                <th>Área</th>
		                                <th>Nombre</th>
		                                <th>Tiempo</th>
										@ability ('precios' | 'cotizaciones')
											{{--*/ $area = $totalareasp = 0; /*--}}

			                                <th>Valor</th>
			                                <th>Total</th>
										@endability
		                            </tr>
		                        </thead>
								<tbody>
									{{-- variables para calcular las areas --}}
									@foreach (App\Models\Production\Cotizacion6::getCotizaciones6($cotizacion2->id) as $areap)
										<tr>
											<td>{{ $areap->areap_nombre == '' ? '-': $areap->areap_nombre }}</td>
			                                <td>{{ $areap->cotizacion6_nombre == '' ? '-': $areap->cotizacion6_nombre }}</td>
			                                <td class="text-left">{{  $areap->cotizacion6_tiempo }}</td>
											@ability ('precios' | 'cotizaciones')
												{{--*/
													$tiempo = explode(':', $areap->cotizacion6_tiempo);
													$totalareasp += round(($tiempo[0] + ($tiempo[1] / 60)) * $areap->cotizacion6_valor);
												/*--}}

												<td class="text-right">{{ number_format($areap->cotizacion6_valor, 2, ',', '.') }}</td>
				                                <td class="text-right">{{ number_format($area, 2, ',', '.') }}</td>
											@endability
										</tr>
									@endforeach
								</tbody>
								@ability ('precios' | 'cotizaciones')
			                        <tfoot>
			                            <tr>
			                                <td colspan="3"></td>
			                                <th class="text-right">Total</th>
			                                <th class="text-right">{{ number_format($totalareasp, 2, ',', '.') }}</th>
			                            </tr>
			                        </tfoot>
								@endability
		                    </table>
		                </div>
					</div>
				</div>

				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Empaques de producción</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table id="browse-cotizacion-producto-empaques-list" class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="25%">Empaque</th>
									<th width="25%">Insumo</th>
									<th width="10%">Medidas</th>
									<th width="10%">Cantidad</th>
									@ability ('precios' | 'cotizaciones')
										{{--*/ $totalempaques = 0; /*--}}

										<th width="15%">Valor unidad</th>
										<th width="15%">Valor</th>
									@endability
								</tr>
							</thead>
							<tbody>
								@foreach (App\Models\Production\Cotizacion9::getCotizaciones9( $cotizacion2->id) as $empaque)
									<tr>
										<td>{{ isset($empaque->empaque_nombre) ? $empaque->empaque_nombre : '-' }}</td>
										<td>{{ isset($empaque->producto_nombre) ? $empaque->producto_nombre : '-' }}</td>
										<td>{{ $empaque->cotizacion9_medidas }}</td>
										<td>{{ $empaque->cotizacion9_cantidad }}</td>
										@ability ('precios' | 'cotizaciones')
											<td class="text-right">{{ number_format($empaque->cotizacion9_valor_unitario, 2, ',', '.') }}</td>
											<td class="text-right">{{ number_format($empaque->cotizacion9_valor_total, 2, ',', '.') }}</td>

											{{--*/ $totalempaques += $empaque->cotizacion9_valor_total; /*--}}
										@endability
									</tr>
								@endforeach
							</tbody>
							@ability ('precios' | 'cotizaciones')
								<tfoot>
									<tr>
										<td colspan="4"></td>
										<th class="text-right">Total</th>
										<th class="text-right" id="total">{{ number_format($totalempaques, 2, ',', '.') }}</th>
									</tr>
								</tfoot>
							@endability
						</table>
					</div>
				</div>

				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Transportes de producción</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table id="browse-cotizacion-producto-transportes-list" class="table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th width="25%">Transporte</th>
									<th width="25%">Insumo</th>
									<th width="10%">Medidas</th>
									<th width="10%">Cantidad</th>
									@ability ('precios' | 'cotizaciones')
										{{--*/ $totaltransportes = 0; /*--}}

										<th width="15%">Valor unidad</th>
										<th width="15%">Valor</th>
									@endability
								</tr>
							</thead>
							<tbody>
								@foreach (App\Models\Production\Cotizacion10::getCotizaciones10( $cotizacion2->id) as $transporte)
									<tr>
										<td>{{ isset($transporte->transporte_nombre) ? $transporte->transporte_nombre : '-' }}</td>
										<td>{{ isset($transporte->producto_nombre) ? $transporte->producto_nombre : '-' }}</td>
										<td>{{ $transporte->cotizacion10_medidas }}</td>
										<td>{{ $transporte->cotizacion10_cantidad }}</td>
										@ability ('precios' | 'cotizaciones')
											<td class="text-right">{{ number_format($transporte->cotizacion10_valor_unitario, 2, ',', '.') }}</td>
											<td class="text-right">{{ number_format($transporte->cotizacion10_valor_total, 2, ',', '.') }}</td>

											{{--*/ $totaltransportes += $transporte->cotizacion10_valor_total; /*--}}
										@endability
									</tr>
								@endforeach
							</tbody>
							@ability ('precios' | 'cotizaciones')
								<tfoot>
									<tr>
										<td colspan="4"></td>
										<th class="text-right">Total</th>
										<th class="text-right" id="total">{{ number_format($totaltransportes, 2, ',', '.') }}</th>
									</tr>
								</tfoot>
							@endability
						</table>
					</div>
				</div>
        	</div>
        </div>

		@ability ('utilidades' | 'cotizaciones')
			<div class="row">
			    <div class="col-md-6 col-md-offset-3">
			        <div class="box box-danger">
			                {{-- Content informacion --}}
			                {{--*/ $subtotal = $total = $viaticos = 0; /*--}}
			                {{--*/
			                    $viaticos = round($cotizacion2->cotizacion2_viaticos / $cotizacion2->cotizacion2_cantidad);
								$totalmaterialesp = round($totalmaterialesp / $cotizacion2->cotizacion2_cantidad);
			                    $prevtotalmaterialesp = $totalmaterialesp;
			                    $totalmaterialesp = $totalmaterialesp/((100-$cotizacion2->cotizacion2_margen_materialp)/100);
								$totalareasp = round($totalareasp / $cotizacion2->cotizacion2_cantidad);
								$prevtotalareasp = $totalareasp;
								$totalareasp = $totalareasp/((100-$cotizacion2->cotizacion2_margen_areap)/100);
								$totalempaques = round($totalempaques / $cotizacion2->cotizacion2_cantidad);
								$prevtotalempaques = $totalempaques;
								$totalempaques = $totalempaques/((100-$cotizacion2->cotizacion2_margen_empaque)/100);
								$totaltransportes = round($totaltransportes / $cotizacion2->cotizacion2_cantidad);
								$prevtotaltransportes = $totaltransportes;
								$totaltransportes = $totaltransportes/((100-$cotizacion2->cotizacion2_margen_transporte)/100);
			                    $subtotal = $cotizacion2->cotizacion2_precio_venta + $viaticos + $totalmaterialesp + $totalareasp + $totalempaques + $totaltransportes;
								$percentageprecio = ($cotizacion2->cotizacion2_precio_venta/$subtotal)*100;
								$percentageviaticos = ($viaticos/$subtotal)*100;
								$percentagematerialesp = ($totalmaterialesp/$subtotal)*100;
								$percentageareasp = ($totalareasp/$subtotal)*100;
								$percentageempaques = ($totalempaques/$subtotal)*100;
								$percentagetransportes = ($totaltransportes/$subtotal)*100;
								$prevtotaldescuento = $subtotal;
								$totaldescuento = $cotizacion2->cotizacion2_descuento == 0 ? 0 : ($subtotal-($subtotal*($cotizacion2->cotizacion2_descuento/100)));
								$prevtotalcomision = $totaldescuento;
								$totalcomision = $totaldescuento/((100-$cotizacion2->cotizacion2_comision)/100);
								$iva = round($cotizacion2->cotizacion2_total_valor_unitario * ($cotizacion->cotizacion1_iva/100));
								$total = $cotizacion2->cotizacion2_total_valor_unitario + $iva;
			                /*--}}

							<div class="box-body">
								<div class="list-group">
								    <div class="list-group-item list-group-item-info">
								        <div class="row">
								            <div class="col-xs-2 col-sm-2"><b>Precio</b></div>
								            <div class="col-xs-9 col-sm-9 text-right"><b>{{ number_format($cotizacion2->cotizacion2_precio_venta, 2, ',', '.')}}</b></div>
											<div class="col-xs-1 col-sm-1 text-right"><small class="badge bg-info">{{ number_format($percentageprecio, 2) }}%</small></div>
								        </div>
								    </div>
									<div class="list-group-item list-group-item-info">
										<div class="row">
											<div class="col-xs-2 col-sm-2"><b>Viáticos</b></div>
											<div class="col-xs-9 col-sm-9 text-right"><b>{{ number_format($viaticos, 2, ',', '.')}}</b></div>
											<div class="col-xs-1 col-sm-1 text-right"><small class="badge bg-info">{{ number_format($percentageviaticos, 2) }}%</small></div>
										</div>
									</div>
									<div class="list-group-item list-group-item-info">
										<div class="row">
											<div class="col-xs-6 col-sm-2 text-left"><b>Materiales</b></div>
											<div class="col-xs-6 col-sm-3 text-right"><small class="badge bg-red">{{ number_format($prevtotalmaterialesp, 2, ',', '.') }}</small></div>
											<div class="col-xs-4 col-sm-2 text-right">{{ $cotizacion2->cotizacion2_margen_materialp }}</div>
											<div class="col-xs-2 col-sm-1 text-left"><b><small>(%)</small></b></div>
											<div class="col-xs-5 col-sm-3 text-right"><b><span>{{ number_format($totalmaterialesp, 2, ',', '.') }}</span></b></div>
											<div class="col-xs-1 col-sm-1 text-right"><small class="badge bg-info">{{ number_format($percentagematerialesp, 2) }}%</small></div>
										</div>
									</div>
									<div class="list-group-item list-group-item-info">
										<div class="row">
											<div class="col-xs-6 col-sm-2 text-left"><b>Áreas</b></div>
											<div class="col-xs-6 col-sm-3 text-right"><small class="badge bg-red">{{ number_format($prevtotalareasp, 2, ',', '.') }}</small></div>
											<div class="col-xs-4 col-sm-2 text-right">{{ $cotizacion2->cotizacion2_margen_areap }}</div>
											<div class="col-xs-2 col-sm-1 text-left"><b><small>(%)</small></b></div>
											<div class="col-xs-5 col-sm-3 text-right"><b><span>{{ number_format($totalareasp, 2, ',', '.') }}</span></b></div>
											<div class="col-xs-1 col-sm-1 text-right"><small class="badge bg-info">{{ number_format($percentageareasp, 2) }}%</small></div>
										</div>
									</div>
									<div class="list-group-item list-group-item-info">
										<div class="row">
											<div class="col-xs-6 col-sm-2 text-left"><b>Empaques</b></div>
											<div class="col-xs-6 col-sm-3 text-right"><small class="badge bg-red">{{ number_format($prevtotalempaques, 2, ',', '.') }}</small></div>
											<div class="col-xs-4 col-sm-2 text-right">{{ $cotizacion2->cotizacion2_margen_empaque }}</div>
											<div class="col-xs-2 col-sm-1 text-left"><b><small>(%)</small></b></div>
											<div class="col-xs-5 col-sm-3 text-right"><b><span>{{ number_format($totalempaques, 2, ',', '.') }}</span></b></div>
											<div class="col-xs-1 col-sm-1 text-right"><small class="badge bg-info">{{ number_format($percentageempaques, 2) }}%</small></div>
										</div>
									</div>
									<div class="list-group-item list-group-item-info">
										<div class="row">
											<div class="col-xs-6 col-sm-2 text-left"><b>Transportes</b></div>
											<div class="col-xs-6 col-sm-3 text-right"><small class="badge bg-red">{{ number_format($prevtotaltransportes, 2, ',', '.') }}</small></div>
											<div class="col-xs-4 col-sm-2 text-right">{{ $cotizacion2->cotizacion2_margen_transporte }}</div>
											<div class="col-xs-2 col-sm-1 text-left"><b><small>(%)</small></b></div>
											<div class="col-xs-5 col-sm-3 text-right"><b><span>{{ number_format($totaltransportes, 2, ',', '.') }}</span></b></div>
											<div class="col-xs-1 col-sm-1 text-right"><small class="badge bg-info">{{ number_format($percentagetransportes, 2) }}%</small></div>
										</div>
									</div>
									<div class="list-group-item list-group-item-success">
										<div class="row">
											<div class="col-xs-2 col-sm-8"><b>Subtotal</b></div>
											<div class="col-xs-10 col-sm-4 text-right">
												<span class="pull-right badge bg-red">$ {{ number_format($subtotal, 2, ',', '.') }}</span>
											</div>
										</div>
									</div>
									<div class="list-group-item list-group-item-success">
										<div class="row">
											<div class="col-xs-6 col-sm-2 text-left"><b>Descuento</b></div>
											<div class="col-xs-6 col-sm-3 text-right"><small class="badge bg-red">{{ number_format($prevtotaldescuento, 2, ',', '.') }}</small></div>
											<div class="col-xs-4 col-sm-2 text-right">{{ $cotizacion2->cotizacion2_descuento }}</div>
											<div class="col-xs-2 col-sm-1 text-left"><b><small>(%)</small></b></div>
											<div class="col-xs-6 col-sm-4 text-right"><b><span>{{ number_format($totaldescuento, 2, ',', '.') }}</span></b></div>
										</div>
									</div>
									<div class="list-group-item list-group-item-success">
										<div class="row">
											<div class="col-xs-6 col-sm-2 text-left"><b>Comisión</b></div>
											<div class="col-xs-6 col-sm-3 text-right"><small class="badge bg-red">{{ number_format($prevtotalcomision, 2, ',', '.') }}</small></div>
											<div class="col-xs-4 col-sm-2 text-right">{{ $cotizacion2->cotizacion2_comision }}</div>
											<div class="col-xs-2 col-sm-1 text-left"><b><small>(%)</small></b></div>
											<div class="col-xs-6 col-sm-4 text-right"><b><span>{{ number_format($totalcomision, 2, ',', '.') }}</span></b></div>
										</div>
									</div>
									<div class="list-group-item list-group-item-success">
										<div class="row">
											<div class="col-xs-10 col-sm-2"><b>Volumen</b></div>
											<div class="col-xs-2 col-sm-2">{{ $cotizacion2->cotizacion2_volumen }}</div>
											<div class="col-xs-12 col-sm-8 text-right">
												<span class="pull-right badge bg-red">$ {{ number_format($cotizacion2->cotizacion2_vtotal, 2, ',', '.') }}</span>
											</div>
										</div>
									</div>
									<div class="list-group-item list-group-item-success">
										<div class="row">
											<div class="col-xs-10 col-sm-2"><b>Redondear</b></div>
											<div class="col-xs-2 col-sm-2">{{ $cotizacion2->cotizacion2_round }}</div>
											<div class="col-xs-2 col-sm-2 col-sm-offset-2"><b>Total</b></div>
											<div class="col-xs-10 col-sm-4 text-right">
												<span class="pull-right badge bg-red">$ {{ number_format($cotizacion2->cotizacion2_total_valor_unitario, 2, ',', '.') }}</span>
											</div>
										</div>
									</div>
									<div class="list-group-item list-group-item-danger">
										<div class="row">
											<div class="col-xs-2 col-sm-2"><b>IVA ({{ $cotizacion->cotizacion1_iva }}%)</b></div>
											<div class="col-xs-10 col-sm-10 text-right">
												<span class="pull-right badge bg-green">{{ number_format($iva, 2, ',', '.') }}</span>
											</div>
										</div>
									</div>
									<div class="list-group-item list-group-item-danger">
										<div class="row">
											<div class="col-xs-2 col-sm-2"><b>Total</b></div>
											<div class="col-xs-10 col-sm-10 text-right">
												<span class="pull-right badge bg-green">{{ number_format($total, 2, ',', '.') }}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<p><b>Los campos de viáticos, materiales, áreas, empaques y transportes se dividirán por la cantidad ingresada.</b></p>
							</div>
						</div>
			        </div>
			    </div>
			</div>
		@endability
	</section>
@stop
