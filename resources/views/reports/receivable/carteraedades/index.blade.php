@extends('layout.layout')

@section('title') Reporte de cartera por edades @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte de cartera por edades
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte de cartera por edades</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rcarteraedades.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
                    <div class="row">
					    <label for="filter_tercero" class="col-sm-1 col-md-offset-1 control-label">Tercero</label>
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
                        <label for="filter_fecha" class="control-label col-md-1">Fecha</label>
	                    <div class="form-group col-md-2 ">
	                        <div class="input-group">
	                            <div class="input-group-addon">
	                                <i class="fa fa-calendar"></i>
	                            </div>
	                            <input type="text" id="filter_fecha" name="filter_fecha" class="form-control input-sm datepicker" value="{{ date('Y-m-d') }}" required>
	                        </div>
	                    </div>
					</div>
				</div>
                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rcarteraedades'])
            </form>
		</div>

        @include('partials.message')
	</section>
@stop
