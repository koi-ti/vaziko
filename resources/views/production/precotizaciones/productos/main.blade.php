@extends('layout.layout')

@section('title') Pre-cotizaciones @stop

@section('content')
    @yield ('module')

    <script type="text/template" id="add-precotizacion-producto-tpl">
        <section class="content-header">
            <h1>
                Pre-cotizaciones <small>Administración de pre-cotizaciones</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
                <li><a href="{{ route('precotizaciones.index') }}">Pre-cotización</a></li>
                <li><a href="{{ route('precotizaciones.edit', ['precotizacion' => $precotizacion->id]) }}">{{ $precotizacion->precotizacion_codigo }}</a></li>
                <li class="active">Producto</li>
                <% if (!edit) { %>
                    <li class="active">Nuevo</li>
                <% } else { %>
                    <li class="active">Editar</li>
                <% } %>
            </ol>
        </section>

        <section class="content">
            <div class="box box-success spinner-main">
        		<div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                            <a href="{{ route('precotizaciones.edit', ['precotizacion' => $precotizacion->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                        </div>
                        <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                            <button type="button" class="btn btn-success btn-sm btn-block submit-precotizacion2">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="alert alert-success">
                        <h4><b>Información general</b></h4>
                        <div class="row">
                            <label class="col-md-2 control-label">Referencia</label>
                            <div class="form-group col-md-10">
                                {{ $precotizacion->precotizacion1_referencia }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-2 control-label">Cliente</label>
                            <div class="form-group col-md-10">
                                {{ $precotizacion->tercero_nit }} - {{ $precotizacion->tercero_nombre }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-2 control-label">Pre-cotización</label>
                            <div class="form-group col-md-10">
                                {{ $precotizacion->precotizacion_codigo }}
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
                                <% if( !_.isUndefined(productop_nombre) && !_.isNull(productop_nombre) && productop_nombre != '') { %>
                                    <%- productop_nombre %>
                                <% }else{ %>
                                    {{ $producto->productop_nombre }}
                                <% } %>
                            </div>
                        </div>
                    </div>

                    <form method="POST" accept-charset="UTF-8" id="form-precotizacion-producto" data-toggle="validator">
                        <div class="row">
                            <label for="precotizacion2_referencia" class="col-sm-1 control-label">Referencia</label>
                            <div class="form-group col-md-8">
                                <input id="precotizacion2_referencia" class="form-control input-sm input-toupper" name="precotizacion2_referencia" value="<%- precotizacion2_referencia %>" placeholder="Referencia" type="text" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <label for="precotizacion2_cantidad" class="col-sm-1 control-label">Cantidad</label>
                            <div class="form-group col-md-2">
                                <input id="precotizacion2_cantidad" value="<%- precotizacion2_cantidad %>" class="form-control input-sm event-price" name="precotizacion2_cantidad" type="number" min="1" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="precotizacion2_observaciones" class="col-sm-1 control-label">Observaciones</label>
                            <div class="form-group col-md-11">
                                <textarea id="precotizacion2_observaciones" name="precotizacion2_observaciones" class="form-control" rows="2" placeholder="Observaciones"><%- precotizacion2_observaciones %></textarea>
                            </div>
                        </div>

                        @if($producto->productop_abierto || $producto->productop_cerrado)
                            <div class="box box-success">
                                <div class="box-body">
                                    @if($producto->productop_abierto)
                                        <div class="row">
                                            <label class="col-sm-offset-1 col-sm-1 control-label">Abierto</label>
                                            <label for="precotizacion2_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                            <div class="form-group col-md-3">
                                                <div class="col-md-9">
                                                    <input id="precotizacion2_ancho" value="<%- precotizacion2_ancho %>" class="form-control input-sm" name="precotizacion2_ancho" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-md-3 text-left">{{ $producto->m1_sigla }}</div>
                                            </div>

                                            <label for="precotizacion2_alto" class="col-sm-1 control-label text-right">Alto</label>
                                            <div class="form-group col-md-3">
                                                <div class="col-md-9">
                                                    <input id="precotizacion2_alto" value="<%- precotizacion2_alto %>" class="form-control input-sm" name="precotizacion2_alto" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-md-3 text-left">{{ $producto->m2_sigla }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($producto->productop_cerrado)
                                        <div class="row">
                                            <label class="col-sm-offset-1 col-sm-1 control-label">Cerrado</label>
                                            <label for="precotizacion2_c_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                            <div class="form-group col-md-3">
                                                <div class="col-md-9">
                                                    <input id="precotizacion2_c_ancho" value="<%- precotizacion2_c_ancho %>" class="form-control input-sm" name="precotizacion2_c_ancho" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-md-3 text-left">{{ $producto->m3_sigla }}</div>
                                            </div>

                                            <label for="precotizacion2_c_alto" class="col-sm-1 control-label text-right">Alto</label>
                                            <div class="form-group col-md-3">
                                                <div class="col-md-9">
                                                    <input id="precotizacion2_c_alto" value="<%- precotizacion2_c_alto %>" class="form-control input-sm" name="precotizacion2_c_alto" type="number" min="0" step="0.01" required>
                                                </div>
                                                <div class="col-md-3 text-left">{{ $producto->m4_sigla }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_3d)
                            <div class="box box-success">
                                <div class="box-body">
                                    <div class="row">
                                        <label class="col-sm-offset-1 col-sm-1 control-label">3D</label>
                                        <label for="precotizacion2_3d_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                        <div class="form-group col-md-2">
                                            <div class="col-md-9">
                                                <input id="precotizacion2_3d_ancho" value="<%- precotizacion2_3d_ancho %>" class="form-control input-sm" name="precotizacion2_3d_ancho" type="number" min="0" step="0.01" required>
                                            </div>
                                            <div class="col-md-3 text-left">{{ $producto->m5_sigla }}</div>
                                        </div>

                                        <label for="precotizacion2_3d_alto" class="col-sm-1 control-label text-right">Alto</label>
                                        <div class="form-group col-md-2">
                                            <div class="col-md-9">
                                                <input id="precotizacion2_3d_alto" value="<%- precotizacion2_3d_alto %>" class="form-control input-sm" name="precotizacion2_3d_alto" type="number" min="0" step="0.01" required>
                                            </div>
                                            <div class="col-md-3 text-left">{{ $producto->m6_sigla }}</div>
                                        </div>

                                        <label for="precotizacion2_3d_profundidad" class="col-sm-1 control-label text-right">Profundidad</label>
                                        <div class="form-group col-md-2">
                                            <div class="col-md-9">
                                                <input id="precotizacion2_3d_profundidad" value="<%- precotizacion2_3d_profundidad %>" class="form-control input-sm" name="precotizacion2_3d_profundidad" type="number" min="0" step="0.01" required>
                                            </div>
                                            <div class="col-md-3 text-left">{{ $producto->m7_sigla }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_tiro || $producto->productop_retiro)
                            <div class="box box-success">
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
                                                            <th class="text-center">T <input type="checkbox" id="precotizacion2_tiro" name="precotizacion2_tiro" class="check-type" value="precotizacion2_tiro" <%- parseInt(precotizacion2_tiro) ? 'checked': ''%>></th>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_yellow" name="precotizacion2_yellow" value="precotizacion2_yellow" <%- parseInt(precotizacion2_yellow) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_magenta" name="precotizacion2_magenta" value="precotizacion2_magenta" <%- parseInt(precotizacion2_magenta) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_cyan" name="precotizacion2_cyan" value="precotizacion2_cyan" <%- parseInt(precotizacion2_cyan) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_key" name="precotizacion2_key" value="precotizacion2_key" <%- parseInt(precotizacion2_key) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_color1" name="precotizacion2_color1" value="precotizacion2_color1" <%- parseInt(precotizacion2_color1) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_color2" name="precotizacion2_color2" value="precotizacion2_color2" <%- parseInt(precotizacion2_color2) ? 'checked': ''%>></td>
                                                        </tr>
                                                    @endif
                                                    @if($producto->productop_retiro)
                                                        <tr>
                                                            <th class="text-center">R <input type="checkbox" id="precotizacion2_retiro" name="precotizacion2_retiro" class="check-type" value="precotizacion2_retiro" <%- parseInt(precotizacion2_retiro) ? 'checked': ''%>></th>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_yellow2" name="precotizacion2_yellow2" value="precotizacion2_yellow2" <%- parseInt(precotizacion2_yellow2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_magenta2" name="precotizacion2_magenta2" value="precotizacion2_magenta2" <%- parseInt(precotizacion2_magenta2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_cyan2" name="precotizacion2_cyan2" value="precotizacion2_cyan2" <%- parseInt(precotizacion2_cyan2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_key2" name="precotizacion2_key2" value="precotizacion2_key2" <%- parseInt(precotizacion2_key2) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_color12" name="precotizacion2_color12" value="precotizacion2_color12" <%- parseInt(precotizacion2_color12) ? 'checked': ''%>></td>
                                                            <td class="text-center"><input type="checkbox" id="precotizacion2_color22" name="precotizacion2_color22" value="precotizacion2_color22" <%- parseInt(precotizacion2_color22) ? 'checked': ''%>></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @if($producto->productop_tiro)
                                            <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                                <label for="precotizacion2_nota_tiro" class="control-label">Nota tiro</label>
                                                <textarea id="precotizacion2_nota_tiro" name="precotizacion2_nota_tiro" class="form-control" rows="2" placeholder="Nota tiro"><%- precotizacion2_nota_tiro %></textarea>
                                            </div>
                                        @endif

                                        @if($producto->productop_retiro)
                                            <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                                <label for="precotizacion2_nota_retiro" class="control-label">Nota retiro</label>
                                                <textarea id="precotizacion2_nota_retiro" name="precotizacion2_nota_retiro" class="form-control" rows="2" placeholder="Nota retiro"><%- precotizacion2_nota_retiro %></textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Content produccion --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Maquinas de producción</h3>
                                    </div>
                                    <div class="box-body">
                                        @foreach( App\Models\Production\PreCotizacion8::getPreCotizaciones8($producto->id, isset($precotizacion2) ? $precotizacion2->id : null ) as $maquina)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label class="checkbox-inline without-padding white-space-normal" for="precotizacion8_maquinap_{{ $maquina->id }}">
                                                        <input type="checkbox" id="precotizacion8_maquinap_{{ $maquina->id }}" name="precotizacion8_maquinap_{{ $maquina->id }}" value="precotizacion8_maquinap_{{ $maquina->id }}" {{ $maquina->activo ? 'checked': '' }}> {{ $maquina->maquinap_nombre }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Acabados de producción</h3>
                                    </div>
                                    <div class="box-body">
                                        @foreach( App\Models\Production\PreCotizacion7::getPreCotizaciones7($producto->id, isset($precotizacion2) ? $precotizacion2->id : null ) as $acabado)
            								<div class="row">
            									<div class="form-group col-md-12">
            										<label class="checkbox-inline without-padding white-space-normal" for="precotizacion7_acabadop_{{ $acabado->id }}">
            											<input type="checkbox" id="precotizacion7_acabadop_{{ $acabado->id }}" name="precotizacion7_acabadop_{{ $acabado->id }}" value="precotizacion7_acabadop_{{ $acabado->id }}" {{ $acabado->activo ? 'checked': '' }}> {{ $acabado->acabadop_nombre }}
            										</label>
            									</div>
            								</div>
            							@endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Content imagenes --}}
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Imágenes</h3>
                        </div>

                        <div class="box-body table-responsive no-padding">
                            <div class="fine-uploader"></div>
                        </div>
                    </div>

                    {{-- Content materialesp --}}
                    <div id="materialesp-wrapper-producto" class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Materiales de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-materialp-producto" data-toggle="validator">
                                <div class="row">
                                    @foreach( App\Models\Production\PreCotizacion3::getMaterials( $producto->id ) as $key => $value )
                                        <div class="form-group col-md-4">
                                            <label>{{ $value }}</label>
                                        </div>
                                    @endforeach
                                </div><br>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <select name="precotizacion3_materialp" id="precotizacion3_materialp" class="form-control select2-default-clear change-materialp" data-placeholder="Material de producción" data-field="precotizacion3_producto" data-wrapper="materialesp-wrapper-producto" data-reference="material" required>
                                            <option value hidden selected>Seleccione</option>
                                            @foreach( App\Models\Production\PreCotizacion3::getMaterials( $producto->id ) as $key => $value )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <select name="precotizacion3_producto" id="precotizacion3_producto" class="form-control select2-default-clear change-insumo" data-placeholder="Insumo" data-historial="historial_precotizacion3" data-valor="precotizacion3_valor_unitario" disabled required>
                                            <option value hidden selected>Seleccione</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="precotizacion3_medidas" name="precotizacion3_medidas" placeholder="Medidas" class="form-control input-xs input-formula calculate-formula" data-response="precotizacion3_cantidad" maxlength="50" required>
                                            <span class="input-group-addon">=</span>
                                            <input type="text" id="precotizacion3_cantidad" name="precotizacion3_cantidad" placeholder="Total" class="form-control text-right" disabled>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="precotizacion3_valor_unitario" name="precotizacion3_valor_unitario" class="form-control input-sm" type="text" data-currency required>
                                        <div class="help-block pull-right"><a id="historial_precotizacion3" class="historial-insumo cursor-pointer"></a></div>
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
                                <table id="browse-precotizacion-producto-materiales-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
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
                    <div id="areasp-wrapper-producto" class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Áreas de producción</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" accept-charset="UTF-8" id="form-areap-producto" data-toggle="validator">
                                <div class="row">
                                    <div class="form-group col-sm-5 col-md-offset-1">
                                        <select id="precotizacion6_areap" name="precotizacion6_areap" class="form-control select2-default-clear">
                                            <option value hidden selected>Seleccione</option>
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
                                        <input type="number" id="precotizacion6_horas" name="precotizacion6_horas" placeholder="Hora" value="0" class="form-control input-xs" min="0" step="1" max="9999" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <input type="number" id="precotizacion6_minutos" name="precotizacion6_minutos" placeholder="Minutos" value="0" class="form-control input-xs" min="00" step="01" max="59" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="precotizacion6_valor" name="precotizacion6_valor" class="form-control input-sm" type="text" data-currency required>
                                        <div class="help-block with-errors"></div>
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
                                <table id="browse-precotizacion-producto-areas-list" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="2" width="5%"></th>
                                            <th>Área</th>
                                            <th>Nombre</th>
                                            <th width="10%">Tiempo</th>
                                            <th width="15%">Valor</th>
                                            <th width="15%">Total</th>
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
                    <div id="empaques-wrapper-producto" class="box box-success">
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
                                        <select name="precotizacion9_materialp" id="precotizacion9_materialp" class="form-control select2-default-clear change-materialp" data-placeholder="Empaques de producción" data-field="precotizacion9_producto" data-wrapper="empaques-wrapper-producto" data-reference="empaque" required>
                                            <option value hidden selected>Seleccione</option>
                                            @foreach( App\Models\Production\Productop5::getPackaging() as $empaque )
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <select name="precotizacion9_producto" id="precotizacion9_producto" class="form-control select2-default-clear change-insumo" data-placeholder="Insumo" data-historial="historial_precotizacion9" data-valor="precotizacion9_valor_unitario" disabled required>
                                            <option value hidden selected>Seleccione</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="precotizacion9_medidas" name="precotizacion9_medidas" placeholder="Medidas" class="form-control input-xs input-formula calculate-formula" data-response="precotizacion9_cantidad" maxlength="50" required>
                                            <span class="input-group-addon">=</span>
                                            <input type="text" id="precotizacion9_cantidad" name="precotizacion3_cantidad" class="form-control text-right" placeholder="Total" disabled>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <input id="precotizacion9_valor_unitario" name="precotizacion9_valor_unitario" class="form-control input-sm" type="text" required data-currency>
                                        <div class="help-block pull-right"><a id="historial_precotizacion9" class="historial-insumo cursor-pointer"></a></div>
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
                                <table id="browse-precotizacion-producto-empaques-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
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
        </section>
    </script>

    <script type="text/template" id="precotizacion-delete-materialp-confirm-tpl">
        <p>¿Está seguro que desea eliminar el material <b><%- materialp_nombre %> </b>?</p>
    </script>

    <script type="text/template" id="precotizacion-delete-empaque-confirm-tpl">
        <p>¿Está seguro que desea eliminar el empaque <b><%- empaque_nombre %> </b>?</p>
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
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-materialp-precotizacion-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- materialp_nombre %></td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
        <td><%- precotizacion3_medidas %></td>
        <td><%- precotizacion3_cantidad %></td>
        <td class="text-right"><%- window.Misc.currency( precotizacion3_valor_unitario ) %></td>
        <td class="text-right"><%- window.Misc.currency( precotizacion3_valor_total ) %></td>
    </script>

    <script type="text/template" id="precotizacion-producto-materialp-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-materialp-precotizacion-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
        <td colspan="4">
            <div class="input-group">
                <input type="text" id="precotizacion3_medidas_<%- id %>" name="precotizacion3_medidas_<%- id %>" value="<%- precotizacion3_medidas %>" placeholder="Medidas" class="form-control input-xs input-formula calculate-formula" data-response="precotizacion3_cantidad_<%- id %>" maxlength="50" required>
                <span class="input-group-addon">=</span>
                <input type="text" id="precotizacion3_cantidad_<%- id %>" name="precotizacion3_cantidad_<%- id %>" value="<%- precotizacion3_cantidad %>" placeholder="Total" class="form-control text-right" disabled>
            </div>
        </td>
        <td colspan="2" class="text-right">
            <input id="precotizacion3_valor_unitario_<%- id %>" name="precotizacion3_valor_unitario_<%- id %>" value="<%- precotizacion3_valor_unitario %>" class="form-control input-sm" type="text" data-currency required>
        </td>
    </script>

    <script type="text/template" id="precotizacion-producto-empaque-item-tpl">
        <% if( edit ) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-empaque-precotizacion-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-producto-empaque-precotizacion-edit" data-resource="<%- id %>">
                    <span><i class="fa fa-pencil-square-o"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- !_.isUndefined(empaque_nombre) && !_.isNull(empaque_nombre) ? empaque_nombre : "-" %></td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
        <td><%- precotizacion9_medidas %></td>
        <td><%- precotizacion9_cantidad %></td>
        <td class="text-right"><%- window.Misc.currency( precotizacion9_valor_unitario ) %></td>
        <td class="text-right"><%- window.Misc.currency( precotizacion9_valor_total ) %></td>
    </script>

    <script type="text/template" id="precotizacion-producto-empaque-edit-item-tpl">
        <td class="text-center" colspan="2">
            <a class="btn btn-success btn-xs item-producto-empaque-precotizacion-success" data-resource="<%- id %>">
                <span><i class="fa fa-check"></i></span>
            </a>
        </td>
        <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
        <td colspan="4">
            <div class="input-group">
                <input type="text" id="precotizacion9_medidas_<%- id %>" name="precotizacion9_medidas_<%- id %>" value="<%- precotizacion9_medidas %>" placeholder="Medidas" class="form-control input-xs input-formula calculate-formula" data-response="precotizacion9_cantidad_<%- id %>" maxlength="50" required>
                <span class="input-group-addon">=</span>
                <input type="text" id="precotizacion9_cantidad_<%- id %>" name="precotizacion9_cantidad_<%- id %>" value="<%- precotizacion9_cantidad %>" placeholder="Total" class="form-control text-right" disabled>
            </div>
        </td>
        <td colspan="2" class="text-right">
            <input id="precotizacion9_valor_unitario_<%- id %>" name="precotizacion9_valor_unitario_<%- id %>" value="<%- precotizacion9_valor_unitario %>" class="form-control input-sm" type="text" data-currency required>
        </td>
    </script>

    <script type="text/template" id="precotizacion-producto-areasp-item-tpl">
        <% if(edit) { %>
           <td class="text-center">
               <a class="btn btn-default btn-xs item-producto-areasp-precotizacion-remove" data-resource="<%- id %>">
                   <span><i class="fa fa-times"></i></span>
               </a>
           </td>
           <td class="text-center">
               <a class="btn btn-default btn-xs item-producto-areasp-precotizacion-edit" data-resource="<%- id %>">
                   <span><i class="fa fa-pencil-square-o"></i></span>
               </a>
           </td>
       <% } %>
       <td><%- areap_nombre ? areap_nombre : '-' %></td>
       <td><%- precotizacion6_nombre ? precotizacion6_nombre : '-' %></td>
       <td><%- precotizacion6_horas %>:<%- precotizacion6_minutos %></td>
       <td class="text-right"><%- window.Misc.currency( precotizacion6_valor ) %></td>
       <td class="text-right"><%- window.Misc.currency( total ) %></td>
    </script>

    <script type="text/template" id="precotizacion-producto-areasp-edit-item-tpl">
       <td colspan="2" class="text-center">
           <a class="btn btn-success btn-xs item-producto-areasp-precotizacion-success" data-resource="<%- id %>">
               <span><i class="fa fa-check"></i></span>
           </a>
       </td>
       <td><%- areap_nombre ? areap_nombre : precotizacion6_nombre %></td>
       <td colspan="2">
           <input type="number" id="precotizacion6_horas_<%- id %>" name="precotizacion6_horas_<%- id %>" placeholder="Hora" value="<%- precotizacion6_horas %>" class="form-control input-xs change-time" data-type="hs" min="0" step="1" max="9999" required>
       </td>
       <td colspan="2">
           <input type="number" id="precotizacion6_minutos_<%- id %>" name="precotizacion6_minutos_<%- id %>" placeholder="Minutos" value="<%- precotizacion6_minutos %>" class="form-control input-xs change-time" data-type="ms" min="00" step="01" max="59" required>
       </td>
    </script>

    <script type="text/template" id="qq-template-precotizacion">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{{ trans('app.files.drop') }}">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>

            <div class="buttons">
                <div class="qq-upload-button-selector qq-upload-button">
                    <div><i class="fa fa-folder-open" aria-hidden="true"></i> {{ trans('app.files.choose-file') }}</div>
                </div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>{{ trans('app.files.process') }}</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
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
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">{{ trans('app.delete') }}</button>
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
