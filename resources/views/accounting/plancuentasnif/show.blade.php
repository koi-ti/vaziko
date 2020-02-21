@extends('accounting.plancuentasnif.main')

@section('breadcrumb')
	<li><a href="{{ route('plancuentasnif.index') }}">Plan de cuentas NIF</a></li>
	<li class="active">{{ $plancuentanif->plancuentasn_cuenta }}</li>
@stop


@section('module')
	<div class="box box-success">
		<div class="box-body">
			<div class="row">
				<div class="form-group col-md-3">
					<label class="control-label">Cuenta</label>
					<div>{{ $plancuentanif->plancuentasn_cuenta }}</div>
				</div>

				<div class="form-group col-md-1">
					<label class="control-label">Nivel</label>
					<div>{{ $plancuentanif->plancuentasn_nivel }}</div>
				</div>

				<div class="form-group col-md-8">
					<label class="control-label">Nombre</label>
					<div>{{ $plancuentanif->plancuentasn_nombre }}</div>
				</div>
			</div>
			@if ($plancuentanif->plancuentasn_centro)
				<div class="row">
					<div class="form-group col-md-6">
						<label class="control-label">Centro de costo</label>
						<div>{{ $plancuentanif->centrocosto_nombre }}</div>
					</div>
				</div>
			@endif
			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">Naturaleza</label>
					<div>{{ $plancuentanif->plancuentasn_naturaleza ? config('koi.contabilidad.plancuentas.naturaleza')[$plancuentanif->plancuentasn_naturaleza] : '' }}</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">¿Requiere tercero?</label>
					<div>{{ $plancuentanif->plancuentasn_tercero ? 'Si' : 'No' }}</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">Tipo</label>
					<div>{{ $plancuentanif->plancuentasn_tipo ? config('koi.contabilidad.plancuentas.tipo')[$plancuentanif->plancuentasn_tipo] : '' }}</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">Tasa</label>
					<div>{{ $plancuentanif->plancuentasn_tasa }}</div>
				</div>
			</div>
		</div>
		<div class="box-footer with-border">
        	<div class="row">
				<div class="col-md-2 @ability ('editar' | 'plancuentasnif') col-md-offset-4 @elseability col-md-offset-5 @endability col-sm-6 col-xs-6 text-left">
					<a href="{{ route('plancuentasnif.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
				</div>
				@ability ('editar' | 'plancuentasnif')
					<div class="col-md-2 col-sm-6 col-xs-6 text-right">
						<a href="{{ route('plancuentasnif.edit', ['plancuentasnif' => $plancuentanif->id ]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
					</div>
				@endability
			</div>
		</div>
	</div>
@stop
