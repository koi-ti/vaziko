@extends('layout.layout')

@section('title') Ordenes de producción @stop

@section('content')
    <section class="content-header">
        <h1>
            Ordenes de producción <small>Administración de ordenes de producción</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-orden-producto-tpl">
        <form method="POST" accept-charset="UTF-8" id="form-orden-producto" data-toggle="validator">
        	<div class="row">
                <label class="col-sm-1 control-label">Orden</label>
                <div class="form-group col-md-1">
                	{{ $orden->orden_codigo }}
                </div>

                <label class="col-sm-2 control-label">Código producto</label>
                <div class="form-group col-md-1">
					{{ $producto->id }}
				</div>
            </div>

            <div class="row">
                <label class="col-sm-1 control-label">Producto</label>
                <div class="form-group col-md-11">
                	{{ $producto->productop_nombre }}
                </div>
            </div>

            <div class="row">
                <label for="orden2_referencia" class="col-sm-1 control-label">Referencia</label>
                <div class="form-group col-md-8">
                    <input id="orden2_referencia" value="<%- orden2_referencia %>" placeholder="Referencia" class="form-control input-sm input-toupper" name="orden2_referencia" type="text" maxlength="200" required>
                </div>

                <label for="orden2_cantidad" class="col-sm-1 control-label">Cantidad</label>
                <div class="form-group col-md-2">
                    <input id="orden2_cantidad" value="<%- orden2_cantidad %>" class="form-control input-sm" name="orden2_cantidad" type="number" min="1" required>
                </div>
            </div>

            @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'ordenes']) )
                <div class="row">
                    <label for="orden2_precio_formula" class="col-sm-1 control-label">Fórmula</label>
                    <div class="form-group col-md-8">
                    	<input id="orden2_precio_formula" value="<%- orden2_precio_formula %>" placeholder="Fórmula" class="form-control input-sm" name="orden2_precio_formula" type="text" maxlength="200">
               		</div>
               		<label for="orden2_round_formula" class="col-sm-1 control-label">Redondear</label>
                    <div class="form-group col-md-1">
                        <input id="orden2_round_formula" value="<%- orden2_round_formula %>" class="form-control input-sm" name="orden2_round_formula" type="text" maxlength="5">
                    </div>
               </div>

               <div class="row">
                    <label for="orden2_precio_venta" class="col-sm-1 control-label">Precio</label>
                    <div class="form-group col-md-3">
                    	<input id="orden2_precio_venta" value="<%- orden2_precio_venta %>" placeholder="Precio" class="form-control input-sm" name="orden2_precio_venta" type="text" maxlength="30" data-currency required>
               		</div>
               	</div>
            @endif

            @if($producto->productop_abierto || $producto->productop_cerrado)
                <div class="box box-primary">
                    <div class="box-body">
                        @if($producto->productop_abierto)
                            <div class="row">
                                <label class="col-sm-offset-1 col-sm-1 control-label">Abierto</label>
                                <label for="orden2_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        <input id="orden2_ancho" value="<%- orden2_ancho %>" class="form-control input-sm" name="orden2_ancho" type="number" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m1_sigla }}</div>
                                </div>

                                <label for="orden2_alto" class="col-sm-1 control-label text-right">Alto</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        <input id="orden2_alto" value="<%- orden2_alto %>" class="form-control input-sm" name="orden2_alto" type="number" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m2_sigla }}</div>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_cerrado)
                            <div class="row">
                                <label class="col-sm-offset-1 col-sm-1 control-label">Cerrado</label>
                                <label for="orden2_c_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        <input id="orden2_c_ancho" value="<%- orden2_c_ancho %>" class="form-control input-sm" name="orden2_c_ancho" type="number" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m3_sigla }}</div>
                                </div>

                                <label for="orden2_c_alto" class="col-sm-1 control-label text-right">Alto</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        <input id="orden2_c_alto" value="<%- orden2_c_alto %>" class="form-control input-sm" name="orden2_c_alto" type="number" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m4_sigla }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($producto->productop_3d)
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <label class="col-sm-offset-1 col-sm-1 control-label">3D</label>
                            <label for="orden2_3d_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                    <input id="orden2_3d_ancho" value="<%- orden2_3d_ancho %>" class="form-control input-sm" name="orden2_3d_ancho" type="number" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m5_sigla }}</div>
                            </div>

                            <label for="orden2_3d_alto" class="col-sm-1 control-label text-right">Alto</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                    <input id="orden2_3d_alto" value="<%- orden2_3d_alto %>" class="form-control input-sm" name="orden2_3d_alto" type="number" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m6_sigla }}</div>
                            </div>

                            <label for="orden2_3d_profundidad" class="col-sm-1 control-label text-right">Profundidad</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                    <input id="orden2_3d_profundidad" value="<%- orden2_3d_profundidad %>" class="form-control input-sm" name="orden2_3d_profundidad" type="number" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m7_sigla }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($producto->productop_tiro || $producto->productop_retiro)
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <label class="col-sm-offset-2 col-sm-1 control-label"></label>
                            <label class="col-sm-1 control-label">C</label>
                            <label class="col-sm-1 control-label">M</label>
                            <label class="col-sm-1 control-label">Y</label>
                            <label class="col-sm-1 control-label">K</label>
                            <label class="col-sm-1 control-label">P1</label>
                            <label class="col-sm-1 control-label">P2</label>
                        </div>

                        @if($producto->productop_tiro)
                            <div class="row">
                                <div class="col-sm-offset-2 col-md-1">
                                    <label for="orden2_tiro" class="control-label">T</label>
                                    <input type="checkbox" id="orden2_tiro" name="orden2_tiro" value="orden2_tiro" <%- orden2_tiro ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_yellow" name="orden2_yellow" value="orden2_yellow" <%- orden2_yellow ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_magenta" name="orden2_magenta" value="orden2_magenta" <%- orden2_magenta ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_cyan" name="orden2_cyan" value="orden2_cyan" <%- orden2_cyan ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_key" name="orden2_key" value="orden2_key" <%- orden2_key ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_color1" name="orden2_color1" value="orden2_color1" <%- orden2_color1 ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_color2" name="orden2_color2" value="orden2_color2" <%- orden2_color2 ? 'checked': ''%>>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_retiro)
                            <div class="row">
                                <div class="col-sm-offset-2 col-md-1">
                                    <label for="orden2_retiro" class="control-label">R</label>
                                    <input type="checkbox" id="orden2_retiro" name="orden2_retiro" value="orden2_retiro" <%- orden2_retiro ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_yellow2" name="orden2_yellow2" value="orden2_yellow2" <%- orden2_yellow2 ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_magenta2" name="orden2_magenta2" value="orden2_magenta2" <%- orden2_magenta2 ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_cyan2" name="orden2_cyan2" value="orden2_cyan2" <%- orden2_cyan2 ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_key2" name="orden2_key2" value="orden2_key2" <%- orden2_key2 ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_color12" name="orden2_color12" value="orden2_color12" <%- orden2_color12 ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="orden2_color22" name="orden2_color22" value="orden2_color22" <%- orden2_color22 ? 'checked': ''%>>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            @if($producto->productop_tiro)
                                <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                    <label for="orden2_nota_tiro" class="control-label">Nota tiro</label>
                                    <textarea id="orden2_nota_tiro" name="orden2_nota_tiro" class="form-control" rows="2" placeholder="Nota tiro"><%- orden2_nota_tiro %></textarea>
                                </div>
                            @endif

                            @if($producto->productop_retiro)
                                <div class="form-group @if($producto->productop_tiro && $producto->productop_retiro) col-sm-6 @else col-sm-12 @endif">
                                    <label for="orden2_nota_retiro" class="control-label">Nota retiro</label>
                                    <textarea id="orden2_nota_retiro" name="orden2_nota_retiro" class="form-control" rows="2" placeholder="Nota retiro"><%- orden2_nota_retiro %></textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <label for="orden2_observaciones" class="col-sm-1 control-label">Detalle</label>
                <div class="form-group col-sm-10">
                    <textarea id="orden2_observaciones" name="orden2_observaciones" class="form-control" rows="2" placeholder="Detalle"><%- orden2_observaciones %></textarea>
                </div>
            </div>

            <br/>
            <div class="row">
                {{-- Content maquinas --}}
                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Máquinas</h3>
                        </div>
                        <div class="box-body" id="browse-orden-producto-maquinas-list">
                            {{-- render maquinas list --}}
                        </div>
                    </div>
                </div>

                {{-- Content materiales --}}
                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Materiales</h3>
                        </div>
                        <div class="box-body" id="browse-orden-producto-materiales-list">
                            {{-- render materiales list --}}
                        </div>
                    </div>
                </div>

                {{-- Content acabados --}}
                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Acabados</h3>
                        </div>
                        <div class="box-body" id="browse-orden-producto-acabados-list">
                            {{-- render acabados list --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </script>

    <script type="text/template" id="orden-producto-maquina-item-tpl">
        <div class="form-group col-md-12">
            <label class="checkbox-inline without-padding white-space-normal" for="orden3_maquinap_<%- id %>">
                <input type="checkbox" id="orden3_maquinap_<%- id %>" name="orden3_maquinap_<%- id %>" value="orden3_maquinap_<%- id %>" <%- activo ? 'checked': ''%>> <%- maquinap_nombre %>
            </label>
        </div>
    </script>

    <script type="text/template" id="orden-producto-material-item-tpl">
        <div class="form-group col-md-12">
            <label class="checkbox-inline without-padding white-space-normal" for="orden4_materialp_<%- id %>">
                <input type="checkbox" id="orden4_materialp_<%- id %>" name="orden4_materialp_<%- id %>" value="orden4_materialp_<%- id %>" <%- activo ? 'checked': ''%>> <%- materialp_nombre %>
            </label>
        </div>
    </script>

    <script type="text/template" id="orden-producto-acabado-item-tpl">
        <div class="form-group col-md-12">
            <label class="checkbox-inline without-padding white-space-normal" for="orden5_acabadop_<%- id %>">
                <input type="checkbox" id="orden5_acabadop_<%- id %>" name="orden5_acabadop_<%- id %>" value="orden5_acabadop_<%- id %>" <%- activo ? 'checked': ''%>> <%- acabadop_nombre %>
            </label>
        </div>
    </script>
@stop