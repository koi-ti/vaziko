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
            <div class="box box-danger spinner-main">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                            <a href="{{ route('cotizaciones.edit', ['cotizaciones' => $cotizacion->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                        </div>
                        <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                            <button type="button" class="btn btn-danger btn-sm btn-block submit-cotizacion2">{{ trans('app.save') }}</button>
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
                                <div class="help-block with-errors"></div>
                            </div>

                            <label for="cotizacion2_cantidad" class="col-sm-1 control-label">Cantidad</label>
                            <div class="form-group col-md-2">
                                <input id="cotizacion2_cantidad" value="<%- cotizacion2_cantidad %>" class="form-control input-sm total-calculate" name="cotizacion2_cantidad" type="number" min="1" required>
                                <div class="help-block with-errors"></div>
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
                                                            <th class="text-center">T <input type="checkbox" id="cotizacion2_tiro" name="cotizacion2_tiro" class="check-type" value="cotizacion2_tiro" <%- parseInt(cotizacion2_tiro) ? 'checked': ''%>></th>
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
                                                            <th class="text-center">R <input type="checkbox" id="cotizacion2_retiro" name="cotizacion2_retiro" class="check-type" value="cotizacion2_retiro" <%- parseInt(cotizacion2_retiro) ? 'checked': ''%>></th>
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

                        {{-- Content produccion --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Máquinas de producción</h3>
                                    </div>
                                    <div class="box-body">
                                        @foreach( App\Models\Production\Cotizacion3::getCotizaciones3($producto->id, isset($cotizacion2) ? $cotizacion2->id : null ) as $maquina)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="checkbox-inline without-padding white-space-normal" for="cotizacion3_maquinap_{{ $maquina->id }}">
                                                        <input type="checkbox" id="cotizacion3_maquinap_{{ $maquina->id }}" name="cotizacion3_maquinap_{{ $maquina->id }}" value="cotizacion3_maquinap_{{ $maquina->id }}" {{ $maquina->activo ? 'checked': '' }}> {{ $maquina->maquinap_nombre }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="box box-danger">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Acabados de producción</h3>
                                    </div>
                                    <div class="box-body">
                                        @foreach( App\Models\Production\Cotizacion5::getCotizaciones5($producto->id, isset($cotizacion2) ? $cotizacion2->id : null ) as $acabado)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="checkbox-inline without-padding white-space-normal" for="cotizacion5_acabadop_{{ $acabado->id }}">
                                                        <input type="checkbox" id="cotizacion5_acabadop_{{ $acabado->id }}" name="cotizacion5_acabadop_{{ $acabado->id }}" value="cotizacion5_acabadop_{{ $acabado->id }}" {{ $acabado->activo ? 'checked': '' }}> {{ $acabado->acabadop_nombre }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
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
                                            <input id="cotizacion2_precio_formula" value="<%- cotizacion2_precio_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_precio_formula" type="text" maxlength="200" data-response="cotizacion2_precio_venta">
                                        </div>
                                        <label for="cotizacion2_precio_venta" class="col-sm-1 control-label">Precio</label>
                                        <div class="form-group col-md-4">
                                            <input id="cotizacion2_precio_venta" value="<%- cotizacion2_precio_venta %>" placeholder="Precio" class="form-control input-sm total-calculate" name="cotizacion2_precio_venta" type="text" maxlength="30" data-currency required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="cotizacion2_transporte_formula" class="col-sm-1 control-label">Fórmula</label>
                                        <div class="form-group col-md-6">
                                            <input id="cotizacion2_transporte_formula" value="<%- cotizacion2_transporte_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_transporte_formula" type="text" maxlength="200" data-response="cotizacion2_transporte">
                                        </div>
                                        <label for="cotizacion2_transporte" class="col-sm-1 control-label">Transporte</label>
                                        <div class="form-group col-md-4">
                                            <input id="cotizacion2_transporte" value="<%- cotizacion2_transporte %>" class="form-control input-sm total-calculate" name="cotizacion2_transporte" type="text" maxlength="30" data-currency>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="cotizacion2_viaticos_formula" class="col-sm-1 control-label">Fórmula</label>
                                        <div class="form-group col-md-6">
                                            <input id="cotizacion2_viaticos_formula" value="<%- cotizacion2_viaticos_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_viaticos_formula" type="text" maxlength="200" data-response="cotizacion2_viaticos">
                                        </div>
                                        <label for="cotizacion2_viaticos" class="col-sm-1 control-label">Viáticos</label>
                                        <div class="form-group col-md-4">
                                            <input id="cotizacion2_viaticos" value="<%- cotizacion2_viaticos %>" class="form-control input-sm total-calculate" name="cotizacion2_viaticos" type="text" maxlength="30" data-currency>
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

                    {{-- Content materialesp --}}
                    <div id="materialesp-wrapper-producto" class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Materiales de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-materialp-producto" data-toggle="validator">
                                <div class="row">
                                    @foreach( App\Models\Production\Cotizacion4::getMaterials( $producto->id ) as $materialp )
                                        <div class="form-group col-md-4">
                                            <label>{{ $materialp }}</label>
                                        </div>
                                    @endforeach
                                </div><br>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <select name="cotizacion4_materialp" id="cotizacion4_materialp" class="form-control select2-default-clear change-materialp" data-placeholder="Material de producción" data-field="cotizacion4_producto" data-wrapper="materialesp-wrapper-producto" data-reference="material" required>
                                            <option value hidden selected>Seleccione</option>
                                            @foreach( App\Models\Production\Cotizacion4::getMaterials( $producto->id ) as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <select name="cotizacion4_producto" id="cotizacion4_producto" class="form-control select2-default-clear change-insumo" data-placeholder="Insumo" data-historial="historial_cotizacion4" data-valor="cotizacion4_valor_unitario" disabled required>
                                            <option value hidden selected>Seleccione</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="cotizacion4_medidas" name="cotizacion4_medidas" placeholder="Medidas" class="form-control input-xs input-formula calculate-formula" data-response="cotizacion4_cantidad" maxlength="50" required>
                                            <span class="input-group-addon">=</span>
                                            <input type="text" id="cotizacion4_cantidad" name="cotizacion4_cantidad" placeholder="Total" class="form-control text-right" disabled>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="cotizacion4_valor_unitario" name="cotizacion4_valor_unitario" class="form-control input-sm" type="text" data-currency required>
                                        <div class="help-block pull-right"><a id="historial_cotizacion4" class="historial-insumo cursor-pointer"></a></div>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="submit" class="btn btn-danger btn-sm btn-block">
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
                                            <th width="10%">Medidas</th>
                                            <th width="10%">Cantidad</th>
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
                    <div  id="areasp-wrapper-producto" class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Áreas de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-areap-producto" data-toggle="validator">
                                <div class="row">
                                    <div class="form-group col-sm-5 col-md-offset-1">
                                        <select name="cotizacion6_areap" id="cotizacion6_areap" class="form-control select2-default-clear" data-placeholder="Áreas de producción">
                                            <option value hidden selected>Seleccione</option>
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
                                        <button type="submit" class="btn btn-danger btn-sm btn-block">
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
                                            <th colspan="2"></th>
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
                                                <td colspan="5"></td>
                                                <th class="text-right">Total</th>
                                                <th class="text-right" id="total">0</th>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Content empaques --}}
                    <div id="empaques-wrapper-producto" class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Empaques de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-empaque-producto" data-toggle="validator">
                                <div class="row">
                                    @foreach( App\Models\Production\Productop5::getPackaging() as $empaque )
                                        <div class="form-group col-md-4">
                                            <label>{{ $empaque }}</label>
                                        </div>
                                    @endforeach
                                </div><br>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <select name="cotizacion9_materialp" id="cotizacion9_materialp" class="form-control select2-default-clear change-materialp" data-placeholder="Empaque de producción" data-field="cotizacion9_producto" data-wrapper="materialesp-wrapper-producto" data-reference="empaque" required>
                                            <option value hidden selected>Seleccione</option>
                                            @foreach( App\Models\Production\Productop5::getPackaging() as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <select name="cotizacion9_producto" id="cotizacion9_producto" class="form-control select2-default-clear change-insumo" data-placeholder="Insumo" data-historial="historial_cotizacion9" data-valor="cotizacion9_valor_unitario" disabled required>
                                            <option value hidden selected>Seleccione</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="cotizacion9_medidas" name="cotizacion9_medidas" placeholder="Medidas" class="form-control input-xs input-formula calculate-formula" data-response="cotizacion9_cantidad" maxlength="50" required>
                                            <span class="input-group-addon">=</span>
                                            <input type="text" id="cotizacion9_cantidad" name="cotizacion9_cantidad" placeholder="Total" class="form-control text-right" disabled>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="cotizacion9_valor_unitario" name="cotizacion9_valor_unitario" class="form-control input-sm" type="text" required data-currency>
                                        <div class="help-block pull-right"><a id="historial_cotizacion9" class="historial-insumo cursor-pointer"></a></div>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="submit" class="btn btn-danger btn-sm btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- table table-bordered table-striped -->
                            <div class="box-body table-responsive no-padding">
                                <table id="browse-cotizacion-producto-empaques-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th width="25%">Empaque</th>
                                            <th width="25%">Insumo</th>
                                            <th width="10%">Medidas</th>
                                            <th width="10%">Cantidad</th>
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
                                            <div class="col-xs-6 col-sm-2 text-left"><b>Materiales</b></div>
                                            <div class="col-xs-6 col-sm-3 text-right"><small id="info-prev-materiales" class="badge bg-red"></small></div>
                                            <div class="col-xs-4 col-sm-2 text-left">
                                                <input id="cotizacion2_margen_materialp" name="cotizacion2_margen_materialp" class="form-control input-sm total-calculate" value="<%- cotizacion2_margen_materialp %>" type="number" min="0" max="100" step="0.1">
                                            </div>
                                            <div class="col-xs-2 col-sm-1 text-center"><small>(%)</small></div>
                                            <div class="col-xs-6 col-sm-4 text-right"><b><span id="info-materiales"></span></b></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-info">
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2"><b>Áreas</b></div>
                                            <div class="col-xs-10 col-sm-10 text-right"><b><span id="info-areas"></span></b></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-info">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-2 text-left"><b>Empaques</b></div>
                                            <div class="col-xs-6 col-sm-3 text-right"><small id="info-prev-empaques" class="badge bg-red"></small></div>
                                            <div class="col-xs-4 col-sm-2 text-left">
                                                <input id="cotizacion2_margen_empaque" name="cotizacion2_margen_empaque" class="form-control input-sm total-calculate" value="<%- cotizacion2_margen_empaque %>" type="number" min="0" max="100" step="0.1">
                                            </div>
                                            <div class="col-xs-2 col-sm-1 text-center"><small>(%)</small></div>
                                            <div class="col-xs-6 col-sm-4 text-right"><b><span id="info-empaques"></span></b></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-success">
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2"><b>Subtotal</b></div>
                                            <div class="col-xs-10 col-sm-10 text-right">
                                                <span class="pull-right badge bg-red" id="info-subtotal"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-success">
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-2"><b>Volumen</b></div>
                                            <div class="col-xs-3 col-sm-2">
                                                <input id="cotizacion2_volumen" name="cotizacion2_volumen" class="form-control input-sm total-calculate" value="<%- cotizacion2_volumen %>" type="number" min="0" max="99">
                                            </div>
                                            <div class="col-xs-12 col-sm-8 text-right">
                                                <span class="pull-right badge bg-red" id="info-comision"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item list-group-item-success">
                                        <div class="row">
                                            <div class="col-xs-3 col-sm-2"><b>Redondear</b></div>
                                            <div class="col-xs-3 col-sm-2">
                                                <input id="cotizacion2_round" name="cotizacion2_round" class="form-control input-sm total-calculate" value="<%- cotizacion2_round %>" type="number" min="-3" max="3" step="1" title="Si el digito se encuentra en 0, sera redondeado automaticamente">
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-sm-offset-2"><b>Total</b></div>
                                            <div class="col-xs-10 col-sm-4 text-right">
                                                <span class="pull-right badge bg-red" id="info-total"></span>
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

    <script type="text/template" id="cotizacion-delete-materialp-confirm-tpl">
        <p>¿Está seguro que desea eliminar el material <b><%- materialp_nombre %> </b>?</p>
    </script>

    <script type="text/template" id="cotizacion-delete-empaque-confirm-tpl">
        <p>¿Está seguro que desea eliminar el empaque <b><%- empaque_nombre %> </b>?</p>
    </script>

    <script type="text/template" id="cotizacion-delete-areap-confirm-tpl">
        <p>¿Está seguro que desea eliminar el area <b><%- cotizacion6_areap %> <%- cotizacion6_nombre %></b>?</p>
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

    <script type="text/template" id="cotizacion-producto-materialp-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-materialp-cotizacion-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
        <td colspan="4">
            <div class="input-group">
                <input type="text" id="cotizacion4_medidas_<%- id %>" name="cotizacion4_medidas_<%- id %>" placeholder="Medidas" class="form-control input-xs input-formula calculate-formula" data-response="cotizacion4_cantidad_<%- id %>" maxlength="50" value="<%- cotizacion4_medidas %>" required>
                <span class="input-group-addon">=</span>
                <input type="text" id="cotizacion4_cantidad_<%- id %>" name="cotizacion4_cantidad_<%- id %>" placeholder="Total" value="<%- cotizacion4_cantidad %>" class="form-control text-right" disabled>
            </div>
        </td>
        <td colspan="2" class="text-right">
            <input id="cotizacion4_valor_unitario_<%- id %>" name="cotizacion4_valor_unitario_<%- id %>" value="<%- cotizacion4_valor_unitario %>" class="form-control input-sm" type="text" data-currency required>
        </td>
    </script>

    <script type="text/template" id="cotizacion-producto-empaque-item-tpl">
        <% if( edit ) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-empaque-cotizacion-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-empaque-cotizacion-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- !_.isUndefined(empaque_nombre) && !_.isNull(empaque_nombre) ? empaque_nombre : '-' %></td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : '-' %></td>
        <td><%- cotizacion9_medidas %></td>
        <td><%- cotizacion9_cantidad %></td>
        <td class="text-right"><%- window.Misc.currency( cotizacion9_valor_unitario ) %></td>
        <td class="text-right"><%- window.Misc.currency( cotizacion9_valor_total ) %></td>
    </script>

    <script type="text/template" id="cotizacion-producto-empaque-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-empaque-cotizacion-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
        <td colspan="4">
            <div class="input-group">
                <input type="text" id="cotizacion9_medidas_<%- id %>" name="cotizacion9_medidas_<%- id %>" placeholder="Medidas" class="form-control input-xs input-formula calculate-formula" data-response="cotizacion9_cantidad_<%- id %>" maxlength="50" value="<%- cotizacion9_medidas %>" required>
                <span class="input-group-addon">=</span>
                <input type="text" id="cotizacion9_cantidad_<%- id %>" name="cotizacion9_cantidad_<%- id %>" placeholder="Total" value="<%- cotizacion9_cantidad %>" class="form-control text-right" disabled>
            </div>
        </td>
        <td  colspan="2" class="text-right">
            <input id="cotizacion9_valor_unitario_<%- id %>" name="cotizacion9_valor_unitario_<%- id %>" value="<%- cotizacion9_valor_unitario %>" class="form-control input-sm" type="text" data-currency required>
        </td>
    </script>

    <script type="text/template" id="cotizacion-producto-areas-item-tpl">
        <% if(edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-areap-cotizacion-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-areap-cotizacion-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- areap_nombre ? areap_nombre : '-' %></td>
        <td><%- cotizacion6_nombre ? cotizacion6_nombre : '-' %></td>
        <td class="text-center"><%- cotizacion6_horas %>:<%- cotizacion6_minutos %></td>
        @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
            <td class="text-right"><%- window.Misc.currency( cotizacion6_valor ) %></td>
            <td class="text-right"><%- window.Misc.currency( total ) %></td>
        @endif
    </script>

    <script type="text/template" id="cotizacion-producto-areas-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-areap-cotizacion-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- areap_nombre ? areap_nombre : '-' %></td>
        <td><%- cotizacion6_nombre ? cotizacion6_nombre : '-' %></td>
        <td colspan="3">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <input type="number" id="cotizacion6_horas_<%- id %>" name="cotizacion6_horas_<%- id %>" placeholder="Hora" value="<%- cotizacion6_horas %>" class="form-control input-xs" min="0" step="1" max="9999" required>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <input type="number" id="cotizacion6_minutos_<%- id %>" name="cotizacion6_minutos_<%- id %>" placeholder="Minutos" value="<%- cotizacion6_minutos %>" class="form-control input-xs" min="00" step="01" max="59" required>
                </div>
            </div>
        </td>
    </script>

    <script type="text/template" id="qq-template-cotizacion-producto">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{{ trans('app.files.drop') }}">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>

            @if(Auth::user()->ability('admin', 'opcional3', ['module' => 'cotizaciones']))
                <div class="buttons">
                    <div class="qq-upload-button-selector qq-upload-button">
                        <div><i class="fa fa-folder-open" aria-hidden="true"></i> {{ trans('app.files.choose-file') }}</div>
                    </div>
                </div>
                <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>{{ trans('app.files.process') }}</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
            @endif
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <a class="preview-link" target="_blank">
                        <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    </a>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">{{ trans('app.cancel') }}</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">{{ trans('app.files.retry') }}</button>
                    @if(Auth::user()->ability('admin', 'opcional3', ['module' => 'cotizaciones']))
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">{{ trans('app.delete') }}</button>
                        <span class="btn-imprimir"><input type="checkbox" class="qq-imprimir"> Imprimir </span>
                    @endif
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cerrar</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Si</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">{{ trans('app.cancel') }}</button>
                    <button type="button" class="qq-ok-button-selector">{{ trans('app.continue') }}</button>
                </div>
            </dialog>
        </div>
    </script>
@stop
