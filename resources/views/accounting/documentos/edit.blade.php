@extends('accounting.documentos.main')

@section('breadcrumb')	
	<li><a href="{{route('documentos.index')}}">Documentos</a></li>
	<li><a href="{{ route('documentos.show', ['documentos' => $documento->id]) }}">{{ $documento->documento_codigo }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="documento-create">
		{!! Form::open(['id' => 'form-documento', 'data-toggle' => 'validator']) !!}
	        <div class="box-header with-border">
	        	<div class="row">
					<div class="col-md-2 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('documentos.show', ['documentos' => $documento->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>

			<div class="box-body" id="render-form-documento">
				{{-- Render form documentos --}}
			</div>
		{!! Form::close() !!}
	</div>
@stop