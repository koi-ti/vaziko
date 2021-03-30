@extends('layout.layout')

@section('title') Configuración @stop

@section('content')
    <section class="content-header">
		<h1>
			Configuración <small>Configuración</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Configuración</li>
		</ol>
    </section>

	<section id="configuracion-main" class="content">
        <div class="row">
            @ability ('cierre' | 'configuracion')
                <div class="col-sm-6">
                    <div class="box box-success spinner-main">
                        <div class="box-header">
                            <h4 class="title-configuracion text-center">Cierre contable {{ $message }}</h4>
                        </div>
                        <div class="box-footer">
                            {!! Form::open(['id' => 'form-closing', 'method' => 'POST']) !!}
                                <div class="col-md-2 col-sm-6 col-xs-6 col-md-offset-5">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.update') }}</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            @endability
            @ability ('saldos' | 'configuracion')
                <div class="col-sm-6">
                    <div class="box box-success spinner-main">
                        <div class="box-header">
                            <h4 class="title-configuracion text-center">Actualizar saldos</h4>
                        </div>
                        {!! Form::open(['id' => 'form-balance', 'method' => 'POST']) !!}
                            <div class="box-footer">
                                <div class="col-md-2 col-sm-6 col-xs-6 col-md-offset-5">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.update') }}</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endability
        </div>

        <script type="text/template" id="config-confirm-tpl">
            <p><%- message %></p>
        </script>
    </section>
@stop
