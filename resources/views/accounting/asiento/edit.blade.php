@extends('accounting.asiento.main')

@section('breadcrumb')
	<li><a href="{{ route('asientos.index') }}">Asientos contables</a></li>
	<li><a href="{{ route('asientos.show', ['asientos' => $asiento->id]) }}">{{ $asiento->asiento1_numero }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="asientos-create">
		<div id="render-form-asientos">
			{{-- Render form asientos --}}
		</div>
	</div>
@stop