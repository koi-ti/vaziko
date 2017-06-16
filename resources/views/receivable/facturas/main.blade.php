@extends('layout.layout')

@section('title') Facturas @stop

@section('content')
    <section class="content-header">
        <h1>
            Facturas <small>Administración de facturas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-factura-item-tpl">
        <td><%- orden2_id %></td>
        <td><%- productop_nombre %></td>
        <td class="text-center"><%- factura2_cantidad %></td>
        <td class="text-center"><%- window.Misc.currency( orden2_precio_venta ) %></td>
        <td class="text-right" id="subtotal_<%- id %>">0</td>
    </script>
@stop