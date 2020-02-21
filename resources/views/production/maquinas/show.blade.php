@extends('production.maquinas.main')

@section('breadcrumb')
    <li><a href="{{ route('maquinasp.index')}}">Máquinas</a></li>
    <li class="active">{{ $maquina->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $maquina->id }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $maquina->maquinap_nombre }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'maquinasp') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('maquinasp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'maquinasp')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('maquinasp.edit', ['maquinasp' => $maquina->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
