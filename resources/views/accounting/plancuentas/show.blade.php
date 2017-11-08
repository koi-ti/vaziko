@extends('accounting.plancuentas.main')

@section('breadcrumb')	
	<li><a href="{{ route('plancuentas.index') }}">Plan de cuentas</a></li>
	<li class="active">{{ $plancuenta->plancuentas_cuenta }}</li>
@stop


@section('module')
	<div class="box box-success">
		<div class="box-body">
			<div class="row">
				<div class="form-group col-md-3">
					<label class="control-label">Cuenta</label>
					<div>{{ $plancuenta->plancuentas_cuenta }}</div>      
				</div>

				<div class="form-group col-md-1">
					<label class="control-label">Nivel</label>
					<div>{{ $plancuenta->plancuentas_nivel }}</div>
				</div>

				<div class="form-group col-md-8">
					<label class="control-label">Nombre</label>
					<div>{{ $plancuenta->plancuentas_nombre }}</div>
				</div>
			</div>

			@if($plancuenta->plancuentas_centro)
				<div class="row">
					<div class="form-group col-md-6">
						<label class="control-label">Centro de costo</label>
						<div>{{ $plancuenta->centrocosto_nombre }}</div>
					</div>
				</div>
			@endif

			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">Naturaleza</label>
					<div>{{ $plancuenta->plancuentas_naturaleza ? config('koi.contabilidad.plancuentas.naturaleza')[$plancuenta->plancuentas_naturaleza] : '' }}</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">¿Requiere tercero?</label>
					<div>{{ $plancuenta->plancuentas_tercero ? 'Si' : 'No' }}</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">Tipo</label>
					<div>{{ $plancuenta->plancuentas_tipo ? config('koi.contabilidad.plancuentas.tipo')[$plancuenta->plancuentas_tipo] : '' }}</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-3">
					<label class="control-label">Tasa</label>
					<div>{{ $plancuenta->plancuentas_tasa }}</div>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Equivalencia en NIF</label>
					<div>{{ $plancuenta->plancuentasn_cuenta }} - {{ $plancuenta->plancuentasn_nombre }}</div>
				</div>
			</div>
		</div>
		<div class="box-footer with-border">
        	<div class="row">
				<div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
					<a href="{{ route('plancuentas.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
				</div>
				<div class="col-md-2 col-sm-6 col-xs-6 text-right">
					<a href="{{ route('plancuentas.edit', ['plancuentas' => $plancuenta->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
				</div>
			</div>
		</div>
	</div>
@stop