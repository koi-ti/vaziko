@extends('inventory.productos.main')

@section('breadcrumb')
    <li><a href="{{ route('productos.index')}}">Insumos</a></li>
    <li class="active">{{ $producto->producto_codigo }}</li>
@stop

@section('module')
    <section id="product-content-section">
        <!-- Modal generic producto -->
        <div class="modal fade" id="modal-product-generic" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header small-box {{ config('koi.template.bg') }}">
                        <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="inner-title-modal modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="content-modal">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="box box-success" id="producto-show">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Código</label>
                    <div>{{ $producto->producto_codigo }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Código proveedor</label>
                    <div>{{ $producto->producto_codigoori }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Referencia</label>
                    <div><a href="{{ route('productos.show', ['productos' => $producto->referencia_id]) }}" title="Ver referencia">{{ $producto->referencia_codigo }}</a></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nombre</label>
                    <div>{{ $producto->producto_nombre }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Grupo</label>
                    <div>{{ $producto->grupo_nombre }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Subgrupo</label>
                    <div>{{ $producto->subgrupo_nombre }}</div>
                </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Material de producción</label>
                            <div>{!! $producto->materialp_nombre ? $producto->materialp_nombre : "-" !!}</div>
                    </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Unidad de medida</label>
                    <div>{{ $producto->unidadmedida_nombre }} ({{ $producto->unidadmedida_sigla }})</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Vida útil</label>
                    <div>{{ $producto->producto_vidautil }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">¿Maneja unidades?</label>
                    <div>
                        <input type="checkbox" id="producto_unidades" name="producto_unidades" value="producto_unidades" disabled {{ $producto->producto_unidades ? 'checked': '' }}>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">¿Meneja serie?</label>
                    <div>
                        <input type="checkbox" id="producto_serie" name="producto_serie" value="producto_serie" disabled {{ $producto->producto_serie ? 'checked': '' }}>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">¿Producto metrado?</label>
                    <div>
                        <input type="checkbox" id="producto_metrado" name="producto_metrado" value="producto_metrado" disabled {{ $producto->producto_metrado ? 'checked': '' }}>
                    </div>
                </div>

                @if( $producto->producto_metrado )
                    <div class="form-group col-md-2">
                        <label class="control-label">Ancho (Metros)</label>
                        <div>{{ $producto->producto_ancho }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Largo (Metros)</label>
                        <div>{{ $producto->producto_largo }}</div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Precio</label>
                    <div>{{ number_format($producto->producto_precio, 2, '.', ',') }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Costo promedio</label>
                    <div>{{ number_format($producto->producto_costo, 2, '.', ',') }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-2 {{ $producto->id == $producto->producto_referencia ? 'col-md-offset-4' : 'col-md-offset-5'}} col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('productos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    @if($producto->id == $producto->producto_referencia)
                        <a href="{{ route('productos.edit', ['productos' => $producto->id]) }}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Disponibilidad</h3>
                </div>
                <div class="box-body">
                    <div class=" table-responsive">
                        <table class="table table-striped table-condensed table-bordered" cellspacing="0">
                            <tbody>
                                <!-- Producto metrado -->
                                @if( $producto->producto_metrado )
                                <tr>
                                    <th>Sucursal</th>
                                    <th>Disponible (Mts)</th>
                                </tr>

                                @if( $available->isEmpty() )
                                <tr>
                                    <th colspan="2" class="text-center">NO EXISTEN UNIDADES EN INVENTARIO</th>
                                </tr>
                                @else
                                @foreach( $available as $item)
                                <tr>
                                    <td>{{ $item->sucursal_nombre }}</td>
                                    <td><a href="#" class="get-info-availability" title="Ver rollos" data-action="rollos" data-sucursal="{{ $item->sucursal }}" >{{ $item->disponible }}</a></td>
                                </tr>
                                @endforeach
                                @endif
                                @else
                                <tr>
                                    <th width="60%">Sucursal</th>
                                    <th width="20%">Disponible</th>
                                    <th width="20%">Reservadas</th>
                                </tr>

                                @if( $available->isEmpty() )
                                <tr>
                                    <th colspan="3" class="text-center">NO EXISTEN UNIDADES EN INVENTARIO</th>
                                </tr>
                                @else
                                @foreach( $available as $item)
                                <tr>
                                    <td>{{ $item->sucursal_nombre }}</td>
                                    <td>{{ $item->disponible }}</td>
                                    <td>{{ $item->prodbode_reservada }}</td>
                                </tr>
                                @endforeach
                                @endif
                                <!--  Hablitar btn para ver series de productos padres -->
                                @if( $producto->producto_serie && $producto->id == $producto->producto_referencia )
                                <tr>
                                    <th colspan="3" class="text-center"><a class="btn get-info-availability" data-action="series">Ver series</a></th>
                                </tr>
                                <table id="browse-prodbode-table" class="table table-striped table-condensed" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="30%">Sucursal</th>
                                            <th width="20%">Código</th>
                                            <th width="30%">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--Render series--}}
                                    </tbody>
                                </table>
                                @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Historial</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class=" table-responsive">
                        <table id="browse-history-producto-list" class="table table-striped table-condensed table-bordered" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="40%">Producción</th>
                                    <th width="15%">Fecha</th>
                                    <th width="20%">Costo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="3" class="text-center">NO EXISTEN UNIDADES EN INVENTARIO</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/template" id="itemrollo-product-tpl">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <!-- table table-bordered table-striped -->
                <div class="box-body table-responsive no-padding">
                    <table id="browse-itemtollo-list" class="table table-hover table-bordered" cellspacing="0">
                        <tr>
                            <th>Item</th>
                            <th>Metros (m)</th>
                            <th>Saldo (m)</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id="producto-history-item-list-tpl">
        <% if (type == 'PRE') { %>
            <td><span class="label label-success">PRECOTIZACIÓN</span></td>
        <% } else if (type == 'COT') { %>
            <td><span class="label label-danger">COTIZACIÓN</span></td>
        <% } else { %>
            <td><span class="label label-info">ORDEN DE PRODUCCIÓN</span></td>
        <% } %>
        <td><%- moment(fecha).format('YYYY-MM-DD') %></td>
        <td class="text-right"><%- window.Misc.currency(valor) %></td>
    </script>
@stop
