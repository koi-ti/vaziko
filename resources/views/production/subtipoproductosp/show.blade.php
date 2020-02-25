@extends('production.subtipoproductosp.main')

@section('breadcrumb')
    <li><a href="{{ route('subtipoproductosp.index')}}">Subtipo de producto</a></li>
    <li class="active">{{ $subtipoproductop->subtipoproductop_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nombre</label>
                    <div>{{ $subtipoproductop->subtipoproductop_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Tipo de producto</label>
                    <div>{{ $subtipoproductop->tipoproductop_nombre }}</div>
                </div>
                <div class="form-group col-md-2"><br>
                    <label class="checkbox-inline" for="subtipoproductop_activo">
                        <input type="checkbox" id="subtipoproductop_activo" name="subtipoproductop_activo" value="subtipoproductop_activo" disabled {{ $subtipoproductop->subtipoproductop_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'subtipoproductosp') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('subtipoproductosp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'subtipoproductosp')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('subtipoproductosp.edit', ['subtipoproductosp' => $subtipoproductop->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
