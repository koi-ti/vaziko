@extends('layout.layout')

@section('title') Reporte tiempos de producción @stop

@section('content')
    <section class="content-header">
		<h1>
			Tiempos de producción
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte tiempos de producción</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success" id="rtiemposp-main">
	    	<form id="form-rtiemposp" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                                <input id="filter_funcionario" placeholder="Funcionario" class="form-control tercero-koi-component" name="filter_funcionario[]" type="text" maxlength="15" data-wrapper="spinner-main" data-tiempop="true" data-name="filter_funcionario_nombre">
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-sm-5 col-xs-10">
                            <input id="filter_funcionario_nombre" name="filter_funcionario_nombre[]" placeholder="Nombre funcionario" class="form-control input-sm" type="text" maxlength="15" readonly>
                        </div>
                        <div class="col-sm-1 col-xs-2">
                            <a class="btn btn-success btn-flat btn-sm add-funcionario">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div id="render-funcionarios"></div>

					<div class="row">
                        @ability ('exportar' | 'rtiemposp')
    						<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
    							<button type="submit" class="btn btn-block btn-danger white btn-sm btn-export-pdf-koi-component">
    								<i class="fa fa-file-pdf-o"></i> Generar pdf
    							</button>
    						</div>
                        @endability
                        @ability ('graficas' | 'rtiemposp')
    						<div class="col-md-2 col-sm-6 col-xs-6">
    							<button type="submit" class="btn btn-primary btn-sm btn-block btn-export-chart-koi-component">
                                    <i class="fa fa-pie-chart"></i> Generar gráfica
    							</button>
    						</div>
                        @endability
					</div>
				</div>
			</form>
		</div>

        <div id="render-chart"></div>
	</section>

    <script type="text/template" id="add-rtiempop-charts">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Información adicional</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart-container">
                            <canvas id="chart_funcionario" width="500" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>
@stop
