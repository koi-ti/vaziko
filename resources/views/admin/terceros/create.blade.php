@extends('admin.terceros.main')

@section('breadcrumb')
	<li><a href="{{ route('terceros.index') }}">Terceros</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="tercero-create">
		<div class="box-body" id="render-form-tercero">
			{{-- Render form tercero --}}
		</div>
	</div>
@stop
