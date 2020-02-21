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
	    <div class="box box-success">
	    	<form action="{{ route('rplancuentas.index') }}" method="GET" data-toggle="validator">
			 	<input class="hidden" id="type-report-koi-component" name="type"></input>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-md-offset-5 col-md-2">
							<label for="nivel" class="control-label">Nivel</label>
							<select name="nivel" id="nivel" class="form-control select2-default-clear">
								<option value="" selected></option>
								@foreach (config('koi.contabilidad.plancuentas.niveles') as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
                @include('partials.buttons', ['type' => 'exportar', 'module' => 'rplancuentas'])
			</form>
		</div>
	</section>
@stop
