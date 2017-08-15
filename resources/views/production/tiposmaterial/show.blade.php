@extends('production.tiposmaterial.main')

@section('breadcrumb')
    <li><a href="{{ route('tiposmaterialp.index')}}">Tipos de material</a></li>
    <li class="active">{{ $tipomaterial->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipomaterial->tipomaterial_nombre }}</div>
                </div>

                <div class="form-group col-md-2"><br>
                    <label class="checkbox-inline" for="tipomaterial_activo">
                        <input type="checkbox" id="tipomaterial_activo" name="tipomaterial_activo" value="tipomaterial_activo" disabled {{ $tipomaterial->tipomaterial_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('tiposmaterialp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('tiposmaterialp.edit', ['tiposmaterialp' => $tipomaterial->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
