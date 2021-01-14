@extends('layout.layout')

@section('title') Reporte auxiliar por cuenta @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte auxiliar por cuenta
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte auxiliar por cuenta</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rauxcuenta.index') }}" method="GET" data-toggle="validator">
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
								<input type="text" id="filter_cuenta" name="filter_cuenta" placeholder="Cuenta" class="form-control plancuenta-koi-component" maxlength="15" data-name="filter_cuenta_nombre" required>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<input id="filter_cuenta_nombre" name="filter_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
						</div>
					</div>
					<div class="row">
                        <label for="filter_mes" class="control-label col-sm-3 text-right">Mes</label>
						<div class="form-group col-sm-4">
							<select name="filter_mes" id="filter_mes" class="form-control select2-default-clear" required>
								@foreach (config('koi.meses') as $key => $value)
									<option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</div>
                        <label for="filter_ano" class="control-label col-sm-1">Año</label>
						<div class="form-group col-sm-1">
							<select name="filter_ano" id="filter_ano" class="form-control" required>
								@for ($i = config('koi.app.ano'); $i <= date('Y'); $i++)
									<option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
								@endfor
							</select>
						</div>
					</div>
				</div>
                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rauxcuenta'])
			</form>
		</div>

        @include('partials.message')
	</section>
@stop
