@extends('admin.puntosventa.main')

@section('breadcrumb')
    <li><a href="{{ route('puntosventa.index')}}">Puntos de venta</a></li>
	<li><a href="{{ route('puntosventa.show', ['puntosventa' => $puntoventa->id]) }}">{{ $puntoventa->puntoventa_nombre }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="puntosventa-create">
		{!! Form::open(['id' => 'form-puntosventa', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-puntosventa">
				{{-- Render form puntosventa --}}
			</div>

			 <div class="box-footer with-border">
	        	<div class="row">
					<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('puntosventa.show', ['puntosventa' => $puntoventa->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@stop
