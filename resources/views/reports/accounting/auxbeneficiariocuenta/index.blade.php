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
								<input id="filter_cuenta" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="filter_cuenta" type="text" maxlength="15" data-name="filter_cuenta_nombre" >
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<input id="filter_cuenta_nombre" name="filter_cuenta_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
						</div>
					</div>
					<div class="row">
                        <div class="row">
    						<div class="form-group col-md-offset-4 col-sm-offset-4 col-xs-6 col-sm-3 col-md-2">
    							<label for="mes_inicial" class="control-label">Mes inicial</label>
    							<select name="mes_inicial" id="mes_inicial" class="form-control" required>
    								@foreach( config('koi.meses') as $key => $value)
    									<option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
    								@endforeach
    							</select>
    						</div>

    						<div class="form-group col-xs-6 col-sm-3 col-md-2">
    							<label for="ano_inicial" class="control-label">Año inicial</label>
    							<select name="ano_inicial" id="ano" class="form-control" required>
    								@for($i = config('koi.app.ano'); $i <= date('Y'); $i++)
    									<option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
    								@endfor
    							</select>
    						</div>
    					</div>
                        <div class="row">
    						<div class="form-group col-md-offset-4 col-sm-offset-4 col-xs-6 col-sm-3 col-md-2">
    							<label for="mes_final" class="control-label">Mes final</label>
    							<select name="mes_final" id="mes" class="form-control" required>
    								@foreach( config('koi.meses') as $key => $value)
    									<option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
    								@endforeach
    							</select>
    						</div>

    						<div class="form-group col-xs-6 col-sm-3 col-md-2">
    							<label for="ano_final" class="control-label">Año final</label>
    							<select name="ano_final" id="ano" class="form-control" required>
    								@for($i = config('koi.app.ano'); $i <= date('Y'); $i++)
    									<option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
    								@endfor
    							</select>
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
