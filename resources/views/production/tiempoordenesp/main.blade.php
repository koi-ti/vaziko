@extends('layout.layout')

@section('title') Tiempo ordenes de producción @stop

@section('content')
    <section class="content-header">
		<h1>
			Tiempo ordenes de producción <small>Administración tiempo ordenes de producción</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li>Tiempo ordenes de producción</li>
		</ol>
    </section>

   	<section class="content">
	    <div class="box box-success" id="tiempoordenp-create">
		 	{!! Form::open(['id' => 'form-create-tiempoordenp', 'data-toggle' => 'validator']) !!}
                <div class="box-body">
                    <div class="row">
                        <label for="tiempoordenp_ordenp" class="col-md-1 col-md-offset-1 control-label">Orden</label>
                        <div class="form-group col-md-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat btn-koi-search-orden-component-table" data-field="tiempoordenp_ordenp">
                                        <i class="fa fa-building-o"></i>
                                    </button>
                                </span>
                                <input id="tiempoordenp_ordenp" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="tiempoordenp_ordenp" type="text" maxlength="15" data-name="tiempoordenp_ordenp_beneficiario" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input id="tiempoordenp_ordenp_beneficiario" name="tiempoordenp_ordenp_beneficiario" placeholder="Orden beneficiario" class="form-control input-sm" type="text" readonly required>
                        </div>
                    </div>

                    <div class="row">
                        <label for="tiempoordenp_fecha" class="col-md-1 col-md-offset-1 control-label">Fecha</label>
                        <div class="form-group col-md-2">
                            <input type="text" id="tiempoordenp_fecha" name="tiempoordenp_fecha" placeholder="Fecha inicio" class="form-control input-sm datepicker" required>
                        </div>
                        <label for="tiempoordenp_hora_inicio" class="col-md-1 control-label">H. inicio</label>
                        <div class="form-group col-md-2">
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input type="text" id="tiempoordenp_hora_inicio" name="tiempoordenp_hora_inicio" placeholder="Inicio" class="form-control input-sm timepicker" required>
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="tiempoordenp_hora_fin" class="col-md-1 control-label">H. fin</label>
                        <div class="form-group col-md-2">
                            <div class="bootstrap-timepicker">
                                <div class="input-group">
                                    <input type="text" id="tiempoordenp_hora_fin" name="tiempoordenp_hora_fin" placeholder="Fin" class="form-control input-sm timepicker" required>
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="tiempoordenp_areap" class="control-label col-md-1 col-md-offset-1">Área</label>
                        <div class="form-group col-md-4">
                            <select name="tiempoordenp_areap" id="tiempoordenp_areap" class="form-control select2-default-clear">
                                <option value="" selected>Seleccione</option>
                                @foreach( App\Models\Production\Areap::getAreas() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

    			<div class="box-header with-border">
    	        	<div class="row">
    					<div class="col-md-2 col-md-offset-5 col-sm-12 col-xs-6 text-right">
    						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
    					</div>
    				</div>
    			</div>

                <div class="">
                    <div class="row">
                        <h4 class="col-md-2"><b>Bienvenido Sr(a) {{ Auth::user()->getName() }}</b></h4>
                    </div>
                </div>
			{!! Form::close() !!}
		</div>
	</section>
@stop
