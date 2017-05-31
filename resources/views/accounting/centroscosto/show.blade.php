@extends('accounting.centroscosto.main')

@section('breadcrumb')	
	<li><a href="{{ route('centroscosto.index') }}">Centros de costo</a></li>
	<li class="active">{{ $centrocosto->centrocosto_codigo }}</li>
@stop

@section('module')
	<div class="box box-success">
		<div class="box-body">
			<div class="row">	
				<div class="form-group col-md-2">
					<label class="control-label">Código</label>
					<div>{{ $centrocosto->centrocosto_codigo }}</div>
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">Centro</label>
					<div>{{ $centrocosto->centrocosto_centro }}</div>
				</div>
				<div class="form-group col-md-7">
					<label class="control-label">Nombre</label>
					<div>{{ $centrocosto->centrocosto_nombre }}</div>
				</div>
			</div>

			<div class="row">	
				<div class="form-group col-md-12">
					<label class="control-label">Descripcion 1</label>
					<div>{{ $centrocosto->centrocosto_descripcion1 }}</div>
				</div>
			</div>

			<div class="row">	
				<div class="form-group col-md-12">
					<label class="control-label">Descripcion 2</label>
					<div>{{ $centrocosto->centrocosto_descripcion2 }}</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">Tipo</label>
					<div>{{ $centrocosto->centrocosto_tipo ? config('koi.contabilidad.centrocosto.tipo')[$centrocosto->centrocosto_tipo] : '' }}</div>
				</div>
			</div>

			<div class="row">	
				<div class="form-group col-md-2 col-xs-4 col-sm-4">
					<label class="control-label">Titulo</label>
					<div>{{ $centrocosto->centrocosto_estructura == 'S' ? 'Si' : 'No' }}</div>
				</div>
				<div class="form-group col-md-2 col-xs-8 col-sm-3">
					<br>
					<label class="checkbox-inline" for="centrocosto_activo">
						<input type="checkbox" id="centrocosto_activo" name="centrocosto_activo" value="centrocosto_activo" disabled {{ $centrocosto->centrocosto_activo ? 'checked': '' }}> Activo
					</label>				
				</div>
			</div>
		</div>
		<div class="box-footer with-border">
        	<div class="row">
				<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
					<a href="{{ route('centroscosto.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
				</div>
				<div class="col-md-2 col-sm-6 col-xs-6 text-right">
					<a href="{{ route('centroscosto.edit', ['centrocosto' => $centrocosto->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
				</div>
			</div>
		</div>
	</div>
@stop