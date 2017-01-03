@extends('production.ordenes.main')

@section('breadcrumb')
    <li><a href="{{ route('ordenes.index')}}">Ordenes</a></li>
	<li class="active">{{ $orden->orden_codigo }}</li>
@stop


@section('module')
	<div class="box box-success" id="ordenes-show">
		<div class="box-header with-border">
        	<div class="row">
				<div class="col-md-2 col-sm-6 col-xs-6 text-left">
					<a href="{{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
				</div>

				<div class="col-md-1 col-md-offset-9 col-sm-6 col-xs-6 text-right">
					<a href="{{ route('ordenes.exportar', ['ordenes' => $orden->id]) }}" class="btn btn-danger btn-sm btn-block">
						<i class="fa fa-file-pdf-o"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="form-group col-md-2">
					<label class="control-label">Código</label>
					<div>{{ $orden->orden_codigo }}</div>
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
		</div>
	</div>
@stop