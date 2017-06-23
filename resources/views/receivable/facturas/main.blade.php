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

    <script type="text/template" id="add-facturas-tpl" >
        <div class="box-body">
            <form method="POST" accept-charset="UTF-8" id="form-factura1" data-toggle="validator">
                <div class="row">
                    <label for="factura1_fecha" class="col-md-1 control-label">Fecha</label>
                    <div class="form-group col-md-2">
                        <input type="text" id="factura1_fecha" name="factura1_fecha" placeholder="Fecha" class="form-control input-sm datepicker"  value="<%- factura1_fecha %>" required>
                    </div>

                    <label for="factura1_fecha_vencimiento" class="col-md-1 control-label">Vencimiento</label>
                    <div class="form-group col-md-2">
                        <input type="text" id="factura1_fecha_vencimiento" name="factura1_fecha_vencimiento" placeholder="Vencimiento" class="form-control input-sm datepicker" value="<%- factura1_fecha_vencimiento %>" required>
                    </div>

                    <label for="factura1_puntoventa" class="col-md-1 control-label">Punto de venta</label>
                    <div class="form-group col-md-3">
                        <select name="factura1_puntoventa" id="factura1_puntoventa" class="form-control" required>
                            <option value="" selected>Seleccione</option>
                            @foreach( App\Models\Base\PuntoVenta::getPuntosVenta() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="factura1_tercero" class="col-sm-1 col-md-1 control-label">Cliente</label>
                    <div class="form-group col-sm-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table " data-field="factura1_tercero">
                                    <i class="fa fa-user"></i>
                                </button>
                            </span>
                            <input id="factura1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="factura1_tercero" type="text" maxlength="15" data-name="factura1_tercero_nombre" value="<%- tercero_nit %>" required>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-5 col-xs-10">
                        <input id="factura1_tercero_nombre" name="factura1_tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                    </div>

                    <label for="factura1_cuotas" class="col-md-1 control-label">Cuotas</label>
                    <div class="form-group col-sm-1 col-md-1">     
                        <input id="factura1_cuotas" name="factura1_cuotas" class="form-control input-sm" type="number" min="1" step="1" value="1" required>
                    </div>  
                </div>
                <div class="row">
                    <label for="factura1_beneficiario" class="col-md-1 control-label">Orden</label>
                    <div class="form-group col-md-2 col-sm-8 col-xs-8">
                        <div class="input-group input-group-sm">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat btn-koi-search-orden-component-table" data-field="factura1_orden">
                                    <i class="fa fa-building-o"></i>
                                </button>
                            </span>
                            <input id="factura1_orden" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="factura1_orden" type="text" maxlength="15" data-factura="true" data-name="factura1_orden_beneficiario" required>
                        </div>
                    </div>
                    <div class="col-sm-5 col-md-5 col-xs-10">
                        <input id="factura1_orden_beneficiario" name="factura1_orden_beneficiario" placeholder="Tercero" class="form-control input-sm" type="text" readonly required>
                    </div>
                </div>
                
                <div class="box-footer with-border">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                            <a href="{{ route('facturas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                        </div>
                        <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </div>

                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding form-group">
                    <table id="browse-detalle-factura-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">Código</th>
                                <th width="60%">Producto</th>
                                <th width="10%">Cantidad</th>
                                <th width="5%">Saldo</th>
                                <th class="text-center" width="5%">Facturado</th>
                                <th class="text-center" width="10%">V. Unitario</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Render content ordenes --}}
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </script>

    <script type="text/template" id="add-factura-item-tpl">
        <td><%- orden2_id %></td>
        <td><%- productop_nombre %></td>
        <td class="text-center"><%- factura2_cantidad %></td>
        <td class="text-center"><%- window.Misc.currency( orden2_precio_venta ) %></td>
        <td class="text-right" id="subtotal_<%- id %>">0</td>
    </script>

    <script type="text/template" id="facturado-item-list-tpl">
        <td><%- id %></td>
        <td><%- productop_nombre %>
            <div id="render_comments_<%- id %>"></div>
        </td>
        <td>
            <input id="facturado_cantidad_<%- id %>" name="facturado_cantidad_<%- id %>" class="form-control input-sm" type="number" min="0" max="<%- orden2_cantidad %>" value="0" step="1" required>
        </td>
        <td class="text-center"><%- orden2_cantidad %></td>
        <td class="text-center"><%- orden2_facturado %></td>
        <td><%- window.Misc.currency( orden2_precio_venta ) %></td>
    </script>
@stop