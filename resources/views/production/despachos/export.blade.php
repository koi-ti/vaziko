@extends('reports.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	{{--*/ $empresa = App\Models\Base\Empresa::getEmpresa(); /*--}}

	{{-- Copia 1 --}}
	@include('production.despachos.despacho')

	{{-- Separator --}}
	<div class="margin-bottom-60">&nbsp;</div>

	{{-- Copia 2 --}}
	@include('reports.title')
	<br/>
	@include('production.despachos.despacho')
@stop