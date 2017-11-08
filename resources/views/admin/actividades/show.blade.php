@extends('admin.actividades.main')

@section('breadcrumb')
<li><a href="{{route('actividades.index')}}">Actividades</a></li>
<li class="active">{{ $actividad->actividad_codigo }}</li>
@stop

@section('module')
<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="form-group col-md-2">
                <label class="control-label">Código</label>
                <div>{{ $actividad->actividad_codigo }}</div>
            </div>
            <div class="form-group col-md-8">
                <label class="control-label">Nombre</label>
                <div>{{ $actividad->actividad_nombre }}</div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <label class="control-label">% Cree</label>
                <div>{{ $actividad->actividad_tarifa }}</div>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">Categoria</label>
                <div>{{ $actividad->actividad_categoria }}</div>
            </div>
        </div>
    </div>
    <div class="box-footer with-border">
        <div class="row">
            <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                <a href=" {{ route('actividades.index')}} " class="btn btn-default btn-sm btn-block"> {{ trans('app.comeback') }}</a>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                <a href=" {{ route('actividades.edit', ['actividades' => $actividad->id])}}" class="btn btn-primary btn-sm btn-block">{{trans('app.edit')}}</a>
            </div>
        </div>
    </div>
</div>
@stop
