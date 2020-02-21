@extends('layout.layout')

@section('title') Reporte historial proveedores @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte historial proveedores
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte historial proveedores</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rhistorialproveedores.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
					    <label for="filter_tercero" class="col-md-1 col-md-1 control-label col-md-offset-3">Proveedor</label>
					    <div class="form-group col-md-2">
					        <div class="input-group input-group-sm">
					            <span class="input-group-btn">
					                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="filter_tercero">
					                    <i class="fa fa-user"></i>
					                </button>
					            </span>
					            <input id="filter_tercero" placeholder="Proveedor" class="form-control tercero-koi-component" name="filter_tercero" type="text" maxlength="15" data-name="filter_terecero_nombre" required>
					        </div>
					    </div>
					    <div class="col-md-4 col-xs-12">
					        <input id="filter_terecero_nombre" name="filter_terecero_nombre" placeholder="Nombre proveedor" class="form-control input-sm" type="text" maxlength="15" readonly required>
					    </div>
					</div>
					<div class="row">
						<label for="filter_fecha_inicio" class="col-sm-1 control-label col-md-offset-3">Fecha inicio</label>
	                    <div class="form-group col-md-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_inicio" name="filter_fecha_inicio" class="form-control input-sm datepicker" value="{{ date('Y-m-d') }}" required>
	                        </div>
	                    </div>
						<label for="filter_fecha_fin" class="col-sm-1 control-label">Fecha fin</label>
	                    <div class="form-group col-md-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_fin" name="filter_fecha_fin" value="{{ date('Y-m-d') }}" class="form-control input-sm datepicker" required>
	                        </div>
	                    </div>
					</div>
                    @include('partials.buttons', ['type' => 'exportar', 'module' => 'rhistorialproveedores'])
				</div>
			</form>
		</div>
	</section>
@stop
