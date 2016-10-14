@extends('inventory.subgrupos.main')

@section('breadcrumb')
	<li><a href="{{ route('subgrupos.index') }}">Subgrupos</a></li>
	<li><a href="{{ route('subgrupos.show', ['subgrupos' => $subgrupo->id]) }}">{{ $subgrupo->subgrupo_codigo }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="subgrupos-create">
		{!! Form::open(['id' => 'form-subgrupos', 'data-toggle' => 'validator']) !!}
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('subgrupos.show', ['subgrupos' => $subgrupo->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>

			<div class="box-body" id="render-form-subgrupo">
				{{-- Render form subgrupo --}}
			</div>
		{!! Form::close() !!}
	</div>
@stop