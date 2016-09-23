@extends('accounting.asiento.main')

@section('breadcrumb')
	<li><a href="{{ route('asientos.index') }}">Asientos contables</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="asientos-create">
		<div id="render-form-asientos">
			{{-- Render form asientos --}}
		</div>
	</div>
@stop