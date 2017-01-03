@extends('production.areas.main')

@section('breadcrumb')
	<li><a href="{{ route('areasp.index') }}">Áreas</a></li>
	<li><a href="{{ route('areasp.show', ['areasp' => $area->id]) }}">{{ $area->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="areasp-create">
		{!! Form::open(['id' => 'form-areasp', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-areap">
				{{-- Render form areap --}}
			</div>

			<div class="box-footer clearfix">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('areasp.show', ['areasp' => $area->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop