@extends('accounting.plancuentasnif.main')

@section('breadcrumb')	
	<li><a href="{{ route('plancuentasnif.index') }}">Plan de cuentas NIF</a></li>
	<li class="active">Nuevo</li> 
@stop

@section('module')
	<div class="box box-success" id="plancuentasnif-create">
		{!! Form::open(['id' => 'form-plancuentasnif', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-plancuentasnif">
				{{-- Render form plancuentas --}}
			</div>
			
	        <div class="box-footer with-border">
	        	<div class="row">
					<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('plancuentasnif.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop