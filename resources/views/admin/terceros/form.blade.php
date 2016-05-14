<div class="box-body">
	<div class="row">
		<div class="form-group col-md-3">
			<label for="tercero_nit" class="control-label">Documento</label>
			<div class="row">
				<div class="col-md-9">
					{!! Form::text('tercero_nit', null, ['id' => 'tercero_nit', 'placeholder' => 'Nit', 'class' => 'form-control input-sm', 'required']) !!}       
				</div>
				<div class="col-md-3">
					{!! Form::text('tercero_digito', null, ['id' => 'tercero_digito', 'class' => 'form-control input-sm', 'readonly', 'required']) !!}
				</div>
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_tipo" class="control-label">Tipo</label>
			{!! Form::select('tercero_tipo', ['' => 'Seleccione'] + config('koi.terceros.tipo'), null, ['id' => 'tercero_tipo', 'class' => 'form-control', 'required']) !!}
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_persona" class="control-label">Persona</label>
			{!! Form::select('tercero_persona', ['' => 'Seleccione'] + config('koi.terceros.persona'), null, ['id' => 'tercero_persona', 'class' => 'form-control', 'required']) !!}
		</div>
		
		<div class="form-group col-md-3">
			<label for="tercero_regimen" class="control-label">Regimen</label>
			{!! Form::select('tercero_regimen', ['' => 'Seleccione'] + config('koi.terceros.regimen'), null, ['id' => 'tercero_regimen', 'class' => 'form-control', 'required']) !!}
		</div>
	</div>

	{{-- Render template name-partner-tpl --}}
	<div class="row" id="name-partner-content"></div>

	<div class="row">
		<div class="form-group col-md-3">
			<label for="tercero_direccion" class="control-label">Dirección</label>
      		<div class="input-group input-group-sm">
				{!! Form::text('tercero_direccion', null, ['id' => 'tercero_direccion', 'placeholder' => 'Dirección', 'class' => 'form-control address-koi-component', 'required']) !!}
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="tercero_direccion">
						<i class="fa fa-map-signs"></i>
					</button>
				</span>
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_municipio" class="control-label">Municipio</label>
			{!! Form::select('tercero_municipio', App\Models\Base\Municipio::getMunicipios(), null, ['id' => 'tercero_municipio', 'class' => 'form-control select2-default', 'required']) !!}
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_email" class="control-label">Email</label>
			{!! Form::text('tercero_email', null, ['id' => 'tercero_email', 'placeholder' => 'Email', 'class' => 'form-control input-sm']) !!}
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_representante" class="control-label">Representante Legal</label>
			{!! Form::text('tercero_representante', null, ['id' => 'tercero_representante', 'placeholder' => 'Representante Legal', 'class' => 'form-control input-sm input-toupper']) !!}
		</div>
    </div>

    <div class="row">
    	<div class="form-group col-md-3">
			<label for="tercero_telefono1" class="control-label">Teléfono</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-phone"></i>
				</div>
				{!! Form::text('tercero_telefono1', null, ['id' => 'tercero_telefono1', 'data-mask' => 'data-mask', 'data-inputmask' => '"mask": "(999) 999-99-99"', 'class' => 'form-control input-sm']) !!}
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_telefono2" class="control-label">2do. Teléfono</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-phone"></i>
				</div>
				{!! Form::text('tercero_telefono2', null, ['id' => 'tercero_telefono2', 'data-mask' => 'data-mask', 'data-inputmask' => '"mask": "(999) 999-99-99"', 'class' => 'form-control input-sm']) !!}
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_fax" class="control-label">Fax</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-fax"></i>
				</div>
				{!! Form::text('tercero_fax', null, ['id' => 'tercero_fax', 'data-mask' => 'data-mask', 'data-inputmask' => '"mask": "(999) 999-99-99"', 'class' => 'form-control input-sm']) !!}
			</div>
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_celular" class="control-label">Celular</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-mobile"></i>
				</div>
				{!! Form::text('tercero_celular', null, ['id' => 'tercero_celular', 'data-mask' => 'data-mask', 'data-inputmask' => '"mask": "999 999-99-99"', 'class' => 'form-control input-sm']) !!}
			</div>
		</div>
    </div>

    <div class="row">
    	<div class="form-group col-md-10">
    		<label for="tercero_actividad" class="control-label">Actividad Económica</label>
			{!! Form::select('tercero_actividad', App\Models\Base\Actividad::getActividades(), null, ['id' => 'tercero_actividad', 'class' => 'form-control select2-default', 'required']) !!}
    	</div>
    	<div class="form-group col-md-2">
    		<label for="tercero_retecree" class="control-label">% Cree</label>
    		<div id="tercero_retecree"></div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_activo', 'socio', null, ['id' => 'tercero_activo', 'class' => 'minimal' ]) !!}
    		<label for="tercero_activo" class="control-label">Activo</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_socio', 'socio', null, ['id' => 'tercero_socio', 'class' => 'minimal' ]) !!}
    		<label for="tercero_socio" class="control-label">Socio</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_cliente', 'cliente', null, ['id' => 'tercero_cliente', 'class' => 'minimal' ]) !!}
    		<label for="tercero_cliente" class="control-label">Cliente</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_acreedor', 'acreedor', null, ['id' => 'tercero_acreedor', 'class' => 'minimal' ]) !!}
    		<label for="tercero_acreedor" class="control-label">Acreedor</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_interno', 'interno', null, ['id' => 'tercero_interno', 'class' => 'minimal' ]) !!}
    		<label for="tercero_interno" class="control-label">Interno</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_mandatario', 'mandatario', null, ['id' => 'tercero_mandatario', 'class' => 'minimal' ]) !!}
    		<label for="tercero_mandatario" class="control-label">Mandatario</label>
    	</div>
    </div>

    <div class="row">
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_empleado', 'empleado', null, ['id' => 'tercero_empleado', 'class' => 'minimal' ]) !!}
    		<label for="tercero_empleado" class="control-label">Empleado</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_proveedor', 'proveedor', null, ['id' => 'tercero_proveedor', 'class' => 'minimal' ]) !!}
    		<label for="tercero_proveedor" class="control-label">Proveedor</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_extranjero', 'extranjero', null, ['id' => 'tercero_extranjero', 'class' => 'minimal' ]) !!}
    		<label for="tercero_extranjero" class="control-label">Extranjero</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_afiliado', 'afiliado', null, ['id' => 'tercero_afiliado', 'class' => 'minimal' ]) !!}
    		<label for="tercero_afiliado" class="control-label">Afiliado</label>
    	</div>
    	<div class="form-group col-md-2">
    		{!! Form::checkbox('tercero_otro', 'otro', null, ['id' => 'tercero_otro', 'class' => 'minimal' ]) !!}
    		<label for="tercero_otro" class="control-label">Otro</label>
    	</div>
    	<div class="form-group col-md-2">
			{!! Form::text('tercero_cual', null, ['id' => 'tercero_cual', 'placeholder' => '¿Cual?', 'class' => 'form-control input-sm input-toupper']) !!}
		</div>
    </div>
