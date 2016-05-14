<div class="box-body">
    <div class="row">
		<div class="form-group col-md-3">
			<label for="centrocosto_codigo" class="control-label">Código</label>
			{!! Form::text('centrocosto_codigo', null, ['id' => 'centrocosto_codigo', 'placeholder' => 'Código', 'class' => 'form-control input-sm', 'required', 'maxlength' => '20' ]) !!}       
		</div>
    </div>
	<div class="row">
		<div class="form-group col-md-6">
			<label for="centrocosto_nombre" class="control-label">Nombre</label>
			{!! Form::text('centrocosto_nombre', null, ['id' => 'centrocosto_nombre', 'placeholder' => 'Nombre', 'class' => 'form-control input-sm input-toupper', 'required']) !!}       
		</div>
    </div>
</div>	