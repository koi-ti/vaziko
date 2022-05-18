@extends('inventory.subgrupos.main')

@section('breadcrumb')
    <li><a href="{{ route('subgrupos.index')}}">Subgrupo</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="subgrupos-create">
		{!! Form::open(['id' => 'form-subgrupos', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-subgrupo">
				{{-- Render form subgrupo --}}
			</div>

			<div class="box-footer with-border">
	        	<div class="row">
					<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('subgrupos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
