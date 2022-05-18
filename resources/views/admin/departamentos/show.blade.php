@extends('admin.departamentos.main')

@section('breadcrumb')
    <li><a href="{{ route('departamentos.index')}}">Departamentos</a></li>
    <li class="active">{{ $departamento->departamento_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="col-md-2">
                    <label>Código</label>
                    <div>{{ $departamento->departamento_codigo }}</div>
                </div>
                <div class="col-md-8">
                    <label>Nombre</label>
                    <div>{{ $departamento->departamento_nombre }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('departamentos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
