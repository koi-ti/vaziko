@extends('production.materiales.main')

@section('breadcrumb')
    <li><a href="{{ route('materialesp.index')}}">Materiale</a></li>
    <li class="active">{{ $material->materialp_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $material->materialp_nombre }}</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">Tipo de material</label>
                    <div>{{ $material->materialp_tipomaterial ? $material->tipomaterial->tipomaterial_nombre : '-' }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Descripción</label>
                    <div>{{ $material->materialp_descripcion ?: '-' }}</div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Empaque</label>
                    <div><input type="checkbox" disabled {{ $material->materialp_empaque ? 'checked': '' }}></div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'materialesp') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('materialesp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'materialesp')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('materialesp.edit', ['materialesp' => $material->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
