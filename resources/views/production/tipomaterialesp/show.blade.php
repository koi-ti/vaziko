@extends('production.tipomaterialesp.main')

@section('breadcrumb')
    <li><a href="{{ route('tipomaterialesp.index')}}">Tipo de material</a></li>
    <li class="active">{{ $tipomaterialp->tipomaterial_nombre }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-5">
                    <label class="control-label">Nombre</label>
                    <div>{{ $tipomaterialp->tipomaterial_nombre }}</div>
                </div>

                <div class="form-group col-md-2"><br>
                    <label class="checkbox-inline" for="tipomaterial_activo">
                        <input type="checkbox" id="tipomaterial_activo" name="tipomaterial_activo" value="tipomaterial_activo" disabled {{ $tipomaterialp->tipomaterial_activo ? 'checked': '' }}> Activo
                    </label>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 @ability ('editar' | 'tipomaterialesp') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('tipomaterialesp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                @ability ('editar' | 'tipomaterialesp')
                    <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                        <a href=" {{ route('tipomaterialesp.edit', ['tipomaterialp' => $tipomaterialp->id]) }}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                    </div>
                @endability
            </div>
        </div>
    </div>
@stop
