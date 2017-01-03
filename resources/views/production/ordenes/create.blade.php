@extends('production.ordenes.main')

@section('breadcrumb')
    <li><a href="{{ route('ordenes.index')}}">Ordenes</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-whithout-border" id="ordenes-create">
		<div id="render-form-orden">
			{{-- Render form orden --}}
		</div>
	</div>
@stop