@extends('production.ordenes.main')

@section('breadcrumb')
    <li><a href="{{ route('ordenes.index')}}">Ordenes</a></li>
	<li class="active">{{ $orden->orden_codigo }}</li>
@stop


@section('module')
	<div class="box box-whithout-border" id="ordenes-show">
        <div class="row">
            <div class="form-group col-md-12">
                <div class="nav-tabs-custom tab-success tab-whithout-box-shadow">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_orden" data-toggle="tab">Orden</a></li>
                        <li><a href="#tab_despachos" data-toggle="tab">Distribución por clientes</a></li>
                        <li class="pull-right">
                            <button type="button" class="btn btn-block btn-danger btn-sm export-ordenp">
                                <i class="fa fa-file-pdf-o"></i>
                            </button>
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
											<div>{{ $orden->orden_formapago ? config('koi.produccion.formaspago')[$orden->orden_formapago] : ''  }}</div>
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
                                                            <th width="10%">Precio</th>
                                                            <th width="10%">Total</th>
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
                                                            <td></td>
                                                            <td class="text-right" id="subtotal-total">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <th class="text-right">Iva</th>
                                                            <td colspan="3" class="text-right" id="iva-total">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <th class="text-right">Total</th>
                                                            <td colspan="3" class="text-right" id="total-total">0</td>
                                                        </tr>
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
                   	</div>
            	</div>
           	</div>
       	</div>
	</div>
@stop