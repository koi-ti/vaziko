@extends('layout.layout')

@section('title') Reporte relación de impuestos @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte relación de impuestos
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte relación de impuestos</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rimpuestos.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
                    <div class="row">
					    <label for="filter_tercero" class="col-sm-1 col-md-offset-3 control-label">Tercero</label>
					    <div class="form-group col-md-2">
					        <div class="input-group input-group-sm">
					            <span class="input-group-btn">
					                <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="filter_tercero">
					                    <i class="fa fa-user"></i>
					                </button>
					            </span>
					            <input id="filter_tercero" placeholder="Tercero" class="form-control tercero-koi-component" name="filter_tercero" type="text" maxlength="15" data-name="filter_terecero_nombre">
					        </div>
					    </div>
					    <div class="col-md-4 col-xs-12">
					        <input id="filter_terecero_nombre" name="filter_terecero_nombre" placeholder="Nombre tercero" class="form-control input-sm" type="text" maxlength="15" readonly>
					    </div>
					</div>
                    <div class="row">
						<label for="cuenta_inicio" class="col-sm-1 col-md-offset-3 control-label">Cuenta Inicio</label>
						<div class="form-group col-sm-3 col-md-2">
				      		<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="cuenta_inicio">
										<i class="fa fa-tasks"></i>
									</button>
								</span>
								<input id="cuenta_inicio" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="cuenta_inicio" type="text" maxlength="15" data-name="cuenta_inicio_nombre">
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<input id="cuenta_inicio_nombre" name="cuenta_inicio_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
						</div>
					</div>
                    <div class="row">
                        <label for="cuenta_fin" class="col-sm-1 col-md-offset-3 control-label">Cuenta final</label>
                        <div class="form-group col-sm-3 col-md-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="cuenta_fin">
                                        <i class="fa fa-tasks"></i>
                                    </button>
                                </span>
                                <input id="cuenta_fin" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="cuenta_fin" type="text" maxlength="15" data-name="cuenta_fin_nombre" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <input id="cuenta_fin_nombre" name="cuenta_fin_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <label for="fecha_inicial" class="control-label col-md-1 col-md-offset-3">Fecha inicial</label>
	                    <div class="form-group col-md-2 ">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="fecha_inicial" name="fecha_inicial" class="form-control input-sm datepicker" value="{{ date('Y-m-d') }}" required>
	                        </div>
	                    </div>
                        <label for="fecha_final" class="control-label col-md-1">Fecha final</label>
	                    <div class="form-group col-md-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="fecha_final" name="fecha_final" class="form-control input-sm datepicker" value="{{ date('Y-m-d') }}" required>
	                        </div>
	                    </div>
					</div>
				</div>
                <div class="box-footer">
                    <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                        <button type="submit" class="btn btn-default btn-sm btn-block btn-export-xls-koi-component">
                            <i class="fa fa-file-text-o"></i> {{ trans('app.xls') }}
                        </button>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-6">
                        <button type="submit" class="btn btn-default btn-sm btn-block btn-export-pdf-koi-component">
                            <i class="fa fa-file-pdf-o"></i> {{ trans('app.pdf') }}
                        </button>
                    </div>
                </div>
			</form>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
		</div>
	</section>
@stop
