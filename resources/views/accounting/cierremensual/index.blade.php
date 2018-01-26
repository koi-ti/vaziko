@extends('accounting.cierremensual.main')

@section('breadcrumb')
	<li class="active">Cierre contable mensual</li>
@stop

@section('module')
	<div id="cierremensual-main" class="box box-success">
        <div class="box-header with-border">
            <h3 class="title-cierres">CIERRE CONTABLE {{ $mes }} DE {{ $year }}</h3>
        </div>
		<div class="box-body">
			@if (Session::has('message'))
				<div class="alert alert-success col-md-6 col-md-offset-3"><p class="text-center">{{ Session::get('message') }}</p></div>
			@elseif(Session::has('error'))
				<div class="alert alert-danger col-md-6 col-md-offset-3"><p class="text-center">{{ Session::get('error') }}</p></div>
			@endif
		</div>
        <div class="box-footer">
			{!! Form::open(['id' => 'form-close-month', 'method' => 'POST']) !!}
				<div class="col-md-2 col-sm-6 col-xs-6 col-md-offset-5">
					<button type="button" class="btn btn-primary btn-sm btn-block sumbit-close-month">{{ trans('app.create') }}</button>
				</div>
			{!! Form::close() !!}
        </div>
	</div>
@stop
