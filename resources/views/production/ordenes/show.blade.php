@extends('production.ordenes.main')

@section('module')
    <section class="content-header">
        <h1>
            Ordenes de producción <small>Administración de ordenes de producción</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li><a href="{{ route('ordenes.index')}}">Orden</a></li>
            <li class="active">{{ $orden->orden_codigo }}</li>
        </ol>
    </section>

    @if (isset($data))
        @include("production.ordenes.show.operario")
    @else
        @include("production.ordenes.show.normal")
    @endif
@stop
