@extends('production.areas.main')

@section('breadcrumb')
    <li><a href="{{ route('areasp.index')}}">Área</a></li>
    <li class="active">{{ $area->areap_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $area->areap_nombre }}</div>
                </div>

                @ability ('precios' | 'areasp')
                    <div class="form-group col-md-3">
                        <label class="control-label">Valor</label>
                        <div>$ {{ number_format($area->areap_valor,2,',','.') }}</div>
                    </div>
                @endability
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'areasp') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('areasp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'areasp')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('areasp.edit', ['areasp' => $area->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
