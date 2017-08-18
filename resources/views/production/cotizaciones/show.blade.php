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
            <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_cotizacion" data-toggle="tab">Cotización</a></li>
                    <li><a href="#tab_despachos" data-toggle="tab">Distribución por clientes</a></li>
                    <li class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Opciones <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                                @if( !$cotizacion->cotizacion1_abierta && !$cotizacion->cotizacion1_anulada && Auth::user()->ability('admin', 'opcional1', ['module' => 'cotizaciones']) )
                                    <a role="menuitem" tabindex="-1" href="#" class="open-cotizacion">
                                        <i class="fa fa-unlock"></i>Reabrir cotización
                                    </a>
                                @endif

                                @if( Auth::user()->ability('admin', 'crear', ['module' => 'cotizaciones']) )
                                    <a role="menuitem" tabindex="-1" href="#" class="clone-cotizacion">
                                        <i class="fa fa-clone"></i>Clonar cotización
                                    </a>
                                @endif
                                <a role="menuitem" tabindex="-1" href="#" class="export-cotizacion">
                                    <i class="fa fa-file-pdf-o"></i>Exportar
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="tab-content">
                    {{-- Content cotizacion --}}
                    <div class="tab-pane active" id="tab_cotizacion">
                        <div class="box box-whithout-border">
                            <div class="box-body">
                            	<div class="row">
									<div class="form-group col-md-2">
										<label class="control-label">Código</label>
										<div>
                                            {{ $cotizacion->cotizacion_codigo }}
                                            @if($cotizacion->cotizacion1_anulada)
                                                <span class="label label-danger">ANULADA</span>
                                            @elseif($cotizacion->cotizacion1_abierta)
                                                <span class="label label-success">ABIERTA</span>
                                            @else
                                                <span class="label label-warning">CERRADA</span>
                                            @endif
                                        </div>
									</div>
									<div class="form-group col-md-9">
										<label class="control-label">Referencia</label>
										<div>{{ $cotizacion->cotizacion1_referencia }}</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-3">
										<label class="control-label">F. Inicio</label>
										<div>{{ $cotizacion->cotizacion1_fecha_inicio }}</div>
									</div>
									<div class="form-group col-md-3">
										<label class="control-label">F. Entrega</label>
										<div>{{ $cotizacion->cotizacion1_fecha_entrega }}</div>
									</div>

									<div class="form-group col-md-3">
										<label class="control-label">H. Entrega</label>
										<div>{{ $cotizacion->cotizacion1_hora_entrega }}</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-9">
										<label class="control-label">Cliente</label>
										<div>
											<a href="{{ route('terceros.show', ['terceros' =>  $cotizacion->cotizacion1_cliente ]) }}">
												{{ $cotizacion->tercero_nit }}
											</a>- {{ $cotizacion->tercero_nombre }}
										</div>
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
									<div class="form-group col-md-6">
										<label class="control-label">Suministran</label>
										<div>{{ $cotizacion->cotizacion1_suministran }}</div>
									</div>
									<div class="form-group col-md-6">
										<label class="control-label">Forma pago</label>
										<div>{{ $cotizacion->cotizacion1_formapago ? config('koi.produccion.formaspago')[$cotizacion->cotizacion1_formapago] : ''  }}</div>
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
                                    <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                                        <a href="{{ route('cotizaciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                                    </div>
                                </div>

                                <br />

                                <div class="box box-success" id="wrapper-productop-cotizacion">
                                   	<div class="box-body">
                                   		<!-- table table-bordered table-striped -->
                                        <div class="box-body table-responsive no-padding">
                                            <table id="browse-cotizacion-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Código</th>
                                                        <th width="65%">Nombre</th>
                                                        <th width="10%">Cantidad</th>
                                                        <th width="10%">Facturado</th>
                                                        @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                                                            <th width="10%">Precio</th>
                                                            <th width="10%">Total</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Render content productos --}}
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <th class="text-right">Subtotal</th>
                                                        <td class="text-center" id="subtotal-cantidad">0</td>
                                                        @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                                                            <td colspan="2"></td>
                                                            <td class="text-right" id="subtotal-total">0</td>
                                                        @endif
                                                    </tr>
                                                    @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                                                        <tr>
                                                            <td></td>
                                                            <th class="text-right">Iva</th>
                                                            <td colspan="4" class="text-right" id="iva-total">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <th class="text-right">Total</th>
                                                            <td colspan="4" class="text-right" id="total-total">0</td>
                                                        </tr>
                                                    @endif
                                                </tfoot>
                                            </table>
                                        </div>
                                   	</div>
                               </div>
                            </div>
                      	</div>
                  	</div>

                  	<div class="tab-pane" id="tab_despachos">
                        <div class="box box-whithout-border">
                            <div class="box-body">
                            	<!-- table table-bordered table-striped -->
                                <div class="box-body table-responsive no-padding">
                                    <table id="browse-cotizacion-despachosp-list" class="table table-hover table-bordered" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="5%">Código</th>
                                                <th width="75%">Contacto</th>
                                                <th width="15%">Fecha</th>
                                                <th width="5%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Render content productos --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
               	</div>
        	</div>
        </div>
    </section>

    <script type="text/template" id="cotizacion-open-confirm-tpl">
        <p>¿Está seguro que desea reabrir la cotizacion de producción <b>{{ $cotizacion->cotizacion_codigo }}</b>?</p>
    </script>
@stop
