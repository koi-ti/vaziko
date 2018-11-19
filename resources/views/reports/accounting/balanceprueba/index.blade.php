@extends('layout.layout')

@section('title') Reporte balance prueba @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte balance prueba
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte balance prueba</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rbalanceprueba.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
                        <label for="filter_initial_month" class="col-md-offset-3 col-md-1">Mes inicio</label>
                        <div class="form-group col-md-2">
                            <select name="filter_initial_month" id="filter_initial_month" class="form-control" required>
                                @foreach( config('koi.meses') as $key => $value)
                                    <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
	                    </div>
                        <label for="filter_initial_year" class="col-md-1 control-label">Año inicio</label>
	                    <div class="form-group col-md-2">
                            <select name="filter_initial_year" id="filter_initial_year" class="form-control" required>
                                @for($i = 2000; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }} >{{ $i }}</option>
                                @endfor
                            </select>
	                    </div>
                    </div>
                    <div class="row">
                        <label for="filter_end_month" class="col-md-offset-3 col-md-1 control-label">Mes fin</label>
                            <div class="form-group col-md-2">
                            <select name="filter_end_month" id="filter_end_month" class="form-control" required>
                                @foreach( config('koi.meses') as $key => $value)
                                    <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
	                    </div>
                        <label for="filter_end_year" class="col-md-1 control-label">Año fin</label>
	                    <div class="form-group col-md-2">
                            <select name="filter_end_year" id="filter_end_year" class="form-control" required>
                                @for($i = 2000; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }} >{{ $i }}</option>
                                @endfor
                            </select>
	                    </div>
					</div>
				</div>
                <div class="box-footer">
                    <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                        <button type="submit" class="btn btn-default btn-sm btn-block btn-export-xls-koi-component">
                            <i class="fa fa-file-text-o"></i> {{ trans('app.xls') }}
                        </button>
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
