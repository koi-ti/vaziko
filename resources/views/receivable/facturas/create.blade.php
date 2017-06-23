@extends('receivable.facturas.main')

@section('breadcrumb')
	<li><a href="{{ route('facturas.index') }}">Facturas</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="factura-create">
		<div id="render-form-factura">
			{{-- Render form factura --}}
		</div>
	</div>
@stop