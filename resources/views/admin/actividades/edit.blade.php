@extends('admin.actividades.main')

@section('breadcrumb')	
	<li><a href="{{route('actividades.index')}}">Actividades</a></li>
	<li><a href="{{ route('actividades.show', ['actividades' => $actividad->id]) }}">{{ $actividad->actividad_codigo }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="actividad-create">
		{!! Form::open(['id' => 'form-actividad', 'data-toggle' => 'validator']) !!}
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('actividades.show', ['actividades' => $actividad->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>

			<div class="box-body" id="render-form-actividad">
				{{-- Render form actividades --}}
			</div>
		{!! Form::close() !!}
	</div>
@stop