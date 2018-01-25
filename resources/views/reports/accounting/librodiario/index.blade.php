@extends('layout.layout')

@section('title') Reporte libro diario @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte Libro diario
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte Libro diario</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rlibrodiario.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
	                    <div class="form-group col-md-2 col-md-offset-4">
                            <label for="filter_fecha_inicial" class="control-label">Fecha inicial</label>
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_inicial" name="filter_fecha_inicial" class="form-control input-sm datepicker" value="{{ date('Y-m-d') }}" required>
	                        </div>
	                    </div>
	                    <div class="form-group col-md-2">
                            <label for="filter_fecha_final" class="control-label">Fecha final</label>
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha_final" name="filter_fecha_final" value="{{ date('Y-m-d') }}" class="form-control input-sm datepicker" required>
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
				</div>
			</form>
		</div>
	</section>
@stop
