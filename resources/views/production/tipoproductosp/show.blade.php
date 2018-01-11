@extends('production.tipoproductosp.main')

@section('breadcrumb')
    <li><a href="{{ route('tipoproductosp.index')}}">Tipo de producto</a></li>
    <li class="active">{{ $tipoproductop->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipoproductop->tipoproductop_nombre }}</div>
                </div>

                <div class="form-group col-md-2"><br>
                    <label class="checkbox-inline" for="tipoproductop_activo">
                        <input type="checkbox" id="tipoproductop_activo" name="tipoproductop_activo" value="tipoproductop_activo" disabled {{ $tipoproductop->tipoproductop_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('tipoproductosp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('tipoproductosp.edit', ['tipoproductosp' => $tipoproductop->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop