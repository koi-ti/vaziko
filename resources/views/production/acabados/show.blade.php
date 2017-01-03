@extends('production.acabados.main')

@section('breadcrumb')
    <li><a href="{{ route('acabadosp.index')}}">Acabados</a></li>
    <li class="active">{{ $acabado->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('acabadosp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('acabadosp.edit', ['acabadosp' => $acabado->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $acabado->id }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $acabado->acabadop_nombre }}</div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Descripción</label>
                    <div>{{ $acabado->acabadop_descripcion }}</div>
                </div>
            </div>
        </div>
    </div>
@stop