@extends('accounting.centroscosto.main')

@section('breadcrumb')	
	<li><a href="{{ route('centroscosto.index') }}">Centros de costo</a></li>
	<li class="active">Editar ({{ $centrocosto->centrocosto_codigo }})</li>
@stop

@section('module')
	<div class="box box-success" id="centrocosto-create">
	 	{!! Form::open(['id' => 'form-centrocosto', 'data-toggle' => 'validator']) !!}			
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('centroscosto.show', ['centroscosto' => $centrocosto->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>

			<div class="box-body" id="render-form-centrocosto">
				{{-- Render form centrocosto --}}
			</div>
		{!! Form::close() !!}
	</div>
@stop