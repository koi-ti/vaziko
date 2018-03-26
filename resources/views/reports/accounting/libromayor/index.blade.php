@extends('layout.layout')

@section('title') Reporte libro mayor @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte Libro mayor
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte Libro mayor</li>
		</ol>
    </section>
   	<section class="content">
	    <div class="box box-success">
	    	<form action="{{ route('rlibromayor.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
	                    <div class="form-group col-md-2 col-md-offset-4">
                            <label for="filter_month" class="control-label">Mes</label>
                            <select name="filter_month" id="filter_month" class="form-control" required>
                                @foreach( config('koi.meses') as $key => $value)
                                    <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
	                    </div>
	                    <div class="form-group col-md-2">
                            <label for="filter_year" class="control-label">Año</label>
                            <select name="filter_year" id="filter_year" class="form-control" required>
                                @for($i = 2000; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }} >{{ $i }}</option>
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
		</div>
	</section>
@stop
