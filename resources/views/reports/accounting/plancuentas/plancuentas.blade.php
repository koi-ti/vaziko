@extends('layout.layout')

@section('title') Reporte plan de cuentas @stop

@section('content')
    <section class="content-header">
		<h1>
			Reporte plan de cuentas <small>P.U.C</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Reporte plan de cuentas</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success" id="empresa-create">
		 	{!! Form::open(['id' => 'form-create-empresa', 'data-toggle' => 'validator']) !!}

			<div class="box-body">
				<div class="row">
					<div class="form-group col-md-offset-5 col-md-2">
						<label for="plancuentas_nivel" class="control-label">Nivel</label>
						<select name="plancuentas_nivel" id="plancuentas_nivel" class="form-control select2-default-clear">
							<option value="" selected></option>
							@foreach( config('koi.contabilidad.plancuentas.niveles') as $key => $value)
								<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					{{-- <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
						<button type="submit" class="btn btn-default btn-sm btn-block">
							<i class="fa fa-file-text-o"></i> {{ trans('app.xls') }}
						</button>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6">
						<button type="submit" class="btn btn-default btn-sm btn-block">
							<i class="fa fa-file-pdf-o"></i> {{ trans('app.pdf') }}
						</button>
					</div> --}}

					<div class="col-md-2 col-sm-6 col-xs-6 col-md-offset-5">
						<button type="submit" class="btn btn-default btn-sm btn-block">
							<i class="fa fa-file-pdf-o"></i> {{ trans('app.pdf') }}
						</button>
					</div>
				</div>
			</div>

			{!! Form::close() !!}
		</div>
	</section>
@stop