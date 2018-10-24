@extends('layout.layout')

@section('title') Saldos @stop

@section('content')
    <section class="content-header">
		<h1>
			Saldos <small>Administración de saldos</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
            <li class="active">Saldos</li>
		</ol>
    </section>

	<section class="content">
        <div class="box box-success">
            <div class="box-body">
                <form action="{{ route('saldos.index') }}" method="GET" data-toggle="validator">
                    <input class="hidden" id="saldos" name="saldos" value="true"></input>
                    <div class="row">
                        <div class="form-group col-md-2 col-md-offset-4">
                            <label for="filter_mes">Mes</label>
                            <select class="form-control" name="filter_mes">
                                @foreach( config('koi.meses') as $key => $value)
                                    <option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="filter_mes">Año</label>
                            <select class="form-control" name="filter_ano">
                                @for($i = config('koi.app.ano'); $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
					</div>
                    <div class="box-footer">
                        <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                            <button type="submit" class="btn btn-default btn-sm btn-block">
                                <i class="fa fa-edit"></i> Actualizar saldos
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{session('success')}}</li>
                </ul>
            </div>
        @endif
    </section>
@stop
