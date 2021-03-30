@extends('layout.layout')

@section('title') Reporte auxiliares contables @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte auxiliares contables
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte auxiliares contables</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rauxcontable.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
                    <div class="row form-group">
					    <label for="filter_tercero" class="col-sm-3 control-label text-right">Tercero</label>
					    <div class="form-group col-md-3">
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
                    <div class="row form-group">
						<label for="filter_cuenta_inicio" class="col-sm-3 control-label text-right">Cuenta inicio</label>
						<div class="form-group col-sm-3">
				      		<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="filter_cuenta_inicio">
										<i class="fa fa-tasks"></i>
									</button>
								</span>
								<input id="filter_cuenta_inicio" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="filter_cuenta_inicio" type="text" maxlength="15" data-name="filter_cuenta_inicio_nombre">
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<input id="filter_cuenta_inicio_nombre" name="filter_cuenta_inicio_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
						</div>
					</div>
                    <div class="row form-group">
                        <label for="filter_cuenta_fin" class="col-sm-3 control-label text-right">Cuenta final</label>
                        <div class="form-group col-sm-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="filter_cuenta_fin">
                                        <i class="fa fa-tasks"></i>
                                    </button>
                                </span>
                                <input id="filter_cuenta_fin" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="filter_cuenta_fin" type="text" maxlength="15" data-name="filter_cuenta_fin_nombre">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <input id="filter_cuenta_fin_nombre" name="filter_cuenta_fin_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
                        </div>
                    </div>
					<div class="row form-group">
                        <label for="filter_fecha_inicial" class="control-label col-sm-3 text-right">Fecha inicial</label>
	                    <div class="form-group col-sm-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_inicial" name="filter_fecha_inicial" class="form-control input-sm datepicker" value="{{ date('Y-m-d') }}" required>
	                        </div>
	                    </div>
                        <label for="filter_fecha_final" class="control-label col-sm-2 text-right">Fecha final</label>
	                    <div class="form-group col-sm-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_final" name="filter_fecha_final" value="{{ date('Y-m-d') }}" class="form-control input-sm datepicker" required>
	                        </div>
	                    </div>
					</div>
				</div>
                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rauxcontable'])
			</form>
		</div>
	</section>
@stop
