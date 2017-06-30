@extends('layout.layout')

@section('title') Cotizaciones @stop

@section('content')
    @yield ('module')

   {{-- Templates --}}
    <script type="text/template" id="add-cotizacion-tpl">
        <section class="content-header">
            <h1>
                Cotizaciones <small>Administración de cotiaziones</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
                    <li><a href="{{ route('cotizaciones.index') }}">Cotizaciones</a></li>
                <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                    <li><a href="<%- window.Misc.urlFull( Route.route('cotizaciones.show', { cotizaciones: id}) ) %>"><%- id %></a></li>
                    <li class="active">Editar</li>
                <% }else{ %>
                    <li class="active">Nuevo</li>
                <% } %>
            </ol>
        </section>

        <section class="content">
            <div class="box box-success" id="spinner-main">
                <div class="box-body">
                    <form method="POST" accept-charset="UTF-8" id="form-cotizacion" data-toggle="validator">
                        <div class="row">
                            <label for="cotizacion1_numero" class="col-sm-1 control-label">Número</label>
                            <div class="form-group col-sm-1">
                                <input id="cotizacion1_numero" name="cotizacion1_numero" value="<%- cotizacion1_numero %>" placeholder="Número" class="form-control input-sm input-toupper" type="number" min="0" step="1" required>
                            </div>

                            <label for="cotizacion1_ano" class="col-sm-1 control-label">Año</label>
                            <div class="form-group col-sm-1">
                                <input id="cotizacion1_ano" value="<%- cotizacion1_ano %>" placeholder="Año" class="form-control input-sm input-toupper" name="cotizacion1_ano" type="number" maxlength="4" data-minlength="4" required>
                            </div>

                            <label for="cotizacion1_fecha" class="col-sm-1 control-label">Fecha</label>
                            <div class="form-group col-md-2 col-sm-4 col-xs-4">
                                <input type="text" id="cotizacion1_fecha" name="cotizacion1_fecha" class="form-control text-center input-sm datepicker" value="<%- cotizacion1_fecha %>" required>
                            </div>

                            <label for="cotizacion1_entrega" class="col-sm-1 control-label">F. Entrega</label>
                            <div class="form-group col-md-2 col-sm-4 col-xs-4">
                                <input type="text" id="cotizacion1_entrega" name="cotizacion1_entrega" class="form-control text-center input-sm datepicker" value="<%- cotizacion1_entrega %>" required>
                            </div>
                        </div>

                        <div class="row">
                            <label for="cotizacion1_cliente" class="col-sm-1 control-label">Cliente</label>
                            <div class="form-group col-sm-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="cotizacion1_cliente">
                                            <i class="fa fa-user"></i>
                                        </button>
                                    </span>
                                    <input id="cotizacion1_cliente" placeholder="Documento" class="form-control tercero-koi-component" name="cotizacion1_cliente" type="text" maxlength="15" data-wrapper="spinner-main" data-contacto="btn-add-contact" data-name="cotizacion1_cliente_nombre" value="<%- tercero_nit %>" required>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input id="cotizacion1_cliente_nombre" name="cotizacion1_cliente_nombre" placeholder="Nombre Cliente" class="form-control input-sm" type="text" maxlength="15" value="<%- tercero_nombre %>" readonly required>
                            </div>
                        </div>

                        <div class="row">
                            <label for="tcontacto_nombre" class="col-sm-1 control-label">Contacto</label>
                            <div class="form-group col-md-3 col-sm-2 col-xs-10">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-contacto-component-table" data-field="cotizacion1_contacto" data-name="tcontacto_nombre" data-phone="tcontacto_telefono" data-tercero="btn-add-contact">
                                            <i class="fa fa-address-book"></i>
                                        </button>
                                    </span>
                                    <input id="cotizacion1_contacto" name="cotizacion1_contacto" type="hidden" value="<%- cotizacion1_contacto %>">
                                    <input id="tcontacto_nombre" placeholder="Contacto" class="form-control" name="tcontacto_nombre" type="text" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1 col-xs-2">
                                <button type="button" id="btn-add-contact" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="contacto" data-field="cotizacion1_contacto" data-name="tcontacto_nombre" data-tercero="<%- cotizacion1_cliente %>" data-phone="tcontacto_telefono">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <label for="tcontacto_telefono" class="col-sm-1 control-label">Teléfono</label>
                            <div class="form-group col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input id="tcontacto_telefono" class="form-control input-sm" name="tcontacto_telefono" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="cotizacion1_descripcion" class="col-sm-1 control-label">Descripcion</label>
                            <div class="form-group col-sm-8">
                                <textarea id="cotizacion1_descripcion" name="cotizacion1_descripcion" class="form-control" rows="2" placeholder="Descripcion"><%- cotizacion1_descripcion %></textarea>
                            </div>
                        </div>

                        <div class="box-footer with-border">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                                    <a href="<%- window.Misc.urlFull( edit ? Route.route('cotizaciones.show', { cotizaciones: id}) : Route.route('cotizaciones.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                                </div>
                            </div>
                        </div><br>
                    </form>

                    <div id="render-detalle"></div>
                </div>
            </div>
        </section>
    </script>

    <script type="text/template" id="add-detalle-cotizacion-tpl">
        <div class="box box-success">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Seleccione un tipo</h3>
                            </div>

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                                        <h4><a class="btn btn-default add-producto">Producto</a></h4>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                                        <h4><a class="btn btn-default add-producto">Material</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- table table-bordered table-striped -->
        <div class="box-body table-responsive no-padding" hidden>
            <table id="browse-cotizacion2-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Producto</th>
                        <th>Material</th>
                        <th>Medida</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <th class="text-left">Total</th>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="box box-success">
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-cotizacion3" data-toggle="validator">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="cotizacion3_areap" class="control-label">Área</label>
                            <select name="cotizacion3_areap" id="cotizacion3_areap" class="form-control select2-default-clear" required>
                                <option value="" selected>Seleccione</option>
                                @foreach( App\Models\Production\Areap::getAreas() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="cotizacion3_nombre" class="control-label">Nombre</label>
                            <input id="cotizacion3_nombre" name="cotizacion3_nombre" placeholder="Nombre" class="form-control input-sm input-toupper" type="text" required maxlength="20">
                        </div>
                        
                        <div class="form-group col-sm-2">
                            <label for="cotizacion3_horas" class="control-label">Horas</label>
                            <input id="cotizacion3_horas" name="cotizacion3_horas" placeholder="Horas" class="form-control input-sm" type="number" step="1" min="0" required>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="cotizacion3_valor" class="control-label">Valor</label>
                            <input id="cotizacion3_valor" name="cotizacion3_valor" placeholder="Nombre" class="form-control input-sm" type="text" required data-currency>
                        </div>
                        <div class="form-group col-sm-1"><br>
                            <button type="submit" class="btn btn-success btn-sm btn-block disabled">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>  
                    </div>
                </form>
            </div>
        </div>

        <!-- table table-bordered table-striped -->
        <div class="box-body table-responsive no-padding">
            <table id="browse-cotizacion3-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Área</th>
                        <th>Nombre</th>
                        <th>Horas</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <th class="text-left">Total</th>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div> 
    </script>

    <script type="text/template" id="detalle-item-list-tpl">
        <% if(edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-cotizacion2-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- cotizacion2_productoc %></td>
        <td><%- materialp_nombre %></td>
        <td><%- cotizacion2_medida %></td>
        <td><%- cotizacion2_cantidad %></td>
        <td><%- windows.Misc.currency( cotizacion2_valor ) %></td>
    </script>

    <script type="text/template" id="detalle-area-item-list-tpl">
        <% if(edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-cotizacion3-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- areap_nombre %></td>
        <td><%- cotizacion3_nombre %></td>
        <td><%- cotizacion3_horas %></td>
        <td><%- windows.Misc.currency( cotizacion3_valor ) %></td>
    </script>

   <!--  <form method="POST" accept-charset="UTF-8" id="form-cotizacion2" data-toggle="validator">
    <div class="row">
        <label for="cotizacion2_productoc" class="col-sm-1 control-label">Producto</label>
        <div class="form-group col-sm-5">
            <input id="cotizacion2_productoc" name="cotizacion2_productoc" placeholder="Nombre" class="form-control input-sm input-toupper" type="text" required>
        </div>

        <label for="cotizacion2_materialp" class="col-sm-1 control-label text-right">Material</label>
        <div class="form-group col-md-4">
            <select name="cotizacion2_materialp" id="cotizacion2_materialp" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('materialesp.index'))%>" data-placeholder="Seleccione" placeholder="Seleccione">
            </select>
        </div>
    </div>
    <div class="row">
        <label for="cotizacion2_medida" class="col-sm-1 control-label">Medida</label>
        <div class="form-group col-sm-4">
            <input id="cotizacion2_medida" name="cotizacion2_medida" placeholder="Medida" class="form-control input-sm input-toupper" type="text" required maxlength="25">
        </div>

        <label for="cotizacion2_cantidad" class="col-sm-1 control-label text-right">Cantidad</label>
        <div class="form-group col-sm-2">
            <input id="cotizacion2_cantidad" name="cotizacion2_cantidad" placeholder="Cantidad" class="form-control input-sm" type="number" min="0" step="1" required>
        </div>

        <label for="cotizacion2_valor" class="col-sm-1 control-label text-right">Valor</label>
        <div class="form-group col-sm-2">
            <input id="cotizacion2_valor" name="cotizacion2_valor" class="form-control input-sm" type="text" required data-currency>
        </div>
        <div class="form-group col-sm-1">
            <button type="submit" class="btn btn-success btn-sm btn-block disabled">
                <i class="fa fa-plus"></i>
            </button>
        </div>                                
    </div>
</form> -->

@stop