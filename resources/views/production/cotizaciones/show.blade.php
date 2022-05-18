@extends('production.cotizaciones.main')

@section('module')
    <section class="content-header">
        <h1>
            Cotizaciones <small>Administración de cotizaciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li><a href="{{ route('cotizaciones.index')}}">Cotización</a></li>
            <li class="active">{{ $cotizacion->cotizacion_codigo }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-solid" id="cotizaciones-show">
            <div class="nav-tabs-custom tab-danger tab-whithout-box-shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_cotizacion" data-toggle="tab">Cotización</a></li>
                    @ability ('graficas' | 'cotizaciones')
                        <li><a href="#tab_graficas" data-toggle="tab">Gráficas de producción</a></li>
                    @endability
                    @ability ('graficas' | 'cotizaciones')
                        <li><a href="#tab_archivos" data-toggle="tab">Archivos</a></li>
                    @endability
                    @ability ('bitacora' | 'cotizaciones')
                        <li><a href="#tab_bitacora" data-toggle="tab">Bitácora</a></li>
                    @endability
                    <li class="pull-right">
                        <div class="btn-group" role="group">
                            @ability ('abrir' | 'cotizaciones')
                                @if (!$cotizacion->cotizacion1_abierta && !$cotizacion->cotizacion1_anulada)
                                    <a class="btn btn-danger open-cotizacion" title="Reabrir cotización"><i class="fa fa-unlock"></i></a>
                                @endif
                            @endability
                            @ability ('clonar' | 'cotizaciones')
                                <a class="btn btn-danger clone-cotizacion" title="Clonar cotización"><i class="fa fa-clone"></i></a>
                            @endability
                            @ability ('exportar' | 'cotizaciones')
                                <a class="btn btn-danger export-cotizacion" title="Exportar"><i class="fa fa-file-pdf-o"></i></a>
                            @endability
                        </div>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_cotizacion">
                        <div class="box box-whithout-border">
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-2 col-md-1">
                                        <label class="control-label">Estado</label>
                                        <span class="label label-warning">{{ config('koi.produccion.estados')[$cotizacion->cotizacion1_estados] }}</span>
                                    </div>
                                </div>
                            	<div class="row">
									<div class="form-group col-md-2">
										<label class="control-label">Código</label>
										<div>
                                            {{ $cotizacion->cotizacion_codigo }}
                                            @if ($cotizacion->cotizacion1_anulada)
                                                <span class="label label-danger">ANULADA</span>
                                            @elseif ($cotizacion->cotizacion1_abierta)
                                                <span class="label label-success">ABIERTA</span>
                                            @else
                                                <span class="label label-warning">CERRADA</span>
                                            @endif
                                        </div>
									</div>
                                    @if ($cotizacion->cotizacion1_orden)
                                        <div class="form-group col-md-2">
                                            <label>Orden de producción</label>
                                            <div><a href="{{ route('ordenes.show', ['ordenes' => $cotizacion->cotizacion1_orden]) }}" title="Ir a orden de producción">{{ $cotizacion->orden_codigo }}</a></div>
                                        </div>
                                    @endif
                                    @if ($cotizacion->cotizacion1_precotizacion)
    									<div class="form-group col-md-2">
    										<label>Pre-cotización</label>
                                            <div><a href="{{ route('precotizaciones.show', ['precotizaciones' => $cotizacion->cotizacion1_precotizacion]) }}" title="Ir a precotización">{{ $cotizacion->precotizacion_codigo }}</a></div>
    									</div>
                                    @endif
									<div class="form-group col-md-7">
										<label class="control-label">Referencia</label>
										<div>{{ $cotizacion->cotizacion1_referencia }}</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-2">
										<label class="control-label">F. Inicio</label>
										<div>{{ $cotizacion->cotizacion1_fecha_inicio }}</div>
									</div>

									<div class="form-group col-md-7">
										<label class="control-label">Cliente</label>
										<div>
											<a href="{{ route('terceros.show', ['terceros' =>  $cotizacion->cotizacion1_cliente ]) }}">
												{{ $cotizacion->tercero_nit }}
											</a>- {{ $cotizacion->tercero_nombre }}
										</div>
									</div>
									<div class="form-group col-md-3">
										<label class="control-label">Forma de pago</label>
										<div>{{ $cotizacion->cotizacion1_formapago }}</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6">
										<label class="control-label">Contacto</label>
										<div>{{ $cotizacion->tcontacto_nombre }}</div>
									</div>
									<div class="form-group col-md-3">
										<label class="control-label">Teléfono</label>
										<div>{{ $cotizacion->tcontacto_telefono }}</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12">
										<label class="control-label">Suministran</label>
										<div>{{ $cotizacion->cotizacion1_suministran }}</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12">
										<label class="control-label">Detalle</label>
										<div>{{ $cotizacion->cotizacion1_observaciones }}</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-12">
										<label class="control-label">Terminado</label>
										<div>{{ $cotizacion->cotizacion1_terminado }}</div>
									</div>
                                    <input type="hidden" id="cotizacion1_iva" value="{{ $cotizacion->cotizacion1_iva }}">
                                    <input type="hidden" id="cotizacion_codigo" value="{{ $cotizacion->cotizacion_codigo }}">
								</div>
								<div class="row">
									<div class="form-group col-md-2">
										<label class="control-label">Usuario elaboro</label>
										<div>
											<a href="{{ route('terceros.show', ['terceros' =>  $cotizacion->cotizacion1_usuario_elaboro ]) }}" title="Ver tercero">
												{{ $cotizacion->username_elaboro }}</a>
										</div>
									</div>
									<div class="form-group col-md-2">
										<label class="control-label">Fecha elaboro</label>
										<div>{{ $cotizacion->cotizacion1_fecha_elaboro }}</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6">
										<label class="control-label">Vendedor</label>
										<div>
											<a href="{{ route('terceros.show', ['terceros' =>  $cotizacion->cotizacion1_vendedor ]) }}" title="Ver vendedor">
                                            {{ $cotizacion->vendedor_nit }}</a> - {{ $cotizacion->vendedor_nombre }}
										</div>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<div class="row">
                                    <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                                        <a href="{{ route('cotizaciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-danger" id="wrapper-productop-cotizacion">
                            <div class="box-body table-responsive no-padding">
                                <table id="browse-cotizacion-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">Código</th>
                                            <th width="60%">Nombre</th>
                                            <th width="10%">Cantidad</th>
                                            <th width="10%">Facturado</th>
                                            @ability ('precios' | 'cotizaciones')
                                                <th width="10%">Precio</th>
                                                <th width="10%">Total</th>
                                            @endability
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Render content productos --}}
                                    </tbody>
                                    @ability ('precios' | 'cotizaciones')
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <th class="text-right">Subtotal</th>
                                                <th class="text-center" id="subtotal-cantidad">0</th>
                                                <th class="text-center" id="subtotal-facturado">0</th>
                                                <td></td>
                                                <th class="text-right" id="subtotal-total">0</th>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <th class="text-right">Iva ({{ $cotizacion->cotizacion1_iva }}%)</th>
                                                <th colspan="5" class="text-right" id="iva-total"></th>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <th class="text-right">Total</th>
                                                <th colspan="5" class="text-right" id="total-total">0</th>
                                            </tr>
                                        </tfoot>
                                    @endability
                                </table>
                            </div>
                  	     </div>
                    </div>
                    @ability ('graficas' | 'cotizaciones')
                        <div class="tab-pane" id="tab_graficas">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="chart-container">
                                        <canvas id="chart_producto" width="500" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endability
                    @ability ('archivos' | 'cotizaciones')
                        <div class="tab-pane" id="tab_archivos">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <textarea class="form-control" rows="25" placeholder="Observaciones" disabled>{{ $cotizacion->cotizacion1_observaciones_archivo }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <div class="fine-uploader"></div>
                                </div>
                            </div>
                        </div>
                    @endability
                    @ability ('bitacora' | 'cotizaciones')
                        <div class="tab-pane" id="tab_bitacora">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="browse-bitacora-list" class="table no-padding" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="10%"><small>Módulo</small></th>
                                                        <th width="10%"><small>Acción</small></th>
                                                        <th width="50%"><small>Descripción</small></th>
                                                        <th width="15%"><small>IP</small></th>
                                                        <th width="15%"><small>Usuario cambio</small></th>
                                                        <th width="15%"><small>Fecha cambio</small></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endability
               	</div>
        	</div>
        </div>
    </section>

    <script type="text/template" id="cotizacion-open-confirm-tpl">
        <p>¿Está seguro que desea reabrir la cotizacion de producción <b>{{ $cotizacion->cotizacion_codigo }}</b>?</p>
    </script>

    <script type="text/template" id="cotizacion-clone-confirm-tpl">
        <p>¿Está seguro que desea clonar la cotización <b>{{ $cotizacion->cotizacion_codigo }}</b>?</p>
    </script>

    <script type="text/template" id="cotizacion-producto-item-list-tpl">
        <td>
            <a href="<%- window.Misc.urlFull(Route.route('cotizaciones.productos.show', {productos: id})) %>" title="Ver producto"><%- id %></a>
        </td>
        <td><%- productop_nombre %></td>
        <td class="text-center"><%- cotizacion2_cantidad %></td>
        <td class="text-center"><%- cotizacion2_facturado %></td>
        @ability ('precios' | 'cotizaciones')
            <td class="text-right"><%- window.Misc.currency(cotizacion2_total_valor_unitario) %></td>
            <td class="text-right"><%- window.Misc.currency(cotizacion2_precio_total) %></td>
        @endability
    </script>
@stop
