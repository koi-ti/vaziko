@extends('admin.roles.main')

@section('breadcrumb')
    <li><a href="{{ route('roles.index')}}">Roles</a></li>
    <li class="active">{{ $roles->id }}</li>
@stop

@section('module')
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href=" {{ route('roles.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                    <a href=" {{ route('roles.edit', ['roles' => $roles->id])}}" class="btn btn-primary btn-sm btn-block"> {{trans('app.edit')}}</a>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="control-label">Nombre</label>
                </div>
            </div>
        </div>
    </div>
@stop