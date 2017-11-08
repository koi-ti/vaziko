@extends('accounting.folders.main')

@section('breadcrumb')
	<li><a href="{{ route('folders.index') }}">Folders</a></li>
	<li><a href="{{ route('folders.show', ['folders' => $folder->id]) }}">{{ $folder->folder_codigo }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="folder-create">
		{!! Form::open(['id' => 'form-folder', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-folder">
				{{-- Render form folders --}}
			</div>

			<div class="box-footer with-border">
	        	<div class="row">
					<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('folders.show', ['folders' => $folder->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop