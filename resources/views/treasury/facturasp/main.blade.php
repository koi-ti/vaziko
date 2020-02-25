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
        <td class="text-center"><%- facturap2_cuota %></td>
        <td class="text-center"><%- facturap2_vencimiento %></td>
        @ability ('precios' | 'facturasp')
            <td class="text-right"><%- window.Misc.currency(facturap2_saldo) %></td>
        @endability
    </script>
@stop
