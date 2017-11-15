@extends('production.actividadesop.main')

@section('breadcrumb')
	<li><a href="{{ route('actividadesop.index') }}">Actividades de produccióm</a></li>
	<li><a href="{{ route('actividadesop.show', ['actividadop' => $actividadop->id]) }}">{{ $actividadop->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="actividadop-create">
		{!! Form::open(['id' => 'form-actividadop', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-actividadop">
				{{-- Render form actividadop --}}
			</div>

			<div class="box-footer with-border">
	        	<div class="row">
					<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('actividadesop.show', ['actividadop' => $actividadop->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
