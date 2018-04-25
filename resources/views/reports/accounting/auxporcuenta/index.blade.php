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
	    	<form action="{{ route('rauxporcuenta.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
						<label for="cuenta_inicio" class="col-sm-2 col-md-offset-2 control-label text-right">Cuenta</label>
						<div class="form-group col-sm-3 col-md-2">
				      		<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-flat btn-koi-search-plancuenta-component" data-field="cuenta_inicio">
										<i class="fa fa-tasks"></i>
									</button>
								</span>
								<input id="cuenta_inicio" placeholder="Cuenta" class="form-control plancuenta-koi-component" name="cuenta_inicio" type="text" maxlength="15" data-name="cuenta_inicio_nombre" required>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<input id="cuenta_inicio_nombre" name="cuenta_inicio_nombre" placeholder="Nombre cuenta" class="form-control input-sm" type="text" maxlength="15" disabled>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-offset-4 col-sm-offset-4 col-xs-6 col-sm-3 col-md-2">
							<label for="mes" class="control-label">Mes</label>
							<select name="mes" id="mes" class="form-control" required>
								@foreach( config('koi.meses') as $key => $value)
									<option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
								@endforeach
								<!-- <option value="13">Trece</option> -->
							</select>
						</div>

						<div class="form-group col-xs-6 col-sm-3 col-md-2">
							<label for="ano" class="control-label">Año</label>
							<select name="ano" id="ano" class="form-control" required>
								@for($i = config('koi.app.ano'); $i <= date('Y'); $i++)
									<option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
								@endfor
							</select>
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
