@extends('layout.layout')

@section('title') Reporte balance general @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte balance general
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte balance general</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rbalancegeneral.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
                <div class="box-body">
                    <div class="row">
                        <label for="filter_cuenta" class="col-sm-3 control-label text-right">Cuenta</label>
                        <div class="form-group col-sm-3 col-md-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="filter_cuenta">
                                        <i class="fa fa-tasks"></i>
                                    </button>
                                </span>
                                <input id="filter_cuenta" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="filter_cuenta" type="text" maxlength="15" data-name="filter_cuenta_nombre" required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <input id="filter_cuenta_nombre" name="filter_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
                        </div>
                    </div>
					<div class="row">
                        <label for="filter_listado" class="col-sm-3 control-label text-right">Nivel del listado</label>
	                    <div class="form-group col-sm-4">
                            <select name="filter_listado" id="filter_listado" class="form-control select2-default-clear" required>
                                <option value selected></option>
                                <option value="1">Solo Cuentas</option>
                                <option value="2">Cuentas y Beneficiarios Tipo 1</option>
                                <option value="3">Cuentas y Beneficiarios Tipo 1 y 2</option>
                            </select>
	                    </div>
                        <label for="filter_nivel" class="col-sm-1 control-label text-right">Nivel de la cuenta</label>
	                    <div class="form-group col-sm-1">
                            <input type="number" id="filter_nivel" name="filter_nivel" value="1" class="form-control input-sm" min="1">
	                    </div>
					</div>
				</div>
                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rbalancegeneral'])
			</form>
		</div>
	</section>
@stop
