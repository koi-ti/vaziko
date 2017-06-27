@extends('layout.layout')

@section('title') Facturas proveedor @stop

@section('content')
    <section class="content-header">
        <h1>
            Facturas proveedor <small>Administración de facturas proveedor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="facturap-item-list-tpl">
        <td><%- facturap2_cuota %></td>
        <td><%- facturap2_vencimiento %></td>
        <td><%- facturap2_saldo %></td>
    </script>
@stop