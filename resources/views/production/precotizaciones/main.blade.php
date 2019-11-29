@extends('layout.layout')

@section('title') Pre-cotizaciones @stop

@section('content')
    @yield ('module')

    <script type="text/template" id="precotizacion-producto-item-list-tpl">
        <td>
            <a href="<%- window.Misc.urlFull( Route.route('precotizaciones.productos.show', {productos: id})) %>" title="Ver producto"><%- id %></a>
        </td>
        <td><%- productop_nombre %></td>
        <td class="text-center"><%- precotizacion2_cantidad %></td>
    </script>
@stop
