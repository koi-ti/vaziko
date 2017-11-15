@extends('production.subactividadesop.main')

@section('breadcrumb')
    <li><a href="{{ route('subactividadesop.index')}}">SubActividades de producción</a></li>
    <li class="active">{{ $subactividadop->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $subactividadop->id }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-5">
                    <label class="control-label">Actividad</label>
                    <div>{{ $subactividadop->actividadop->actividadop_nombre }}</div>
                </div>

                <div class="form-group col-md-5">
                    <label class="control-label">Nombre</label>
                    <div>{{ $subactividadop->subactividadop_nombre }}</div>
                </div>

                <div class="form-group col-md-2">
                    <label class="checkbox-inline" for="subactividadop_activo">
                        <input type="checkbox" id="subactividadop_activo" name="subactividadop_activo" value="subactividadop_activo" disabled {{ $subactividadop->subactividadop_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('subactividadesop.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('subactividadesop.edit', ['subactividadop' => $subactividadop->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
