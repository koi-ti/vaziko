@extends('admin.terceros.main')

@section('breadcrumb')	
	<li><a href="{{ route('terceros.index') }}">Terceros</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="tercero-create">
		{!! Form::open(['route' => 'terceros.store', 'id' => 'form-create-tercero', 'data-toggle' => 'validator', 'role' => 'form']) !!}
			
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('terceros.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>

			<div class="box-body" id="render-form-tercero">
				{{-- Render form tercero --}}
			</div>

		{!! Form::close() !!}
	</div>
@stop