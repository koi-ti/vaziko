@extends('accounting.asiento.main')

@section('breadcrumb')	
	<li><a href="{{ route('asientos.index') }}">Asientos contables</a></li>
	<li><a href="{{ route('asientos.show', ['asientos' => $asiento->id]) }}">{{ $asiento->asiento1_numero }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="asientos-create">
        <div class="box-header with-border">
        	<div class="row">
				<div class="col-md-2 col-sm-6 col-xs-6 text-left">
					<a href="{{ route('asientos.show', ['asientos' => $asiento->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
				</div>
				<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
					<button type="submit" class="btn btn-primary btn-sm btn-block submit-asiento">{{ trans('app.save') }}</button>
				</div>
			</div>
		</div>

		<div class="box-body" id="render-form-asientos">
			{{-- Render form asientos --}}
		</div>
	</div>
@stop