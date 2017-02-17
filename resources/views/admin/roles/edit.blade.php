@extends('admin.roles.main')

@section('breadcrumb')
	<li><a href="{{ route('roles.index') }}">Roles</a></li>
	<li><a href="{{ route('roles.show', ['rol' => $rol->id]) }}">{{ $rol->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="rol-create">
		{!! Form::open(['id' => 'form-rol', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-rol">
				{{-- Render form rol --}}
			</div>

	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
						<a href="{{ route('roles.show', ['rol' => $rol->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop