@extends('production.productos.main')

@section('breadcrumb')
    <li><a href="{{ route('productosp.index')}}">Productos</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="productosp-create">
		<div id="render-form-productop">
			{{-- Render form productop --}}
		</div>
	</div>
@stop