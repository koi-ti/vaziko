@extends('layout.layout')

@section('title') Notificaciones @stop

@section('content')
    <section class="content-header">
		<h1>
			Tus notificaciones
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li>Notificaciones</li>
		</ol>
    </section>

   	<section class="content" id="notification-main">
        <div class="box box-success">
            <div class="box-body">
                {!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
	            	<div class="row">
	                    <label for="search_fecha" class="col-md-offset-2 col-sm-1 control-label">Fecha</label>
	                    <div class="col-sm-2">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input id="search_fecha" placeholder="Fecha" class="form-control input-sm datepicker" name="search_fecha" type="text">
                            </div>
	                    </div>

                        <label for="search_estado" class="col-sm-1 control-label">Estado</label>
	                    <div class="col-sm-4 text-left">
	                        <select name="search_estado" id="search_estado" class="form-control">
                                <option value selected>Todas</option>
                                <option value="F">Pendientes</option>
                                <option value="T">Vistas</option>
	                        </select>
	                    </div>
	                </div><br>
	                <div class="row">
	                	<div class="col-sm-offset-4 col-sm-2 col-xs-4">
                            <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                        </div>
	                	<div class="col-sm-2 col-xs-4">
                            <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                        </div>
	                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="box box-solid">
                    <div id="spinner-notification">
                        <ul class="list-group">
                            @foreach ($notificaciones as $notificacion)
                                <li class="list-group-item {{ $notificacion->notificacion_visto ? 'active' : 'view-true' }}" data-notification="{{ $notificacion->id }}">
                                    <h4>{{ $notificacion->notificacion_titulo }} <small class="pull-right {{ $notificacion->notificacion_visto ? 'text white' : ''}}"><i class="fa fa-clock-o"></i> {{ $notificacion->notificacion_fh }}</small></h4>
                                    <p>{{ $notificacion->notificacion_descripcion }} <span class="pull-right">{!! $notificacion->notificacion_visto ? '<i class="fa fa-check"></i><i class="fa fa-check"></i>' : '' !!}</span></p>
                                </li>
                            @endforeach
                            <div class="pull-right">{!! $notificaciones->render() !!}</div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</section>
@stop
