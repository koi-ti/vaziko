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
            <form method="POST" accept-charset="UTF-8" id="form-factura" data-toggle="validator">
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
                            <input id="factura1_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="factura1_tercero" type="text" maxlength="15" data-orden2="factura1_orden" data-name="factura1_tercero_nombre" value="<%- tercero_nit %>" required>
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

                <div class="box-footer with-border">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                            <a href="{{ route('facturas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                        </div>
                        <div class="col-md-2  col-sm-5 col-xs-6 text-right">
                            <button type="button" class="btn btn-primary btn-sm btn-block submit-factura">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </div><br>
            </form>

            <div id="render-detail"></div>
        </div>
    </script>

    <script type="text/template" id="add-detail-factura">
        <div class="box box-success">
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-detail-factura" data-toggle="validator">
                    <div class="row">
                        <label for="factura1_orden" class="col-md-1 col-md-offset-1 control-label text-center">Orden</label>
                        <div class="form-group col-md-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-orden2-component-table" data-field="factura1_orden">
                                        <i class="fa fa-building-o"></i>
                                    </button>
                                </span>
                                <input id="factura1_orden" placeholder="Orden" class="form-control ordenp2-koi-component orden2-change-koi" name="factura1_orden" type="text" maxlength="15" data-name="factura1_orden_beneficiario" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input id="factura1_orden_beneficiario" name="factura1_orden_beneficiario" placeholder="Orden beneficiario" class="form-control input-sm" type="text" readonly required>
                        </div>
                        <div class="form-group col-sm-1">
                            <button type="submit" class="btn btn-success btn-sm btn-block disabled">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- table table-bordered table-striped -->
                    <div class="box-body table-responsive no-padding">
                        <table id="browse-detalle-factura-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th width="5%">Código</th>
                                    <th width="50%">Producto</th>
                                    <th width="10%">Orden</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="5%">Saldo</th>
                                    <th class="text-center" width="5%">Facturado</th>
                                    <th class="text-center" width="10%">V. Unitario</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-factura-item-tpl">
        <td><%- orden2_id %></td>
        <td><%- productop_nombre %></td>
        <td class="text-center"><%- factura2_cantidad %></td>
        <td class="text-right"><%- window.Misc.currency( orden2_total_valor_unitario ) %></td>
        <td class="text-right" id="subtotal_<%- id %>">0</td>
    </script>

    <script type="text/template" id="facturado-item-list-tpl">
        <td class="text-center">
            <a class="btn btn-default btn-xs item-detail-factura-remove" data-resource="<%- id %>">
                <span><i class="fa fa-times"></i></span>
            </a>
        </td>
        <td><%- id %></td>
        <td><%- productop_nombre %></td>
        <td><%- orden_codigo %></td>
        <td>
            <input id="facturado_cantidad_<%- id %>" name="facturado_cantidad_<%- id %>" class="form-control input-sm" type="number" min="0" max="<%- orden2_cantidad %>" value="0" step="1" required>
        </td>
        <td class="text-center"><%- orden2_cantidad %></td>
        <td class="text-center"><%- orden2_facturado %></td>
        <td class="text-right"><%- window.Misc.currency( orden2_total_valor_unitario ) %></td>
    </script>

    <script type="text/template" id="add-detalle-factura-tpl">
        <td><%- factura4_cuota %></td>
    	<td><%- factura4_vencimiento %></td>
        <td><%- window.Misc.currency(factura4_valor) %></td>
        <td><%- window.Misc.currency(factura4_saldo) %></td>
    </script>
@stop
