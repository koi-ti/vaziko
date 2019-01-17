@extends('layout.layout')

@section('title') Cotizaciones @stop

@section('content')
    @yield ('module')

    <script type="text/template" id="add-cotizacion-producto-tpl">
        <section class="content-header">
            <h1>
                Cotizaciones <small>Administración de cotizaciones</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
                <li><a href="{{ route('cotizaciones.index') }}">Cotización</a></li>
                <li><a href="{{ route('cotizaciones.edit', ['cotizaciones' => $cotizacion->id]) }}">{{ $cotizacion->cotizacion_codigo }}</a></li>
                <li class="active">Producto</li>
                <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                    <li class="active">Editar</li>
                <% }else{ %>
                    <li class="active">Nuevo</li>
                <% } %>
            </ol>
        </section>

        <section class="content">
            <div class="box box-success" id="spinner-main">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                            <a href="{{ route('cotizaciones.edit', ['cotizaciones' => $cotizacion->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                        </div>
                        <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                            <button type="button" class="btn btn-primary btn-sm btn-block submit-cotizacion2">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="alert alert-danger">
                        <h4><b>Información general</b></h4>
                        <div class="row">
                            <label class="col-md-2 control-label">Referencia</label>
                            <div class="form-group col-md-10">
                                {{ $cotizacion->cotizacion1_referencia }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-2 control-label">Cliente</label>
                            <div class="form-group col-md-10">
                                {{ $cotizacion->tercero_nit }} - {{ $cotizacion->tercero_nombre }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-2 control-label">Cotización</label>
                            <div class="form-group col-md-10">
                                {{ $cotizacion->cotizacion_codigo }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-2 control-label">Código producto</label>
                            <div class="form-group col-md-10">
                                {{ $producto->id }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-2 control-label">Producto</label>
                            <div class="form-group col-md-10">
                                <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                                    <%- productop_nombre %>
                                <% }else{ %>
                                    {{ $producto->productop_nombre }}
                                <% } %>
                            </div>
                        </div>
                    </div>

                    <form method="POST" accept-charset="UTF-8" id="form-cotizacion-producto" data-toggle="validator">
                        <div class="row">
                            <label for="cotizacion2_referencia" class="col-sm-1 control-label">Referencia</label>
                            <div class="form-group col-md-8">
                                <input id="cotizacion2_referencia" value="<%- cotizacion2_referencia %>" placeholder="Referencia" class="form-control input-sm input-toupper" name="cotizacion2_referencia" type="text" maxlength="200" required>
                            </div>

                            <label for="cotizacion2_cantidad" class="col-sm-1 control-label">Cantidad</label>
                            <div class="form-group col-md-2">
                                <input id="cotizacion2_cantidad" value="<%- cotizacion2_cantidad %>" class="form-control input-sm event-price" name="cotizacion2_cantidad" type="number" min="1" required>
                            </div>
                        </div>

                        <div class="row">
                            <label for="cotizacion2_observaciones" class="col-sm-1 control-label">Observaciones</label>
                            <div class="form-group col-md-11">
                                <textarea id="cotizacion2_observaciones" placeholder="Observaciones" class="form-control" rows="2" name="cotizacion2_observaciones"><%- cotizacion2_observaciones %></textarea>
                            </div>
                        </div>

                        @if($producto->productop_abierto || $producto->productop_cerrado)
                            <div class="box box-danger">
                                <div class="box-body">
                                    @if($producto->productop_abierto)
                                        <div class="row">
                                            <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Abierto</label>
                                            <label for="cotizacion2_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    <input id="cotizacion2_ancho" value="<%- cotizacion2_ancho %>" class="form-control input-sm" name="cotizacion2_ancho" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m1_sigla }}</div>
                                            </div>

                                            <label for="cotizacion2_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    <input id="cotizacion2_alto" value="<%- cotizacion2_alto %>" class="form-control input-sm" name="cotizacion2_alto" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m2_sigla }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($producto->productop_cerrado)
                                        <div class="row">
                                            <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Cerrado</label>
                                            <label for="cotizacion2_c_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    <input id="cotizacion2_c_ancho" value="<%- cotizacion2_c_ancho %>" class="form-control input-sm" name="cotizacion2_c_ancho" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m3_sigla }}</div>
                                            </div>

                                            <label for="cotizacion2_c_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    <input id="cotizacion2_c_alto" value="<%- cotizacion2_c_alto %>" class="form-control input-sm" name="cotizacion2_c_alto" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m4_sigla }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_3d)
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="row">
                                        <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">3D</label>
                                        <label for="cotizacion2_3d_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                <input id="cotizacion2_3d_ancho" value="<%- cotizacion2_3d_ancho %>" class="form-control input-sm" name="cotizacion2_3d_ancho" type="number" min="0" step="0.01" required>
                                            </div>
                                            <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m5_sigla }}</div>
                                        </div>

                                        <label for="cotizacion2_3d_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                <input id="cotizacion2_3d_alto" value="<%- cotizacion2_3d_alto %>" class="form-control input-sm" name="cotizacion2_3d_alto" type="number" min="0" step="0.01" required>
                                            </div>
                                            <div class="col-xs-2 col-md-3 text-left">{{ $producto->m6_sigla }}</div>
                                        </div>

                                        <label for="cotizacion2_3d_profundidad" class="col-xs-2 col-sm-1 control-label text-right">Profundidad</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                <input id="cotizacion2_3d_profundidad" value="<%- cotizacion2_3d_profundidad %>" class="form-control input-sm" name="cotizacion2_3d_profundidad" type="number" min="0" step="0.01" required>
                                            </div>
                                            <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m7_sigla }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_tiro || $producto->productop_retiro)
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3 col-xs-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"></th>
                                                        <th class="text-center">C</th>
                                                        <th class="text-center">M</th>
                                                        <th class="text-center">Y</th>
                                                        <th class="text-center">K</th>
                                                        <th class="text-center">P1</th>
                                                        <th class="text-center">P2</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($producto->productop_tiro)
                                                        <tr>
                                                            <th class="text-center">T <input type="checkbox" id="cotizacion2_tiro" name="cotizacion2_tiro" value="cotizacion2_tiro" <%- parseInt(cotizacion2_tiro) ? 'checked': ''%>></th>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_yellow" name="cotizacion2_yellow" value="cotizacion2_yellow" <%- parseInt(cotizacion2_yellow) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_magenta" name="cotizacion2_magenta" value="cotizacion2_magenta" <%- parseInt(cotizacion2_magenta) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_cyan" name="cotizacion2_cyan" value="cotizacion2_cyan" <%- parseInt(cotizacion2_cyan) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_key" name="cotizacion2_key" value="cotizacion2_key" <%- parseInt(cotizacion2_key) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_color1" name="cotizacion2_color1" value="cotizacion2_color1" <%- parseInt(cotizacion2_color1) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_color2" name="cotizacion2_color2" value="cotizacion2_color2" <%- parseInt(cotizacion2_color2) ? 'checked': ''%>></td>
                                                        </tr>
                                                    @endif
                                                    @if($producto->productop_retiro)
                                                        <tr>
                                                            <th class="text-center">R <input type="checkbox" id="cotizacion2_retiro" name="cotizacion2_retiro" value="cotizacion2_retiro" <%- parseInt(cotizacion2_retiro) ? 'checked': ''%>></th>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_yellow2" name="cotizacion2_yellow2" value="cotizacion2_yellow2" <%- parseInt(cotizacion2_yellow2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_magenta2" name="cotizacion2_magenta2" value="cotizacion2_magenta2" <%- parseInt(cotizacion2_magenta2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_cyan2" name="cotizacion2_cyan2" value="cotizacion2_cyan2" <%- parseInt(cotizacion2_cyan2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_key2" name="cotizacion2_key2" value="cotizacion2_key2" <%- parseInt(cotizacion2_key2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_color12" name="cotizacion2_color12" value="cotizacion2_color12" <%- parseInt(cotizacion2_color12) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="cotizacion2_color22" name="cotizacion2_color22" value="cotizacion2_color22" <%- parseInt(cotizacion2_color22) ? 'checked': ''%>></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @if($producto->productop_tiro)
                                            <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                                <label for="cotizacion2_nota_tiro" class="control-label">Nota tiro</label>
                                                <textarea id="cotizacion2_nota_tiro" name="cotizacion2_nota_tiro" class="form-control" rows="2" placeholder="Nota tiro"><%- cotizacion2_nota_tiro %></textarea>
                                            </div>
                                        @endif

                                        @if($producto->productop_retiro)
                                            <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                                <label for="cotizacion2_nota_retiro" class="control-label">Nota retiro</label>
                                                <textarea id="cotizacion2_nota_retiro" name="cotizacion2_nota_retiro" class="form-control" rows="2" placeholder="Nota retiro"><%- cotizacion2_nota_retiro %></textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            {{-- Content maquinas --}}
                            <div class="col-sm-6">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Máquinas de producción</h3>
                                    </div>
                                    <div class="box-body" id="browse-cotizacion-producto-maquinas-list">
                                        {{-- render maquinas list --}}
                                    </div>
                                </div>
                            </div>

                            {{-- Content acabados --}}
                            <div class="col-sm-6">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Acabados de producción</h3>
                                    </div>
                                    <div class="box-body" id="browse-cotizacion-producto-acabados-list">
                                        {{-- render acabados list --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Fórmulas</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <label for="cotizacion2_precio_formula" class="col-sm-1 control-label">Fórmula</label>
                                        <div class="form-group col-md-6">
                                            <input id="cotizacion2_precio_formula" value="<%- cotizacion2_precio_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_precio_formula" type="text" maxlength="200" data-input="P">
                                        </div>
                                        <label for="cotizacion2_precio_venta" class="col-sm-1 control-label">Precio</label>
                                        <div class="form-group col-md-4">
                                            <input id="cotizacion2_precio_venta" value="<%- cotizacion2_precio_venta %>" placeholder="Precio" class="form-control input-sm event-price" name="cotizacion2_precio_venta" type="text" maxlength="30" data-currency required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="cotizacion2_transporte_formula" class="col-sm-1 control-label">Fórmula</label>
                                        <div class="form-group col-md-6">
                                            <input id="cotizacion2_transporte_formula" value="<%- cotizacion2_transporte_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_transporte_formula" type="text" maxlength="200" data-input="T">
                                        </div>
                                        <label for="cotizacion2_transporte" class="col-sm-1 control-label">Transporte</label>
                                        <div class="form-group col-md-4">
                                            <input id="cotizacion2_transporte" value="<%- cotizacion2_transporte %>" class="form-control input-sm event-price" name="cotizacion2_transporte" type="text" maxlength="30" data-currency>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="cotizacion2_viaticos_formula" class="col-sm-1 control-label">Fórmula</label>
                                        <div class="form-group col-md-6">
                                            <input id="cotizacion2_viaticos_formula" value="<%- cotizacion2_viaticos_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_viaticos_formula" type="text" maxlength="200" data-input="V">
                                        </div>
                                        <label for="cotizacion2_viaticos" class="col-sm-1 control-label">Viáticos</label>
                                        <div class="form-group col-md-4">
                                            <input id="cotizacion2_viaticos" value="<%- cotizacion2_viaticos %>" class="form-control input-sm event-price" name="cotizacion2_viaticos" type="text" maxlength="30" data-currency>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Imágenes</h3>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <div class="fine-uploader"></div>
                            </div>
                        </div>
                    </form>

                    @if( $cotizacion->cotizacion1_precotizacion )
                        {{-- Content impresiones --}}
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Impresiones</h3>
                            </div>
                            <div class="box-body" id="cotizacion7-wrapper-producto">
                                <!-- table table-bordered table-striped -->
                                <div class="box-body table-responsive no-padding">
                                    <table id="browse-cotizacion-producto-impresiones-list" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="70%">Detalle</th>
                                                <th width="12%">Ancho</th>
                                                <th width="12%">Alto</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Content materialesp --}}
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Materiales de producción</h3>
                        </div>
                        <div class="box-body" id="cotizacion4-wrapper-producto">
                            <form method="POST" accept-charset="UTF-8" id="form-cotizacion4-producto" data-toggle="validator">
                                <div class="row">
                                    @foreach( App\Models\Production\Cotizacion4::getMaterials( $producto->id ) as $key => $value )
                                        <div class="form-group col-md-4">
                                            <label>{{ $value }}</label>
                                        </div>
                                    @endforeach
                                </div><br>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <select name="cotizacion4_materialp" id="cotizacion4_materialp" class="form-control select2-default-clear" data-placeholder="Material de producción" required>
                                            <option value="">Seleccione</option>
                                            @foreach( App\Models\Production\Cotizacion4::getMaterials( $producto->id ) as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <select name="cotizacion4_producto" id="cotizacion4_producto" class="form-control select2-default-clear" data-placeholder="Insumo" disabled required>
                                            <option value="">Seleccione</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-2">
                                        <input type="number" id="cotizacion4_cantidad" name="cotizacion4_cantidad" placeholder="Cantidad" class="form-control input-xs" min="0" step="0.01" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="text" id="cotizacion4_medidas" name="cotizacion4_medidas" placeholder="Medidas" class="form-control input-xs" maxlength="50" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="cotizacion4_valor_unitario" name="cotizacion4_valor_unitario" class="form-control input-sm" type="text" required data-currency>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="button" class="btn btn-success btn-sm btn-block submit-cotizacion4">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- table table-bordered table-striped -->
                            <div class="box-body table-responsive no-padding">
                                <table id="browse-cotizacion-producto-materiales-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th width="25%">Material</th>
                                            <th width="25%">Insumo</th>
                                            <th width="10%">Dimensiones</th>
                                            <th width="5%">Cantidad</th>
                                            <th width="15%">Valor unidad</th>
                                            <th width="15%">Valor</th>
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
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Áreas de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-cotizacion6-producto" data-toggle="validator">
                                <div class="row">
                                    <div class="form-group col-sm-5 col-md-offset-1">
                                        <select name="cotizacion6_areap" id="cotizacion6_areap" class="form-control select2-default-clear" data-placeholder="Áreas de producción">
                                            <option value="" selected>Seleccione</option>
                                            @foreach( App\Models\Production\Areap::getAreas() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-5">
                                        <input id="cotizacion6_nombre" name="cotizacion6_nombre" placeholder="Nombre" class="form-control input-sm input-toupper" type="text" maxlength="20">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-2 col-md-offset-2">
                                        <input type="number" id="cotizacion6_horas" name="cotizacion6_horas" placeholder="Hora" class="form-control input-xs" min="0" step="1" max="9999" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <input type="number" id="cotizacion6_minutos" name="cotizacion6_minutos" placeholder="Minutos" class="form-control input-xs" min="00" step="01" max="59" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="cotizacion6_valor" name="cotizacion6_valor" class="form-control input-sm" type="text" required data-currency>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="button" class="btn btn-success btn-sm btn-block submit-cotizacion6">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- table table-bordered table-striped -->
                            <div class="box-body table-responsive no-padding">
                                <table id="browse-cotizacion-producto-areas-list" class="table table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th width="30%">Área</th>
                                            <th width="30%">Nombre</th>
                                            <th width="20%" class="text-center">Tiempo</th>
                                            @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                                                <th width="10%">Valor</th>
                                                <th width="10%">Total</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <th class="text-right">Total</th>
                                                <th class="text-right" id="total">0</th>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="box box-danger">
                            <div class="box-body">
                                <div class="list-group">
                                    <div class="list-group-item list-group-item-info">
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2"><b>Precio</b></div>
                                            <div class="col-xs-10 col-sm-10 text-right"><b><span id="info-precio"></span></b></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-info">
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2"><b>Transporte</b></div>
                                            <div class="col-xs-10 col-sm-10 text-right"><b><span id="info-transporte"></span></b></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-info">
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2"><b>Viáticos</b></div>
                                            <div class="col-xs-10 col-sm-10 text-right"><b><span id="info-viaticos"></span></b></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-info">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-3 text-left"><b>Materiales <small>(%)</small></b></div>
                                            <div class="col-xs-3 col-sm-2 text-left">
                                                <input id="cotizacion2_margen_materialp" name="cotizacion2_margen_materialp" class="form-control input-sm event-price" value="<%- cotizacion2_margen_materialp %>" type="number" min="0" max="100" step="0.1">
                                            </div>
                                            <div class="col-xs-5 col-sm-7 text-right"><b><span id="info-materiales"></span></b></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-info">
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2"><b>Áreas</b></div>
                                            <div class="col-xs-10 col-sm-10 text-right"><b><span id="info-areas"></span></b></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-success">
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2"><b>Subtotal</b></div>
                                            <div class="col-xs-10 col-sm-10 text-right">
                                                <span class="pull-right badge bg-red" id="subtotal-price"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-success">
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-2"><b>Volumen</b></div>
                                            <div class="col-xs-3 col-sm-2">
                                                <input id="cotizacion2_volumen" name="cotizacion2_volumen" class="form-control input-sm event-price" value="<%- cotizacion2_volumen %>" type="number" min="0" max="99">
                                            </div>
                                            <div class="col-xs-3 col-sm-2"><b>Redondear</b></div>
                                            <div class="col-xs-3 col-sm-2">
                                                <input id="cotizacion2_round" name="cotizacion2_round" class="form-control input-sm event-price" value="<%- cotizacion2_round %>" type="number" min="-3" max="3" step="1" title="Si el digito se encuentra en 0, sera redondeado automaticamente">
                                            </div>
                                            <div class="col-xs-12 col-sm-4 text-right">
                                                <span class="pull-right badge bg-red" id="cotizacion2_vtotal"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-success">
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2"><b>Total</b></div>
                                            <div class="col-xs-10 col-sm-10 text-right">
                                                <span class="pull-right badge bg-red" id="total-price"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <p><b>Los campos de transporte, viáticos, materiales y áreas se dividirán por la cantidad ingresada.</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </script>

    {{-- Templates para materialp --}}
    <script type="text/template" id="cotizacion-delete-materialp-confirm-tpl">
        <p>¿Está seguro que desea eliminar el material <b><%- materialp_nombre %> </b>?</p>
    </script>

    <script type="text/template" id="cotizacion-producto-materialp-item-tpl">
        <% if( edit ) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-materialp-cotizacion-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-materialp-cotizacion-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- materialp_nombre %></td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
        <td><%- cotizacion4_medidas %></td>
        <td><%- cotizacion4_cantidad %></td>
        <td class="text-right"><%- window.Misc.currency( cotizacion4_valor_unitario ) %></td>
        <td class="text-right"><%- window.Misc.currency( cotizacion4_valor_total ) %></td>
    </script>

    <script type="text/template" id="edit-materialproducto-tpl">
        <div class="row">
            <label class="col-sm-1 control-label">Material</label>
            <div class="form-group col-sm-4">
                <label class="label-xs"><%- materialp_nombre %></label>
            </div>

            <label class="col-sm-1 control-label">Insumo</label>
            <div class="form-group col-sm-6">
                <label class="label-xs"><%- producto_nombre %></label>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-1 control-label">Cantidad</label>
            <div class="form-group col-sm-2">
                <input type="number" id="cotizacion4_cantidad" name="cotizacion4_cantidad" placeholder="Cantidad" value="<%- cotizacion4_cantidad %>" class="form-control input-xs" min="0" step="0.01" required>
                <div class="help-block with-errors"></div>
            </div>

            <label class="col-sm-1 control-label">Medidas</label>
            <div class="form-group col-sm-4">
                <input type="text" id="cotizacion4_medidas" name="cotizacion4_medidas" placeholder="Medidas" value="<%- cotizacion4_medidas %>" class="form-control input-xs" maxlength="50" required>
                <div class="help-block with-errors"></div>
            </div>

            <label class="col-sm-1 control-label">Valor</label>
            <div class="form-group col-sm-3">
                <input id="cotizacion4_valor_unitario" name="cotizacion4_valor_unitario" value="<%- cotizacion4_valor_unitario %>" class="form-control input-sm" type="text" required data-currency>
            </div>
        </div>
    </script>

    <script type="text/template" id="cotizacion-producto-maquina-item-tpl">
        <div class="form-group col-md-12">
            <label class="checkbox-inline without-padding white-space-normal" for="cotizacion3_maquinap_<%- id %>">
                <input type="checkbox" id="cotizacion3_maquinap_<%- id %>" name="cotizacion3_maquinap_<%- id %>" value="cotizacion3_maquinap_<%- id %>" <%- parseInt(activo) ? 'checked': ''%>> <%- maquinap_nombre %>
            </label>
        </div>
    </script>

    <script type="text/template" id="cotizacion-producto-acabado-item-tpl">
        <div class="form-group col-md-12">
            <label class="checkbox-inline without-padding white-space-normal" for="cotizacion5_acabadop_<%- id %>">
                <input type="checkbox" id="cotizacion5_acabadop_<%- id %>" name="cotizacion5_acabadop_<%- id %>" value="cotizacion5_acabadop_<%- id %>" <%- parseInt(activo) ? 'checked': ''%>> <%- acabadop_nombre %>
            </label>
        </div>
    </script>

    <script type="text/template" id="cotizacion-delete-confirm-tpl">
        <p>¿Está seguro que desea eliminar el area <b><%- cotizacion6_areap %> <%- cotizacion6_nombre %></b>?</p>
    </script>

    <script type="text/template" id="cotizacion-producto-areas-item-tpl">
        <% if(edit) { %>
           <td class="text-center">
               <a class="btn btn-default btn-xs item-producto-areas-remove" data-resource="<%- id %>">
                   <span><i class="fa fa-times"></i></span>
               </a>
           </td>
       <% } %>
       <td><%- areap_nombre %></td>
       <td><%- cotizacion6_nombre %></td>
       <td>
           <div class="row">
               <div class="col-xs-12 col-sm-6">
                   <input type="number" id="cotizacion6_horas" name="cotizacion6_horas" placeholder="Hora" value="<%- cotizacion6_horas %>" class="form-control input-xs change-time" data-type="hs" min="0" step="1" max="9999" required>
               </div>
               <div class="col-xs-12 col-sm-6">
                   <input type="number" id="cotizacion6_minutos" name="cotizacion6_minutos" placeholder="Minutos" value="<%- cotizacion6_minutos %>" class="form-control input-xs change-time" data-type="ms" min="00" step="01" max="59" required>
               </div>
           </div>
       </td>
       @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'ordenes']) )
           <td class="text-right"><%- window.Misc.currency( cotizacion6_valor ) %></td>
           <td class="text-right"><%- window.Misc.currency( total ) %></td>
       @endif
    </script>

    <script type="text/template" id="cotizacion-producto-impresion-item-tpl">
       <td><%- cotizacion7_texto %></td>
       <td><%- cotizacion7_ancho %></td>
       <td><%- cotizacion7_alto %></td>
    </script>
@stop
