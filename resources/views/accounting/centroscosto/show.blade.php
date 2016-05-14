@extends('accounting.centroscosto.main')

@section('breadcrumb')	
	<li><a href="{{ route('centroscosto.index') }}">Centros de costo</a></li>
	<li class="active">{{ $centrocosto->centrocosto_codigo }}</li>
@stop

@section('module')
	<div class="box box-success">
		<div class="box-header with-border">
        	<div class="row">
				<div class="col-md-2 col-sm-6 col-xs-6 text-left">
					<a href="{{ route('centroscosto.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
				</div>
				<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
					<a href="{{ route('centroscosto.edit', ['centrocosto' => $centrocosto->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
				</div>
			</div>
		</div>

		<div class="box-body">
			<div class="row">	
				<div class="form-group col-md-3">
					<label class="control-label">Código</label>
					<div>{{ $centrocosto->centrocosto_codigo }}</div>
				</div>
			</div>
			<div class="row">	
				<div class="form-group col-md-6">
					<label class="control-label">Nombre</label>
					<div>{{ $centrocosto->centrocosto_nombre }}</div>
				</div>
			</div>
		</div>
	</div>
@stop