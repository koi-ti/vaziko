@extends('production.subactividadesp.main')

@section('breadcrumb')
    <li><a href="{{ route('subactividadesp.index')}}">Subactividad de producción</a></li>
    <li class="active">{{ $subactividadp->subactividadp_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nombre</label>
                    <div>{{ $subactividadp->subactividadp_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Actividad</label>
                    <div>{{ $subactividadp->actividadp->actividadp_nombre }}</div>
                </div>
                <div class="form-group col-md-2"><br>
                    <label class="checkbox-inline" for="subactividadp_activo">
                        <input type="checkbox" id="subactividadp_activo" name="subactividadp_activo" value="subactividadp_activo" disabled {{ $subactividadp->subactividadp_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'subactividadesp') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('subactividadesp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'subactividadesp')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('subactividadesp.edit', ['subactividadp' => $subactividadp->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
