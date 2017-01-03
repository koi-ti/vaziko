@extends('production.ordenes.productos.main')

@section('breadcrumb')
	<li><a href="{{ route('ordenes.index') }}">Ordenes</a></li>
	<li><a href="{{ route('ordenes.edit', ['ordenes' => $orden->id]) }}">{{ $orden->orden_codigo }}</a></li>
	<li class="active">Producto</li>
@stop

@section('module')
	<div class="box box-success" id="ordenes-productos-create">
		<div class="box-header with-border">
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-6 text-left">
                    <a href="{{ route('ordenes.edit', ['ordenes' => $orden->id]) }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
                </div>
                <div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
                    <a href="{{ route('ordenes.productos.edit', ['productos' => $ordenp2->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
                </div>
            </div>
        </div>

        <div class="box-body">
			<div class="row">
				<div class="form-group col-md-2">
					<label class="control-label">Código</label>
					<div>{{ $orden->orden_codigo }}</div>
				</div>
				<div class="form-group col-md-9">
					<label class="control-label">Referencia</label>
					<div>{{ $ordenp2->productop_nombre }}</div>
				</div>
			</div>
		</div>
	</div>
@stop