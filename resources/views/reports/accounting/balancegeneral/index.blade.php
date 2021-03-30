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

   	<section id="rbalancegeneral-main" class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rbalancegeneral.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row form-group">
						<label for="filter_cuenta_inicio" class="col-sm-1 col-md-offset-2 control-label text-right">Cuenta Inicio</label>
						<div class="form-group col-sm-3 col-md-2">
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
						<label for="filter_cuenta_fin" class="col-sm-1 col-md-offset-2 control-label text-right">Cuenta Final</label>
						<div class="form-group col-sm-3 col-md-2">
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
                        <label for="filter_mes" class="control-label col-sm-1 col-md-offset-2 text-right">Mes</label>
						<div class="form-group col-sm-3 col-md-2">
							<select name="filter_mes" id="filter_mes" class="form-control" required>
								@foreach (config('koi.meses') as $key => $value)
									<option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</div>
                        <label for="filter_ano" class="control-label col-md-1 text-right">Año</label>
						<div class="form-group col-xs-6 col-sm-3 col-md-2">
							<select name="filter_ano" id="filter_ano" class="form-control" required>
								@for ($i = config('koi.app.ano'); $i <= date('Y'); $i++)
									<option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
								@endfor
							</select>
						</div>
					</div>
                    <div class="row form-group">
                        <label for="filter_tercero_check" class="col-sm-1 col-md-offset-2 control-label text-right">¿Tercero?</label>
                        <div class="form-group col-md-1">
                            <label class="checkbox-inline" for="filter_tercero_check">
                                 <input type="checkbox" id="filter_tercero_check" name="filter_tercero_check" value="filter_tercero_check">
                            </label>
                        </div>
					</div>
                    <div class="row form-group" id="render-tercero"></div>
				</div>
                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rbalancegeneral'])
			</form>
		</div>
	</section>

    <script type="text/template" id="add-tercero-tpl">
        <label for="filter_tercero" class="col-sm-3 control-label text-right">Tercero</label>
        <div class="col-sm-3">
            <div class="input-group input-group-sm">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="filter_tercero">
                        <i class="fa fa-user"></i>
                    </button>
                </span>
                <input id="filter_tercero" placeholder="Tercero" class="form-control tercero-koi-component" name="filter_tercero" type="text" maxlength="15" data-name="filter_terecero_nombre">
            </div>
        </div>
        <div class="col-sm-3">
            <input id="filter_terecero_nombre" name="filter_terecero_nombre" placeholder="Nombre tercero" class="form-control input-sm" type="text" maxlength="15" readonly>
        </div>
    </script>
@stop
