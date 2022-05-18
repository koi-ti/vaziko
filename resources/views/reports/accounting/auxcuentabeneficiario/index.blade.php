@extends('layout.layout')

@section('title') Reporte auxiliar cuenta/beneficiario @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte auxiliar cuenta/beneficiario
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte auxiliar cuenta/beneficiario</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rauxcuentabeneficiario.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
                    <div class="row">
					    <label for="filter_tercero" class="col-sm-2 col-md-offset-2 control-label text-right">Tercero</label>
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
						<label for="filter_cuenta" class="col-sm-2 col-md-offset-2 control-label text-right">Cuenta</label>
						<div class="form-group col-sm-3 col-md-2">
				      		<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="filter_cuenta">
										<i class="fa fa-tasks"></i>
									</button>
								</span>
								<input id="filter_cuenta" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="filter_cuenta" type="text" maxlength="15" data-name="filter_cuenta_nombre">
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<input id="filter_cuenta_nombre" name="filter_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
						</div>
					</div>
					<div class="row">
                        <label for="filter_fecha_inicial" class="control-label col-md-2 text-right col-md-offset-2">Fecha inicial</label>
	                    <div class="form-group col-md-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_inicial" name="filter_fecha_inicial" class="form-control input-sm datepicker" value="{{ date('Y-m-d') }}" required>
	                        </div>
	                    </div>
                        <label for="filter_fecha_final" class="control-label col-md-1">Fecha final</label>
	                    <div class="form-group col-md-2">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_final" name="filter_fecha_final" value="{{ date('Y-m-d') }}" class="form-control input-sm datepicker" required>
	                        </div>
	                    </div>
					</div>
				</div>
                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rauxcuentabeneficiario'])
			</form>
		</div>

        @include('partials.message')
	</section>
@stop
