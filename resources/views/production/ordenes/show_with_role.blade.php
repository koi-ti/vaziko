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

    <section class="content" id="ordenes-show">
        <div class="box box-primary">
            <div class="box-body bg-primary">
            	<div class="row">
					<div class="form-group col-md-2">
						<label class="control-label">Código</label>
						<div>
                            {{ $orden->orden_codigo }}
                            @if($orden->orden_anulada)
                                <span class="label label-danger">ANULADA</span>
                            @elseif($orden->orden_abierta)
                                <span class="label label-success">ABIERTA</span>
                            @elseif($orden->orden_culminada)
                                <span class="label bg-blue">CULMINADO</span>
                            @else
                                <span class="label label-warning">CERRADA</span>
                            @endif
                        </div>
					</div>
                    @if ($orden->precotizacion_codigo)
						<div class="form-group col-md-2">
							<label class="control-label">Pre-cotización</label>
							<div>
                                <a href="{{ route('precotizaciones.show', ['precotizaciones' => $orden->cotizacion1_precotizacion]) }}" title="Ir a precotización">{{ $orden->precotizacion_codigo }}</a>
                            </div>
						</div>
                    @endif
                    @if ($orden->cotizacion_codigo)
						<div class="form-group col-md-2">
							<label class="control-label">Cotización</label>
							<div>
                                <a href="{{ route('cotizaciones.show', ['cotizaciones' => $orden->orden_cotizacion]) }}" title="Ir a cotización">{{ $orden->cotizacion_codigo }}</a>
                            </div>
						</div>
                    @endif
					<div class="form-group col-md-5">
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
                @if ($orden->orden_observaciones)
    				<div class="row">
    					<div class="form-group col-md-12">
    						<label class="control-label">Detalle</label>
    						<div>{{ $orden->orden_observaciones }}</div>
    					</div>
    				</div>
                @endif
                @if ($orden->orden_terminado)
    				<div class="row">
    					<div class="form-group col-md-12">
    						<label class="control-label">Terminado</label>
    						<div>{{ $orden->orden_terminado }}</div>
    					</div>
    				</div>
                @endif
				<div class="row">
                    @if ($orden->orden_fecha_recogida1)
    					<div class="form-group col-md-3">
    						<label class="control-label">F. Recogida #1</label>
    						<div>{{ $orden->orden_fecha_recogida1 }}</div>
    					</div>
                    @endif
                    @if ($orden->orden_hora_recogida1)
    					<div class="form-group col-md-3">
    						<label class="control-label">H. Recogida #1</label>
                            <div>{{ $orden->orden_hora_recogida1 }}</div>
    					</div>
                    @endif
                    @if ($orden->orden_fecha_recogida2)
    					<div class="form-group col-md-3">
    						<label class="control-label">F. Recogida #2</label>
    						<div>{{ $orden->orden_fecha_recogida2 }}</div>
    					</div>
                    @endif
                    @if ($orden->orden_hora_recogida2)
                        <div class="form-group col-md-3">
                            <label class="control-label">H. Recogida #2</label>
                            <div>{{ $orden->orden_hora_recogida2 }}</div>
                        </div>
                    @endif
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
            </div>
        </div>

        <div class="box box-solid">
            <div class="nav-tabs-custom tab-primary tab-whithout-box-shadow">
                <ul class="nav nav-tabs nav-products">
                    @foreach ($productos as $key => $producto)
                        <li class="{{ $key == 0 ? 'active' : ''}}"><a href="#tab_orden_{{ $producto->id }}" data-toggle="tab">{{ $key += 1 }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-content">
                @foreach ($productos as $key => $producto)
                    <div class="tab-pane {{ $key == 0 ? 'active' : ''}}" id="tab_orden_{{ $producto->id }}">
                        @if($producto->productop_abierto || $producto->productop_cerrado)
                            <div class="box box-primary">
                                <div class="box-body">
                                    @if($producto->productop_abierto)
                                        <div class="row">
                                            <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Abierto</label>
                                            <label for="orden2_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    {{ $ordenp2->orden2_ancho }}
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m1_sigla }}</div>
                                            </div>

                                            <label for="orden2_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    {{ $ordenp2->orden2_alto }}
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m2_sigla }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($producto->productop_cerrado)
                                        <div class="row">
                                            <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Cerrado</label>
                                            <label for="orden2_c_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    {{ $ordenp2->orden2_c_ancho }}
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m3_sigla }}</div>
                                            </div>

                                            <label for="orden2_c_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    {{ $ordenp2->orden2_c_alto }}
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m4_sigla }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_3d)
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">3D</label>
                                        <label for="orden2_3d_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                {{ $ordenp2->orden2_3d_ancho }}
                                            </div>
                                            <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m5_sigla }}</div>
                                        </div>

                                        <label for="orden2_3d_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                {{ $ordenp2->orden2_3d_alto }}
                                            </div>
                                            <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m6_sigla }}</div>
                                        </div>

                                        <label for="orden2_3d_profundidad" class="col-xs-2 col-sm-1 control-label text-right">Profundidad</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                {{ $ordenp2->orden2_3d_profundidad }}
                                            </div>
                                            <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m7_sigla }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_tiro || $producto->productop_retiro)
                            <div class="box box-primary">
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
                                                    @if($producto->productop_tiro)
                                                        <tr>
                                                            <th class="text-center">T <input type="checkbox" disabled {{ $ordenp2->orden2_tiro ? 'checked': '' }}></th>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_yellow ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_magenta ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_cyan ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_key ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_color1 ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_color2 ? 'checked': '' }}></td>
                                                        </tr>
                                                    @endif
                                                    @if($producto->productop_retiro)
                                                        <tr>
                                                            <th class="text-center">R <input type="checkbox" disabled {{ $ordenp2->orden2_retiro ? 'checked': '' }}></th>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_yellow2 ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_magenta2 ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_cyan2 ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_key2 ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_color12 ? 'checked': '' }}></td>
                                                            <td class="text-center"><input type="checkbox" disabled {{ $ordenp2->orden2_color22 ? 'checked': '' }}></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @if($producto->productop_tiro)
                                            <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                                <label for="orden2_nota_tiro" class="control-label">Nota tiro</label>
                                                <div>{{ $ordenp2->orden2_nota_tiro }}</div>
                                            </div>
                                        @endif

                                        @if($producto->productop_retiro)
                                            <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                                <label for="orden2_nota_retiro" class="control-label">Nota retiro</label>
                                                <div>{{ $ordenp2->orden2_nota_retiro }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Imagenes de producción</h3>
                            </div>
                            <div class="box-body">
                                <div class="fine-uploader"></div>
                            </div>
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Máquinas de producción</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (App\Models\Production\Ordenp3::getOrdenesp3(5, $producto->id) as $maquina)
                                            @if ($maquina->activo)
                                                <tr>
                                                    <td>{{ $maquina->maquinap_nombre }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Acabados de producción</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (App\Models\Production\Ordenp5::getOrdenesp5(5, $producto->id) as $acabado)
                                            @if ($acabado->activo)
                                                <tr>
                                                    <td>{{ $acabado->acabadop_nombre }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Materiales de producción</h3>
                            </div>
                            <div class="box-body">
                                <table id="browse-orden-producto-materiales-list" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="25%">Insumo</th>
                                            <th width="10%">Medidas</th>
                                            <th width="10%">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (App\Models\Production\Ordenp4::getOrdenesp4($producto->id) as $materialp)
                                            <tr>
                                                <td>{{ $materialp->producto_nombre }}</td>
                                                <td>{{ $materialp->orden4_medidas }}</td>
                                                <td>{{ $materialp->orden4_cantidad }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Areas de producción</h3>
                            </div>
                            <div class="box-body">
                                <table id="browse-orden-producto-areas-list" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Área</th>
                                            <th>Nombre</th>
                                            <th>Horas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (App\Models\Production\Ordenp6::getOrdenesp6($producto->id) as $areap)
                                            <tr>
                                                <td>{{ $areap->areap_nombre == '' ? '-': $areap->areap_nombre }}</td>
                                                <td>{{ $areap->orden6_nombre == '' ? '-': $areap->orden6_nombre }}</td>
                                                <td class="text-center">{{  $areap->orden6_tiempo }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Empaques de producción</h3>
                            </div>
                            <div class="box-body">
                                <table id="browse-orden-producto-empaques-list" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="25%">Empaque</th>
                                            <th width="25%">Insumo</th>
                                            <th width="10%">Medidas</th>
                                            <th width="10%">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (App\Models\Production\Ordenp9::getOrdenesp9($producto->id) as $empaque)
                                            <tr>
                                                <td>{{ isset($empaque->empaque_nombre) ? $empaque->empaque_nombre : '-' }}</td>
                                                <td>{{ isset($empaque->producto_nombre) ? $empaque->producto_nombre : '-' }}</td>
                                                <td>{{ $empaque->orden9_medidas }}</td>
                                                <td>{{ $empaque->orden9_cantidad }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Transportes de producción</h3>
                            </div>
                            <div class="box-body">
                                <table id="browse-orden-producto-transportes-list" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="25%">Transporte</th>
                                            <th width="25%">Insumo</th>
                                            <th width="10%">Medidas</th>
                                            <th width="10%">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (App\Models\Production\Ordenp10::getOrdenesp10($producto->id) as $transporte)
                                            <tr>
                                                <td>{{ isset($transporte->transporte_nombre) ? $transporte->transporte_nombre : '-' }}</td>
                                                <td>{{ isset($transporte->producto_nombre) ? $transporte->producto_nombre : '-' }}</td>
                                                <td>{{ $transporte->orden10_medidas }}</td>
                                                <td>{{ $transporte->orden10_cantidad }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Quienes trabajaron en esta orden</h3>
            </div>
            <div class="box-body">
                <table id="browse-tiemposp-global-list" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Tercero</th>
                            <th width="6%">Fecha</th>
                            <th width="5%">H. inicio</th>
                            <th width="5%">H. fin</th>
                            <th width="15%">Actividad</th>
                            <th width="20%">Subactividad</th>
                            <th width="25%">Área</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="7" class="text-center">No existen registros.</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                    <a href="{{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </section>

    <script type="text/template" id="ordenp-tiempop-item-list-tpl">
        <td><%- tercero_nombre %></td>
        <td><%- tiempop_fecha %></td>
        <td><%- moment(tiempop_hora_inicio, 'HH:mm').format('HH:mm') %></td>
        <td><%- moment(tiempop_hora_fin, 'H:mm').format('H:mm') %></td>
        <td><%- actividadp_nombre %></td>
        <td><%- !_.isNull(subactividadp_nombre) ? subactividadp_nombre : ' - ' %></td>
        <td><%- areap_nombre %></td>
    </script>
@stop
