@extends('receivable.facturas.main')

@section('breadcrumb')
    <li><a href="{{ route('facturas.index')}}">Factura</a></li>
    <li class="active">{{ $factura->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body" id="factura-show">
        	<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Fecha</label>
                    <div>{{ $factura->factura1_fecha }}</div>
                </div>

                <div class="form-group col-md-3">
                    <label class="control-label">Vencimiento</label>
                    <div>{{ $factura->factura1_fecha_vencimiento }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Cuotas</label>
                    <div>{{ $factura->factura1_cuotas }}</div>
                </div>
                <div class="form-group col-md-3">
                    <div class="dropdown pull-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Opciones <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="#" class="export-factura">
                                    <i class="fa fa-file-pdf-o"></i>Exportar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
        	</div>
        	<div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Punto de venta</label>
                    <div>{{ $factura->puntoventa_prefijo }} - {{ $factura->puntoventa_nombre }}</div>
                </div>
		        <div class="form-group col-md-6">
                    <label class="control-label">Cliente</label>
                    <div><a href="{{ route('terceros.show', ['terceros' =>  $factura->factura1_tercero ]) }}" title="Ver tercero">{{ $factura->tercero_nit }} </a> - {{ $factura->tercero_nombre }} </div>
                </div>
        	</div>

        	<div class="row">
        		<div class="form-group col-md-6">
                    <label class="control-label">Orden</label>
                    <div>{{ $factura->orden_codigo }} - {{ $factura->orden_beneficiario }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Subtotal</label>
                    <div>$ {{ number_format($factura->factura1_subtotal, '2', ',', '.') }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Iva</label>
                    <div>$ {{ number_format($factura->factura1_iva, '2', ',', '.') }}</div>
                </div>
        	</div>

        	<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Descuento</label>
                    <div>$ {{ number_format($factura->factura1_descuento, '2', ',', '.') }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Total</label>
                    <div>$ {{ number_format($factura->factura1_total, '2', ',', '.') }}</div>
                </div>
        	</div>

	        <div class="row">
	            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
	                <a href=" {{ route('facturas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
	            </div>
	        </div><br>

	        <div class="box box-solid">
	        	<div class="box-body">
		            <div class="table-responsive no-padding">
		                <table id="browse-detalle-factura-list" class="table table-bordered" cellspacing="0">
		                    <thead>
		                        <tr>
		                            <th>Codigo</th>
		                            <th>Nombre</th>
		                            <th>Facturado</th>
		                            <th>V. Unitario</th>
		                            <th>Total</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        {{-- Render content detalle factura --}}
		                    </tbody>
		                    <tfoot>
		                    	<tr>
	                                <td></td>
	                                <th class="text-right">Subtotal</th>
	                                <td class="text-center" id="subtotal-facturado">0</td>
	                                <td></td>
	                                <td class="text-right" id="subtotal-total">0</td>
	                            </tr>
		                        <tr>
	                                <td></td>
	                                <th class="text-right">Iva (19%)</th>
	                                <td colspan="3" class="text-right" id="iva-total">0</td>
	                            </tr>
	                            <tr>
	                                <td></td>
	                                <th class="text-right">Total</th>
	                                <td colspan="3" class="text-right" id="total-total">0</td>
	                            </tr>
		                    </tfoot>
		                </table>
		    		</div>
	        	</div>
	    	</div>
        </div>
    </div>        
@stop