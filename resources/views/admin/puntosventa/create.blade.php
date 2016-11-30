@extends('admin.puntosventa.main')

@section('breadcrumb')
    <li><a href="{{ route('puntosventa.index')}}">Puntos de venta</a></li>
	<li class="active">Nueva</li>
@stop

@section('module')
	<div class="box box-success" id="puntosventa-create">
		{!! Form::open(['id' => 'form-puntosventa', 'data-toggle' => 'validator']) !!}
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('puntosventa.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>

			<div class="box-body" id="render-form-puntosventa">
				{{-- Render form puntosventa --}}
			</div>
		{!! Form::close() !!}
	</div>
@stop