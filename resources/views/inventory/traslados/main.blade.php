@extends('layout.layout')

@section('title') Traslados de mercancia @stop

@section('content')
    <section class="content-header">
        <h1>
            Traslados de mercancia <small>Administración de traslados de mercancia</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-traslado-tpl">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href="<%- window.Misc.urlFull( Route.route('traslados.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                </div>
                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                    <button type="button" class="btn btn-primary btn-sm btn-block submit-traslado">{{ trans('app.save') }}</button>
                </div>
            </div>
        </div>
        <div class="box-body" id="render-form-traslados">
            <form method="POST" accept-charset="UTF-8" id="form-traslado" data-toggle="validator">
                <div class="box-body">
                    <div class="row">
                        <label for="traslado1_sucursal" class="col-sm-1 control-label">Sucursal</label>
                        <div class="form-group col-sm-3">
                            <select name="traslado1_sucursal" id="traslado1_sucursal" class="form-control change-sucursal-consecutive-koi-component" data-wrapper="traslados-create" data-field="traslado1_numero" data-module="traslados" required>
                                <option value="" selected>Seleccione</option>
                                @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                                    <option value="{{ $key }}" <%- traslado1_sucursal == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="traslado1_numero" class="col-sm-1 control-label">Número</label>
                        <div class="form-group col-sm-2">
                            <input id="traslado1_numero" name="traslado1_numero" placeholder="Número" class="form-control input-sm input-toupper" type="number" required readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label for="traslado1_destino" class="col-sm-1 control-label">Destino</label>
                        <div class="form-group col-sm-3">
                            <select name="traslado1_destino" id="traslado1_destino" class="form-control" required>
                                <option value="" selected>Seleccione</option>
                                @foreach( App\Models\Base\Sucursal::getSucursales() as $key => $value)
                                    <option value="{{ $key }}" <%- traslado1_destino == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>


                        <label for="traslado1_fecha" class="col-sm-1 control-label">Fecha</label>
                        <div class="form-group col-sm-2">
                            <input type="text" id="traslado1_fecha" name="traslado1_fecha" placeholder="Fecha" value="<%- traslado1_fecha %>" class="form-control input-sm datepicker" required>
                        </div>
                    </div>

                    <div class="row">
                        <label for="traslado1_observaciones" class="col-sm-1 control-label">Detalle</label>
                        <div class="form-group col-sm-8">
                            <textarea id="traslado1_observaciones" name="traslado1_observaciones" class="form-control" rows="2" placeholder="Detalle"><%- traslado1_observaciones %></textarea>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Detalle -->
            <div class="box box-success">
                <form method="POST" accept-charset="UTF-8" id="form-item-traslado" data-toggle="validator">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-sm-2 col-md-offset-1">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="producto_codigo">
                                            <i class="fa fa-barcode"></i>
                                        </button>
                                    </span>
                                    <input id="producto_codigo" placeholder="Producto" class="form-control producto-koi-component" name="producto_codigo" type="text" maxlength="15" data-wrapper="traslados-create" data-name="producto_nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-10">
                                <input id="producto_nombre" name="producto_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" maxlength="15" readonly required>
                            </div>
                            <div class="col-sm-1 col-xs-1">
                                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="producto" data-field="producto_codigo">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="form-group col-sm-1 text-right">
                                <label for="traslado2_cantidad" class="control-label">Unidades</label>
                            </div>
                            <div class="form-group col-sm-1">
                                <input id="traslado2_cantidad" name="traslado2_cantidad" class="form-control input-sm" type="number" required>
                            </div>
                            <div class="form-group col-sm-1">
                                <button type="submit" class="btn btn-success btn-sm btn-block">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table id="browse-detalle-traslado-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                        <tr>
                            <th></th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Unidades</th>
                        </tr>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <th class="text-left">Total</th>
                                <td class="text-right" id="total-costo">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="add-traslado2-item-tpl">
        <% if(edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-traslado2-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- producto_codigo %></td>
        <td><%- producto_nombre %></td>
        <td><%- traslado2_cantidad %></td>
    </script>
@stop