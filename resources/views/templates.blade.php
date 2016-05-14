{{-- templates --}}
<script type="text/template" id="contact-item-list-tpl">
	<td><%- tcontacto_nombre %></td>
	<td><%- tcontacto_direccion %></td>
	<td><%- tcontacto_telefono %></td>
	<td><%- tcontacto_celular %></td>
	<td><%- tcontacto_email %></td>
	<td><%- tcontacto_cargo %></td>
</script>

<script type="text/template" id="add-centrocosto-tpl">
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
</script>