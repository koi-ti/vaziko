@extends('treasury.facturasp.main')

@section('breadcrumb')
    <li><a href="{{ route('facturap.index')}}">Factura proveedor</a></li>
    <li class="active">{{ $facturap->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body" id="facturapp-show">
        	<div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">Fecha</label>
                    <div>{{ $facturap->facturap1_fecha }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Cuotas</label>
                    <div>{{ $facturap->facturap1_cuotas }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Sucursal</label>
                    <div>{{ $facturap->sucursal_nombre }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Cod. factura</label>
                    <div>{{ $facturap->facturap1_factura }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Cliente</label>
                    <div><a href="{{ route('terceros.show', ['terceros' =>  $facturap->facturap1_tercero ]) }}" target="_blank" title="Ver tercero">{{ $facturap->tercero_nit }} </a> - {{ $facturap->tercero_nombre }} </div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Periodicidad</label>
                    <div>{{ $facturap->facturap1_periodicidad }} <small><b>(dias)</b></small></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Observaciones</label>
                    <div>{{ $facturap->facturap1_observaciones }}</div>
                </div>
        	</div>

	        <div class="row">
	            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
	                <a href=" {{ route('facturap.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
	            </div>
	        </div>
        </div>

        <div class="box box-solid">
        	<div class="box-body">
	            <div class="table-responsive no-padding col-md-6 col-md-offset-3">
	                <table id="browse-detalle-facturap-list" class="table table-bordered" cellspacing="0">
	                    <thead>
	                        <tr>
	                            <th>Cuota</th>
	                            <th>Vencimiento</th>
                                @ability ('precios' | 'facturasp')
	                               <th>Valor</th>
                                @endability
	                        </tr>
	                    </thead>
	                    <tbody>
	                        {{-- Render content detalle facturap --}}
	                    </tbody>
	                </table>
	    		</div>
        	</div>
    	</div>
    </div>

    @if( $facturap->facturap1_asiento )
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                        <h5><a href="{{ route('asientos.show', ['asientos' =>  $facturap->facturap1_asiento ]) }}" target="_blanck" title="Ver Asiento"> Ver asiento contable </a></h5>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                        <h5><b>{{ $facturap->documento_nombre }} - {{ $facturap->asiento1_numero }}</b></h5>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
