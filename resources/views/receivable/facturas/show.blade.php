@extends('receivable.facturas.main')

@section('module')
    <section class="content-header">
        <h1>
            Facturas <small>Administración de facturas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            <li><a href="{{ route('facturas.index')}}">Factura</a></li>
            <li class="active">{{ $factura->id }}</li>
        </ol>
    </section>

    <section class="content" id="factura-show">
        <div class="box box-success spinner-main">
            <div class="box-body">
                <div class="dropdown pull-right">
                    <label class="label label-{{ $factura->factura1_anulado ? 'danger' : 'success' }}">ESTADO: {{ $factura->factura1_anulado ? 'ANULADA' : 'ACTIVO' }}</label>
                    <div class="btn-group">
                        <a href="{{ route('facturas.exportar', ['facturas' =>  $factura->id ]) }}" class="btn btn-danger btn-sm" target="_blank">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        @if (!$factura->factura1_anulado && auth()->user()->ability('admin', 'anular', ['module' => 'facturas']))
                            <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a role="menuitem" tabindex="-1" href="#" class="anular-factura">
                                        <i class="fa fa-ban"></i>Anular
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="control-label">Punto de venta</label>
                        <div>{{ $factura->puntoventa->puntoventa_nombre }}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Prefijo</label>
                        <div>{{ $factura->puntoventa->puntoventa_prefijo }}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Número</label>
                        <div>{{ $factura->factura1_numero }}</div>
                    </div>
                </div>
            	<div class="row">
    		        <div class="form-group col-md-6">
                        <label class="control-label">Cliente</label>
                        <div>Documento: <a href="{{ route('terceros.show', ['terceros' =>  $factura->factura1_tercero ]) }}" target="_blanck" title="Ver tercero">{{ $factura->tercero_nit }} </a> <br> Nombre: {{ $factura->tercero_nombre }} </div>
                    </div>
            	</div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="control-label">Fecha</label>
                        <div>{{ $factura->factura1_fecha }}</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Vencimiento</label>
                        <div>{{ $factura->factura1_fecha_vencimiento }}</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Cuotas</label>
                        <div>{{ $factura->factura1_cuotas }}</div>
                    </div>
                </div>
                @ability ('precios' | 'facturas')
                	<div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label">Subtotal</label>
                            <div>$ {{ number_format($factura->factura1_subtotal, '2', ',', '.') }}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Iva</label>
                            <div>$ {{ number_format($factura->factura1_iva, '2', ',', '.') }}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Total</label>
                            <div>$ {{ number_format($factura->factura1_total, '2', ',', '.') }}</div>
                        </div>
                	</div>
                @endability
        	</div>
            <div class="box-footer with-border">
    	        <div class="row">
    	            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
    	                <a href=" {{ route('facturas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
    	            </div>
    	        </div>
            </div>
        </div>

        <div class="box box-success spinner-main">
        	<div class="box-body">
	            <div class="table-responsive no-padding">
	                <table id="browse-detalle-factura-list" class="table table-bordered" cellspacing="0">
	                    <thead>
	                        <tr>
	                            <th width="10%">Codigo</th>
	                            <th width="60%">Nombre</th>
	                            <th width="5%">Facturado {!! $factura->factura1_anulado ? '<span class="label label-danger">Anulado</span>' : '' !!}</th>
                                @ability ('precios' | 'facturas')
    	                            <th width="15%">Valor unitario</th>
    	                            <th width="15%">Total</th>
                                @endability
	                        </tr>
	                    </thead>
	                    <tbody>
	                        {{-- Render content detalle factura --}}
	                    </tbody>
                        @ability ('precios' | 'facturas')
    	                    <tfoot>
    	                    	<tr>
                                    <th colspan="2" class="text-right">SUBTOTAL</th>
                                    <td colspan="3" class="text-right">{{ number_format($factura->factura1_subtotal, '2', ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right">IVA ({{ $factura->factura1_porcentaje_iva }}%)</th>
                                    <td colspan="3" class="text-right">{{ number_format($factura->factura1_iva, '2', ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right">RTE FTE</th>
                                    <td colspan="3" class="text-right">{{ number_format($factura->factura1_retefuente, '2', ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right">RTE ICA</th>
                                    <td colspan="3" class="text-right">{{ number_format($factura->factura1_reteica, '2', ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right">RTE IVA</th>
                                    <td colspan="3" class="text-right">{{ number_format($factura->factura1_reteiva, '2', ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-right">TOTAL</th>
                                    <td colspan="3" class="text-right">{{ number_format($factura->factura1_total, '2', ',', '.') }}</td>
                                </tr>
    	                    </tfoot>
                        @endability
	                </table>
	    		</div>
        	</div>
    	</div>

        <div class="box box-success spinner-main">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="browse-factura4-list" class="table no-margin">
                        <thead>
                            <tr>
                                <th class="text-center">Cuota</th>
                                <th class="text-center">Vencimiento</th>
                                @ability ('precios' | 'facturas')
                                    <th class="text-right">Valor</th>
                                    <th class="text-right">Saldo</th>
                                @endability
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="box box-success spinner-main">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                        <h4><a href="{{ route('asientos.show', ['asientos' =>  $factura->factura1_asiento ]) }}" target="_blanck" title="Ver Asiento"> Ver asiento contable </a></h4>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                        <h4><b>{{ $factura->documento_nombre }} - {{ $factura->asiento_numero }}</b></h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/template" id="factura-anular-confirm-tpl">
        <p>¿Esta seguro que desea anular la factura?</p>
    </script>

    <script type="text/template" id="add-factura-item-tpl">
        <td><%- factura2_orden2 %></td>
        <td><%- factura2_producto_nombre %></td>
        <td class="text-center"><%- factura2_cantidad %></td>
        @ability ('precios' | 'facturas')
            <td class="text-right"><%- window.Misc.currency(factura2_producto_valor_unitario) %></td>
            <td class="text-right"><%- window.Misc.currency(factura2_cantidad * factura2_producto_valor_unitario) %></td>
        @endability
    </script>

    <script type="text/template" id="add-detalle-factura-tpl">
        <td class="text-center"><%- factura4_cuota %></td>
        <td class="text-center"><%- factura4_vencimiento %></td>
        @ability ('precios' | 'facturas')
            <td class="text-right"><%- window.Misc.currency(factura4_valor) %></td>
            <td class="text-right"><%- window.Misc.currency(factura4_saldo) %></td>
        @endability
    </script>
@stop
