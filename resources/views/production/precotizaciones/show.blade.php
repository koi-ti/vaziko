@extends('production.precotizaciones.main')

@section('module')
    <section class="content-header">
        <h1>
            Pre-cotizaciones <small>Administración de pre-cotizaciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li><a href="{{ route('precotizaciones.index')}}">Pre-cotización</a></li>
            <li class="active">{{ $precotizacion->precotizacion_codigo }}</li>
        </ol>
    </section>

    <section class="content" id="precotizaciones-show">
        <div class="box box-success spinner-main">
            <div class="box-body">
            	<div class="row">
					<div class="form-group col-md-2">
						<label class="control-label">Código</label>
						<div>
                            {{ $precotizacion->precotizacion_codigo }}
                            @if ($precotizacion->precotizacion1_culminada)
                                <span class="label label-primary">CULMINADA</span>
                            @elseif ($precotizacion->precotizacion1_abierta)
                                <span class="label label-success">ABIERTA</span>
                            @else
                                <span class="label label-warning">CERRADA</span>
                            @endif
                        </div>
					</div>
					<div class="form-group col-md-3">
						<label class="control-label">Fecha</label>
						<div>{{ $precotizacion->precotizacion1_fecha }}</div>
					</div>
				</div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <label class="control-label">Referencia</label>
                        <div>{{ $precotizacion->precotizacion1_referencia }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-9">
                        <label class="control-label">Cliente</label>
                        <div>
                            <a href="{{ route('terceros.show', ['terceros' =>  $precotizacion->precotizacion1_cliente ]) }}">
                                {{ $precotizacion->tercero_nit }}
                            </a>- {{ $precotizacion->tercero_nombre }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="control-label">Contacto</label>
                        <div>{{ $precotizacion->tcontacto_nombre }}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Teléfono</label>
                        <div>{{ $precotizacion->tcontacto_telefono }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Suministran</label>
                        <div>{{ $precotizacion->precotizacion1_suministran }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Detalle</label>
                        <div>{{ $precotizacion->precotizacion1_observaciones }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Usuario elaboro</label>
                        <div>
                            <a href="{{ route('terceros.show', ['terceros' =>  $precotizacion->precotizacion1_usuario_elaboro ]) }}" title="Ver tercero">
                                {{ $precotizacion->username_elaboro }}</a>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Fecha elaboro</label>
                        <div>{{ $precotizacion->precotizacion1_fh_elaboro }}</div>
                    </div>
                    @if ($precotizacion->precotizacion1_usuario_culminada)
                        <div class="form-group col-md-2">
                            <label class="control-label">Usuario culmino</label>
                            <div>
                                <a href="{{ route('terceros.show', ['terceros' =>  $precotizacion->precotizacion1_usuario_culminada ]) }}" title="Ver tercero">
                                    {{ $precotizacion->username_culminada }}</a>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Fecha culmino</label>
                            <div>{{ $precotizacion->precotizacion1_fh_culminada }}</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="box-footer with-border">
                <div class="row">
                    <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                        <a href="{{ route('precotizaciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-success spinner-main">
            <div class="box-body">
                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table id="browse-precotizacion-productop-list" class="table table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">Código</th>
                                <th width="65%">Nombre</th>
                                <th width="10%">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th colspan="3" class="text-center">No existen registros.</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
       </div>
    </section>
@stop
