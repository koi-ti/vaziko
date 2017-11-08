@extends('layout.layout')

@section('title') Subtipos de producto @stop

@section('content')
    <section class="content-header">
        <h1>
            Subtipos de producto <small>Administración subtipos de producto</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>
@stop
