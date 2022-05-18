@extends('layout.layout')

@section('title') Ordenes de producción @stop

@section('content')
    @yield ('module')

    <script type="text/template" id="add-orden-producto-tpl">
        <section class="content-header">
            <h1>
                Ordenes de producción <small>Administración de ordenes de producción</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            	<li><a href="{{ route('ordenes.index') }}">Ordenes</a></li>
            	<li><a href="{{ route('ordenes.edit', ['ordenes' => $orden->id]) }}">{{ $orden->orden_codigo }}</a></li>
                <li class="active">Producto</li>
                <% if (!_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                    <li class="active">Editar</li>
                <% }else{ %>
                    <li class="active">Nuevo</li>
                <% } %>
            </ol>
        </section>

        <section class="content">
            <div class="box box-primary spinner-main">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-sm-2 col-sm-6 col-xs-6 text-left">
                            <a href="{{ route('ordenes.edit', ['ordenes' => $orden->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                        </div>
                        <div class="col-sm-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                            <button type="button" class="btn btn-primary btn-sm btn-block submit-ordenp2">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="alert alert-info">
                        <h4><b>Información general</b></h4>
                        <div class="row">
                            <label class="col-sm-2 control-label">Referencia</label>
                            <div class="form-group col-sm-10">
                                {{ $orden->orden_referencia }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 control-label">Cliente</label>
                            <div class="form-group col-sm-10">
                                {{ $orden->tercero_nit }} - {{ $orden->tercero_nombre }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 control-label">Orden</label>
                            <div class="form-group col-sm-10">
                                {{ $orden->orden_codigo }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 control-label">Código producto</label>
                            <div class="form-group col-sm-10">
                                {{ $producto->id }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 control-label">Producto</label>
                            <div class="form-group col-sm-10">
                                <% if (!_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                                    <%- productop_nombre %>
                                <% }else{ %>
                                    {{ $producto->productop_nombre }}
                                <% } %>
                            </div>
                        </div>
                    </div>

                    <form method="POST" accept-charset="UTF-8" id="form-orden-producto" data-toggle="validator">
                        <div class="row">
                            <label for="orden2_referencia" class="col-sm-1 control-label">Referencia</label>
                            <div class="form-group col-md-8">
                                <input id="orden2_referencia" value="<%- orden2_referencia %>" placeholder="Referencia" class="form-control input-sm input-toupper change-info-title" name="orden2_referencia" type="text" maxlength="200" data-input-info="info-referencia" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <label for="orden2_cantidad" class="col-sm-1 control-label">Cantidad</label>
                            <div class="form-group col-sm-2">
                                <input id="orden2_cantidad" value="<%- orden2_cantidad %>" class="form-control input-sm total-calculate change-info-title" name="orden2_cantidad" type="number" min="1" data-input-info="info-cantidad" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="orden2_observaciones" class="col-sm-1 control-label">Observaciones</label>
                            <div class="form-group col-md-11">
                                <textarea id="orden2_observaciones" placeholder="Observaciones" class="form-control" rows="2" name="orden2_observaciones"><%- orden2_observaciones %></textarea>
                            </div>
                        </div>

                        @if ($producto->productop_abierto || $producto->productop_cerrado)
                            <div class="box box-primary">
                                <div class="box-body">
                                    @if ($producto->productop_abierto)
                                        <div class="row">
                                            <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Abierto</label>
                                            <label for="orden2_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    <input id="orden2_ancho" value="<%- orden2_ancho %>" class="form-control input-sm" name="orden2_ancho" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m1_sigla }}</div>
                                            </div>

                                            <label for="orden2_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    <input id="orden2_alto" value="<%- orden2_alto %>" class="form-control input-sm" name="orden2_alto" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m2_sigla }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($producto->productop_cerrado)
                                        <div class="row">
                                            <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Cerrado</label>
                                            <label for="orden2_c_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    <input id="orden2_c_ancho" value="<%- orden2_c_ancho %>" class="form-control input-sm" name="orden2_c_ancho" type="number" min="0" step="0.01" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m3_sigla }}</div>
                                            </div>

                                            <label for="orden2_c_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                            <div class="form-group col-xs-10 col-sm-3">
                                                <div class="col-xs-10 col-sm-9">
                                                    <input id="orden2_c_alto" value="<%- orden2_c_alto %>" class="form-control input-sm" name="orden2_c_alto" type="number" min="0" step="0.01" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m4_sigla }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($producto->productop_3d)
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">3D</label>
                                        <label for="orden2_3d_ancho" class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                <input id="orden2_3d_ancho" value="<%- orden2_3d_ancho %>" class="form-control input-sm" name="orden2_3d_ancho" type="number" min="0" step="0.01" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m5_sigla }}</div>
                                        </div>

                                        <label for="orden2_3d_alto" class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                <input id="orden2_3d_alto" value="<%- orden2_3d_alto %>" class="form-control input-sm" name="orden2_3d_alto" type="number" min="0" step="0.01" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m6_sigla }}</div>
                                        </div>

                                        <label for="orden2_3d_profundidad" class="col-xs-2 col-sm-1 control-label text-right">Profundidad</label>
                                        <div class="form-group col-xs-10 col-sm-2">
                                            <div class="col-xs-10 col-sm-9">
                                                <input id="orden2_3d_profundidad" value="<%- orden2_3d_profundidad %>" class="form-control input-sm" name="orden2_3d_profundidad" type="number" min="0" step="0.01" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            <div class="col-xs-2 col-sm-3 text-left">{{ $producto->m7_sigla }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($producto->productop_tiro || $producto->productop_retiro)
                            <div class="box box-primary">
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
                                                    @if ($producto->productop_tiro)
                                                        <tr>
                                                            <th class="text-center">T <input type="checkbox" id="orden2_tiro" name="orden2_tiro" class="production-check-measurements" value="orden2_tiro" data-resource="orden2" <%- parseInt(orden2_tiro) ? 'checked': ''%>></th>
                                                            <td class="text-center"><input type="checkbox" id="orden2_yellow" name="orden2_yellow" value="orden2_yellow" <%- parseInt(orden2_yellow) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_magenta" name="orden2_magenta" value="orden2_magenta" <%- parseInt(orden2_magenta) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_cyan" name="orden2_cyan" value="orden2_cyan" <%- parseInt(orden2_cyan) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_key" name="orden2_key" value="orden2_key" <%- parseInt(orden2_key) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_color1" name="orden2_color1" value="orden2_color1" <%- parseInt(orden2_color1) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_color2" name="orden2_color2" value="orden2_color2" <%- parseInt(orden2_color2) ? 'checked': ''%>></td>
                                                        </tr>
                                                    @endif
                                                    @if ($producto->productop_retiro)
                                                        <tr>
                                                            <th class="text-center">R <input type="checkbox" id="orden2_retiro" name="orden2_retiro" class="production-check-measurements" value="orden2_retiro" data-resource="orden2" <%- parseInt(orden2_retiro) ? 'checked': ''%>></th>
                                                            <td class="text-center"><input type="checkbox" id="orden2_yellow2" name="orden2_yellow2" value="orden2_yellow2" <%- parseInt(orden2_yellow2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_magenta2" name="orden2_magenta2" value="orden2_magenta2" <%- parseInt(orden2_magenta2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_cyan2" name="orden2_cyan2" value="orden2_cyan2" <%- parseInt(orden2_cyan2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_key2" name="orden2_key2" value="orden2_key2" <%- parseInt(orden2_key2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_color12" name="orden2_color12" value="orden2_color12" <%- parseInt(orden2_color12) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="orden2_color22" name="orden2_color22" value="orden2_color22" <%- parseInt(orden2_color22) ? 'checked': ''%>></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @if ($producto->productop_tiro)
                                            <div class="form-group @if ($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                                <label for="orden2_nota_tiro" class="control-label">Nota tiro</label>
                                                <textarea id="orden2_nota_tiro" name="orden2_nota_tiro" class="form-control" rows="2" placeholder="Nota tiro"><%- orden2_nota_tiro %></textarea>
                                            </div>
                                        @endif

                                        @if ($producto->productop_retiro)
                                            <div class="form-group @if ($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                                <label for="orden2_nota_retiro" class="control-label">Nota retiro</label>
                                                <textarea id="orden2_nota_retiro" name="orden2_nota_retiro" class="form-control" rows="2" placeholder="Nota retiro"><%- orden2_nota_retiro %></textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($producto->tips->count())
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Tips del producto</h3>
                                        </div>
                                        <div class="box-body">
                                            <ul class="list-group">
                                                @foreach ($producto->tips as $tip)
                                                    <li class="list-group-item">{{ $tip->productop2_tip }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Content produccion --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Máquinas de producción</h3>
                                    </div>
                                    <div class="box-body">
                                        @foreach (App\Models\Production\Ordenp3::getOrdenesp3($producto->id, isset($ordenp2) ? $ordenp2->id : null) as $maquina)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="checkbox-inline without-padding white-space-normal" for="orden3_maquinap_{{ $maquina->id }}">
                                                        <input type="checkbox" id="orden3_maquinap_{{ $maquina->id }}" name="orden3_maquinap_{{ $maquina->id }}" value="orden3_maquinap_{{ $maquina->id }}" {{ $maquina->activo ? 'checked': '' }}> {{ $maquina->maquinap_nombre }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Acabados de producción</h3>
                                    </div>
                                    <div class="box-body">
                                        @foreach (App\Models\Production\Ordenp5::getOrdenesp5($producto->id, isset($ordenp2) ? $ordenp2->id : null) as $acabado)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="checkbox-inline without-padding white-space-normal" for="orden5_acabadop_{{ $acabado->id }}">
                                                        <input type="checkbox" id="orden5_acabadop_{{ $acabado->id }}" name="orden5_acabadop_{{ $acabado->id }}" value="orden5_acabadop_{{ $acabado->id }}" {{ $acabado->activo ? 'checked': '' }}> {{ $acabado->acabadop_nombre }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Fórmulas</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <label for="orden2_precio_formula" class="col-sm-1 control-label">Fórmula</label>
                                    <div class="form-group col-md-6">
                                        <input id="orden2_precio_formula" value="<%- orden2_precio_formula %>" placeholder="Fórmula" class="form-control input-sm production-calculate-formula" name="orden2_precio_formula" type="text" maxlength="200" data-response="orden2_precio_venta">
                                    </div>
                                    <label for="orden2_precio_venta" class="col-sm-1 control-label">Precio</label>
                                    <div class="form-group col-md-4">
                                        <input id="orden2_precio_venta" value="<%- orden2_precio_venta %>" placeholder="Precio" class="form-control input-sm total-calculate" name="orden2_precio_venta" type="text" maxlength="30" data-currency required>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="orden2_viaticos_formula" class="col-sm-1 control-label">Fórmula</label>
                                    <div class="form-group col-md-6">
                                        <input id="orden2_viaticos_formula" value="<%- orden2_viaticos_formula %>" placeholder="Fórmula" class="form-control input-sm production-calculate-formula" name="orden2_viaticos_formula" type="text" maxlength="200" data-response="orden2_viaticos">
                                    </div>
                                    <label for="orden2_viaticos" class="col-sm-1 control-label">Viaticos</label>
                                    <div class="form-group col-md-4">
                                        <input id="orden2_viaticos" value="<%- orden2_viaticos %>" class="form-control input-sm total-calculate" name="orden2_viaticos" type="text" maxlength="30" data-currency>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Imágenes</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <div class="fine-uploader"></div>
                        </div>
                    </div>

                    {{-- Content materialesp --}}
                    <div id="materialesp-wrapper-producto" class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Materiales de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-materialp-producto" data-toggle="validator">
                                <div class="row">
                                    @foreach (App\Models\Production\Ordenp4::getMaterials ($producto->id) as $materialp)
                                        <div class="form-group col-md-4">
                                            <label>{{ $materialp }}</label>
                                        </div>
                                    @endforeach
                                </div><br>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <select name="orden4_materialp" id="orden4_materialp" class="form-control select2-default-clear change-production-materialp" data-placeholder="Material de producción" data-field="orden4_producto" data-wrapper="materialesp-wrapper-producto" data-reference="material" required>
                                            <option value hidden selected>Seleccione</option>
                                            @foreach (App\Models\Production\Ordenp4::getMaterials ($producto->id) as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <select name="orden4_producto" id="orden4_producto" class="form-control select2-default-clear change-insumo" data-placeholder="Insumo" data-historial="historial_orden4" data-valor="orden4_valor_unitario" disabled required>
                                            <option value hidden selected>Seleccione</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="orden4_medidas" name="orden4_medidas" placeholder="Medidas" class="form-control input-xs input-formula production-calculate-formula" data-response="orden4_cantidad" maxlength="50" required>
                                            <span class="input-group-addon">=</span>
                                            <input type="text" id="orden4_cantidad" name="orden4_cantidad" placeholder="Total" class="form-control text-right" disabled>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="orden4_valor_unitario" name="orden4_valor_unitario" class="form-control input-sm" type="text" required data-currency>
                                        <div class="help-block pull-right"><a id="historial_orden4" class="historial-insumo cursor-pointer"></a></div>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- table table-bordered table-striped -->
                            <div class="box-body table-responsive no-padding">
                                <table id="browse-orden-producto-materiales-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
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
                    <div id="areasp-wrapper-producto" class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Áreas de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-areap-producto" data-toggle="validator">
                                <div class="row">
                                    <div class="form-group col-sm-5 col-md-offset-1">
                                        <select id="orden6_areap" name="orden6_areap" class="form-control select2-default-clear change-production-areap" data-wrapper="areasp-wrapper-producto" data-input-name="orden6_nombre" data-input-value="orden6_valor" data-placeholder="Áreas de producción">
                                            <option value hidden selected>Seleccione</option>
                                            @foreach (App\Models\Production\Areap::getAreas() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <input id="orden6_nombre" name="orden6_nombre" placeholder="Nombre" class="form-control input-sm input-toupper" type="text" maxlength="20">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-2 col-md-offset-2">
                                        <input type="number" id="orden6_horas" name="orden6_horas" placeholder="Hora" value="0" class="form-control input-xs" min="0" step="1" max="9999" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <input type="number" id="orden6_minutos" name="orden6_minutos" placeholder="Minutos" value="0" class="form-control input-xs" min="00" step="01" max="59" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="orden6_valor" name="orden6_valor" class="form-control input-sm" type="text" required data-currency>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- table table-bordered table-striped -->
                            <div class="box-body table-responsive no-padding">
                                <table id="browse-orden-producto-areas-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th width="30%">Área</th>
                                            <th width="30%">Nombre</th>
                                            <th width="20%" class="text-center">Tiempo</th>
                                            <th width="10%">Valor</th>
                                            <th width="10%">Total</th>
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

                    {{-- Content empaques --}}
                    <div id="empaques-wrapper-producto" class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Empaques de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-empaque-producto" data-toggle="validator">
                                <div class="row">
                                    @foreach (App\Models\Production\Productop5::getPackaging() as $empaque)
                                        <div class="form-group col-md-4">
                                            <label>{{ $empaque }}</label>
                                        </div>
                                    @endforeach
                                </div><br>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <select name="orden9_materialp" id="orden9_materialp" class="form-control select2-default-clear change-production-materialp" data-placeholder="Empaque de producción" data-field="orden9_producto" data-wrapper="empaques-wrapper-producto" data-reference="empaque" required>
                                            <option value hidden selected>Seleccione</option>
                                            @foreach (App\Models\Production\Productop5::getPackaging() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <select name="orden9_producto" id="orden9_producto" class="form-control select2-default-clear change-insumo" data-placeholder="Insumo" data-historial="historial_orden9" data-valor="orden9_valor_unitario" disabled required>
                                            <option value hidden selected>Seleccione</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="orden9_medidas" name="orden9_medidas" placeholder="Medidas" class="form-control input-xs input-formula production-calculate-formula" data-response="orden9_cantidad" maxlength="50" required>
                                            <span class="input-group-addon">=</span>
                                            <input type="text" id="orden9_cantidad" name="orden9_cantidad" placeholder="Total" class="form-control text-right" disabled>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="orden9_valor_unitario" name="orden9_valor_unitario" class="form-control input-sm" type="text" required data-currency>
                                        <div class="help-block pull-right"><a id="historial_orden9" class="historial-insumo cursor-pointer"></a></div>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- table table-bordered table-striped -->
                            <div class="box-body table-responsive no-padding">
                                <table id="browse-orden-producto-empaques-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th width="25%">Empaque</th>
                                            <th width="25%">Insumo</th>
                                            <th width="15%">Medidas</th>
                                            <th width="15%">Cantidad</th>
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

                    {{-- Content transportes --}}
                    <div id="transportes-wrapper-producto" class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Transportes de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-transporte-producto" data-toggle="validator">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <select name="orden10_transporte" id="orden10_transporte" class="form-control select2-default-clear change-production-transporte" data-placeholder="Transporte" data-input-name="orden10_nombre" data-input-value="orden10_valor_unitario">
                                            <option value hidden selected>Seleccione</option>
                                            @foreach (App\Models\Production\Areap::getTransportes() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input id="orden10_nombre" name="orden10_nombre" placeholder="Nombre" class="form-control input-sm input-toupper" type="text" maxlength="200">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-2 col-md-offset-2">
                                        <input type="number" id="orden10_horas" name="orden10_horas" placeholder="Hora" value="0" class="form-control input-xs" min="0" step="1" max="9999" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <input type="number" id="orden10_minutos" name="orden10_minutos" placeholder="Minutos" value="0" class="form-control input-xs" min="0" step="01" max="59" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="orden10_valor_unitario" name="orden10_valor_unitario" class="form-control input-sm" type="text" required data-currency>
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
                                <table id="browse-orden-producto-transportes-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th width="25%">Transporte</th>
                                            <th width="25%">Nombre</th>
                                            <th width="15%">Tiempo</th>
                                            <th width="15%">Valor unidad</th>
                                            <th width="15%">Valor</th>
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

                <div class="row">
                    @ability ('utilidades' | 'ordenes')
                        <div class="@ability ('graficas' | 'ordenes') col-md-8 @elseability col-md-9 col-md-offset-2 @endability">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title text-center">{{ $orden->orden_codigo }}</h3><hr>
                                    <h3 class="box-title" id="info-referencia"><%- orden2_referencia %></h3>
                                    <h5 class="pull-right" id="info-cantidad"><%- orden2_cantidad %></h5>
                                </div>
                                <div class="box-body">
                                    <div class="list-group">
                                        @ability ('especial' | 'ordenes')
                                            <div class="list-group-item list-group-item-info">
                                                <div class="row">
                                                    <div class="col-xs-2 col-sm-2"><b>Precio</b></div>
                                                    <div class="col-xs-9 col-sm-8 text-right"><b><span id="info-precio"></span></b></div>
                                                    <div class="col-xs-6 col-sm-2 text-right"><small id="percentage-precio" class="badge bg-info">0%</small></div>
                                                </div>
                                            </div>
                                            <div class="list-group-item list-group-item-info">
                                                <div class="row">
                                                    <div class="col-xs-2 col-sm-2"><b>Viáticos</b></div>
                                                    <div class="col-xs-9 col-sm-8 text-right"><b><span id="info-viaticos"></span></b></div>
                                                    <div class="col-xs-6 col-sm-2 text-right"><small id="percentage-viaticos" class="badge bg-info">0%</small></div>
                                                </div>
                                            </div>
                                        @endability
                                        <div class="list-group-item list-group-item-info">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-1 text-left"><b>Materiales</b></div>
                                                @if (auth()->user()->hasRole('admin'))
                                                    <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-2 @elseability col-sm-9 @endability text-right"><small id="info-prev-materiales" class="badge bg-red"></small></div>
                                                @else
                                                    <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-3 @elseability col-sm-9 @endability text-right"><small id="info-prev-materiales" class="badge bg-red"></small></div>
                                                @endif
                                                <div class="@ability ('especial' | 'ordenes') col-xs-1 col-sm-1 @elseability col-sm-2 @endability text-right"><small id="percentage-prev-materiales" class="badge bg-info">%</small></div>
                                                @ability ('especial' | 'ordenes')
                                                    <div class="col-xs-4 col-sm-2 text-left">
                                                        <input id="orden2_margen_materialp" name="orden2_margen_materialp" class="form-control input-sm total-calculate" value="<%- orden2_margen_materialp %>" type="number" min="0" max="100" step="0.1">
                                                    </div>
                                                    <div class="col-xs-2 col-sm-1 text-center"><small>(%)</small></div>
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <div class="col-xs-5 col-sm-1"><b><span id="diferencia-materiales"></span></b></div>
                                                    @endif
                                                    <div class="col-xs-5 col-sm-2 text-right"><b><span id="info-materiales"></span></b></div>
                                                    <div class="col-xs-1 col-sm-2 text-right"><small id="percentage-materiales" class="badge bg-info">0%</small></div>
                                                @endability
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-info">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-1 text-left"><b>Áreas</b></div>
                                                @if (auth()->user()->hasRole('admin'))
                                                    <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-2 @elseability col-sm-9 @endability text-right"><small id="info-prev-areasp" class="badge bg-red"></small></div>
                                                @else
                                                    <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-3 @elseability col-sm-9 @endability text-right"><small id="info-prev-areasp" class="badge bg-red"></small></div>
                                                @endif
                                                <div class="@ability ('especial' | 'ordenes') col-xs-1 col-sm-1 @elseability col-sm-2 @endability text-right"><small id="percentage-prev-areasp" class="badge bg-info">%</small></div>
                                                @ability ('especial' | 'ordenes')
                                                    <div class="col-xs-4 col-sm-2 text-left">
                                                        <input id="orden2_margen_areap" name="orden2_margen_areap" class="form-control input-sm total-calculate" value="<%- orden2_margen_areap %>" type="number" min="0" max="100" step="0.1">
                                                    </div>
                                                    <div class="col-xs-2 col-sm-1 text-center"><small>(%)</small></div>
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <div class="col-xs-5 col-sm-1"><b><span id="diferencia-areasp"></span></b></div>
                                                    @endif
                                                    <div class="col-xs-5 col-sm-2 text-right"><b><span id="info-areasp"></span></b></div>
                                                    <div class="col-xs-1 col-sm-2 text-right"><small id="percentage-areasp" class="badge bg-info">0%</small></div>
                                                @endability
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-info">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-1 text-left"><b>Empaques</b></div>
                                                @if (auth()->user()->hasRole('admin'))
                                                    <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-2 @elseability col-sm-9 @endability text-right"><small id="info-prev-empaques" class="badge bg-red"></small></div>
                                                @else
                                                    <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-3 @elseability col-sm-9 @endability text-right"><small id="info-prev-empaques" class="badge bg-red"></small></div>
                                                @endif
                                                <div class="@ability ('especial' | 'ordenes') col-xs-1 col-sm-1 @elseability col-sm-2 @endability text-right"><small id="percentage-prev-empaques" class="badge bg-info">%</small></div>
                                                @ability ('especial' | 'ordenes')
                                                    <div class="col-xs-4 col-sm-2 text-left">
                                                        <input id="orden2_margen_empaque" name="orden2_margen_empaque" class="form-control input-sm total-calculate" value="<%- orden2_margen_empaque %>" type="number" min="0" max="100" step="0.1">
                                                    </div>
                                                    <div class="col-xs-2 col-sm-1 text-center"><small>(%)</small></div>
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <div class="col-xs-5 col-sm-1"><b><span id="diferencia-empaques"></span></b></div>
                                                    @endif
                                                    <div class="col-xs-5 col-sm-2 text-right"><b><span id="info-empaques"></span></b></div>
                                                    <div class="col-xs-1 col-sm-2 text-right"><small id="percentage-empaques" class="badge bg-info">0%</small></div>
                                                @endability
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-info">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-1 text-left"><b>Transportes</b></div>
                                                @if (auth()->user()->hasRole('admin'))
                                                    <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-2 @elseability col-sm-9 @endability text-right"><small id="info-prev-transportes" class="badge bg-red"></small></div>
                                                @else
                                                    <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-3 @elseability col-sm-9 @endability text-right"><small id="info-prev-transportes" class="badge bg-red"></small></div>
                                                @endif
                                                <div class="@ability ('especial' | 'ordenes') col-xs-1 col-sm-1 @elseability col-sm-2 @endability text-right"><small id="percentage-prev-transportes" class="badge bg-info">%</small></div>
                                                @ability ('especial' | 'ordenes')
                                                    <div class="col-xs-4 col-sm-2 text-left">
                                                        <input id="orden2_margen_transporte" name="orden2_margen_transporte" class="form-control input-sm total-calculate" value="<%- orden2_margen_transporte %>" type="number" min="0" max="100" step="0.1">
                                                    </div>
                                                    <div class="col-xs-2 col-sm-1 text-center"><small>(%)</small></div>
                                                    @if (auth()->user()->hasRole('admin'))
                                                        <div class="col-xs-5 col-sm-1"><b><span id="diferencia-transportes"></span></b></div>
                                                    @endif
                                                    <div class="col-xs-5 col-sm-2 text-right"><b><span id="info-transportes"></span></b></div>
                                                    <div class="col-xs-1 col-sm-2 text-right"><small id="percentage-transportes" class="badge bg-info">0%</small></div>
                                                @endability
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-success">
                                            <div class="row">
                                                <div class="col-xs-2 col-sm-2"><b>Subtotal</b></div>
                                                <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-2 @elseability col-sm-10 @endability text-right">
                                                    <span class="badge bg-red" id="info-prev-subtotal"></span>
                                                </div>
                                                @ability ('especial' | 'ordenes')
                                                    <div class="col-xs-10 col-sm-5 text-right">
                                                        <span class="badge bg-green" id="info-subtotal"></span>
                                                    </div>
                                                    <div class="col-xs-10 col-sm-3 text-right">
                                                        <span class="badge bg-red" id="info-subtotal-header"></span>
                                                    </div>
                                                @endability
                                            </div>
                                        </div>
                                        @ability ('especial' | 'ordenes')
                                            <div class="list-group-item list-group-item-success">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-1 text-left"><b>Descuento</b></div>
                                                    <div class="col-xs-6 col-sm-3 text-right"><small id="info-prev-descuento" class="badge bg-red"></small></div>
                                                    <div class="col-xs-6 col-sm-1"></div>
                                                    <div class="col-xs-4 col-sm-2 text-left">
                                                        <input id="orden2_descuento" name="orden2_descuento" class="form-control input-sm total-calculate" value="<%- orden2_descuento %>" type="number" min="0" max="100" step="0.1">
                                                    </div>
                                                    <div class="col-xs-2 col-sm-1 text-center"><small>(%)</small></div>
                                                    <div class="col-xs-6 col-sm-4 text-right"><b><span id="info-descuento"></span></b></div>
                                                </div>
                                            </div>
                                            <div class="list-group-item list-group-item-success">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-1 text-left"><b>Comisión</b></div>
                                                    <div class="col-xs-6 col-sm-3 text-right"><small id="info-prev-comision" class="badge bg-red"></small></div>
                                                    <div class="col-xs-6 col-sm-1"></div>
                                                    <div class="col-xs-4 col-sm-2 text-left">
                                                        <input id="orden2_comision" name="orden2_comision" class="form-control input-sm total-calculate" value="<%- (!edit) ? '{{ ($orden->vendedor) ? $orden->vendedor->tercero_comision : 0 }}' : orden2_comision %>" type="number" min="0" max="100" step="0.1">
                                                    </div>
                                                    <div class="col-xs-2 col-sm-1 text-center"><small>(%)</small></div>
                                                    <div class="col-xs-6 col-sm-4 text-right"><b><span id="info-comision"></span></b></div>
                                                </div>
                                            </div>
                                            <div class="list-group-item list-group-item-success">
                                                <div class="row">
                                                    <div class="col-xs-3 col-sm-2"><b>Volumen</b></div>
                                                    <div class="col-xs-3 col-sm-2">
                                                        <input id="orden2_volumen" name="orden2_volumen" class="form-control input-sm total-calculate" value="<%- orden2_volumen %>" type="number" min="0" step="0.1" max="99">
                                                    </div>
                                                    <div class="col-xs-12 col-sm-8 text-right">
                                                        <span class="badge bg-red" id="info-volumen"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item list-group-item-success">
                                                <div class="row">
                                                    <div class="col-xs-3 col-sm-2"><b>Redondear</b></div>
                                                    <div class="col-xs-3 col-sm-2">
                                                        <input id="orden2_round" name="orden2_round" class="form-control input-sm total-calculate" value="<%- orden2_round %>" type="number" min="-3" max="3" step="1" title="Si el digito se encuentra en 0, sera redondeado automaticamente">
                                                    </div>
                                                    <div class="col-xs-3 col-sm-2 col-sm-offset-2"><b>Total</b></div>
                                                    <div class="col-xs-3 col-sm-4 text-right">
                                                        <span class="badge bg-red" id="info-pretotal"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item list-group-item-danger">
                                                <div class="row">
                                                    <div class="col-xs-2 col-sm-2"><b>IVA ({{ $orden->orden_iva }}%)</b></div>
                                                    <input type="hidden" id="iva_orden" name="iva_orden" value="{{ $orden->orden_iva }}">
                                                    <div class="col-xs-10 col-sm-7 text-right">
                                                        <span class="badge bg-green" id="info-iva"></span>
                                                    </div>
                                                    <div class="col-xs-10 col-sm-3 text-right">
                                                        <span class="badge bg-red" id="info-iva-header"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endability
                                        <div class="list-group-item list-group-item-danger">
                                            <div class="row">
                                                <div class="col-xs-2 col-sm-2"><b>Total</b></div>
                                                <div class="@ability ('especial' | 'ordenes') col-xs-6 col-sm-2 @elseability col-sm-10 @endability text-right">
                                                    <span class="badge bg-red" id="info-total-subtotal"></span>
                                                </div>
                                                @ability ('especial' | 'ordenes')
                                                    <div class="col-xs-10 col-sm-5 text-right">
                                                        <span class="badge bg-green" id="info-total"></span>
                                                    </div>
                                                    <div class="col-xs-10 col-sm-3 text-right">
                                                        <span class="badge bg-red" id="info-total-header"></span>
                                                    </div>
                                                @endability
                                            </div>
                                        </div>
                                        <div class="list-group-item list-group-item-danger">
                                            <div class="row">
                                                <div class="col-sm-2 col-md-offset-10 col-sm-6 col-xs-6 text-right">
                                                    <button type="button" class="btn btn-primary btn-sm btn-block submit-ordenp2">{{ trans('app.save') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <p><b>Los campos de viáticos, materiales, áreas, empaques y transportes se dividirán por la cantidad ingresada.</b></p>
                                </div>
                            </div>
                        </div>
                    @endability
                    @ability ('graficas' | 'ordenes')
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="chart-container">
                                        <canvas id="chart_producto"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endability
                </div>
        </section>
    </script>

    <script type="text/template" id="orden-delete-materialp-confirm-tpl">
        <p>¿Está seguro que desea eliminar el material <b><%- materialp_nombre %> </b>?</p>
    </script>

    <script type="text/template" id="orden-delete-empaque-confirm-tpl">
        <p>¿Está seguro que desea eliminar el empaque <b><%- empaque_nombre %> </b>?</p>
    </script>

    <script type="text/template" id="orden-delete-areap-confirm-tpl">
        <p>¿Está seguro que desea eliminar el area <b><%- orden6_areap %> <%- orden6_nombre %></b>?</p>
    </script>

    <script type="text/template" id="orden-delete-transporte-confirm-tpl">
        <p>¿Está seguro que desea eliminar el transporte <b><%- nombre %> </b>?</p>
    </script>

    <script type="text/template" id="orden-producto-materialp-item-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-materialp-orden-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-materialp-orden-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- materialp_nombre || '-' %></td>
        <td><%- producto_nombre || '-' %></td>
        <td><%- orden4_medidas %></td>
        <td><%- orden4_cantidad %></td>
        <td class="text-right"><%- window.Misc.currency (orden4_valor_unitario) %></td>
        <td class="text-right"><%- window.Misc.currency (orden4_valor_total) %></td>
    </script>

    <script type="text/template" id="orden-producto-materialp-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-materialp-orden-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- producto_nombre || '-' %></td>
        <td colspan="4">
            <div class="input-group">
                <input type="text" id="orden4_medidas_<%- id %>" name="orden4_medidas_<%- id %>" placeholder="Medidas" class="form-control input-xs input-formula production-calculate-formula" data-response="orden4_cantidad_<%- id %>" maxlength="50" value="<%- orden4_medidas %>" required>
                <span class="input-group-addon">=</span>
                <input type="text" id="orden4_cantidad_<%- id %>" name="orden4_cantidad_<%- id %>" placeholder="Total" value="<%- orden4_cantidad %>" class="form-control text-right" disabled>
            </div>
        </td>
        <td colspan="2" class="text-right">
            <input id="orden4_valor_unitario_<%- id %>" name="orden4_valor_unitario_<%- id %>" value="<%- orden4_valor_unitario %>" class="form-control input-sm" type="text" data-currency required>
        </td>
    </script>

    <script type="text/template" id="orden-producto-empaque-item-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-empaque-orden-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-empaque-orden-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- empaque_nombre || '-' %></td>
        <td><%- producto_nombre || '-' %></td>
        <td><%- orden9_medidas %></td>
        <td><%- orden9_cantidad %></td>
        <td class="text-right"><%- window.Misc.currency (orden9_valor_unitario) %></td>
        <td class="text-right"><%- window.Misc.currency (orden9_valor_total) %></td>
    </script>

    <script type="text/template" id="orden-producto-empaque-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-empaque-orden-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- producto_nombre || '-' %></td>
        <td colspan="4">
            <div class="input-group">
                <input type="text" id="orden9_medidas_<%- id %>" name="orden9_medidas_<%- id %>" placeholder="Medidas" class="form-control input-xs input-formula production-calculate-formula" data-response="orden9_cantidad_<%- id %>" maxlength="50" value="<%- orden9_medidas %>" required>
                <span class="input-group-addon">=</span>
                <input type="text" id="orden9_cantidad_<%- id %>" name="orden9_cantidad_<%- id %>" placeholder="Total" value="<%- orden9_cantidad %>" class="form-control text-right" disabled>
            </div>
        </td>
        <td colspan="2" class="text-right">
            <input id="orden9_valor_unitario_<%- id %>" name="orden9_valor_unitario_<%- id %>" value="<%- orden9_valor_unitario %>" class="form-control input-sm" type="text" data-currency required>
        </td>
    </script>

    <script type="text/template" id="orden-producto-areas-item-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-areap-orden-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-areap-orden-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- areap_nombre || '-' %></td>
        <td><%- orden6_nombre || '-' %></td>
        <td class="text-center"><%- orden6_horas %>:<%- orden6_minutos %></td>
        <td class="text-right"><%- window.Misc.currency (orden6_valor) %></td>
        <td class="text-right"><%- window.Misc.currency (total) %></td>
    </script>

    <script type="text/template" id="orden-producto-areas-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-areap-orden-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- areap_nombre || '-' %></td>
        <td><%- orden6_nombre || '-' %></td>
        <td colspan="3">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <input type="number" id="orden6_horas_<%- id %>" name="orden6_horas_<%- id %>" placeholder="Hora" value="<%- orden6_horas %>" class="form-control input-xs" min="0" step="1" max="9999" required>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <input type="number" id="orden6_minutos_<%- id %>" name="orden6_minutos_<%- id %>" placeholder="Minutos" value="<%- orden6_minutos %>" class="form-control input-xs" min="00" step="01" max="59" required>
                </div>
            </div>
        </td>
    </script>

    <script type="text/template" id="orden-producto-transporte-item-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-transporte-orden-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-transporte-orden-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- transporte_nombre || '-' %></td>
        <td><%- orden10_nombre || '-' %></td>
        <td><%- orden10_tiempo %></td>
        <td class="text-right"><%- window.Misc.currency (orden10_valor_unitario) %></td>
        <td class="text-right"><%- window.Misc.currency (orden10_valor_total) %></td>
    </script>

    <script type="text/template" id="orden-producto-transporte-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-transporte-orden-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- transporte_nombre || '-' %></td>
        <td><%- orden10_nombre || '-' %></td>
        <td colspan="3">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <input type="number" id="orden10_horas_<%- id %>" name="orden10_horas_<%- id %>" placeholder="Hora" value="<%- orden10_horas %>" class="form-control input-xs" min="0" step="1" max="9999" required>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <input type="number" id="orden10_minutos_<%- id %>" name="orden10_minutos_<%- id %>" placeholder="Minutos" value="<%- orden10_minutos %>" class="form-control input-xs" min="00" step="01" max="59" required>
                </div>
            </div>
        </td>
    </script>

    <script type="text/template" id="qq-template-ordenp-producto">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{{ trans('app.files.drop') }}">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            @ability ('archivos' | 'ordenes')
                <div class="buttons">
                    <div class="qq-upload-button-selector qq-upload-button">
                        <div><i class="fa fa-folder-open" aria-hidden="true"></i> {{ trans('app.files.choose-file') }}</div>
                    </div>
                </div>
                <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>{{ trans('app.files.process') }}</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
            @endability
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
                    @ability ('archivos' | 'ordenes')
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">{{ trans('app.delete') }}</button>
                    @endability
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
