@extends('admin.roles.main')

@section('breadcrumb')
	<li><a href="{{ route('roles.index') }}">Roles</a></li>
	<li><a href="{{ route('roles.show', ['rol' => $rol->id]) }}">{{ $rol->id }}</a></li>
	<li class="active">Editar</li>
@stop

@section('module')
	<div class="box box-success" id="rol-create">
		<div class="box-body" id="render-form-rol">
			{{-- Render form rol --}}
		</div>
	</div>
@stop