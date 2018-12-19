@extends('layout.layout')

@section('title') Reporte resumen tiempos de producción @stop

@section('content')
    <section class="content-header">
		<h1>
			Resument tiempos de producción
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte resumen tiempos de producción</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success" id="rtiemposp-main">
	    	<form id="form-rresumentiemposp" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
                        <div class="form-group col-md-2 col-md-offset-4">
                            <label for="filter_fecha_inicial" class="control-label">Fecha de inicio</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="filter_fecha_inicial" name="filter_fecha_inicial" placeholder="Fecha inicio" class="form-control input-sm datepicker" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="filter_fecha_final" class="control-label">Fecha de fin</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="filter_fecha_final" name="filter_fecha_final" placeholder="Fecha inicio" class="form-control input-sm datepicker" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
					</div>

                    <div class="row">
                        <label for="filter_funcionario" class="col-sm-1 col-md-offset-1 control-label">Funcionario</label>
                        <div class="form-group col-sm-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="filter_funcionario">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input id="filter_funcionario" placeholder="Funcionario" class="form-control tercero-koi-component" name="filter_funcionario" type="text" maxlength="15" data-wrapper="spinner-main" data-tiempop="true" data-name="filter_funcionario_nombre">
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-sm-5 col-xs-10">
                            <input id="filter_funcionario_nombre" name="filter_funcionario_nombre" placeholder="Nombre funcionario" class="form-control input-sm" type="text" maxlength="15" readonly>
                        </div>
                    </div>

					<div class="row">
						<div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
							<button type="submit" class="btn btn-block btn-danger white btn-sm btn-export-pdf-koi-component">
								<i class="fa fa-file-pdf-o"></i> Generar pdf
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
	</section>
@stop
