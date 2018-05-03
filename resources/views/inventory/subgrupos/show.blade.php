@extends('inventory.subgrupos.main')

@section('breadcrumb')
    <li><a href="{{ route('subgrupos.index')}}">Subgrupos</a></li>
    <li class="active">{{ $subgrupo->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>{{ $subgrupo->id }}</div>
                </div>
                <div class="form-group col-md-8">
                    <label class="control-label">Nombre</label>
                    <div>{{ $subgrupo->subgrupo_nombre }}</div>
                </div>
            </div>
        </div>
        <div class="box-footer with-border">
            <div class="row">
                <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('subgrupos.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('subgrupos.edit', ['subgrupos' => $subgrupo->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop
