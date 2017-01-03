@extends('production.ordenes.main')

@section('breadcrumb')
	<li><a href="{{ route('ordenes.index') }}">Ordenes</a></li>
	<li><a href="{{ route('ordenes.show', ['ordenes' => $orden->id]) }}">{{ $orden->orden_codigo }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-whithout-border" id="ordenes-create">
		<div id="render-form-orden">
			{{-- Render form orden --}}
		</div>
	</div>
@stop