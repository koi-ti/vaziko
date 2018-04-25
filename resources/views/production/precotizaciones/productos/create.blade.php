@extends('production.precotizaciones.productos.main')

@section('breadcrumb')
	<li><a href="{{ route('precotizaciones.index') }}">Pre-cotización</a></li>
	<li><a href="{{ route('precotizaciones.edit', ['precotizacion' => $precotizacion->id]) }}">{{ $precotizacion->precotizacion_codigo }}</a></li>
	<li class="active">Producto</li>
@stop

@section('module')
	<div class="box box-success" id="precotizaciones-productos-create">
		<div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('precotizaciones.edit', ['precotizacion' => $precotizacion->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-precotizacion2">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>

        <div class="box-body" id="render-form-precotizacion-producto">
			{{-- Render form precotizacion-producto --}}
		</div>
	</div>
@stop
