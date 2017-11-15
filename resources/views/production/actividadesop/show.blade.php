@extends('production.actividadesop.main')

@section('breadcrumb')
    <li><a href="{{ route('actividadesop.index')}}">Actividades de producción</a></li>
    <li class="active">{{ $actividadop->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $actividadop->id }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $actividadop->actividadop_nombre }}</div>
                </div>

                <div class="form-group col-md-2">
                    <label class="checkbox-inline" for="actividadop_activo">
                        <input type="checkbox" id="actividadop_activo" name="actividadop_activo" value="actividadop_activo" disabled {{ $actividadop->actividadop_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('actividadesop.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('actividadesop.edit', ['actividadop' => $actividadop->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
