@extends('admin.sucursal.main')

@section('breadcrumb')
    <li><a href="{{ route('sucursales.index')}}">Sucursales</a></li>
    <li class="active">{{ $sucursal->sucursal_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $sucursal->sucursal_nombre }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'sucursales') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('sucursales.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'sucursales')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('sucursales.edit', ['sucursales' => $sucursal->id])}}" class="btn btn-primary btn-sm btn-block"> {{ trans('app.edit') }}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
