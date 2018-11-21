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

    <section class="content">
        <div class="box box-success" id="factura-show">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Opciones <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="#" class="export-factura">
                                    <i class="fa fa-file-pdf-o"></i>Exportar factura
                                </a>
                                @if( !$factura->factura1_anulado && Carbon\Carbon::createFromFormat('Y-m-d', $factura->factura1_fecha)->month == Carbon\Carbon::now()->month )
                                    <a role="menuitem" tabindex="-1" href="#" class="ban-factura">
                                        <i class="fa fa-ban"></i>Anular factura
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                	<div class="row">
                        <div class="form-group col-md-1">
                            <label class="control-label">Estado</label>
                            @if( $factura->factura1_anulado )
                                <div><span class="label label-danger">Anulado</span></div>
                            @else
                                <div><span class="label label-success">Abierta</span></div>
                            @endif
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label">Fecha</label>
                            <div>{{ $factura->factura1_fecha }}</div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label">Vencimiento</label>
                            <div>{{ $factura->factura1_fecha_vencimiento }}</div>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Número</label>
                            <div>{{ $factura->factura1_numero }}</div>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Cuotas</label>
                            <div>{{ $factura->factura1_cuotas }}</div>
                        </div>
                	</div>
                	<div class="row">
        		        <div class="form-group col-md-6">
                            <label class="control-label">Cliente</label>
                            <div>Documento: <a href="{{ route('terceros.show', ['terceros' =>  $factura->factura1_tercero ]) }}" target="_blanck" title="Ver tercero">{{ $factura->tercero_nit }} </a> <br> Nombre: {{ $factura->tercero_nombre }} </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Punto de venta</label>
                            <div>{{ $factura->puntoventa_prefijo }} - {{ $factura->puntoventa_nombre }}</div>
                        </div>
                	</div>
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
                            <label class="control-label">Descuento</label>
                            <div>$ {{ number_format($factura->factura1_descuento, '2', ',', '.') }}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Total</label>
                            <div>$ {{ number_format($factura->factura1_total, '2', ',', '.') }}</div>
                        </div>
                	</div>
                    <div class="box-footer with-border">
            	        <div class="row">
            	            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
            	                <a href=" {{ route('facturas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            	            </div>
            	        </div>
                    </div>

        	        <div class="box box-solid">
        	        	<div class="box-body">
        		            <div class="table-responsive no-padding">
        		                <table id="browse-detalle-factura-list" class="table table-bordered" cellspacing="0">
        		                    <thead>
        		                        <tr>
        		                            <th width="10%">Codigo</th>
        		                            <th width="45%">Nombre</th>
        		                            <th width="15%">Facturado {!! $factura->factura1_anulado ? '<span class="label label-danger">Anulado</span>' : '' !!}</th>
        		                            <th width="15%">V. Unitario</th>
        		                            <th width="15%">Total</th>
        		                        </tr>
        		                    </thead>
        		                    <tbody>
        		                        {{-- Render content detalle factura --}}
        		                    </tbody>
        		                    <tfoot>
        		                    	<tr>
                                            <td></td>
                                            <th class="text-right">SUBTOTAL</th>
                                            <td class="text-center" id="subtotal-facturado">0</td>
                                            <td></td>
                                            <td class="text-right">{{ number_format($factura->factura1_subtotal, '2', ',', '.') }}</td>
                                        </tr>
                                        <tr>
        	                                <td></td>
        	                                <th class="text-right">IVA ({{ $factura->factura1_porcentaje_iva }}%)</th>
        	                                <td colspan="3" class="text-right">{{ number_format($factura->factura1_iva, '2', ',', '.') }}</td>
        	                            </tr>
                                        <tr>
                                            <td></td>
                                            <th class="text-right">RTE FTE</th>
                                            <td colspan="3" class="text-right">{{ number_format($factura->factura1_retefuente, '2', ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <th class="text-right">RTE ICA</th>
                                            <td colspan="3" class="text-right">{{ number_format($factura->factura1_reteica, '2', ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <th class="text-right">RTE IVA</th>
                                            <td colspan="3" class="text-right">{{ number_format($factura->factura1_reteiva, '2', ',', '.') }}</td>
                                        </tr>
        	                            <tr>
        	                                <td></td>
        	                                <th class="text-right">TOTAL</th>
        	                                <td colspan="3" class="text-right">{{ number_format($factura->factura1_total, '2', ',', '.') }}</td>
        	                            </tr>
        		                    </tfoot>
        		                </table>
        		    		</div>
        	        	</div>
        	    	</div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Detalle de crédito</h3>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="browse-factura4-list" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>Cuota</th>
                                                    <th>Vencimiento</th>
                                                    <th>Valor</th>
                                                    <th>Saldo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-success">
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

    <script type="text/template" id="factura-ban-confirm-tpl">
        <p>¿Esta seguro que desea anular la factura # <b>{{ $factura->factura1_numero }}</b>?</p>
    </script>
@stop
