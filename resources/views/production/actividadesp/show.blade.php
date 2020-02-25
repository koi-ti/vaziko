@extends('production.actividadesp.main')

@section('breadcrumb')
    <li><a href="{{ route('actividadesp.index')}}">Actividad de producción</a></li>
    <li class="active">{{ $actividadp->actividadp_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $actividadp->actividadp_nombre }}</div>
                </div>

                <div class="form-group col-md-2"><br>
                    <label class="checkbox-inline" for="actividadp_activo">
                        <input type="checkbox" disabled {{ $actividadp->actividadp_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'actividadesp') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('actividadesp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'actividadesp')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('actividadesp.edit', ['actividadp' => $actividadp->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
