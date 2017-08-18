@extends('layout.layout')

@section('title') Cotizaciones @stop

@section('content')
    <section class="content-header">
        <h1>
            Cotizaciones <small>Administración de cotizaciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')
    </section>

    <script type="text/template" id="add-cotizacion-producto-tpl">
        <form method="POST" accept-charset="UTF-8" id="form-cotizacion-producto" data-toggle="validator">
        	<div class="row">
                <label class="col-sm-1 control-label">Cotizacion</label>
                <div class="form-group col-md-1">
                	{{ $cotizacion->cotizacion_codigo }}
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
                <label for="cotizacion2_referencia" class="col-sm-1 control-label">Referencia</label>
                <div class="form-group col-md-8">
                    <input id="cotizacion2_referencia" value="<%- cotizacion2_referencia %>" placeholder="Referencia" class="form-control input-sm input-toupper" name="cotizacion2_referencia" type="text" maxlength="200" required>
                </div>

                <label for="cotizacion2_cantidad" class="col-sm-1 control-label">Cantidad</label>
                <div class="form-group col-md-2">
                    <input id="cotizacion2_cantidad" value="<%- cotizacion2_cantidad %>" class="form-control input-sm" name="cotizacion2_cantidad" type="number" min="1" required>
                </div>
            </div>

            @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                <div class="row">
                    <label for="cotizacion2_precio_formula" class="col-sm-1 control-label">Fórmula</label>
                    <div class="form-group col-md-8">
                    	<input id="cotizacion2_precio_formula" value="<%- cotizacion2_precio_formula %>" placeholder="Fórmula" class="form-control input-sm" name="cotizacion2_precio_formula" type="text" maxlength="200">
               		</div>
               		<label for="cotizacion2_round_formula" class="col-sm-1 control-label">Redondear</label>
                    <div class="form-group col-md-1">
                        <input id="cotizacion2_round_formula" value="<%- cotizacion2_round_formula %>" class="form-control input-sm" name="cotizacion2_round_formula" type="text" maxlength="5">
                    </div>
               </div>

               <div class="row">
                    <label for="cotizacion2_precio_venta" class="col-sm-1 control-label">Precio</label>
                    <div class="form-group col-md-3">
                    	<input id="cotizacion2_precio_venta" value="<%- cotizacion2_precio_venta %>" placeholder="Precio" class="form-control input-sm" name="cotizacion2_precio_venta" type="text" maxlength="30" data-currency required>
               		</div>
               	</div>
            @endif

            @if($producto->productop_abierto || $producto->productop_cerrado)
                <div class="box box-primary">
                    <div class="box-body">
                        @if($producto->productop_abierto)
                            <div class="row">
                                <label class="col-sm-offset-1 col-sm-1 control-label">Abierto</label>
                                <label for="cotizacion2_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        <input id="cotizacion2_ancho" value="<%- cotizacion2_ancho %>" class="form-control input-sm" name="cotizacion2_ancho" type="number" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m1_sigla }}</div>
                                </div>

                                <label for="cotizacion2_alto" class="col-sm-1 control-label text-right">Alto</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        <input id="cotizacion2_alto" value="<%- cotizacion2_alto %>" class="form-control input-sm" name="cotizacion2_alto" type="number" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m2_sigla }}</div>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_cerrado)
                            <div class="row">
                                <label class="col-sm-offset-1 col-sm-1 control-label">Cerrado</label>
                                <label for="cotizacion2_c_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        <input id="cotizacion2_c_ancho" value="<%- cotizacion2_c_ancho %>" class="form-control input-sm" name="cotizacion2_c_ancho" type="number" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-3 text-left">{{ $producto->m3_sigla }}</div>
                                </div>

                                <label for="cotizacion2_c_alto" class="col-sm-1 control-label text-right">Alto</label>
                                <div class="form-group col-md-3">
                                    <div class="col-md-9">
                                        <input id="cotizacion2_c_alto" value="<%- cotizacion2_c_alto %>" class="form-control input-sm" name="cotizacion2_c_alto" type="number" min="0" step="0.01" required>
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
                            <label for="cotizacion2_3d_ancho" class="col-sm-1 control-label text-right">Ancho</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                    <input id="cotizacion2_3d_ancho" value="<%- cotizacion2_3d_ancho %>" class="form-control input-sm" name="cotizacion2_3d_ancho" type="number" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m5_sigla }}</div>
                            </div>

                            <label for="cotizacion2_3d_alto" class="col-sm-1 control-label text-right">Alto</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                    <input id="cotizacion2_3d_alto" value="<%- cotizacion2_3d_alto %>" class="form-control input-sm" name="cotizacion2_3d_alto" type="number" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-3 text-left">{{ $producto->m6_sigla }}</div>
                            </div>

                            <label for="cotizacion2_3d_profundidad" class="col-sm-1 control-label text-right">Profundidad</label>
                            <div class="form-group col-md-2">
                                <div class="col-md-9">
                                    <input id="cotizacion2_3d_profundidad" value="<%- cotizacion2_3d_profundidad %>" class="form-control input-sm" name="cotizacion2_3d_profundidad" type="number" min="0" step="0.01" required>
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
                                    <label for="cotizacion2_tiro" class="control-label">T</label>
                                    <input type="checkbox" id="cotizacion2_tiro" name="cotizacion2_tiro" value="cotizacion2_tiro" <%- parseInt(cotizacion2_tiro) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_yellow" name="cotizacion2_yellow" value="cotizacion2_yellow" <%- parseInt(cotizacion2_yellow) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_magenta" name="cotizacion2_magenta" value="cotizacion2_magenta" <%- parseInt(cotizacion2_magenta) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_cyan" name="cotizacion2_cyan" value="cotizacion2_cyan" <%- parseInt(cotizacion2_cyan) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_key" name="cotizacion2_key" value="cotizacion2_key" <%- parseInt(cotizacion2_key) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_color1" name="cotizacion2_color1" value="cotizacion2_color1" <%- parseInt(cotizacion2_color1) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_color2" name="cotizacion2_color2" value="cotizacion2_color2" <%- parseInt(cotizacion2_color2) ? 'checked': ''%>>
                                </div>
                            </div>
                        @endif

                        @if($producto->productop_retiro)
                            <div class="row">
                                <div class="col-sm-offset-2 col-md-1">
                                    <label for="cotizacion2_retiro" class="control-label">R</label>
                                    <input type="checkbox" id="cotizacion2_retiro" name="cotizacion2_retiro" value="cotizacion2_retiro" <%- parseInt(cotizacion2_retiro) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_yellow2" name="cotizacion2_yellow2" value="cotizacion2_yellow2" <%- parseInt(cotizacion2_yellow2) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_magenta2" name="cotizacion2_magenta2" value="cotizacion2_magenta2" <%- parseInt(cotizacion2_magenta2) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_cyan2" name="cotizacion2_cyan2" value="cotizacion2_cyan2" <%- parseInt(cotizacion2_cyan2) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_key2" name="cotizacion2_key2" value="cotizacion2_key2" <%- parseInt(cotizacion2_key2) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_color12" name="cotizacion2_color12" value="cotizacion2_color12" <%- parseInt(cotizacion2_color12) ? 'checked': ''%>>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" id="cotizacion2_color22" name="cotizacion2_color22" value="cotizacion2_color22" <%- parseInt(cotizacion2_color22) ? 'checked': ''%>>
                                </div>
                            </div>
                        @endif

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
                <label for="cotizacion2_observaciones" class="col-sm-1 control-label">Detalle</label>
                <div class="form-group col-sm-10">
                    <textarea id="cotizacion2_observaciones" name="cotizacion2_observaciones" class="form-control" rows="2" placeholder="Detalle"><%- cotizacion2_observaciones %></textarea>
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
                        <div class="box-body" id="browse-cotizacion-producto-maquinas-list">
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
                        <div class="box-body" id="browse-cotizacion-producto-materiales-list">
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
                        <div class="box-body" id="browse-cotizacion-producto-acabados-list">
                            {{-- render acabados list --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </script>

    <script type="text/template" id="cotizacion-producto-maquina-item-tpl">
        <div class="form-group col-md-12">
            <label class="checkbox-inline without-padding white-space-normal" for="cotizacion3_maquinap_<%- id %>">
                <input type="checkbox" id="cotizacion3_maquinap_<%- id %>" name="cotizacion3_maquinap_<%- id %>" value="cotizacion3_maquinap_<%- id %>" <%- parseInt(activo) ? 'checked': ''%>> <%- maquinap_nombre %>
            </label>
        </div>
    </script>

    <script type="text/template" id="cotizacion-producto-material-item-tpl">
        <div class="form-group col-md-12">
            <label class="checkbox-inline without-padding white-space-normal" for="cotizacion4_materialp_<%- id %>">
                <input type="checkbox" id="cotizacion4_materialp_<%- id %>" name="cotizacion4_materialp_<%- id %>" value="cotizacion4_materialp_<%- id %>" <%- parseInt(activo) ? 'checked': ''%>> <%- materialp_nombre %>
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
@stop
