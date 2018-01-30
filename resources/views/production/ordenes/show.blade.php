@extends('production.ordenes.main')


@section('module')
    <section class="content-header">
        <h1>
            Ordenes de producción <small>Administración de ordenes de producción</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li><a href="{{ route('ordenes.index')}}">Orden</a></li>
            <li class="active">{{ $orden->orden_codigo }}</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-solid" id="ordenes-show">
            <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_orden" data-toggle="tab">Orden</a></li>
                    <li><a href="#tab_despachos" data-toggle="tab">Distribución por clientes</a></li>
                    @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'ordenes']) )
                        <li><a href="#tab_tiemposp" data-toggle="tab">Tiempos de producción</a></li>
                    @endif
                    <li class="pull-right">
                        <button type="button" class="btn btn-block btn-danger btn-sm export-ordenp">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                    </li>
                    <li class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Opciones <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                                @if( !$orden->orden_abierta && !$orden->orden_anulada && Auth::user()->ability('admin', 'opcional1', ['module' => 'ordenes']) )
                                    <a role="menuitem" tabindex="-1" href="#" class="open-ordenp">
                                        <i class="fa fa-unlock"></i>Reabrir orden
                                    </a>
                                @endif

                                @if( Auth::user()->ability('admin', 'crear', ['module' => 'ordenes']) )
                                    <a role="menuitem" tabindex="-1" href="#" class="clone-ordenp">
                                        <i class="fa fa-clone"></i>Clonar orden
                                    </a>
                                @endif
                                <a role="menuitem" tabindex="-1" href="#" class="export-ordenp">
                                    <i class="fa fa-file-pdf-o"></i>Exportar
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="tab-content">
                    {{-- Content orden --}}
                    <div class="tab-pane active" id="tab_orden">
                        <div class="box box-whithout-border">
                            <div class="box-body">
                            	<div class="row">
									<div class="form-group col-md-2">
										<label class="control-label">Código</label>
										<div>
                                            {{ $orden->orden_codigo }}
                                            @if($orden->orden_anulada)
                                                <span class="label label-danger">ANULADA</span>
                                            @elseif($orden->orden_abierta)
                                                <span class="label label-success">ABIERTA</span>
                                            @else
                                                <span class="label label-warning">CERRADA</span>
                                            @endif
                                        </div>
									</div>
									<div class="form-group col-md-9">
										<label class="control-label">Referencia</label>
										<div>{{ $orden->orden_referencia }}</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-3">
										<label class="control-label">F. Inicio</label>
										<div>{{ $orden->orden_fecha_inicio }}</div>
									</div>
									<div class="form-group col-md-3">
										<label class="control-label">F. Entrega</label>
										<div>{{ $orden->orden_fecha_entrega }}</div>
									</div>

									<div class="form-group col-md-3">
										<label class="control-label">H. Entrega</label>
										<div>{{ $orden->orden_hora_entrega }}</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-9">
										<label class="control-label">Cliente</label>
										<div>
											<a href="{{ route('terceros.show', ['terceros' =>  $orden->orden_cliente ]) }}">
												{{ $orden->tercero_nit }}
											</a>- {{ $orden->tercero_nombre }}
										</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label class="control-label">Contacto</label>
										<div>{{ $orden->tcontacto_nombre }}</div>
									</div>
									<div class="form-group col-md-3">
										<label class="control-label">Teléfono</label>
										<div>{{ $orden->tcontacto_telefono }}</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label class="control-label">Suministran</label>
										<div>{{ $orden->orden_suministran }}</div>
									</div>
									<div class="form-group col-md-6">
										<label class="control-label">Forma pago</label>
										<div>{{ $orden->orden_formapago }}</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-12">
										<label class="control-label">Detalle</label>
										<div>{{ $orden->orden_observaciones }}</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-12">
										<label class="control-label">Terminado</label>
										<div>{{ $orden->orden_terminado }}</div>
									</div>

                                    <input type="hidden" id="orden_iva" value="{{ $orden->orden_iva }}">
								</div>

								<div class="row">
									<div class="form-group col-md-2">
										<label class="control-label">Usuario elaboro</label>
										<div>
											<a href="{{ route('terceros.show', ['terceros' =>  $orden->orden_usuario_elaboro ]) }}" title="Ver tercero">
												{{ $orden->username_elaboro }}</a>
										</div>
									</div>
									<div class="form-group col-md-2">
										<label class="control-label">Fecha elaboro</label>
										<div>{{ $orden->orden_fecha_elaboro }}</div>
									</div>
								</div>

								<div class="row">
                                    <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                                        <a href="{{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                                    </div>
                                </div>

                                <br />

                                <div class="box box-success" id="wrapper-productop-orden">
                                   	<div class="box-body">
                                   		<!-- table table-bordered table-striped -->
                                        <div class="box-body table-responsive no-padding">
                                            <table id="browse-orden-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Código</th>
                                                        <th width="65%">Nombre</th>
                                                        <th width="10%">Cantidad</th>
                                                        <th width="10%">Facturado</th>
                                                        @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'ordenes']) )
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
                                                        @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'ordenes']) )
                                                            <td colspan="2"></td>
                                                            <td class="text-right" id="subtotal-total">0</td>
                                                        @endif
                                                    </tr>
                                                    @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'ordenes']) )
                                                        <tr>
                                                            <td></td>
                                                            <th class="text-right">Iva ({{ $orden->orden_iva }}%)</th>
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
                                    <table id="browse-orden-despachosp-list" class="table table-hover table-bordered" cellspacing="0">
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

                    @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'ordenes']) )
                        <div class="tab-pane" id="tab_tiemposp">
                            <div class="box box-whithout-border">
                                <div class="box-body table-responsive no-padding">
                                    <table id="browse-orden-tiemposp-list" class="table table-bordered" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="2%">#</th>
                                                <th width="20%">Tercero</th>
                                                <th width="20%">Actividad</th>
                                                <th width="20%">Subactividad</th>
                                                <th width="20%">Área</th>
                                                <th width="8%">Fecha</th>
                                                <th width="5%">H. inicio</th>
                                                <th width="5%">H. fin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Render content productos --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
               	</div>
        	</div>
        </div>
    </section>

    <script type="text/template" id="ordenp-open-confirm-tpl">
        <p>¿Está seguro que desea reabrir la orden de producción <b>{{ $orden->orden_codigo }}</b>?</p>
    </script>

    <script type="text/template" id="ordenp-clone-confirm-tpl">
        <p>¿Está seguro que desea clonar la orden de producción <b>{{ $orden->orden_codigo }}</b>?</p>
    </script>
@stop
