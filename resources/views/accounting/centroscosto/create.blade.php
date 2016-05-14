@extends('accounting.centroscosto.main')

@section('breadcrumb')	
	<li><a href="{{ route('centroscosto.index') }}">Centros de costo</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="centrocosto-create">
		{!! Form::open(['route' => 'centroscosto.store', 'id' => 'form-create-centrocosto', 'data-toggle' => 'validator']) !!}
			
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('centroscosto.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>

			{{-- Include form centrocosto --}}
			@include('accounting.centroscosto.form')

		{!! Form::close() !!}
	</div>
@stop