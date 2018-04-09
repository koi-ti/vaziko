@extends('layout.layout')

@section('title') Pre-cotizaciones @stop

@section('content')
    <section class="content-header">
        <h1>
            Pre-cotizaciones <small>Administración de pre-cotizaciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-precotizacion-producto-tpl">
        <div class="box box-solid">
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-precotizacion-producto" data-toggle="validator">
                	<div class="row">
                        <label class="col-sm-1 control-label">Pre-cotización</label>
                        <div class="form-group col-md-1">
                        	{{ $precotizacion->precotizacion_codigo }}
                        </div>

                        <label class="col-sm-2 control-label">Código producto</label>
                        <div class="form-group col-md-1">
        					{{ $producto->id }}
        				</div>
                    </div>
                    <div class="row">
                        <label class="col-sm-1 control-label">Producto</label>
                        <div class="form-group col-md-8">
                        	{{ $producto->productop_nombre }}
                        </div>
                        <label for="precotizacion2_cantidad" class="col-sm-1 control-label">Cantidad</label>
                        <div class="form-group col-md-2">
                            <input id="precotizacion2_cantidad" value="<%- precotizacion2_cantidad %>" class="form-control input-sm event-price" name="precotizacion2_cantidad" type="number" min="1" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-12" id="fine-uploader"></div>
                </div><br>

                {{-- Content impresiones --}}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Impresiones</h3>
                    </div>
                    <div class="box-body" id="precotizacion5-wrapper-producto">
                        <form method="POST" accept-charset="UTF-8" id="form-precotizacion5-producto" data-toggle="validator">
                            <div class="row">
                                <div class="form-group col-sm-7">
                                    <input type="text" id="precotizacion5_texto" name="precotizacion5_texto" placeholder="Detalle" class="form-control input-xs" maxlength="150" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <input type="text" id="precotizacion5_alto" name="precotizacion5_alto" placeholder="Alto" class="form-control input-xs" maxlength="10" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <input type="text" id="precotizacion5_ancho" name="precotizacion5_ancho" placeholder="Ancho" class="form-control input-xs" maxlength="10" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-1">
                                    <button type="button" class="btn btn-success btn-sm btn-block submit-precotizacion5">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- table table-bordered table-striped -->
                        <div class="box-body table-responsive no-padding">
                            <table id="browse-precotizacion-producto-impresiones-list" class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="6%"></th>
                                        <th width="70%">Detalle</th>
                                        <th width="12%">Alto</th>
                                        <th width="12%">Ancho</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Content materialesp --}}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Materiales de producción</h3>
                    </div>
                    <div class="box-body" id="precotizacion3-wrapper-producto">
                        <form method="POST" accept-charset="UTF-8" id="form-precotizacion3-producto" data-toggle="validator">
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="precotizacion1_proveedor">
                                                <i class="fa fa-user"></i>
                                            </button>
                                        </span>
                                        <input id="precotizacion1_proveedor" placeholder="Proveedor" class="form-control tercero-koi-component" name="precotizacion1_proveedor" type="text" maxlength="15" data-wrapper="spinner-main" data-name="precotizacion1_proveedor_nombre" required>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input id="precotizacion1_proveedor_nombre" name="precotizacion1_proveedor_nombre" placeholder="Nombre proveedor" class="form-control input-sm" type="text" maxlength="15" readonly required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <select name="precotizacion3_materialp" id="precotizacion3_materialp" class="form-control select2-default-clear" data-placeholder="Material de producción" required>
                                        <option value="">Seleccione</option>
                                        @foreach( App\Models\Production\PreCotizacion3::getMaterials( $producto->id ) as $key => $value )
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <select name="precotizacion3_producto" id="precotizacion3_producto" class="form-control select2-default-clear" data-placeholder="Insumo" disabled>
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-2">
                                    <input type="number" id="precotizacion3_cantidad" name="precotizacion3_cantidad" placeholder="Cantidad" class="form-control input-xs" min="1" step="1" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" id="precotizacion3_medidas" name="precotizacion3_medidas" placeholder="Medidas" class="form-control input-xs" maxlength="50" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <input id="precotizacion3_valor_unitario" name="precotizacion3_valor_unitario" class="form-control input-sm" type="text" required data-currency>
                                </div>
                                <div class="form-group col-sm-1">
                                    <button type="button" class="btn btn-success btn-sm btn-block submit-precotizacion3">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- table table-bordered table-striped -->
                        <div class="box-body table-responsive no-padding">
                            <table id="browse-precotizacion-producto-materiales-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th width="30%">Proveedor</th>
                                        <th width="15%">Material</th>
                                        <th width="15%">Insumo</th>
                                        <th width="10%">Dimensiones</th>
                                        <th width="5%">Cantidad</th>
                                        <th width="10%">Valor unidad</th>
                                        <th width="10%">Valor</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <th class="text-right">Total</th>
                                        <th class="text-right" id="total">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Content areasp --}}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Áreas de producción</h3>
                    </div>
                    <div class="box-body">
                        <form method="POST" accept-charset="UTF-8" id="form-precotizacion6-producto" data-toggle="validator">
                            <div class="row">
                                <div class="form-group col-sm-5 col-md-offset-1">
                                    <select name="precotizacion6_areap" id="precotizacion6_areap" class="form-control select2-default-clear">
                                        <option value="" selected>Seleccione</option>
                                        @foreach( App\Models\Production\Areap::getAreas() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-5">
                                    <input id="precotizacion6_nombre" name="precotizacion6_nombre" placeholder="Nombre" class="form-control input-sm input-toupper" type="text" maxlength="20">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-2 col-md-offset-2">
                                    <input type="number" id="precotizacion6_horas" name="precotizacion6_horas" placeholder="Hora" class="form-control input-xs" min="0" step="1" max="9999" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <input type="number" id="precotizacion6_minutos" name="precotizacion6_minutos" placeholder="Minutos" class="form-control input-xs" min="00" step="01" max="59" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <input id="precotizacion6_valor" name="precotizacion6_valor" class="form-control input-sm" type="text" required data-currency>
                                </div>
                                <div class="form-group col-sm-1">
                                    <button type="button" class="btn btn-success btn-sm btn-block submit-precotizacion6">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- table table-bordered table-striped -->
                        <div class="box-body table-responsive no-padding">
                            <table id="browse-precotizacion-producto-areas-list" class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Área</th>
                                        <th>Nombre</th>
                                        <th colspan="2" class="text-center">Tiempo</th>
                                        <th>Valor</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <th class="text-right">Total</th>
                                        <th class="text-right" id="total">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="precotizacion-delete-materialp-confirm-tpl">
        <p>¿Está seguro que desea eliminar el material <b><%- materialp_nombre %> </b>?</p>
    </script>

    <script type="text/template" id="precotizacion-delete-impresion-confirm-tpl">
        <p>¿Está seguro que desea eliminar la impresion <b><%- precotizacion5_texto %> </b>?</p>
    </script>

    <script type="text/template" id="precotizacion-delete-areap-confirm-tpl">
        <p>¿Está seguro que desea eliminar el area <b><%- precotizacion6_areap %> <%- precotizacion6_nombre %></b>?</p>
    </script>

    <script type="text/template" id="precotizacion-producto-materialp-item-tpl">
        <% if( edit ) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-materialp-precotizacion-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- tercero_nombre %></td>
        <td><%- materialp_nombre %></td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
        <td><%- precotizacion3_medidas %></td>
        <td><%- precotizacion3_cantidad %></td>
        <td class="text-right"><%- window.Misc.currency( precotizacion3_valor_unitario ) %></td>
        <td class="text-right"><%- window.Misc.currency( precotizacion3_valor_total ) %></td>
    </script>

    <script type="text/template" id="precotizacion-producto-impresion-item-tpl">
        <% if( edit ) { %>
           <td class="text-center">
               <a class="btn btn-default btn-xs item-producto-impresion-precotizacion-remove" data-resource="<%- id %>">
                   <span><i class="fa fa-times"></i></span>
               </a>
           </td>
       <% } %>
       <td><%- precotizacion5_texto %></td>
       <td><%- precotizacion5_alto %></td>
       <td><%- precotizacion5_ancho %></td>
    </script>

    <script type="text/template" id="precotizacion-producto-areasp-item-tpl">
        <% if(edit) { %>
           <td class="text-center">
               <a class="btn btn-default btn-xs item-producto-areasp-precotizacion-remove" data-resource="<%- id %>">
                   <span><i class="fa fa-times"></i></span>
               </a>
           </td>
       <% } %>
       <td><%- areap_nombre %></td>
       <td><%- precotizacion6_nombre %></td>
       <td class="form-group col-sm-1">
           <input type="number" id="precotizacion6_horas" name="precotizacion6_horas" placeholder="Hora" value="<%- precotizacion6_horas %>" class="form-control input-xs change-time" data-type="hs" min="0" step="1" max="9999" required>
       </td>
       <td class="form-group col-sm-2">
           <input type="number" id="precotizacion6_minutos" name="precotizacion6_minutos" placeholder="Minutos" value="<%- precotizacion6_minutos %>" class="form-control input-xs change-time" data-type="ms" min="00" step="01" max="59" required>
       </td>
       <td class="text-right"><%- window.Misc.currency( precotizacion6_valor ) %></td>
       <td class="text-right"><%- window.Misc.currency( total ) %></td>
    </script>
@stop
