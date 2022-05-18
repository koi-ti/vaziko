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
	                    <div class="form-group col-md-3 col-md-offset-4">
                            <label for="filter_mes" class="control-label">Mes</label>
                            <select name="filter_mes" id="filter_mes" class="form-control select2-default-clear" required>
                                <option value selected></option>
                                @foreach (config('koi.meses') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
	                    </div>
	                    <div class="form-group col-md-1">
                            <label for="filter_ano" class="control-label">Año</label>
                            <select name="filter_ano" id="filter_ano" class="form-control" required>
								@for ($i = config('koi.app.ano'); $i <= date('Y'); $i++)
									<option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
								@endfor
							</select>
	                    </div>
					</div>
				</div>
                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rlibrodiario'])
			</form>
		</div>
	</section>
@stop
