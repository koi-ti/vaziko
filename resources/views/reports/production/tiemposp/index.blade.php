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
	    <div class="box box-success" id="empresa-create">
	    	<form action="{{ route('rtiemposp.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
                    <div class="row">
                        <label for="tiempop_tercero" class="col-sm-1 col-md-offset-1 control-label">Cliente</label>
                        <div class="form-group col-sm-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="tiempop_tercero">
                                        <i class="fa fa-user"></i>
                                    </button>
                                </span>
                                <input id="tiempop_tercero" placeholder="Cliente" class="form-control tercero-koi-component" name="tiempop_tercero" type="text" maxlength="15" data-wrapper="spinner-main" data-name="tiempop_tercero_nombre" value="{{ old('tiempop_tercero') }}" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-sm-5 col-xs-10">
                            <input id="tiempop_tercero_nombre" name="tiempop_tercero_nombre" placeholder="Nombre cliente" class="form-control input-sm" type="text" maxlength="15" value="{{ old('tiempop_tercero_nombre') }}" readonly required>
                        </div>
                    </div>

					<div class="row">
                        <div class="form-group col-md-2 col-md-offset-4">
                            <label for="fecha_inicial" class="control-label">Fecha de inicio</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="fecha_inicial" name="fecha_inicial" placeholder="Fecha inicio" value="{{ old('fecha_inicial') }}" class="form-control input-sm datepicker" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fecha_final" class="control-label">Fecha de fin</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="fecha_final" name="fecha_final" placeholder="Fecha inicio" value="{{ old('fecha_final') }}" class="form-control input-sm datepicker" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
					</div>

					<div class="row">
						<div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
							<button type="submit" class="btn btn-default btn-sm btn-block btn-export-pdf-koi-component">
								<i class="fa fa-file-pdf-o"></i> {{ trans('app.pdf') }}
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
