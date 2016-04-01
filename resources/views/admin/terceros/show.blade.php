@extends('admin.terceros.main')

@section('breadcrumb')	
	<li><a href="{{ route('terceros.index') }}">Terceros</a></li>
	<li class="active">{{ $tercero->tercero_nit }}</li>
@stop

@section('module')
	<div class="box box-success">
		<div class="box-header with-border">
        	<div class="row">
				<div class="col-md-2 col-sm-6 col-xs-6 text-left">
					<a href="{{ route('terceros.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
				</div>
				<div class="col-md-2 col-md-offset-8 col-sm-6 col-xs-6 text-right">
					<a href="{{ route('terceros.edit', ['terceros' => $tercero->id]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('app.edit') }}</a>
				</div>
			</div>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="form-group col-md-3">
					<label class="control-label">Documento</label>
					<div>{{ $tercero->tercero_nit }} - {{ $tercero->tercero_digito }}</div>      
				</div>

				<div class="form-group col-md-3">
					<label class="control-label">Tipo</label>
					<div>{{ $tercero->tercero_tipo ? config('koi.terceros.tipo')[$tercero->tercero_tipo] : ''  }} </div>
				</div>

				<div class="form-group col-md-3">
					<label class="control-label">Regimen</label>
					<div>{{ $tercero->tercero_regimen ? config('koi.terceros.regimen')[$tercero->tercero_regimen] : ''  }} </div>
				</div>

				<div class="form-group col-md-3">
					<label class="control-label">Persona</label>
					<div>{{ $tercero->tercero_persona ? config('koi.terceros.persona')[$tercero->tercero_persona] : ''  }} </div>
				</div>
			</div>

			<div class="row">
				@if($tercero->tercero_persona == 'J')
					<div class="form-group col-md-12">
						<label class="control-label">Razón Social o Comercial</label>
						<div>{{ $tercero->tercero_razonsocial }}</div>       
					</div>
				@else
					<div class="form-group col-md-3">
						<label class="control-label">1er. Nombre</label>
						<div>{{ $tercero->tercero_nombre1 }}</div>        
					</div>

					<div class="form-group col-md-3">
						<label class="control-label">2do. Nombre</label>
						<div>{{ $tercero->tercero_nombre2 }}</div>        
					</div>

					<div class="form-group col-md-3">
						<label class="control-label">1er. Apellido</label>
						<div>{{ $tercero->tercero_apellido1 }}</div>
					</div>

					<div class="form-group col-md-3">
						<label class="control-label">2do. Apellido</label>
						<div>{{ $tercero->tercero_apellido2 }}</div>
					</div>
				@endif
			</div>

			<div class="row">
				<div class="form-group col-md-6">
					<label class="control-label">Dirección</label>
					<div>{{ $tercero->tercero_direccion }}</div>
				</div>

				<div class="form-group col-md-3">
					<label class="control-label">Email</label>
					<div>{{ $tercero->tercero_email }}</div>
				</div>

				<div class="form-group col-md-3">
					<label class="control-label">Representante Legal</label>
					<div>{{ $tercero->tercero_representante }}</div>
				</div>
	        </div>

	        <div class="row">
	        	<div class="form-group col-md-3">
					<label class="control-label">Teléfono</label>
					<div><i class="fa fa-phone"></i> {{ $tercero->tercero_telefono1 }}</div>
				</div>

				<div class="form-group col-md-3">
					<label class="control-label">2do. Teléfono</label>
					<div><i class="fa fa-phone"></i> {{ $tercero->tercero_telefono2 }}</div>
				</div>

				<div class="form-group col-md-3">
					<label class="control-label">Fax</label>
					<div><i class="fa fa-fax"></i> {{ $tercero->tercero_fax }}</div>
				</div>

				<div class="form-group col-md-3">
					<label class="control-label">Celular</label>
					<div><i class="fa fa-mobile"></i> {{ $tercero->tercero_fax }}</div>
				</div>
	        </div>

	        <div class="row">
	        	<div class="form-group col-md-10">
	        		<label class="control-label">Actividad Económica</label>
	        		<div>{{ $actividad->actividad_nombre }}</div>
	        	</div>
	        	<div class="form-group col-md-2">
	        		<label class="control-label">% Cree</label>
	        		<div>{{ $actividad->actividad_tarifa }}</div>
	        	</div>
	        </div>
	        
	        <div class="row">
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_activo', 'socio', $tercero->tercero_activo, ['id' => 'tercero_activo', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_activo" class="control-label">Activo</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_socio', 'socio', $tercero->tercero_socio, ['id' => 'tercero_socio', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_socio" class="control-label">Socio</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_cliente', 'cliente', $tercero->tercero_cliente, ['id' => 'tercero_cliente', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_cliente" class="control-label">Cliente</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_acreedor', 'acreedor', $tercero->tercero_acreedor, ['id' => 'tercero_acreedor', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_acreedor" class="control-label">Acreedor</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_interno', 'interno', $tercero->tercero_interno, ['id' => 'tercero_interno', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_interno" class="control-label">Interno</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_mandatario', 'mandatario', $tercero->tercero_mandatario, ['id' => 'tercero_mandatario', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_mandatario" class="control-label">Mandatario</label>
	        	</div>
	        </div>

	        <div class="row">
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_empleado', 'empleado', $tercero->tercero_empleado, ['id' => 'tercero_empleado', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_empleado" class="control-label">Empleado</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_proveedor', 'proveedor', $tercero->tercero_proveedor, ['id' => 'tercero_proveedor', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_proveedor" class="control-label">Proveedor</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_extranjero', 'extranjero', $tercero->tercero_extranjero, ['id' => 'tercero_extranjero', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_extranjero" class="control-label">Extranjero</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_afiliado', 'afiliado', $tercero->tercero_afiliado, ['id' => 'tercero_afiliado', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_afiliado" class="control-label">Afiliado</label>
	        	</div>
	        	<div class="form-group col-md-2">
	        		{!! Form::checkbox('tercero_otro', 'otro', $tercero->tercero_otro, ['id' => 'tercero_otro', 'class' => 'minimal', 'disabled' => 'disabled' ]) !!}
	        		<label for="tercero_otro" class="control-label">Otro</label>
	        	</div>
	        	<div class="form-group col-md-2">
					<div>{{ $tercero->tercero_cual }}</div>
				</div>
	        </div>
		</div>
	</div>
@stop