</div>	

{{-- templates --}}
<script type="text/template" id="name-partner-tpl">
	<%if(persona == 'J'){ %>
		<div class="form-group col-md-12">
			<label for="tercero_razonsocial" class="control-label">Razón Social o Comercial</label>
			{!! Form::text('tercero_razonsocial', null, ['id' => 'tercero_razonsocial', 'placeholder' => 'Razón Social o Comercial', 'class' => 'form-control input-sm input-toupper', 'required']) !!}        
		</div>
	<% }else{ %>
		<div class="form-group col-md-3">
			<label for="tercero_nombre1" class="control-label">1er. Nombre</label>
			{!! Form::text('tercero_nombre1', null, ['id' => 'tercero_nombre1', 'placeholder' => '1er. Nombre', 'class' => 'form-control input-sm input-toupper', 'required']) !!}        
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_nombre2" class="control-label">2do. Nombre</label>
			{!! Form::text('tercero_nombre2', null, ['id' => 'tercero_nombre2', 'placeholder' => '2do. Nombre', 'class' => 'form-control input-sm input-toupper']) !!}        
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_apellido1" class="control-label">1er. Apellido</label>
			{!! Form::text('tercero_apellido1', null, ['id' => 'tercero_apellido1', 'placeholder' => '1er. Apellido', 'class' => 'form-control input-sm input-toupper', 'required']) !!}
		</div>

		<div class="form-group col-md-3">
			<label for="tercero_apellido2" class="control-label">2do. Apellido</label>
			{!! Form::text('tercero_apellido2', null, ['id' => 'tercero_apellido2', 'placeholder' => '2do. Apellido', 'class' => 'form-control input-sm input-toupper']) !!}
		</div>
	<% } %>
</script>