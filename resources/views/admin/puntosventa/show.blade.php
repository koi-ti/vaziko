@extends('admin.puntosventa.main')

@section('breadcrumb')
    <li><a href="{{ route('puntosventa.index')}}">Puntos de venta</a></li>
    <li class="active">{{ $puntoventa->puntoventa_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nombre</label>
                    <div>{{ $puntoventa->puntoventa_nombre }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Prefijo</label>
                    <div>{{ $puntoventa->puntoventa_prefijo }}</div>
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label">Resolución de facturación DIAN</label>
                    <div>{{ $puntoventa->puntoventa_resolucion_dian }}</div>
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label">Consecutivo</label>
                    <div>{{ $puntoventa->puntoventa_numero }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'puntosventa') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('puntosventa.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'puntosventa')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href="{{ route('puntosventa.edit', ['puntosventa' => $puntoventa->id]) }}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
