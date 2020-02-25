@extends('production.actividadesp.main')

@section('breadcrumb')
	<li><a href="{{ route('actividadesp.index') }}">Actividad de produccióm</a></li>
	<li><a href="{{ route('actividadesp.show', ['actividadp' => $actividadp->id]) }}">{{ $actividadp->actividadp_nombre }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="actividadp-create">
		{!! Form::open(['id' => 'form-actividadp', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-actividadp">
				{{-- Render form actividadp --}}
			</div>

			<div class="box-footer with-border">
	        	<div class="row">
					<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('actividadesp.show', ['actividadp' => $actividadp->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
