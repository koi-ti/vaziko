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
                <div class="form-group col-md-10">
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
                    <input id="cotizacion2_cantidad" value="<%- cotizacion2_cantidad %>" class="form-control input-sm event-price" name="cotizacion2_cantidad" type="number" min="1" required>
                </div>
            </div>

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
            </div>

            @if( Auth::user()->ability('admin', 'opcional2', ['module' => 'cotizaciones']) )
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Fórmulas</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <label for="cotizacion2_precio_formula" class="col-sm-1 control-label">Fórmula</label>
                            <div class="form-group col-md-5">
                                <input id="cotizacion2_precio_formula" value="<%- cotizacion2_precio_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_precio_formula" type="text" maxlength="200" data-input="P">
                            </div>
                            <label for="cotizacion2_precio_round" class="col-sm-1 control-label">Redondear</label>
                            <div class="form-group col-md-1">
                                <input id="cotizacion2_precio_round" value="<%- cotizacion2_precio_round %>" class="form-control input-sm calculate_formula" name="cotizacion2_precio_round" type="text" maxlength="5" data-input="RP">
                            </div>
                            <label for="cotizacion2_precio_venta" class="col-sm-1 control-label">Precio</label>
                            <div class="form-group col-md-3">
                                <input id="cotizacion2_precio_venta" value="<%- cotizacion2_precio_venta %>" placeholder="Precio" class="form-control input-sm event-price" name="cotizacion2_precio_venta" type="text" maxlength="30" data-currency required>
                            </div>
                        </div>
                        <div class="row">
                            <label for="cotizacion2_transporte_formula" class="col-sm-1 control-label">Fórmula</label>
                            <div class="form-group col-md-5">
                                <input id="cotizacion2_transporte_formula" value="<%- cotizacion2_transporte_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_transporte_formula" type="text" maxlength="200" data-input="T">
                            </div>
                            <label for="cotizacion2_transporte_round" class="col-sm-1 control-label">Redondear</label>
                            <div class="form-group col-md-1">
                                <input id="cotizacion2_transporte_round" value="<%- cotizacion2_transporte_round %>" class="form-control input-sm  calculate_formula" name="cotizacion2_transporte_round" type="text" maxlength="5" data-input="RT">
                            </div>
                            <label for="cotizacion2_transporte" class="col-sm-1 control-label">Transporte</label>
                            <div class="form-group col-md-3">
                                <input id="cotizacion2_transporte" value="<%- cotizacion2_transporte %>" class="form-control input-sm event-price" name="cotizacion2_transporte" type="text" maxlength="30" data-currency required>
                            </div>
                        </div>
                        <div class="row">
                            <label for="cotizacion2_viaticos_formula" class="col-sm-1 control-label">Fórmula</label>
                            <div class="form-group col-md-5">
                                <input id="cotizacion2_viaticos_formula" value="<%- cotizacion2_viaticos_formula %>" placeholder="Fórmula" class="form-control input-sm calculate_formula" name="cotizacion2_viaticos_formula" type="text" maxlength="200" data-input="V">
                            </div>
                            <label for="cotizacion2_viaticos_round" class="col-sm-1 control-label">Redondear</label>
                            <div class="form-group col-md-1">
                                <input id="cotizacion2_viaticos_round" value="<%- cotizacion2_viaticos_round %>" class="form-control input-sm  calculate_formula" name="cotizacion2_viaticos_round" type="text" maxlength="5" data-input="RV">
                            </div>
                            <label for="cotizacion2_viaticos" class="col-sm-1 control-label">Viaticos</label>
                            <div class="form-group col-md-3">
                                <input id="cotizacion2_viaticos" value="<%- cotizacion2_viaticos %>" class="form-control input-sm event-price" name="cotizacion2_viaticos" type="text" maxlength="30" data-currency required>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </form>

        {{-- Content areasp --}}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Áreas</h3>
            </div>
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-cotizacion6-producto" data-toggle="validator">
                    <div class="row">
                        <label for="cotizacion6_areap" class="control-label col-sm-1">Área</label>
                        <div class="form-group col-sm-3">
                            <select name="cotizacion6_areap" id="cotizacion6_areap" class="form-control select2-default-clear">
                                <option value="" selected>Seleccione</option>
                                @foreach( App\Models\Production\Areap::getAreas() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-3">
                            <input id="cotizacion6_nombre" name="cotizacion6_nombre" placeholder="Nombre" class="form-control input-sm input-toupper" type="text" maxlength="20">
                        </div>

                        <div class="form-group col-sm-2">
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input type="text" id="cotizacion6_horas" name="cotizacion6_horas" placeholder="Horas" class="form-control input-sm timepicker" required>
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <input id="cotizacion6_valor" name="cotizacion6_valor" class="form-control input-sm" type="text" required data-currency>
                        </div>
                        <div class="form-group col-sm-1">
                            <button type="submit" class="btn btn-success btn-sm btn-block disabled">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table id="browse-cotizacion-producto-areas-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Área</th>
                                <th>Nombre</th>
                                <th>Horas</th>
                                <th>Valor</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <th class="text-right">Total</th>
                                <th class="text-right" id="total">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informacion Adicional</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="col-sm-6">Precio</label>
                                <div class="col-md-6 text-right">
                                    <label id="info-precio">0</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="col-sm-6">Transporte</label>
                                <div class="col-md-6 text-right">
                                    <label id="info-transporte">0</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="col-sm-6">Viaticos</label>
                                <div class="col-md-6 text-right">
                                    <label id="info-viaticos">0</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="col-sm-6">Áreas</label>
                                <div class="col-md-6 text-right">
                                    <label id="info-areas">0,00</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="col-sm-6 control-label">Total</label>
                                <div class="form-group col-md-6">
                                    <input id="total-price" class="form-control input-sm" data-currency disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-sm-12">
                            <b><small>Los campos de transporte, viaticos y areas se dividiran por la cantidad ingresada.</small></b>
                        </div>
                    </div>
                </div>
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
       <td><%- moment(cotizacion6_horas, 'HH:mm').format('HH:mm') %></td>
       <td class="text-right"><%- window.Misc.currency( cotizacion6_valor ) %></td>
       <td class="text-right"><%- window.Misc.currency( total ) %></td>
    </script>
@stop
