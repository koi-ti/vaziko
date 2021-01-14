@extends('layout.layout')

@section('title') Reporte auxiliar beneficiario/cuenta @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte auxiliar beneficiario/cuenta
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte auxiliar beneficiario/cuenta</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rauxbeneficiariocuenta.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
                    <div class="row form-group">
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
					    <div class="col-sm-4">
					        <input id="filter_terecero_nombre" name="filter_terecero_nombre" placeholder="Nombre tercero" class="form-control input-sm" type="text" maxlength="15" readonly>
					    </div>
					</div>
                    <div class="row form-group">
						<label for="filter_cuenta" class="col-sm-3 control-label text-right">Cuenta</label>
						<div class="col-sm-3">
				      		<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="filter_cuenta">
										<i class="fa fa-tasks"></i>
									</button>
								</span>
								<input id="filter_cuenta" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="filter_cuenta" type="text" maxlength="15" data-name="filter_cuenta_nombre" >
							</div>
						</div>
						<div class="col-sm-4">
							<input id="filter_cuenta_nombre" name="filter_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
						</div>
					</div>
					<div class="row form-group">
                        <label for="filter_mes_inicial" class="control-label col-sm-3 text-right">Mes inicial</label>
						<div class="col-sm-3">
							<select name="filter_mes_inicial" id="filter_mes_inicial" class="form-control" required>
								@foreach (config('koi.meses') as $key => $value)
									<option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</div>
                        <label for="filter_ano_inicial" class="control-label col-sm-2 text-right">Año inicial</label>
						<div class="col-sm-2">
							<select id="filter_ano_inicial" name="filter_ano_inicial" class="form-control" required>
								@for ($i = config('koi.app.ano'); $i <= date('Y'); $i++)
									<option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
								@endfor
							</select>
						</div>
					</div>
                    <div class="row form-group">
                        <label for="filter_mes_final" class="control-label col-sm-3 text-right">Mes final</label>
						<div class="col-sm-3">
							<select id="filter_mes_final" name="filter_mes_final" class="form-control" required>
								@foreach (config('koi.meses') as $key => $value)
									<option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</div>
                        <label for="filter_ano_final" class="control-label col-sm-2 text-right">Año final</label>
						<div class="col-sm-2">
							<select name="filter_ano_final" id="filter_ano_final" class="form-control" required>
								@for ($i = config('koi.app.ano'); $i <= date('Y'); $i++)
									<option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
								@endfor
							</select>
						</div>
					</div>
				</div>

                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rauxbeneficiariocuenta'])
			</form>
		</div>

        @include('partials.message')
	</section>
@stop
