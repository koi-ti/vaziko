@extends('layout.layout')

@section('title') Pre-cotizaciones @stop

@section('content')
    @yield ('module')

    <script type="text/template" id="add-precotizacion-tpl">
        <section class="content-header">
            <h1>
                Pre-cotizaciones <small>Administración de pre-cotizaciones</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
                <li><a href="{{ route('precotizaciones.index') }}">Pre-cotización</a></li>
                <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                    <li><a href="<%- window.Misc.urlFull( Route.route('precotizaciones.show', { precotizaciones: id}) ) %>"><%- precotizacion_codigo %></a></li>
                    <li class="active">Editar</li>
                <% }else{ %>
                    <li class="active">Nueva</li>
                <% } %>
            </ol>
        </section>

        <section class="content">
            <div class="box box-success" id="spinner-main">
                <div class="box-body">
                    <form method="POST" accept-charset="UTF-8" id="form-precotizaciones" data-toggle="validator">
                        <div class="row">
                            <% if( typeof(precotizacion_codigo) !== 'undefined' && !_.isUndefined(precotizacion_codigo) && !_.isNull(precotizacion_codigo) && precotizacion_codigo != '') { %>
                                <label class="col-sm-1 control-label">Código</label>
                                <div class="form-group col-md-1">
                                    <%- precotizacion_codigo %>
                                </div>
                            <% } %>

                            <label for="precotizacion1_fecha" class="col-md-1 control-label">Fecha</label>
                            <div class="form-group col-md-2">
                                <input type="text" id="precotizacion1_fecha" name="precotizacion1_fecha" placeholder="Fecha" class="form-control input-sm datepicker" value="<%- precotizacion1_fecha %>" required>
                            </div>

                            <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                                <div class="form-group col-md-offset-5 col-md-2">
                                    <li class="dropdown pull-right">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            Opciones <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="#" class="close-precotizacion">
                                                    <i class="fa fa-lock"></i>Cerrar pre-cotizacion
                                                </a>
                                                @if( Auth::user()->ability('admin', 'crear', ['module' => 'precotizaciones']) )
                                                    <a role="menuitem" tabindex="-1" href="#" class="clone-precotizacion">
                                                        <i class="fa fa-clone"></i>Clonar pre-cotización
                                                    </a>
                                                    {{--<a role="menuitem" tabindex="-1" href="#" class="generate-precotizacion">
                                                        <i class="fa fa-envelope-o"></i>Generar cotización
                                                    </a>--}}
                                                @endif
                                            </li>
                                        </ul>
                                    </li>
                                </div>
                            <% } %>
                        </div>
                        <div class="row">
                            <label for="precotizacion1_referencia" class="col-sm-1 control-label">Referencia</label>
                            <div class="form-group col-md-10">
                                <input id="precotizacion1_referencia" value="<%- precotizacion1_referencia %>" placeholder="Referencia" class="form-control input-sm input-toupper" name="precotizacion1_referencia" type="text" maxlength="100" required>
                            </div>
                        </div>

                        <div class="row">
                            <label for="precotizacion1_cliente" class="col-sm-1 control-label">Cliente</label>
                            <div class="form-group col-sm-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="precotizacion1_cliente">
                                            <i class="fa fa-user"></i>
                                        </button>
                                    </span>
                                    <input id="precotizacion1_cliente" placeholder="Cliente" class="form-control tercero-koi-component" name="precotizacion1_cliente" type="text" maxlength="15" data-wrapper="spinner-main" data-name="precotizacion1_cliente_nombre" data-contacto="btn-add-contact" value="<%- tercero_nit %>" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-10">
                                <input id="precotizacion1_cliente_nombre" name="precotizacion1_cliente_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                            </div>
                            <div class="col-sm-1 col-xs-2">
                                <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="tercero" data-field="precotizacion1_cliente">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <label for="tcontacto_nombre" class="col-sm-1 control-label">Contacto</label>
                            <div class="form-group col-sm-5 col-xs-10">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-contacto-component-table" data-field="precotizacion1_contacto" data-name="tcontacto_nombre" data-phone="tcontacto_telefono" data-tercero="btn-add-contact">
                                            <i class="fa fa-address-book"></i>
                                        </button>
                                    </span>
                                    <input id="precotizacion1_contacto" name="precotizacion1_contacto" type="hidden" value="<%- precotizacion1_contacto %>">
                                    <input id="tcontacto_nombre" placeholder="Contacto" class="form-control" name="tcontacto_nombre" type="text" value="<%- tcontacto_nombre %>" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-1 col-xs-2">
                                <button type="button" id="btn-add-contact" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="contacto" data-field="precotizacion1_contacto" data-name="tcontacto_nombre" data-tercero="<%- precotizacion1_cliente %>" data-phone="tcontacto_telefono">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <label for="tcontacto_telefono" class="col-sm-1 control-label">Teléfono</label>
                            <div class="form-group col-md-3">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input id="tcontacto_telefono" class="form-control input-sm" name="tcontacto_telefono" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask value="<%- tcontacto_telefono %>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="precotizacion1_observaciones" class="col-sm-1 control-label">Detalle</label>
                            <div class="form-group col-sm-10">
                                <textarea id="precotizacion1_observaciones" name="precotizacion1_observaciones" class="form-control" rows="2" placeholder="Detalle"><%- precotizacion1_observaciones %></textarea>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                            <a href="{{ route('precotizaciones.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-6">
                            <button type="button" class="btn btn-primary btn-sm btn-block submit-precotizacion">{{ trans('app.save') }}</button>
                        </div>
                    </div><br>

                    <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                        <div class="box box-success">
                            <div class="box-body">
                                <form method="GET" accept-charset="UTF-8" id="form-productosp3" data-toggle="validator" action="<%- window.Misc.urlFull( Route.route('precotizaciones.productos.create') ) %>">
                                    <div class="row">
                                        <label for="productop" class="control-label col-sm-1 col-md-offset-2">Producto</label>
                                        <div class="form-group col-sm-6 col-xs-11">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-productop-component-table" data-field="productop">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                                <input type="hidden" id="precotizacion" name="precotizacion" value="<%- id %>" required>
                                                <input type="hidden" id="productop" name="productop" data-name="productop_name" required>
                                                <input name="productop_name" id="productop_name" class="form-control" readonly required>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-1">
                                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- table table-bordered table-striped -->
                                <div class="box-body table-responsive no-padding">
                                    <table id="browse-precotizacion-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="2%"></th>
                                                @if( Auth::user()->ability('admin', 'crear', ['module' => 'precotizaciones']) )
                                                    <th width="2%"></th>
                                                @endif
                                                <th width="5%">Código</th>
                                                <th width="60%">Nombre</th>
                                                <th width="5%">Cantidad</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <% } %>
                </div>
            </div>
        </section>
    </script>

    <script type="text/template" id="precotizacion-productop-delete-confirm-tpl">
        <p>¿Está seguro que desea eliminar el producto <b><%- productop_nombre %></b>?</p>
    </script>

    <script type="text/template" id="precotizacion-close-confirm-tpl">
        <p>¿Está seguro que desea cerrar la pre-cotización <b><%- precotizacion_codigo %></b>?</p>
    </script>

    <script type="text/template" id="precotizacion-generate-confirm-tpl">
        <p>¿Está seguro que desea generar la cotización <b><%- precotizacion_codigo %> - <%- precotizacion_referencia %></b>?</p>
    </script>

    <script type="text/template" id="precotizacion-clone-confirm-tpl">
        <p>¿Está seguro que desea clonar la pre-cotización <b><%- precotizacion_codigo %></b>?</p>
    </script>

    <script type="text/template" id="precotizacion-productop-clone-confirm-tpl">
        <p>¿Está seguro que desea clonar el producto <b><%- precotizacion2_codigo %> - <%- productop_nombre %></b>?</p>
    </script>

    <script type="text/template" id="precotizacion-producto-item-list-tpl">
        <% if(edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-precotizacion-producto-remove" data-resource="<%- id %>" title="Eliminar producto">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            @if( Auth::user()->ability('admin', 'crear', ['module' => 'precotizaciones']) )
                <td class="text-center">
                    <a class="btn btn-default btn-xs item-precotizacion-producto-clone" data-resource="<%- id %>" title="Clonar producto">
                        <span><i class="fa fa-clone"></i></span>
                    </a>
                </td>
            @endif
        <% } %>
        <td>
            <a href="<%- window.Misc.urlFull( Route.route('precotizaciones.productos.show', {productos: id}) ) %>" title="Ver producto"><%- id %></a>
        </td>
        <td><%- productop_nombre %></td>
        <td class="text-center"><%- precotizacion2_cantidad %></td>
    </script>
@stop
