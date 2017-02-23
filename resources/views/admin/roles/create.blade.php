@extends('admin.roles.main')

@section('breadcrumb')
    <li><a href="{{ route('roles.index')}}">Roles</a></li>
	<li class="active">Nueva</li>
@stop

@section('module')
	<div class="box box-success" id="rol-create">
		<div class="box-body" id="render-form-rol">
			{{-- Render form roles --}}
		</div>
	</div>
@stop