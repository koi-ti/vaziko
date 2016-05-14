<div class="box-body">
    <div class="row">
		<div class="form-group col-md-3">
			<label for="plancuentas_cuenta" class="control-label">Cuenta</label>
			{!! Form::text('plancuentas_cuenta', null, ['id' => 'plancuentas_cuenta', 'placeholder' => 'Cuenta', 'class' => 'form-control input-sm', 'required', 'maxlength' => '15' ]) !!}       
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-6">
			<label for="plancuentas_nombre" class="control-label">Nombre</label>
			{!! Form::text('plancuentas_nombre', null, ['id' => 'plancuentas_nombre', 'placeholder' => 'Nombre', 'class' => 'form-control input-sm input-toupper', 'required', 'maxlength' => '200' ]) !!}       
		</div>
    </div>

    <div class="row">
		<div class="form-group col-md-3">
    		<label for="plancuentas_naturaleza" class="control-label">Naturaleza</label>
    		{!! Form::select('plancuentas_naturaleza', ['' => 'Seleccione'] + config('koi.contabilidad.naturaleza'), null, ['id' => 'plancuentas_naturaleza', 'class' => 'form-control', 'required']) !!}
		</div>
    </div>

	<div class="row">
		<div class="form-group col-md-5 col-xs-10">
			<label for="plancuentas_centro" class="control-label">Centro de costo</label>
				{!! Form::select('plancuentas_centro', App\Models\Accounting\CentroCosto::getCentrosCosto(), null, ['id' => 'plancuentas_centro', 'class' => 'form-control select2-default-clear', 'required']) !!}
		</div>
		<div class="form-group col-md-1 col-xs-2">
			<div>&nbsp;</div>
			<button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="centrocosto">
				<i class="fa fa-plus"></i>
			</button>
		</div>
	</div>
</div>	

{{-- {!! Form::radio('plancuentas_naturaleza', 'otro', null, ['id' => 'plancuentas_naturaleza', 'class' => 'minimal' ]) !!} --}}
{{-- <label for="plancuentas_naturaleza" class="control-label">Debito</label> --}}