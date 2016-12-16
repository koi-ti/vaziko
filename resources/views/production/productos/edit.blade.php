@extends('production.productos.main')

@section('breadcrumb')
	<li><a href="{{ route('productosp.index') }}">Productos</a></li>
	<li><a href="{{ route('productosp.show', ['productosp' => $producto->id]) }}">{{ $producto->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="productosp-create">
		<div id="render-form-productop">
			{{-- Render form productop --}}
		</div>
	</div>
@stop