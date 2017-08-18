@extends('production.cotizaciones.productos.main')

@section('breadcrumb')
	<li><a href="{{ route('cotizaciones.index') }}">Cotización</a></li>
	<li><a href="{{ route('cotizaciones.edit', ['cotizaciones' => $cotizacion->id]) }}">{{ $cotizacion->cotizacion_codigo }}</a></li>
	<li class="active">Producto</li>
@stop

@section('module')
	<div class="box box-success" id="cotizaciones-productos-create">
		<div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('cotizaciones.edit', ['cotizaciones' => $cotizacion->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-cotizacion2">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>

        <div class="box-body" id="render-form-cotizacion-producto">
			{{-- Render form orden-producto --}}
		</div>
	</div>
@stop
