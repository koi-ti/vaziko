@extends('production.despachos.layout', ['type' => 'pdf', 'title' => $title])

@section('content')
	@include('production.despachos.despacho')

	{{-- Separator --}}
	<div class="margin-bottom-10">&nbsp;</div>

	@include('production.despachos.despacho')
@stop
