@extends('admin.terceros.main')

@section('breadcrumb')
	<li><a href="{{ route('terceros.index') }}">Terceros</a></li>
	<li class="active">Editar ({{ $tercero->tercero_nit }})</li>
@stop

@section('module')
	<div class="box box-success" id="tercero-create">
		<div class="box-body" id="render-form-tercero">
			{{-- Render form empresa --}}
		</div>
	</div>
@stop
