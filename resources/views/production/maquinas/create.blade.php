@extends('production.maquinas.main')

@section('breadcrumb')
    <li><a href="{{ route('maquinasp.index')}}">Maquina</a></li>
	<li class="active">Nuevo</li>
@stop

@section('module')
	<div class="box box-success" id="maquinasp-create">
		{!! Form::open(['id' => 'form-maquinasp', 'data-toggle' => 'validator']) !!}
			<div class="box-body" id="render-form-maquinap">
				{{-- Render form maquinap --}}
			</div>

			<div class="box-footer with-border">
                <div class="row">
					<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
						<a href="{{ route('maquinasp.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                    </div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.create') }}</button>
                    </div>
                </div>
            </div>
		{!! Form::close() !!}
	</div>
@stop
