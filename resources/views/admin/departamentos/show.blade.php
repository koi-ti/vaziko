@extends('admin.departamentos.main')

@section('breadcrumb')
    <li><a href="{{ route('departamentos.index')}}">Departamentos</a></li>
    <li class="active">{{ $departamento->departamento_codigo }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-12 col-xs-12 text-left">
                    <a href=" {{ route('departamentos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>    
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $departamento->departamento_codigo }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $departamento->departamento_nombre }}</div>
            </div>
        </div>
    </div>
@stop