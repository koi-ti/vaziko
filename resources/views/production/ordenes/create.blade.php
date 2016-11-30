@extends('production.ordenes.main')

@section('breadcrumb')
    <li><a href="{{ route('ordenes.index')}}">ordenes</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="ordenes-create">
		{!! Form::open(['id' => 'form-ordenes', 'data-toggle' => 'validator']) !!}

			<div class="box-body" id="render-form-orden">
				{{-- Render form orden --}}
			</div>

			<div class="box-footer clearfix">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>

		{!! Form::close() !!}
	</div>
@stop